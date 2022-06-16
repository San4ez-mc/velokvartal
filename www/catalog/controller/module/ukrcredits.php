<?php
class ControllerModuleUkrcredits extends Controller {

	public function index() {
		$status = false;
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$ukrcredits_setting = $this->config->get($type.'ukrcredits_settings');
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['ukrcredits_button_name'] = $ukrcredits_setting['button_name'][$this->config->get('config_language_id')];
		$data['ukrcredits_css_button'] = $ukrcredits_setting['css_button'];		
		$data['ukrcredits_icons_size'] = $ukrcredits_setting['icons_size'];
		$data['ukrcredits_show_icons'] = $ukrcredits_setting['show_icons'];

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }
		
		$this->load->model('catalog/product');
		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$this->load->model('module/ukrcredits');
			$data['credits_data'] = $this->model_module_ukrcredits->checkproduct($product_info);			
			if ($data['credits_data']['pp'] || $data['credits_data']['ii'] || $data['credits_data']['mb']) {
				$status = true;
				$pricemin = array();
				foreach ($data['credits_data'] as $cdata) {
					if (isset($cdata['mounthprice_int']) && $cdata['mounthprice_int']){
						$pricemin[] = $cdata['mounthprice_int'];
					}
				}
				$minmounthprice = strip_tags($this->currency->format($this->tax->calculate(min($pricemin), $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
				$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
				$this->load->language($dir.'/ukrcredits');
				$data['minmounthprice_text'] = sprintf($this->language->get('text_min'), $minmounthprice);
			}
		}

		if ($status) {
			if (version_compare(VERSION, '3.0.0', '>=')) {
				$template_engine = $this->registry->get('config')->get('template_engine');
				$template_directory = $this->registry->get('config')->get('template_directory');
				$this->registry->get('config')->set('template_engine', 'template');
				if (!file_exists(DIR_TEMPLATE . $template_directory . 'module/ukrcredits_button' . '.tpl')) {
					$this->registry->get('config')->set('template_directory', 'default/template/');
				}
				$template = $this->load->view('module/ukrcredits_button', $data);
				
				$this->registry->get('config')->set('template_engine', $template_engine);
				$this->registry->get('config')->set('template_directory', $template_directory);
				
				return $template;
			} else if (version_compare(VERSION,'2.2','>=')) {
				return $this->load->view('module/ukrcredits_button', $data); 
			} else if (version_compare(VERSION,'2.0','>=')) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ukrcredits_button.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/module/ukrcredits_button.tpl', $data);
				} else {
					return $this->load->view('default/template/module/ukrcredits_button.tpl', $data);
				}
			} else {
				$this->data = $data;
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ukrcredits_button.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/ukrcredits_button.tpl';
				} else {
					$this->template = 'default/template/module/ukrcredits_button.tpl';
				}
				$this->render();
			}
		}
    }
	
	public function loadpopup(){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$this->load->language($dir.'/ukrcredits');		
		$ukrcredits_setting = $this->config->get($type.'ukrcredits_settings');
		$data['ukrcredits_setting'] = $this->config->get($type.'ukrcredits_settings');
		$data['ukrcredits_selector_block'] = $ukrcredits_setting['selector_block'];
		$data['ukrcredits_icons_size'] = $ukrcredits_setting['icons_size'];
		$data['currency_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
		$data['currency_right'] = $this->currency->getSymbolRight($this->session->data['currency']);		
		$data['text_credithead'] = $this->language->get('text_credithead');

		$data['text_mounth'] = $this->language->get('text_mounth');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_payments'] = $this->language->get('text_payments');
		$data['text_submit'] = $this->language->get('text_submit');
		$data['text_per'] = $this->language->get('text_per');
		$data['text_total'] = $this->language->get('text_total');
		
		$data['credit_text'] = $this->language->get('credit_text');
		
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->get['quantity'])) {
				$quantity = $this->request->get['quantity'];
			} else {
				$quantity = 1;
			}
														
			if (isset($this->request->get['option'])) {
				$option = array_filter($this->request->get['option']);
			} else {
				$option = array();	
			}
		}

		$this->load->model('module/ukrcredits');
		$data['credits_data'] = $this->model_module_ukrcredits->checkproduct($product_info, $quantity, $option);			

		if (version_compare(VERSION, '3.0.0', '>=')) {
			$template_engine = $this->registry->get('config')->get('template_engine');
			$template_directory = $this->registry->get('config')->get('template_directory');
			$this->registry->get('config')->set('template_engine', 'template');
			if (!file_exists(DIR_TEMPLATE . $template_directory . 'module/ukrcredits' . '.tpl')) {
				$this->registry->get('config')->set('template_directory', 'default/template/');
			}
			$template = $this->load->view('module/ukrcredits', $data);
			$this->registry->get('config')->set('template_engine', $template_engine);
			$this->registry->get('config')->set('template_directory', $template_directory);					
			$this->response->setOutput($template);					
		} else if (version_compare(VERSION,'2.2','>=')) {
			$this->response->setOutput($this->load->view('module/ukrcredits', $data));
		} else if (version_compare(VERSION,'2.0','>=')) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ukrcredits.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/ukrcredits.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/module/ukrcredits.tpl', $data));
			}
		} else {
			$this->data = $data;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ukrcredits.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/ukrcredits.tpl';
			} else {
				$this->template = 'default/template/module/ukrcredits.tpl';
			}
			$this->response->setOutput($this->render());
		}
    }
	
    public function checkoptions() {

		$this->language->load('checkout/cart');
		
		$json = array();
		
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
						
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {			
			if (isset($this->request->post['quantity'])) {
				$quantity = $this->request->post['quantity'];
			} else {
				$quantity = 1;
			}
														
			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();	
			}
			
			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
			
			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}
			
			if (!$json) {
				$json['success'] = true;
			}
		}
		
		$this->response->setOutput(json_encode($json));		
    }
	
	public function controller(&$route) {
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		$part = explode('/', $route);
		
		if (isset($part[2]) && $part[0] == 'extension' && !is_file(DIR_APPLICATION . 'controller/' . $route . '.php') && is_file(DIR_APPLICATION . 'controller/' . $part[1] . '/' . $part[2] . '.php')) {
			$route = $part[1] . '/' . $part[2];
		}
	}
	
	public function beforeModel(&$route) {
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		$part = explode('/', $route);

		if (!is_file(DIR_APPLICATION . 'model/' . $route . '.php') && is_file(DIR_APPLICATION . 'model/' . $part[1] . '/' . $part[2] . '.php')) {
			$route = $part[1] . '/' . $part[2];
		}
	}
	
	public function afterModel(&$route) {
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		$part = explode('/', $route);
					
		$this->{'model_extension_' . $part[0] . '_' . $part[1]} = $this->{'model_' . $part[0] . '_' . $part[1]};
	}
}