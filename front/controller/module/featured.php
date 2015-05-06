<?php
class ControllerModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/featured');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('front/post');

		$this->load->model('tool/image');

		$data['text_featured'] = $this->language->get('text_featured');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_on'] = $this->language->get('text_on');
		$data['posts'] = array();
		
		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		$posts = array_slice($setting['post'], 0, (int)$setting['limit']);
		
		$this->load->model('front/category');
		
		$data['categories_info'] = array();
		$n = 0;
		foreach ($posts as $post_id) {
			
			
			$post_info = $this->model_front_post->getPost($post_id);
			
			if ($post_info) {	
				
				$categories = $this->model_front_post->getCategories($post_info['post_id']);
				
				foreach ($categories as $category) {
					$categories = $this->model_front_category->getCategory($category['category_id']);
					
						$data['categories_info'][$n][] = array(
							'category_id' => $categories['category_id'],
							'name'        => $categories['name'],
							'href' 		  => $this->url->link('post/category', 'path=' . $categories['category_id'])
						);
					}
				
				
				if ($post_info['image']) {
					$image = $this->model_tool_image->resize($post_info['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}
				
				$data['posts'][] = array(
					'post_id'  	  => $post_info['post_id'],
					'thumb'       => $image,
					'name'        => $post_info['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_post_description_length')) . '..',
					'user'        => $post_info['user'],
					'date_added'  => date($this->language->get('date_format_short'), strtotime($post_info['date_added'])),
					'href'        => $this->url->link('post/post', 'post_id=' . $post_info['post_id'])
				);
				$n++;				
			}
		}

		if ($data['posts']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
			} else {
				return $this->load->view('default/template/module/featured.tpl', $data);
			}
		}
	}
}