<?php
class ControllerPostPost extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('post/post');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('front/category');

		if (isset($this->request->get['path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_front_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('post/category', 'path=' . $path)
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_front_category->getCategory($category_id);

			if ($category_info) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('post/category', 'path=' . $this->request->get['path'] . $url)
				);
			}
		}


		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('post/search', $url)
			);
		}

		if (isset($this->request->get['post_id'])) {
			$post_id = (int)$this->request->get['post_id'];
		} else {
			$post_id = 0;
		}

		$this->load->model('front/post');

		$post_info = $this->model_front_post->getpost($post_id);

		if ($post_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $post_info['name'],
				'href' => $this->url->link('post/post', $url . '&post_id=' . $this->request->get['post_id'])
			);

			$this->document->setTitle($post_info['meta_title']);
			$this->document->setDescription($post_info['meta_description']);
			$this->document->setKeywords($post_info['meta_keyword']);
			$this->document->addLink($this->url->link('post/post', 'post_id=' . $this->request->get['post_id']), 'canonical');
			$this->document->addScript('front/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('front/view/javascript/jquery/magnific/magnific-popup.css');

			$data['heading_title'] = $post_info['name'];
			
			$data['text_by'] = $this->language->get('text_by');
			$data['text_on'] = $this->language->get('text_on');
			$data['text_author'] = $this->language->get('text_author');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_related'] = $this->language->get('text_related');
			$data['text_categories'] = $this->language->get('text_category');
			$data['post_id'] = (int)$this->request->get['post_id'];

			$this->load->model('tool/image');

			if ($post_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($post_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($post_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($post_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}
			
			$data['categories'] = array();
			
			$categories = $this->model_front_post->getCategories($post_info['post_id']);

			foreach ($categories as $category) {
				$category_details = $this->model_front_category->getCategory($category['category_id']);
				
					$data['categories'][] = array(
						'category_id' => $category_details['category_id'],
						'name'        => $category_details['name'],
						'href' 		  => $this->url->link('post/category', 'path=' . $category_details['category_id'])
						);
			}
			
			$data['display'] = $post_info['display'];
			$data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
			$data['user'] = $post_info['user'];
			$data['uhref'] = $this->url->link('post/author', 'author_id=' . $post_info['user_id']);
			$data['user_image'] = $this->model_tool_image->resize($post_info['user_image'], 75, 75);
			$data['posts'] = array();
			
			// Related posts
			$results = $this->model_front_post->getpostRelated($this->request->get['post_id']);
			$n = 0;
			$data['post_categories'] = array();
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				}
				
				$post_categories = $this->model_front_post->getCategories($result['post_id']);
				
					foreach ($post_categories as $post_category) {
						$post_category_details = $this->model_front_category->getCategory($post_category['category_id']);
						
							$data['post_categories'][$n][] = array(
								'category_id' => $post_category_details['category_id'],
								'name'        => $post_category_details['name'],
								'href' 		  => $this->url->link('post/category', 'path=' . $post_category_details['category_id'])
							);
						
					}

				$data['posts'][] = array(
					'post_id'     => $result['post_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'author'      => $this->url->link('post/author', 'author_id=' . $result['user_id']),
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_post_description_length')) . '..',
					'user'        => $result['user'],
					'uhref'       => $this->url->link('post/author', 'author_id=' . $result['user_id']),
					'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'href'        => $this->url->link('post/post', 'post_id=' . $result['post_id'])
				);
				
				$n++;
			}
			// related posts />
			$data['tags'] = array();

			if ($post_info['tag']) {
				$tags = explode(',', $post_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('post/search', 'tag=' . trim($tag))
					);
				}
			}

			$this->model_front_post->updateViewed($this->request->get['post_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/post/post.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/post/post.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/post/post.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('post/post', $url . '&post_id=' . $post_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

}
