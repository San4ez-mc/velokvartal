<?php
class ControllerTotalTotalukrcredits extends Controller {
	private $error = array();

	public function index() {
		
		$token = version_compare(VERSION,'3.0','>=') ? 'user_' : '';
		$type = version_compare(VERSION,'3.0','>=') ? 'total_' : '';
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/total' : 'total';
		$total_page = version_compare(VERSION,'3.0','>=') ? 'marketplace/extension' :
			(version_compare(VERSION,'2.3','>=') ? 'extension/extension' : 'extension/total');
			
		$data['type'] = $type;
			
		$this->load->language($dir.'/totalukrcredits');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($type.'totalukrcredits', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link($total_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=total', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $token.'token=' . $this->session->data[$token.'token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link($total_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=total', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($dir.'/totalukrcredits', $token.'token=' . $this->session->data[$token.'token'], true)
		);

		$data['action'] = $this->url->link($dir.'/totalukrcredits', $token.'token=' . $this->session->data[$token.'token'], true);
		$data['cancel'] = $this->url->link($total_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=total', true);

		if (isset($this->request->post[$type.'totalukrcredits_status'])) {
			$data[$type.'totalukrcredits_status'] = $this->request->post[$type.'totalukrcredits_status'];
		} else {
			$data['totalukrcredits_status'] = $this->config->get($type.'totalukrcredits_status');
		}

		if (isset($this->request->post[$type.'totalukrcredits_sort_order'])) {
			$data[$type.'totalukrcredits_sort_order'] = $this->request->post[$type.'totalukrcredits_sort_order'];
		} else {
			$data['totalukrcredits_sort_order'] = $this->config->get($type.'totalukrcredits_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$template_engine = $this->registry->get('config')->get('template_engine');
			$template_directory = $this->registry->get('config')->get('template_directory');
			$this->registry->get('config')->set('template_engine', 'template');
			if (!file_exists(DIR_TEMPLATE . $template_directory . 'total/totalukrcredits' . '.tpl')) {
				$this->registry->get('config')->set('template_directory', 'default/template/');
			}
			$template = $this->load->view('total/totalukrcredits', $data);
			
			$this->registry->get('config')->set('template_engine', $template_engine);
			$this->registry->get('config')->set('template_directory', $template_directory);
			
			$this->response->setOutput($template);
		} else if (version_compare(VERSION,'2.3','>=')) {
			$this->response->setOutput($this->load->view('total/totalukrcredits', $data));
		} else {
			$this->response->setOutput($this->load->view('total/totalukrcredits.tpl', $data));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/totalukrcredits')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}