<?php
class ModelFrontAuthor extends Model {
	public function updateViewed($author_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "user SET viewed = (viewed + 1) WHERE user_id = '" . (int)$author_id . "'");
	}
	
	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$author_id . "'");
		return $query->row;
	}

	public function getPostsByAuthor($author_id) {
		$query = $this->db->query("SELECT *, 
		pd.name AS name, pd.description as description		
		FROM " . DB_PREFIX . "post p 
		LEFT JOIN " . DB_PREFIX . "post_description pd ON (p.post_id = pd.post_id) 
		WHERE p.user_id = '" . (int)$author_id . "' 
		AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
		AND p.status = '1'
		ORDER BY p.date_added DESC
		LIMIT 10");

		return $query->rows;
	}
	
	public function getCategories($post_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_to_category WHERE post_id = '" . (int)$post_id . "'");

		return $query->rows;
	}
	
	public function getAuthors() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user");
		return $query->rows;
	}

}
