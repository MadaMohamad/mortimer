<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$this->load->language('common/header');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_online'] = $this->language->get('text_online');
		$data['text_approval'] = $this->language->get('text_approval');
		$data['text_post'] = $this->language->get('text_post');
		$data['text_review'] = $this->language->get('text_review');
		$data['text_front'] = $this->language->get('text_front');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_homepage'] = $this->language->get('text_homepage');
		$data['text_documentation'] = $this->language->get('text_documentation');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		$data['text_logout'] = $this->language->get('text_logout');

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/dashboard', '', 'SSL');
		} else {
			$data['logged'] = true;

			$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');

/*
			// Customers
			$this->load->model('report/customer');

			$data['online_total'] = $this->model_report_customer->getTotalCustomersOnline();

			$data['online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');

			$this->load->model('sale/customer');

			$customer_total = $this->model_sale_customer->getTotalCustomers(array('filter_approved' => false));

			$data['customer_total'] = $customer_total;
			$data['customer_approval'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');
*/

			// posts
			$this->load->model('front/post');

			$post_total = $this->model_front_post->getTotalposts(array('filter_quantity' => 0));

			$data['post_total'] = $post_total;

			$data['post'] = $this->url->link('front/post', 'token=' . $this->session->data['token'] . '&filter_quantity=0', 'SSL');

/*
			// Reviews
			$this->load->model('front/review');

			$review_total = $this->model_front_review->getTotalReviews(array('filter_status' => false));

			$data['review_total'] = $review_total;

			$data['review'] = $this->url->link('front/review', 'token=' . $this->session->data['token'] . '&filter_status=0', 'SSL');
*/

						// Online Stores
/*
			$data['stores'] = array();

			$data['stores'][] = array(
				'name' => $this->config->get('config_name'),
				'href' => HTTP_FRONT
			);
*/

		
		}

		return $this->load->view('common/header.tpl', $data);
	}
}