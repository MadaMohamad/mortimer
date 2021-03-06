<?php
class ControllerCommonContentBottom extends Controller {
	public function index() {
		$this->load->model('design/layout');
		
		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}

		$layout_id = 0;

		if ($route == 'post/front' && isset($this->request->get['path'])) {
			$this->load->model('front/front');
			
			$path = explode('_', (string)$this->request->get['path']);

			$layout_id = $this->model_front_front->getfrontLayoutId(end($path));
		}

		if ($route == 'post/post' && isset($this->request->get['post_id'])) {
			$this->load->model('front/post');
			
			$layout_id = $this->model_front_post->getpostLayoutId($this->request->get['post_id']);
		}

		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$this->load->model('front/information');
			
			$layout_id = $this->model_front_information->getInformationLayoutId($this->request->get['information_id']);
		}

		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($route);
		}

		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		}

		$data['modules'] = array();
		
		$modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_bottom');

		foreach ($modules as $module) {
			$part = explode('.', $module['code']);
			
			if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
				$data['modules'][] = $this->load->controller('module/' . $part[0]);
			}
			
			if (isset($part[1])) {
				$setting_info = $this->model_extension_module->getModule($part[1]);
				
				if ($setting_info && $setting_info['status']) {
					$data['modules'][] = $this->load->controller('module/' . $part[0], $setting_info);
				}
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/content_bottom.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/content_bottom.tpl', $data);
		} else {
			return $this->load->view('default/template/common/content_bottom.tpl', $data);
		}
	}
}