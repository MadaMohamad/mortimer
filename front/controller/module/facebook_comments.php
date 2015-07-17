<?php
class ControllerModuleFacebookComments extends Controller {
	public function index($setting) {
		$this->load->language('module/facebook_comments');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/facebook_comments.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/facebook_comments.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/facebook_comments.css');
		}
		
      	$data['heading_title'] = $this->language->get('heading_title');
		
		// add fb tag for APP ID if Facebook Open Graph Meta Tags extension is installed
		if (method_exists($this->document, 'addOpenGraphMetaTags')) {
			$this->document->addOpenGraphMetaTags('fb:app_id', $setting['app_id']);
		}
				
		$data['app_id'] = $setting['app_id'];		
		$data['url'] = $this->getCurrentURL();
		$data['color_scheme'] = $setting['color_scheme'];
		$data['num_posts'] = $setting['num_posts'];
		$data['order_by'] = $setting['order_by'];
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/facebook_comments.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/facebook_comments.tpl', $data);
		} else {
			return $this->load->view('default/template/module/facebook_comments.tpl', $data);
		}

	}
	
	private function getCurrentURL() {
		$url = '';
		
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		} else {
			$route = 'common/home';
		}
		
		if ($route == 'common/home') {
			$url = $this->url->link('common/home');
		} elseif ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$url = $this->url->link('product/product', 'product_id=' . $this->request->get['product_id']);
		} elseif ($route == 'product/category' && isset($this->request->get['path'])) {
			$url = $this->url->link('product/category', 'path=' . $this->request->get['path']);
		} elseif ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$url = $this->url->link('information/information', 'information_id=' . $this->request->get['information_id']);
		} else {
			if ($this->request->server['HTTPS']) {
				$url = $this->config->get('config_ssl');
			} else {
				$url = $this->config->get('config_url');
			}
			
			$url .= $this->request->server["REQUEST_URI"];
		}
		
		return $url;
	}
}
?>