<?php
class ControllerModuleUkrcreditsSimple extends Controller {

	public function index(){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->load->language($dir.'/ukrcredits');	
		$data['ukrcredits_setting'] = $this->config->get($type.'ukrcredits_settings');
		$data['currency_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
		$data['currency_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_mounth'] = $this->language->get('text_mounth');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_payments'] = $this->language->get('text_payments');
		$data['text_per'] = $this->language->get('text_per');
		$data['text_total'] = $this->language->get('text_total');
		
		if (isset($this->request->get['uctype'])) {
            $type = $this->request->get['uctype'];
        } else {
            $type = false;
        }
		
		if ($type) {
			$partsCount = 24;
			foreach ($this->cart->getProducts() as $cart) {
				$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$cart['product_id'] . "'");
				if ($privat_query->row) {
					if ($privat_query->row['partscount_'.$type] <= $partsCount && $privat_query->row['partscount_'.$type] !=0) {
						$partsCount = (int)$privat_query->row['partscount_'.$type];
					}
				}
			}
			if ($partsCount == 24) {
				$partsCount = $setting[$type.'_pq'];
			}
			
			if (version_compare(VERSION, '3.0', '>=')) {
				// Totals
				$this->load->model('setting/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;
				
				// Because __call can not keep var references so we put them into an array. 			
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);
				
				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					$results = $this->model_setting_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get('total_' . $result['code'] . '_status')) {
							$this->load->model('extension/total/' . $result['code']);
							
							// We have to put the totals in an array so that they pass by reference.
							$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}			
			} else if (version_compare(VERSION, '2.3', '>=')) {

				// Totals
				$this->load->model('extension/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;

				// Because __call can not keep var references so we put them into an array.
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);
					
				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('extension/total/' . $result['code']);

							$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}
			} else if (version_compare(VERSION, '2.0', '>=')) {
				// Totals
				$this->load->model('extension/extension');
				$total_data = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();
				
				if(version_compare( VERSION, '2.2.0.0', '>=' )) {
					$total_data = array(
						'totals' => &$totals,
						'taxes'  => &$taxes,
						'total'  => &$total
					);
				}
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array();
						$results = $this->model_extension_extension->getExtensions('total');
						foreach ($results as $key => $value) {
							$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
						}
						array_multisort($sort_order, SORT_ASC, $results);
						foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);
								if(version_compare( VERSION, '2.2.0.0', '>=' )) {
								$this->{'model_total_' . $result['code']}->getTotal($total_data);
							} else {
								$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
							}
						}
					}
					$sort_order = array();
					if(version_compare( VERSION, '2.2.0.0', '>=' )) {
						foreach ($totals as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
						array_multisort($sort_order, SORT_ASC, $totals);
					} else {
						foreach ($total_data as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
						array_multisort($sort_order, SORT_ASC, $total_data);
						$totals = $total_data; 
					}
				}			
			} else {
				// Totals
				$this->load->model('setting/extension');
				
				$total_data = array();					
				$total = 0;
				$taxes = $this->cart->getTaxes();
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array(); 
					
					$results = $this->model_setting_extension->getExtensions('total');
					
					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}
					
					array_multisort($sort_order, SORT_ASC, $results);
					
					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);
				
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
						
						$sort_order = array(); 
					  
						foreach ($total_data as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
			
						array_multisort($sort_order, SORT_ASC, $total_data);
					}		
				}
			}
			
			$replace_array = array($this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));
			$data['total'] = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($total, $this->config->get('tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']));
			
			$data['credit'] = array(
				'type' => $setting[$type.'_merchantType'],
				'name' => $this->language->get('text_title_'.mb_strtolower($setting[$type.'_merchantType'])),
				'partsCount' => $partsCount,
				'price' => $data['total']
			);
			
			if (isset($this->session->data['ukrcredits_'.$type.'_sel'])) {
				$data['credit']['partsCountSel'] = $this->session->data['ukrcredits_'.$type.'_sel'];
			} else {
				$data['credit']['partsCountSel'] = '';
			}

			$data['oc15'] = false;
			if (version_compare(VERSION, '3.0.0', '>=')) {
				$template_engine = $this->registry->get('config')->get('template_engine');
				$template_directory = $this->registry->get('config')->get('template_directory');
				$this->registry->get('config')->set('template_engine', 'template');
				if (!file_exists(DIR_TEMPLATE . $template_directory . 'module/ukrcredits_simple' . '.tpl')) {
					$this->registry->get('config')->set('template_directory', 'default/template/');
				}
				$template = $this->load->view('module/ukrcredits_simple', $data);
				$this->registry->get('config')->set('template_engine', $template_engine);
				$this->registry->get('config')->set('template_directory', $template_directory);					
				$this->response->setOutput($template);					
			} else if (version_compare(VERSION,'2.2','>=')) {
				$this->response->setOutput($this->load->view('module/ukrcredits_simple', $data));
			} else if (version_compare(VERSION,'2.0','>=')) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ukrcredits_simple.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/ukrcredits_simple.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/module/ukrcredits_simple.tpl', $data));
				}
			} else {
				$data['oc15'] = true;
				$this->data = $data;
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ukrcredits_simple.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/ukrcredits_simple.tpl';
				} else {
					$this->template = 'default/template/module/ukrcredits_simple.tpl';
				}
				$this->response->setOutput($this->render());
			}
		}
    }
}