<?php
class ModelFrontPost extends Model {
	public function updateViewed($post_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "post SET viewed = (viewed + 1) WHERE post_id = '" . (int)$post_id . "'");
	}

	public function getPost($post_id) {
		$query = $this->db->query("SELECT DISTINCT *, 
		pd.name AS name, p.image, u.firstname AS firstname, u.username AS user, u.lastname AS lastname, u.image AS user_image, u.user_id AS user_id, p.sort_order FROM " . DB_PREFIX . "post p 
		LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) 		
		LEFT JOIN " . DB_PREFIX . "user u ON (p.user_id = u.user_id)
		 
		WHERE p.post_id = '" . (int)$post_id . "' 
		AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
		AND p.status = '1'");

		if ($query->num_rows) {
			return array(
				'post_id'          => $query->row['post_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'image'            => $query->row['image'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'user'             => $query->row['user'],
				'user_id'          => $query->row['user_id'],
				'firstname'        => $query->row['firstname'],
				'lastname'         => $query->row['lastname'],
				'user_image'       => $query->row['user_image'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}

	public function getposts($data = array()) {
		$sql = "SELECT p.post_id ";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "post_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post_filter pf ON (p2c.post_id = pf.post_id) LEFT JOIN " . DB_PREFIX . "post p ON (pf.post_id = p.post_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post p ON (p2c.post_id = p.post_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "post p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'";


		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			$sql .= ")";
		}


		$sql .= " GROUP BY p.post_id";

		$sort_data = array(
			'pd.name',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$post_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$post_data[$result['post_id']] = $this->getpost($result['post_id']);
		}

		return $post_data;
	}

	public function getLatestposts($limit) {
		$post_data = $this->cache->get('post.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$post_data) {
			$query = $this->db->query("SELECT p.post_id FROM " . DB_PREFIX . "post p WHERE p.status = '1' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$post_data[$result['post_id']] = $this->getpost($result['post_id']);
			}

			$this->cache->set('post.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $post_data);
		}

		return $post_data;
	}

	public function getPopularposts($limit) {
		$post_data = array();

		$query = $this->db->query("SELECT p.post_id FROM " . DB_PREFIX . "post p WHERE p.status = '1' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$post_data[$result['post_id']] = $this->getpost($result['post_id']);
		}

		return $post_data;
	}

	public function getpostRelated($post_id) {
		$post_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_related pr LEFT JOIN " . DB_PREFIX . "post p ON (pr.related_id = p.post_id) WHERE pr.post_id = '" . (int)$post_id . "' AND p.status = '1'");

		foreach ($query->rows as $result) {
			$post_data[$result['related_id']] = $this->getpost($result['related_id']);
		}

		return $post_data;
	}

	public function getpostLayoutId($post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		return $query->rows;
	}

	public function getTotalposts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.post_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "post_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post_filter pf ON (p2c.post_id = pf.post_id) LEFT JOIN " . DB_PREFIX . "post p ON (pf.post_id = p.post_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "post p ON (p2c.post_id = p.post_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "post p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
			}

			$sql .= ")";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

}
