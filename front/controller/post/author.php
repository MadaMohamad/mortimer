<?php
class ControllerPostAuthor extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('post/author');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_author_list'),
			'href' => $this->url->link('post/author/author_list')
		);
		
		$data['text_bio'] = $this->language->get('text_bio');
		$data['text_by'] = $this->language->get('text_by');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_on'] = $this->language->get('text_on');
		$data['text_posts'] = $this->language->get('text_posts');
		$data['text_see_more'] = $this->language->get('text_see_more');
		
		
		if (isset($this->request->get['author_id'])) {
			$author_id = (int)$this->request->get['author_id'];
		} else {
			$author_id = 0;
		}
		
		$this->load->model('front/author');

		$author_info = $this->model_front_author->getAuthor($author_id);

		if ($author_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $author_info['username'],
				'href' => $this->url->link('post/post', $url . '&author_id=' . $this->request->get['author_id'])
			);

			$this->document->setTitle($author_info['username']);
			$this->document->setDescription($this->language->get('description'));
			$this->document->setKeywords($this->language->get('keyword'));
			$this->document->addLink($this->url->link('post/author', 'author_id=' . $this->request->get['author_id']), 'canonical');
			$this->document->addScript('front/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('front/view/javascript/jquery/magnific/magnific-popup.css');

			$data['heading_title'] = $author_info['username'];

			$data['button_continue'] = $this->language->get('button_continue');


			$data['author_id'] = (int)$this->request->get['author_id'];

			$this->load->model('tool/image');

			if ($author_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($author_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($author_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($author_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}
			
			$data['name'] = $author_info['firstname'] . " " . $author_info['lastname'];
			$data['bio'] = html_entity_decode($author_info['bio'], ENT_QUOTES, 'UTF-8');
			$data['see_more'] = $this->url->link('post/search', 'author=' . $author_info['username']);
			
			$data['posts'] = array();

			$posts = $this->model_front_author->getPostsByAuthor($this->request->get['author_id']);
			$n = 0;
			
			foreach ($posts as $result) {
				
				$categories = $this->model_front_author->getCategories($result['post_id']);
				
				$this->load->model('front/category');
				
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
					'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'dhref'       => $this->url->link('post/search', 'date=' . date("Y-m-d",  strtotime($result['date_added']))),
					'href'        => $this->url->link('post/post', 'post_id=' . $result['post_id'])
				);
				
				$n++;
			}
			
			$this->model_front_author->updateViewed($this->request->get['author_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/post/author.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/post/author.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/post/author.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('post/author', $url . '&author_id=' . $author_id)
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

	public function author_list() {
		$this->load->language('post/author');

		$this->document->setTitle($this->language->get('text_header'));
		$this->document->setDescription($this->language->get('list_description'));
		$this->document->setKeywords($this->language->get('list_keyword'));
		$this->document->addLink($this->url->link('post/author_list'), 'canonical');


		$this->load->model('front/author');

		$this->getList();
	
	}

	protected function getList() {
		
		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_author_list'),
			'href' => $this->url->link('post/author_list')
		);
		
		$data['text_name'] = $this->language->get('text_name');
		$data['text_bio'] = $this->language->get('text_bio');
		$data['text_posts'] = $this->language->get('text_posts');
		$data['text_category'] = $this->language->get('text_category');

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
			
			$data['heading_title'] = $this->language->get('text_header');
			$data['button_continue'] = $this->language->get('button_continue');

			$this->load->model('tool/image');

			$authors = $this->model_front_author->getAuthors();
			
			foreach ($authors as $author) {
								
				if ($author['image']) {
					$image = $this->model_tool_image->resize($author['image'], 146, 146);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 146, 146);
				}

				$data['authors'][] = array(
					'author_id'   => $author['user_id'],
					'thumb'       => $image,
					'username'    => $author['username'],
					'name'        => $author['firstname'] . " " . $author['lastname'],
					'bio'         => utf8_substr(strip_tags(html_entity_decode($author['bio'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_post_description_length')) . '..',
					'href'        => $this->url->link('post/author', 'author_id=' . $author['user_id'])
				);
				
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/post/author_list.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/post/author_list.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/post/author_list.tpl', $data));
			}
			
	
	}


}
