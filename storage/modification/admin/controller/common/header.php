<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

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

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());

		if (!isset($this->request->get['user_token']) || !isset($this->session->data['user_token']) || ($this->request->get['user_token'] != $this->session->data['user_token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/login', '', true);
		} else {
			$data['logged'] = true;

				$this->load->model('sale/newfastorder');
				$data['countfastorder'] = $this->model_sale_newfastorder->countTotalNewFastorder();
				$data['newfastorder'] = $this->url->link('sale/newfastorder', 'user_token=' . $this->session->data['user_token'], 'SSL');
				$data['title_fastorder'] = $this->language->get('title_fastorder');
			
	
				$this->load->model('extension/module/cyber_question_answer');
				$this->load->language('extension/module/cyber_question_answer'); 
				$data['heading_title'] = strip_tags($this->language->get('heading_title'));
				$question_answer = (array)$this->config->get('qadata');
				$data['question_answer'] = (array)$this->config->get('qadata'); 
				if (isset($question_answer['status']) && $question_answer['status']) {
					$data['title_icon_header_qa'] = $this->language->get('title_icon_header_qa');
					$data['countquestion_answer'] = $this->model_extension_module_cyber_question_answer->getTotalNewQuestionAnswer();
					$data['question_answer_url'] = $this->url->link('extension/module/cyber_question_answer', 'tablist=1&user_token=' . $this->session->data['user_token'], 'SSL');
				}									
			

			$data['home'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true);
			$data['logout'] = $this->url->link('common/logout', 'user_token=' . $this->session->data['user_token'], true);

			$this->load->model('catalog/reviews_store');
			$this->load->language('catalog/reviews_store'); 
			$data['countreviewsoff'] = $this->model_catalog_reviews_store->countTotalStatusOff();
			$data['link_reviews'] = $this->url->link('catalog/reviews_store', 'user_token=' . $this->session->data['user_token'], true);
			$data['text_reviews_store'] = $this->language->get('text_reviews_store');
			
	
				$this->load->model('extension/module/cyber_found_cheaper_product');
				$found_cheaper_product = (array)$this->config->get('fcpdata');
				$data['found_cheaper_product'] = (array)$this->config->get('fcpdata'); 
				if (isset($found_cheaper_product['status']) && $found_cheaper_product['status']) {
					$data['title_icon_header_fcp'] = $this->language->get('title_icon_header_fcp');
					$data['countfound_cheaper'] = $this->model_extension_module_cyber_found_cheaper_product->getTotalNewFoundCheaper();
					$data['found_cheaper_product_url'] = $this->url->link('extension/module/cyber_found_cheaper_product', 'tablist=1&user_token=' . $this->session->data['user_token'], 'SSL');
				}									
			

			$this->load->model('sale/callback');
			$data['countcallback'] = $this->model_sale_callback->countTotal();
			$data['callback'] = $this->url->link('sale/callback', 'user_token=' . $this->session->data['user_token'], 'SSL');
			$data['text_callback'] = $this->language->get('text_callback');
			
			$data['profile'] = $this->url->link('common/profile', 'user_token=' . $this->session->data['user_token'], true);
			$data['new_category'] = $this->url->link('catalog/category/add', 'user_token=' . $this->session->data['user_token'], true);
			$data['new_customer'] = $this->url->link('user/user/add', 'user_token=' . $this->session->data['user_token'], true);
			$data['new_download'] = $this->url->link('catalog/download/add', 'user_token=' . $this->session->data['user_token'], true);
			$data['new_manufacturer'] = $this->url->link('catalog/manufacturer/add', 'user_token=' . $this->session->data['user_token'], true);
			$data['new_product'] = $this->url->link('catalog/product/add', 'user_token=' . $this->session->data['user_token'], true);

			$this->load->model('user/user');

			$this->load->model('tool/image');

			$user_info = $this->model_user_user->getUser($this->user->getId());

			if ($user_info) {
				$data['firstname'] = $user_info['firstname'];
				$data['lastname'] = $user_info['lastname'];
				$data['username']  = $user_info['username'];
				$data['user_group'] = $user_info['user_group'];

				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
				} else {
					$data['image'] = $this->model_tool_image->resize('profile.png', 45, 45);
				}
			} else {
				$data['firstname'] = '';
				$data['lastname'] = '';
				$data['user_group'] = '';
				$data['image'] = '';
			}

			// Online Stores
			$data['stores'] = array();

			$data['stores'][] = array(
				'name' => $this->config->get('config_name'),
				'href' => HTTP_CATALOG
			);

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();

			foreach ($results as $result) {
				$data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}
		}

		$data['search'] = $this->load->controller('search/search');

		return $this->load->view('common/header', $data);
	}
}
