<?php
class ControllerDashboardActivity extends Controller {
	public function index() {
		$this->load->language('dashboard/activity');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['token'] = $this->session->data['token'];

		$data['activities'] = array();


		return $this->load->view('dashboard/activity.tpl', $data);
	}
}
