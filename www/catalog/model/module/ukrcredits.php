<?php
class ModelModuleUkrcreditsMain extends Model {

	public function checkproduct($product, $quantity = 1, $options = false, $price = false, $specialprice = false) {
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->load->language($dir.'/ukrcredits');
		$status_pp = false;
		$status_ii = false;
		$status_mb = false;
		$replace_array = array($this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));
		
		if ($this->config->get($type.'ukrcredits_status')) {
			$credit_info = $this->getProductUkrcredit($product['product_id']);

			if (($setting['pp_status'] && ($setting['pp_stock'] && $product['quantity'])) || ($setting['pp_status'] && !$setting['pp_stock'])) {
				if (
					(!$setting['pp_product_allowed'] && !$setting['pp_enabled']) || 
					($setting['pp_product_allowed'] && in_array($product['product_id'], $setting['pp_product_allowed'])) ||
					($setting['pp_enabled'] && isset($credit_info['product_pp']) && $credit_info['product_pp'])
					) {
					$status_pp = true;
				}
				if ($status_pp) {
					$pp_price = $product['price'];
					if (!$setting['pp_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$pp_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['pp_special'] && (float)$product['special']) {
						$pp_price = $product['special'];
					}
					if ($setting['pp_min_total'] >= $pp_price || $setting['pp_max_total'] <= $pp_price) {
						$status_pp = false;
					}
					
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $pp_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $pp_price = $new_price;
					  $option_price = $new_option_price;
					}
					
					$partsCountpp = (isset($credit_info['partscount_pp']) && $credit_info['partscount_pp'] !=0) ? $credit_info['partscount_pp'] : (!$setting['pp_pq'] ? '24' : $setting['pp_pq']);
					$markup_pp = (isset($credit_info['markup_pp']) && $credit_info['markup_pp'] !=0) ? $credit_info['markup_pp'] : (!$setting['pp_markup'] ? '24' : $setting['pp_markup']);
					$pp_price = ($pp_price + $option_price) * $markup_pp * $quantity;
					$pp_type = $setting['pp_merchantType'];
					if ($pp_type == 'PP') {
						$mounthprice_int_pp = $pp_price*$markup_pp/($partsCountpp+1);
						if ($setting['pp_markup_type'] == 'custom') {
							$mounthprice_int_pp = $pp_price*(1+(($setting['pp_markup_acquiring']+$setting['pp_markup_custom_PP'][$partsCountpp])/100))/($partsCountpp+1); 
						}						
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_pp, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_pp = sprintf($this->language->get('text_min_pp'), $partsCountpp, $mounthprice);
						$pp_name = $this->language->get('text_title_pp');
					} else {
						$mounthprice_int_pp = $pp_price*$markup_pp/($partsCountpp+1);
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_pp, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_pp = sprintf($this->language->get('text_min_pb'), $partsCountpp, $mounthprice);
						$pp_name = $this->language->get('text_title_pb');
					}
					if ($price) {
						$pp_price = $price;
						if (!$setting['pp_special'] && $specialprice) {
							$pp_price = $specialprice;
						}						
					} else {
						$pp_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($pp_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}

			if (($setting['ii_status'] && ($setting['ii_stock'] && $product['quantity'])) || ($setting['ii_status'] && !$setting['ii_stock'])) {
				if (
					(!$setting['ii_product_allowed'] && !$setting['ii_enabled']) || 
					($setting['ii_product_allowed'] && in_array($product['product_id'], $setting['ii_product_allowed'])) ||
					($setting['ii_enabled'] && isset($credit_info['product_ii']) && $credit_info['product_ii'])
					) {
					$status_ii = true;
				}
				if ($status_ii) {
					$ii_price = $product['price'];
					if (!$setting['ii_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$ii_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['ii_special'] && (float)$product['special']) {
						$ii_price = $product['special'];
					}
					if ($setting['ii_min_total'] >= $ii_price || $setting['ii_max_total'] <= $ii_price) {
						$status_ii = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $ii_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $ii_price = $new_price;
					  $option_price = $new_option_price;
					}
					$partsCountii = (isset($credit_info['partscount_ii']) && $credit_info['partscount_ii'] !=0) ? $credit_info['partscount_ii'] : (!$setting['ii_pq'] ? '24' : $setting['ii_pq']);
					$markup_ii = (isset($credit_info['markup_ii']) && $credit_info['markup_ii'] !=0) ? $credit_info['markup_ii'] : (!$setting['ii_markup'] ? '24' : $setting['ii_markup']);
					$ii_price = ($ii_price + $option_price) * $markup_ii * $quantity;
					$ii_type = $setting['ii_merchantType'];
					if ($ii_type == 'II') {
						$mounthprice_int_ii = ($ii_price*$markup_ii/($partsCountii+1))+(($ii_price*$markup_ii)*(2.9/100));
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_ii, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_ii = sprintf($this->language->get('text_min_ii'), $partsCountii, $mounthprice);
						$ii_name = $this->language->get('text_title_ii');
					} else {
						$mounthprice_int_ii = ($ii_price*$markup_ii/($partsCountii+1))+(($ii_price*$markup_ii)*(0.99/100));
						if ($setting['ii_markup_type'] == 'custom') {
							$mounthprice_int_ii = ($ii_price*(1+(($setting['ii_markup_acquiring']+$setting['ii_markup_custom_II'][$partsCountii])/100))/($partsCountii+1))+(($ii_price*$markup_ii)*(0.99/100));
						}	
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_ii, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_ii = sprintf($this->language->get('text_min_ia'), $partsCountii, $mounthprice);
						$ii_name = $this->language->get('text_title_ia');
					}
					if ($price) {
						$ii_price = $price;
						if (!$setting['ii_special'] && $specialprice) {
							$ii_price = $specialprice;
						}	
					} else {
						$ii_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($ii_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
			
			if (($setting['mb_status'] && ($setting['mb_stock'] && $product['quantity'])) || ($setting['mb_status'] && !$setting['mb_stock'])) {
				if (
					(!$setting['mb_product_allowed'] && !$setting['mb_enabled']) || 
					($setting['mb_product_allowed'] && in_array($product['product_id'], $setting['mb_product_allowed'])) ||
					($setting['mb_enabled'] && isset($credit_info['product_mb']) && $credit_info['product_mb'])
					) {
					$status_mb = true;
				}
				if ($status_mb) {
					$mb_price = $product['price'];
					if (!$setting['mb_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$mb_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['mb_special'] && (float)$product['special']) {
						$mb_price = $product['special'];
					}
					if ($setting['mb_min_total'] >= $mb_price || $setting['mb_max_total'] <= $mb_price) {
						$status_mb = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $mb_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $mb_price = $new_price;
					  $option_price = $new_option_price;
					}
					$partsCountmb = (isset($credit_info['partscount_mb']) && $credit_info['partscount_mb'] !=0) ? $credit_info['partscount_mb'] : (!$setting['mb_pq'] ? '24' : $setting['mb_pq']);
					$markup_mb = (isset($credit_info['markup_mb']) && $credit_info['markup_mb'] !=0) ? $credit_info['markup_mb'] : (!$setting['mb_markup'] ? '24' : $setting['mb_markup']);
					$mb_price = ($mb_price + $option_price) * $markup_mb * $quantity;
					$mb_type = $setting['mb_merchantType'];
					$mounthprice_int_mb = ($mb_price*$markup_mb/($partsCountmb+1));
						if ($setting['mb_markup_type'] == 'custom') {
							$mounthprice_int_mb = $mb_price*(1+(($setting['mb_markup_acquiring']+$setting['mb_markup_custom_MB'][$partsCountmb])/100))/($partsCountmb+1); 
						}	
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_mb, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_mb = sprintf($this->language->get('text_min_mb'), $partsCountmb, $mounthprice);
					$mb_name = $this->language->get('text_title_mb');
					if ($price) {
						$mb_price = $price;
						if (!$setting['mb_special'] && $specialprice) {
							$mb_price = $specialprice;
						}
					} else {
						$mb_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($mb_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
		}		
		if ($status_pp) {
			$pp = array(
				'type' => $pp_type,
				'price' => $pp_price,
				'mounthprice_int' => $mounthprice_int_pp,
				'partsCount' => $partsCountpp,
				'partsCountSel' => isset($this->session->data['ukrcredits_pp_sel'])?$this->session->data['ukrcredits_pp_sel']:'',
				'name' => $pp_name,
				'info' => $this->language->get('text_info_'.$pp_type),
				'mounthprice_text' => $mounthprice_text_pp,
				'sort_order' => $setting['pp_sort_order']
			);
		} else {
			$pp = false;
		}
		
		if ($status_ii) {
			$ii = array(
				'type' => $ii_type,
				'price' => $ii_price,
				'mounthprice_int' => $mounthprice_int_ii,
				'partsCount' => $partsCountii,
				'partsCountSel' => isset($this->session->data['ukrcredits_ii_sel'])?$this->session->data['ukrcredits_ii_sel']:'',
				'name' => $ii_name,
				'info' => $this->language->get('text_info_'.$ii_type),
				'mounthprice_text' => $mounthprice_text_ii,
				'sort_order' => $setting['ii_sort_order']
			);
		} else {
			$ii = false;
		}
		
		if ($status_mb) {
			$mb = array(
				'type' => $mb_type,
				'price' => $mb_price,
				'mounthprice_int' => $mounthprice_int_mb,
				'partsCount' => $partsCountmb,
				'partsCountSel' => isset($this->session->data['ukrcredits_mb_sel'])?$this->session->data['ukrcredits_mb_sel']:'',
				'name' => $mb_name,
				'info' => $this->language->get('text_info_'.$mb_type),
				'mounthprice_text' => $mounthprice_text_mb,
				'sort_order' => $setting['mb_sort_order']
			);
		} else {
			$mb = false;
		}
		
		$credits_data = array(
			'pp' => $pp,
			'ii' => $ii,
			'mb' => $mb,
		);
	
		uasort($credits_data, $this->sort_function('sort_order'));

		return $credits_data;
	}

	private function sort_function($key){
		return function ($a, $b) use ($key) {
			return !empty($a[$key]) && !empty($b[$key]) ? strnatcmp($a[$key], $b[$key]) : false;
		};
	}
}

if (version_compare(phpversion(), '5.6', '<')) {
	require_once 'uc/uc54.php';
} elseif (version_compare(phpversion(), '7.1', '<')) {
	require_once 'uc/uc56.php';
} else {
	require_once 'uc/uc71.php';
}