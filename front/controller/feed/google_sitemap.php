<?php
class ControllerFeedGoogleSitemap extends Controller {
	public function index() {
		if ($this->config->get('google_sitemap_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

			$this->load->model('catalog/post');
			$this->load->model('tool/image');

			$posts = $this->model_catalog_post->getposts();

			foreach ($posts as $post) {
				if ($post['image']) {
					$output .= '<url>';
					$output .= '<loc>' . $this->url->link('post/post', 'post_id=' . $post['post_id']) . '</loc>';
					$output .= '<changefreq>weekly</changefreq>';
					$output .= '<priority>1.0</priority>';
					$output .= '<image:image>';
					$output .= '<image:loc>' . $this->model_tool_image->resize($post['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . '</image:loc>';
					$output .= '<image:caption>' . $post['name'] . '</image:caption>';
					$output .= '<image:title>' . $post['name'] . '</image:title>';
					$output .= '</image:image>';
					$output .= '</url>';
				}
			}

			$this->load->model('catalog/front');

			$output .= $this->getCategories(0);

			$this->load->model('catalog/information');

			$informations = $this->model_catalog_information->getInformations();

			foreach ($informations as $information) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.5</priority>';
				$output .= '</url>';
			}

			$output .= '</urlset>';

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';

		$results = $this->model_catalog_front->getCategories($parent_id);

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['front_id'];
			} else {
				$new_path = $current_path . '_' . $result['front_id'];
			}

			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('post/front', 'path=' . $new_path) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';

			$posts = $this->model_catalog_post->getposts(array('filter_front_id' => $result['front_id']));

			foreach ($posts as $post) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('post/post', 'path=' . $new_path . '&amp;post_id=' . $post['post_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>1.0</priority>';
				$output .= '</url>';
			}

			$output .= $this->getCategories($result['front_id'], $new_path);
		}

		return $output;
	}
}
