<?php
class ControllerDashboardChart extends Controller {
	public function index() {
		$this->load->language('dashboard/chart');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_day'] = $this->language->get('text_day');
		$data['text_week'] = $this->language->get('text_week');
		$data['text_month'] = $this->language->get('text_month');
		$data['text_year'] = $this->language->get('text_year');
		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		return $this->load->view('dashboard/chart.tpl', $data);
	}
	
	public function chart() {
		$this->load->language('dashboard/chart');

		$json = array();
		
		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'day';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}