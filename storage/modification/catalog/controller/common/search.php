<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}


		$this->load->language('cyberstore/lang');
		$data['text_search_word'] = $this->language->get('text_search_word');
		$data['search_word_bd'] = $this->config->get('search_word');
		if(!empty($data['search_word_bd'][$this->config->get('config_language_id')]['text'])) {
			$search_word_explode = explode(",", $data['search_word_bd'][$this->config->get('config_language_id')]['text']);
			if (count($search_word_explode) > 2) {
				$random_word = array_rand($search_word_explode, 2);
				$data['search_word'] = $search_word_explode[$random_word[0]];
			} else {
				$data['search_word'] = $data['search_word_bd'][$this->config->get('config_language_id')]['text'];
			}
		} else {
		$data['search_word'] = '';
		}
		$data['ns_autosearch_data'] = $this->config->get('ns_autosearch_data');
		$data['text_autosearch_model'] = $this->language->get('text_autosearch_model');
		$data['text_autosearch_manufacturer'] = $this->language->get('text_autosearch_manufacturer');
		$data['text_autosearch_stock_status'] = $this->language->get('text_autosearch_stock_status');
		$data['text_autosearch_view_all'] = $this->language->get('text_autosearch_view_all');
		if (isset($this->request->get['filter_category_id'])) {
			$data['filter_category_id'] = $this->request->get['filter_category_id'];
		} else {
			$data['filter_category_id'] = 0;
		}
		$data['text_search_everywhere'] = $this->language->get('text_search_everywhere');
		$data['text_category'] = $this->language->get('text_category');

		$data['categories'] = array();
		$data['show_hc_search'] = (!empty($this->config->get('show_hc_search')) ? 1 : 0);
		if($data['show_hc_search'] == 1){
		$search_category = $this->cache->get('searchcategory.' . (int)$this->config->get('config_language_id').'.'. (int)$this->config->get('config_store_id'));
		if (!empty($search_category)) {
			$data['categories'] = $search_category;
		} else {
			$this->load->model('catalog/category');
			$categories = $this->model_catalog_category->getCategories(0);
			foreach ($categories as $category) {
					$data['categories'][] = array(
						'name'     => $category['name'],
						'category_id'  => $category['category_id'],
					);
			}
			$search_category = $data['categories'];
			$this->cache->set('searchcategory.' . (int)$this->config->get('config_language_id') . '.'. (int)$this->config->get('config_store_id'), $search_category);
		}
		}
		
		return $this->load->view('common/search', $data);
	}
}