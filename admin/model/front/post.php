<?php
class ModelFrontPost extends Model {
	public function addpost($data) {
		$this->event->trigger('pre.admin.post.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "post SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', user_id = '" . $this->user->getId() . "', date_added = NOW()");

		$post_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post SET image = '" . $this->db->escape($data['image']) . "' WHERE post_id = '" . (int)$post_id . "'");
		}

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_description SET post_id = '" . (int)$post_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['post_category'])) {
			foreach ($data['post_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['post_filter'])) {
			foreach ($data['post_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_filter SET post_id = '" . (int)$post_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['post_related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$related_id . "' AND related_id = '" . (int)$post_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$related_id . "', related_id = '" . (int)$post_id . "'");
			}
		}

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post');

		$this->event->trigger('post.admin.post.add', $post_id);

		return $post_id;
	}

	public function editpost($post_id, $data) {
		$this->event->trigger('pre.admin.post.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "post SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "post SET image = '" . $this->db->escape($data['image']) . "' WHERE post_id = '" . (int)$post_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_description SET post_id = '" . (int)$post_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_category'])) {
			foreach ($data['post_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_category SET post_id = '" . (int)$post_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_filter WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_filter'])) {
			foreach ($data['post_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_filter SET post_id = '" . (int)$post_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE related_id = '" . (int)$post_id . "'");

		if (isset($data['post_related'])) {
			foreach ($data['post_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$post_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$related_id . "' AND related_id = '" . (int)$post_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_related SET post_id = '" . (int)$related_id . "', related_id = '" . (int)$post_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");

		if (isset($data['post_layout'])) {
			foreach ($data['post_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_to_layout SET post_id = '" . (int)$post_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_id=" . (int)$post_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post');

		$this->event->trigger('post.admin.post.edit', $post_id);
	}

	public function copypost($post_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE p.post_id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

		
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data = array_merge($data, array('post_description' => $this->getpostDescriptions($post_id)));
			$data = array_merge($data, array('post_related' => $this->getpostRelated($post_id)));
			$data = array_merge($data, array('post_category' => $this->getpostCategories($post_id)));
			$data = array_merge($data, array('post_layout' => $this->getpostLayouts($post_id)));
			$data = array_merge($data, array('post_store' => $this->getpostStores($post_id)));

			$this->addpost($data);
		}
	}

	public function deletepost($post_id) {
		$this->event->trigger('pre.admin.post.delete', $post_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "post WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_filter WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_related WHERE related_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE post_id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "'");

		$this->cache->delete('post');

		$this->event->trigger('post.admin.post.delete', $post_id);
	}

	public function getpost($post_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'post_id=" . (int)$post_id . "') AS keyword FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE p.post_id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getposts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY p.post_id";

		$sort_data = array(
			'pd.name',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getpostsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) LEFT JOIN " . DB_PREFIX . "post_to_category p2c ON (p.post_id = p2c.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getpostDescriptions($post_id) {
		$post_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_description WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $post_description_data;
	}

	public function getpostCategories($post_id) {
		$post_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_category_data[] = $result['category_id'];
		}

		return $post_category_data;
	}

	public function getpostFilters($post_id) {
		$post_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_filter WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_filter_data[] = $result['filter_id'];
		}

		return $post_filter_data;
	}

	public function getpostAttributes($post_id) {
		$post_attribute_data = array();

		$post_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "post_attribute WHERE post_id = '" . (int)$post_id . "' GROUP BY attribute_id");

		foreach ($post_attribute_query->rows as $post_attribute) {
			$post_attribute_description_data = array();

			$post_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_attribute WHERE post_id = '" . (int)$post_id . "' AND attribute_id = '" . (int)$post_attribute['attribute_id'] . "'");

			foreach ($post_attribute_description_query->rows as $post_attribute_description) {
				$post_attribute_description_data[$post_attribute_description['language_id']] = array('text' => $post_attribute_description['text']);
			}

			$post_attribute_data[] = array(
				'attribute_id'                  => $post_attribute['attribute_id'],
				'post_attribute_description' => $post_attribute_description_data
			);
		}

		return $post_attribute_data;
	}

	public function getpostLayouts($post_id) {
		$post_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_layout WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $post_layout_data;
	}

	public function getpostRelated($post_id) {
		$post_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_related WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_related_data[] = $result['related_id'];
		}

		return $post_related_data;
	}


	public function getTotalposts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.post_id) AS total FROM " . DB_PREFIX . "post p LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}



	public function getTotalpostsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalpostsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}