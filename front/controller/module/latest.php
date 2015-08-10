<?php
class ControllerModuleLatest extends Controller {
	public function index($setting) {
		$this->load->language('module/latest');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_on'] = $this->language->get('text_on');
		
		$this->load->model('front/post');
		$this->load->model('tool/image');

		$data['posts'] = array();

		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_front_post->getposts($filter_data);
		$this->load->model('front/category');
		
		$data['categories_info'] = array();
		$n = 0;

		if ($results) {
			foreach ($results as $result) {
				
				$categories = $this->model_front_post->getCategories($result['post_id']);

				foreach ($categories as $category) {
					$categories = $this->model_front_category->getCategory($category['category_id']);
					
						$data['categories_info'][$n][] = array(
							'category_id' => $categories['category_id'],
							'name'        => $categories['name'],
							'href' 		  => $this->url->link('post/category', 'path=' . $categories['category_id'])
						);
					}
				
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 146, 146);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 146, 146);
				}

				$data['posts'][] = array(
					'post_id'     => $result['post_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_post_description_length')) . '..',
					'user'        => $result['user'],
					'uhref'       => $this->url->link('post/author', 'author_id=' . $result['user_id']),
					'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'dhref'       => $this->url->link('post/search', 'date=' . date("Y-m-d",  strtotime($result['date_added']))),
					'href'        => $this->url->link('post/post', 'post_id=' . $result['post_id']),
				);
				
				$n++;
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/latest.tpl', $data);
			} else {
				return $this->load->view('default/template/module/latest.tpl', $data);
			}
		}
	}
}