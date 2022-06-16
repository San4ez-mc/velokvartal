<?php
class ModelTotalTotalukrcredits extends Model {
	public function getTotal($total) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$typetotal = version_compare(VERSION,'3.0','>=') ? 'total_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/total' : 'total';
		if ($this->config->get($typetotal.'totalukrcredits_status')) {
			$this->load->language($dir.'/totalukrcredits');
			$setting = $this->config->get($type.'ukrcredits_settings');

			$products = $this->cart->getProducts();
 			$priceup = 0;
			
			foreach ($products as $product) {
				$ucmarkup = 1;
				
				if (isset($this->session->data['payment_method']['code'])) {
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_pp') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_pp']) && $ukrcredits_query->row['markup_pp'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_pp'];
							} else {
								$ucmarkup = $setting['pp_markup'];
							}
						}
						if ($setting['pp_markup_type'] == 'custom') {
							$ukrcredits_pp_sel = isset($this->session->data['ukrcredits_pp_sel'])?$this->session->data['ukrcredits_pp_sel']:1;
							$ucmarkup = ($setting['pp_markup_custom_PP'][$ukrcredits_pp_sel] + $setting['pp_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_ii') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_ii']) && $ukrcredits_query->row['markup_ii'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_ii'];
							} else {
								$ucmarkup = $setting['ii_markup'];
							}
						}
						if ($setting['ii_markup_type'] == 'custom') {
							$ukrcredits_ii_sel = isset($this->session->data['ukrcredits_ii_sel'])?$this->session->data['ukrcredits_ii_sel']:1;
							$ucmarkup = ($setting['ii_markup_custom_II'][$ukrcredits_ii_sel] + $setting['ii_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_mb') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_mb']) && $ukrcredits_query->row['markup_mb'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_mb'];
							} else {
								$ucmarkup = $setting['mb_markup'];
							}
						}
						if ($setting['mb_markup_type'] == 'custom') {
							$ukrcredits_mb_sel = isset($this->session->data['ukrcredits_mb_sel'])?$this->session->data['ukrcredits_mb_sel']:1;
							$ucmarkup = ($setting['mb_markup_custom_MB'][$ukrcredits_mb_sel] + $setting['mb_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
				}
			}
			
			if ($priceup > 0) {
				if (version_compare(VERSION,'2.2','>=')) {
					$total['totals'][] = array(
						'code'       => 'totalukrcredits',
						'title'      => $this->language->get('text_credit'),
						'value'      => $priceup,
						'sort_order' => $this->config->get($typetotal.'totalukrcredits_sort_order')
					);
					$total['total'] += $priceup;
				} else {
					$total_data[] = array(
						'code'       => 'totalukrcredits',
						'title'      => $this->language->get('text_credit'),
						'value'      => $priceup,
						'sort_order' => $this->config->get($typetotal.'totalukrcredits_sort_order')
					);					
					$total += $priceup;
				}
			}
		}
	}
}