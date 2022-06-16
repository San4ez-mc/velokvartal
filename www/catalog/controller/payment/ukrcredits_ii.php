<?php
class ControllerPaymentUkrcreditsIi extends Controller {
	
    public function index() {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$data['ukrcredits_setting'] = $this->config->get($type.'ukrcredits_settings');
        $this->language->load($dir.'/ukrcredits');
		$data['currency_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
		$data['currency_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_mounth'] = $this->language->get('text_mounth');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_payments'] = $this->language->get('text_payments');
		$data['text_per'] = $this->language->get('text_per');
		$data['text_total'] = $this->language->get('text_total');
		
        $partsCount = 24;
		foreach ($this->cart->getProducts() as $cart) {
			$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$cart['product_id'] . "'");
			if ($privat_query->row) {
				if ($privat_query->row['partscount_ii'] <= $partsCount && $privat_query->row['partscount_ii'] !=0) {
					$partsCount = (int)$privat_query->row['partscount_ii'];
				}
			}
		}
		if ($partsCount == 24) {
			$partsCount = $setting['ii_pq'];
		}
		
		$this->load->model('module/ukrcredits');
		if (!$this->model_module_ukrcredits->checklicense()) {
			return false;
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
        $data['action'] = $this->url->link('payment/ukrcredits_ii/sendDataDeal', '', 'SSL');	
		
		$data['credit'] = array(
			'type' => $setting['ii_merchantType'],
			'name' => $this->language->get('text_title_'.mb_strtolower($setting['ii_merchantType'])),
			'partsCount' => $partsCount,
			'price' => $data['total']
		);
		
		if (isset($this->session->data['ukrcredits_ii_sel'])) {
			$data['credit']['partsCountSel'] = $this->session->data['ukrcredits_ii_sel'];
		} else {
			$data['credit']['partsCountSel'] = '';
		}
		
		$data['oc15'] = false;
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$template_engine = $this->registry->get('config')->get('template_engine');
			$template_directory = $this->registry->get('config')->get('template_directory');
			$this->registry->get('config')->set('template_engine', 'template');
			if (!file_exists(DIR_TEMPLATE . $template_directory . 'payment/ukrcredits' . '.tpl')) {
				$this->registry->get('config')->set('template_directory', 'default/template/');
			}
			$template = $this->load->view('payment/ukrcredits', $data);
			
			$this->registry->get('config')->set('template_engine', $template_engine);
			$this->registry->get('config')->set('template_directory', $template_directory);
			
			return $template;
		} else if (version_compare(VERSION,'2.2','>=')) {
			return $this->load->view('payment/ukrcredits', $data); 
		} else if (version_compare(VERSION,'2.0','>=')) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ukrcredits.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/payment/ukrcredits.tpl', $data);
			} else {
				return $this->load->view('default/template/payment/ukrcredits.tpl', $data);
			}
		} else {
			$data['oc15'] = true;
			$this->data = $data;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ukrcredits.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/ukrcredits.tpl';
			} else {
				$this->template = 'default/template/payment/ukrcredits.tpl';
			}
			$this->render();			
		}
    }
    
    private function generateAnswerSignature ($dataAnsweArr){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
        $passwordStore = $setting['ii_shop_password'];
        $storeId = $setting['ii_shop_id'];
        
        $signatureAnswerStr = $passwordStore.
                              $storeId.
                              $dataAnsweArr['orderId'].
                              $dataAnsweArr['paymentState'].
                              $dataAnsweArr['message'].
                              $passwordStore;
                              
        $signatureAnswer = base64_encode(SHA1($signatureAnswerStr, true));		
		
        return $signatureAnswer;                               
        
    }
    
    private function generateSignature ($dataArr){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
        $productsString = '';
        $signatureStr = '';
        $amountStr ='';
        $passwordStore ='';
        $signature ='';
        $decimalSeparatorArr = array(",", ".");
        foreach ($dataArr['products'] as $key_product=>$val_product) {
              if(!fmod(round($val_product['price'],2),1)){
                $valProductPrice = round($val_product['price'],2).'00';  
              }else{
                $valProductPrice = round($val_product['price'],2);
                $valProductPriceRateArr = explode('.', $valProductPrice);  
                if(strlen($valProductPriceRateArr[1])==1){
                   $valProductPrice = $valProductPrice.'0'; 
                }
              }              
              $productPrice = str_replace($decimalSeparatorArr,'',$valProductPrice);            

              $productsString .= $val_product['name'].$val_product['count'].$productPrice;              
        }
        
        if(!fmod(round($dataArr['amount'],2),1)){
            $dataArrAmount = round($dataArr['amount'],2).'00';
        }else{
             $dataArrAmount = round($dataArr['amount'],2);
             $dataArrAmountRateArr = explode('.', $dataArrAmount);  
             if(strlen($dataArrAmountRateArr[1])==1){
                $dataArrAmount = $dataArrAmount.'0'; 
             }             
        }
        $amountStr = str_replace($decimalSeparatorArr,'',$dataArrAmount);
        $passwordStore = $setting['ii_shop_password'];
                        
        $signatureStr = $passwordStore.
                        $dataArr['storeId'].
                        $dataArr['orderId'].
                        $amountStr.
 //                       $dataArr['currency'].
                        $dataArr['partsCount'].
                        $dataArr['merchantType'].
                        $dataArr['responseUrl'].
                        $dataArr['redirectUrl'].
                        $productsString.
                        $passwordStore;                       

		$signature = base64_encode ( SHA1 ($signatureStr, true)); 

        return $signature;       
    }
    
    private function generateOrderId($orderId,$length = 64){
      $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
      $numChars = strlen($chars);
      $string = '';
      for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
      }
      
      $stringRes = substr($string,0,(int)strlen($string)-(int)strlen('_'.$orderId)).'_'.$orderId;
      
      return $stringRes;
    }
    
    private function clearCartOnSuccess($order_id){
        
        if (isset($this->session->data['order_id'])) {
            $this->cart->clear();

            // Add to activity log
            $this->load->model('account/activity');

            if ($this->customer->isLogged()) {
                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                    'order_id'    => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_account', $activity_data);
            } else {
                $activity_data = array(
                    'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
                    'order_id' => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_guest', $activity_data);
            }

            unset($this->session->data['shiiiing_method']);
            unset($this->session->data['shiiiing_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        } 
    }

	public function setUkrcreditsType(){
		$json = array();
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
		$this->language->load($dir.'/ukrcredits');
		$this->session->data['payment_method']['title'] = $this->language->get('text_title_ii');
		$this->session->data['payment_method']['code'] = 'ukrcredits_ii';
		setcookie('payment_method', 'ukrcredits_ii', time() + 60 * 60 * 24 * 30);
		$this->session->data['ukrcredits_ii_sel'] = $this->request->post['partsCount'];        
        $json['success'] = TRUE;
 
		if ($this->request->get['route'] != 'checkout/checkout') {
           $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}       

		$this->response->setOutput(json_encode($json));
	}
	
    public function sendDataDeal(){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
        $this->load->model('checkout/order');
		$this->load->model('module/ukrcredits');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
           
        if ($order_info) {
            $data_deal['storeId'] = $setting['ii_shop_id'];
            $data_deal['orderId'] = $this->generateOrderId($order_info['order_id']);
            $data_deal['partsCount'] = $this->request->post['partsCount'];
            $data_deal['merchantType'] = $setting['ii_merchantType'];
            $data_deal['products'] = array();
			
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
				$totals = $total_data;
			}


			$sumtotal =0;
			$discount = 0;

			foreach ($totals as $total) {
				if (($total['code'] != 'sub_total') && ($total['code'] != 'total')) {
					if ($total['value'] > 0) {
						$data_deal['products'][] = array(
							'name' => utf8_substr(strip_tags(html_entity_decode(trim($total['title']), ENT_QUOTES, 'UTF-8')), 0, 128),
							'count' => 1,
							'price'    => $this->currency->format($total['value'], 'UAH', '', false)
						);
						$sumtotal += $this->currency->format($total['value'], 'UAH', '', false);
					} else {
						$discount += abs($this->currency->format($total['value'], 'UAH', '', false));
					}
				}
			}

			$productquantity = $this->cart->countProducts();
			$minus = $discount / $productquantity;

            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], 'UAH', '', false) - $minus) <= 0) {
					$productquantity = $productquantity - $product['quantity'];
					$data_deal['products'][] = array(
						'name'     => utf8_substr(strip_tags(html_entity_decode(trim($product['name']), ENT_QUOTES, 'UTF-8')), 0, 128),
						'count' => $product['quantity'],
						'price'    => $this->currency->format($product['price'], 'UAH', '', false)
					);
					$sumtotal += $this->currency->format($product['price'], 'UAH', '', false) * $product['quantity'];
				}
            }
			$minus = $discount / $productquantity;
            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], 'UAH', '', false) - $minus) > 0) {
					$data_deal['products'][] = array(
						'name'     => utf8_substr(strip_tags(html_entity_decode(trim($product['name']), ENT_QUOTES, 'UTF-8')), 0, 128),
						'count' => $product['quantity'],
						'price'    => $this->currency->format($product['price'], 'UAH', '', false) - $minus
					);
					$sumtotal += ($this->currency->format($product['price'], 'UAH', '', false) - $minus) * $product['quantity'];
				}
            }	
			
			$data_deal['amount'] = $sumtotal;

            $data_deal['responseUrl'] = $this->url->link('payment/ukrcredits_ii/callback', '', 'SSL');
            $data_deal['redirectUrl'] = $this->url->link('checkout/checkout');
            $data_deal['signature'] = $this->generateSignature($data_deal);
        }

        $requestDial = json_encode($data_deal);       
		if ($setting['ii_hold']) {
			$url = 'https://payparts2.privatbank.ua/ipp/v2/payment/hold';
		} else {
			$url = 'https://payparts2.privatbank.ua/ipp/v2/payment/create';
		}        
     
        $responseResDeal = $this->model_module_ukrcredits->curlPostWithData($url,$requestDial);

        if(is_array($responseResDeal)){
            if(strcmp($responseResDeal['state'], 'FAIL') == 0){
                $this->log->write('ukrcredits_ii :: DATA DEAL failed: ' . json_encode($responseResDeal));                
            }
			if(isset($responseResDeal['state']) && $responseResDeal['state'] != 'FAIL') {
				$paymenttype = 'II';
				$comment = $this->language->get('text_status_CLIENT_WAIT') . ' / '. ($data_deal['partsCount']-1) . ' ' . $this->language->get('text_mounth');
				$this->model_checkout_order->setUkrcreditsOrderId($order_info['order_id'], $paymenttype, $responseResDeal['orderId'], 'CLIENT_WAIT');
				if (version_compare(VERSION,'2.0','>=')) {
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $setting['clientwait_status_id'], $comment);
				} else {
					$this->model_checkout_order->confirm($order_info['order_id'], $setting['clientwait_status_id'], $comment, $notify = true);
				}
			}
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
     
    }                        

    public function callback() {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
        $requestPostRaw = file_get_contents('php://input');        
        $requestArr = json_decode(trim($requestPostRaw),true);

        $this->load->model('checkout/order');

        $orderIdArr = explode('_',$requestArr['orderId']);
        $order_id = $orderIdArr[1];
		$privat_order_id = $requestArr['orderId'];
		$privat_order_status = $requestArr['paymentState'];
        $comment = $requestArr['message'];
        $localAnswerSignature = $this->generateAnswerSignature ($requestArr);
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        if ($order_info) {        
            if (strcmp($requestArr['signature'], $localAnswerSignature) == 0) {
                switch($requestArr['paymentState']) {
                  case 'SUCCESS':
                      $order_status_id = $setting['completed_status_id'];
                      $this->clearCartOnSuccess($order_id);
                      break;
                  case 'LOCKED':
                      $order_status_id = $setting['created_status_id'];
                      $this->clearCartOnSuccess($order_id);
                      break;
                  case 'CANCELED':
                      $order_status_id = $setting['canceled_status_id'];
                      break;
                  case 'FAIL':
                      $order_status_id = $setting['failed_status_id'];
                      $this->log->write('ukrcredits_ii :: PAYMENT FAIL!  ORDER_ID:'.$order_id .' MESSAGE:'. $requestArr['message']);
                      break;
                  case 'REJECTED':
                      $order_status_id = $setting['rejected_status_id'];
                      $this->log->write('ukrcredits_ii :: PAYMENT REJECTED!  ORDER_ID:'.$order_id .' MESSAGE:'. $requestArr['message']);
                      break;                                                            
                }
				$this->model_checkout_order->updateUkrcreditsOrderPrivat($order_id, $privat_order_status);
				if (version_compare(VERSION,'2.0','>=')) {
					$this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $comment);
				} else {
					$this->model_checkout_order->update($order_id, $order_status_id, $comment, $notify = true);
				}               
                
            } else {
                $this->log->write('ukrcredits_ii :: RECEIVED SIGNATURE MISMATCH!  ORDER_ID:'.$order_id .' RECEIVED SIGNATURE:'. $requestArr['signature']);
				if (version_compare(VERSION,'2.0','>=')) {
					$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('config_order_status_id'));
				} else {
					$this->model_checkout_order->update($order_id, $this->config->get('config_order_status_id'), $notify = true);
				}
            } 
        }
    }
}