<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_search'] = $this->language->get('text_search');
		$data['home'] = $this->url->link('common/home');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('front/category');

		$this->load->model('front/post');

		$data['categories'] = array();

		$categories = $this->model_front_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {

				$data['categories'][] = array(
					'name'     => $category['name'],
					'icon'     => $category['icon'],
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('post/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['search'] = $this->load->controller('common/search');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['post_id'])) {
				$class = '-' . $this->request->get['post_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}