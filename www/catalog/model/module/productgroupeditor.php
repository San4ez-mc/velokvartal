<?php
class ModelModuleProductgroupeditor extends Model {
	public function editSettingGoogle($value) {
		$store_id = 0;
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `code` = 'google_api_key'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = 'google_api_key', `key` = 'config_google_api_key', `value` = '" . $this->db->escape($value) . "'");
	
	}
	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}
		return $product_description_data;
	}
	
	
	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer ORDER BY name ASC";
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	public function getProductManufacturers ($product_id) {
		$row = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id= '" . (int)$product_id. "'");
		if(isset($row->row['manufacturer_id'])){
			return $row->row['manufacturer_id'];
		}
		return '';
	}
	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getTaxClasses($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "tax_class";

			$sql .= " ORDER BY title";

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$tax_class_data = $this->cache->get('tax_class');

			if (!$tax_class_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax_class");

				$tax_class_data = $query->rows;

				$this->cache->set('tax_class', $tax_class_data);
			}

			return $tax_class_data;
		}
	}
	public function getStockStatuses($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "stock_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sql .= " ORDER BY name";

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$stock_status_data = $this->cache->get('stock_status.' . (int)$this->config->get('config_language_id'));

			if (!$stock_status_data) {
				$query = $this->db->query("SELECT stock_status_id, name FROM " . DB_PREFIX . "stock_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

				$stock_status_data = $query->rows;

				$this->cache->set('stock_status.' . (int)$this->config->get('config_language_id'), $stock_status_data);
			}

			return $stock_status_data;
		}
	}
	
	public function groupNameChange($data, $product_id){
		foreach ($data['product_description'] as $language_id => $value) {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET name='". $this->db->escape($value['name']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
		}
	}
	
	public function getProductSeo($product_id,$language_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$language_id . "'");

		return $query->row;
	}
	
	public function getProductCategory($product_id) {				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE `product_id` = '" . (int)$product_id . "'");
			
		return $query->rows;
	}
	public function getCategoryStore($category_id, $store) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . $category_id . "' AND c2s.store_id = '" . (int)$store . "'");
		
		return $query->rows;
	}
	public function getCategoryName($category_id,$language_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE `category_id` = '" . (int)$category_id . "' and `language_id` = '" . $language_id . "'");
		
		return $query->rows;
	}
	public function getManufacturerName($manufacturer_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer  WHERE manufacturer_id = '" . $manufacturer_id . "'");
		if($query->row){
			return $query->row['name'];
		} 
		
	}
	/*SEO DESCRIPTION*/
	public function groupMetaDescriptionChange($data, $product_id){
		if($data['seo_desc_method']=='seo_desc_del'){
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_meta_desc'] = $value['meta_description'];
				$seo['prod_meta_desc'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_desc']);
				$seo['prod_meta_desc'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_desc']);
				$seo['prod_meta_desc'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_desc']);
				$seo['prod_meta_desc'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_desc']);
				$seo['prod_meta_desc'] = str_replace('[c]', $category, $seo['prod_meta_desc']);
				$seo['prod_meta_desc'] = str_replace('[m]', $manufacturer, $seo['prod_meta_desc']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_meta_desc'], "[");			
					$pe = strpos($seo['prod_meta_desc'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_meta_desc'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_meta_desc'] = str_replace($n, $text, $seo['prod_meta_desc']);
						} 
					}
				}			
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_description='". $this->db->escape($seo['prod_meta_desc']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}		
		} else {
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);	
				if(empty($seo_data['meta_description'])){
					$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
					
					$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
					
					$rows = $this->getProductCategory($product_id);
					
					if (!empty($rows)) {
						$child = 0;
						for ($j=0; $j<100; $j++) {					
							if (!isset($rows[$j]['category_id'])) break;
							else if ((int)$rows[$j]['category_id'] > $child) {
								$child = $rows[$j]['category_id'];					
							}	
						}
						$rows = $this->getCategoryName($child,$language_id);
						if (!empty($rows)) $category = $rows[0]['name'];				
					}
					
					$seo['prod_meta_desc'] = $value['meta_description'];
					$seo['prod_meta_desc'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_desc']);
					$seo['prod_meta_desc'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_desc']);
					$seo['prod_meta_desc'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_desc']);
					$seo['prod_meta_desc'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_desc']);
					$seo['prod_meta_desc'] = str_replace('[c]', $category, $seo['prod_meta_desc']);
					$seo['prod_meta_desc'] = str_replace('[m]', $manufacturer, $seo['prod_meta_desc']);
					
					$br = 1;
					for ($i=0; $i<200; $i++) {	
						$pb = strpos($seo['prod_meta_desc'], "[");			
						$pe = strpos($seo['prod_meta_desc'], "]");
						if ($pe) {
							$br = 1;
							$n = substr($seo['prod_meta_desc'], $pb, $pe-$pb+1);
							if (substr_count($n, "|")) {
								$m = substr($n, 1, strlen($n)-2);
								$mm = explode("|", $m);						
								$text = $mm[rand(0, count($mm)-1)];
								$seo['prod_meta_desc'] = str_replace($n, $text, $seo['prod_meta_desc']);
							} 
						}
					}			
					$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_description='". $this->db->escape($seo['prod_meta_desc']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
				}
			}
		}
			
			
			
			
						
	}
	public function getSeoDescrptionSelected($seo_category_id){		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_seo_description WHERE category_id='". (int)$seo_category_id ."' AND selected_id='1'");
		
		return $query->row;
	}
	public function saveSeoDescription($data, $seo_category_id){
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_seo_description SET 
		category_id ='". (int)$seo_category_id ."', 
		selected_id ='0', 
		name_seo_template ='". $this->db->escape($data['name_seo_template']) ."',
		date_added = NOW(),
		data_seo_description ='". $this->db->escape(json_encode($data['product_description'])) ."'");		
	}
	public function applySeoDescription($seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_description SET selected_id ='0' WHERE category_id ='". (int)$seo_category_id ."'");
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_description SET date_added = NOW(), selected_id ='1' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function saveSeoDescriptionNew($data, $seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_description SET date_added = NOW(), name_seo_template ='". $this->db->escape($data['name_seo_template']) ."', data_seo_description ='". $this->db->escape(json_encode($data['product_description'])) ."' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function deleteSeoDescription($seo_id, $seo_category_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "edit_seo_description WHERE seo_id='". (int)$seo_id ."' AND category_id ='". (int)$seo_category_id ."'");
	}
	public function getSeoDescrption($data = array()) {
		$sql = "SELECT * FROM ". DB_PREFIX ."edit_seo_description WHERE category_id='". (int)$data['seo_category_id'] ."' GROUP BY seo_id ORDER BY date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalSeoDesc($seo_category_id) {
		$sql = "SELECT COUNT(*) AS total FROM ". DB_PREFIX ."edit_seo_description WHERE category_id='". (int)$seo_category_id ."'";
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	/*END SEO DESCRIPTION*/
	public function groupMetaTitleChange($data, $product_id){
		if($data['seo_desc_method']=='seo_desc_del'){
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_meta_title'] = $value['meta_title'];
				$seo['prod_meta_title'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[c]', $category, $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[m]', $manufacturer, $seo['prod_meta_title']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_meta_title'], "[");			
					$pe = strpos($seo['prod_meta_title'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_meta_title'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_meta_title'] = str_replace($n, $text, $seo['prod_meta_title']);
						} 
					}
				}	
					
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_title='". $this->db->escape($seo['prod_meta_title']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}
		} else {
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				if(empty($seo_data['meta_title'])){
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_meta_title'] = $value['meta_title'];
				$seo['prod_meta_title'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[c]', $category, $seo['prod_meta_title']);
				$seo['prod_meta_title'] = str_replace('[m]', $manufacturer, $seo['prod_meta_title']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_meta_title'], "[");			
					$pe = strpos($seo['prod_meta_title'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_meta_title'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_meta_title'] = str_replace($n, $text, $seo['prod_meta_title']);
						} 
					}
				}	
					
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_title='". $this->db->escape($seo['prod_meta_title']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}
			}
		}
		
		
			
	}
	
	public function getSeoTitleSelected($seo_category_id){		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_seo_title WHERE category_id='". (int)$seo_category_id ."' AND selected_id='1'");
		
		return $query->row;
	}
	
	
	
	public function saveSeoTitle($data, $seo_category_id){
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_seo_title SET 
		category_id ='". (int)$seo_category_id ."', 
		selected_id ='0', 
		name_seo_template ='". $this->db->escape($data['name_seo_template']) ."',
		date_added = NOW(),
		data_seo_title ='". $this->db->escape(json_encode($data['product_description'])) ."'");		
	}
	public function applySeoTitle($seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_title SET selected_id ='0' WHERE category_id ='". (int)$seo_category_id ."'");
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_title SET date_added = NOW(), selected_id ='1' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function saveSeoTitleNew($data, $seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_title SET date_added = NOW(), name_seo_template ='". $this->db->escape($data['name_seo_template']) ."', data_seo_title ='". $this->db->escape(json_encode($data['product_description'])) ."' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function deleteSeoTitle($seo_id, $seo_category_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "edit_seo_title WHERE seo_id='". (int)$seo_id ."' AND category_id ='". (int)$seo_category_id ."'");
	}
	public function getSeoTitle($data = array()) {
		$sql = "SELECT * FROM ". DB_PREFIX ."edit_seo_title WHERE category_id='". (int)$data['seo_category_id'] ."' GROUP BY seo_id ORDER BY date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalSeoTitle($seo_category_id) {
		$sql = "SELECT COUNT(*) AS total FROM ". DB_PREFIX ."edit_seo_title WHERE category_id='". (int)$seo_category_id ."'";
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	/*END SEO TITLE*/
	
	
	
	public function groupMetaH1Change($data, $product_id){
		if($data['seo_desc_method']=='seo_desc_del'){
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_meta_h1'] = $value['meta_h1'];
				$seo['prod_meta_h1'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[c]', $category, $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[m]', $manufacturer, $seo['prod_meta_h1']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_meta_h1'], "[");			
					$pe = strpos($seo['prod_meta_h1'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_meta_h1'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_meta_h1'] = str_replace($n, $text, $seo['prod_meta_h1']);
						} 
					}
				}	
				
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_h1='". $this->db->escape($seo['prod_meta_h1']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}
		} else { 
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				if(empty($seo_data['meta_h1'])){
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_meta_h1'] = $value['meta_h1'];
				$seo['prod_meta_h1'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[c]', $category, $seo['prod_meta_h1']);
				$seo['prod_meta_h1'] = str_replace('[m]', $manufacturer, $seo['prod_meta_h1']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_meta_h1'], "[");			
					$pe = strpos($seo['prod_meta_h1'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_meta_h1'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_meta_h1'] = str_replace($n, $text, $seo['prod_meta_h1']);
						} 
					}
				}	
					
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_h1='". $this->db->escape($seo['prod_meta_h1']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}
			}
		}
		
			
	}
	
	
	public function getSeoH1Selected($seo_category_id){		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_seo_h1 WHERE category_id='". (int)$seo_category_id ."' AND selected_id='1'");
		
		return $query->row;
	}
	public function saveSeoH1($data, $seo_category_id){
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_seo_h1 SET 
		category_id ='". (int)$seo_category_id ."', 
		selected_id ='0', 
		name_seo_template ='". $this->db->escape($data['name_seo_template']) ."',
		date_added = NOW(),
		data_seo_h1 ='". $this->db->escape(json_encode($data['product_description'])) ."'");		
	}
	public function applySeoH1($seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_h1 SET selected_id ='0' WHERE category_id ='". (int)$seo_category_id ."'");
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_h1 SET date_added = NOW(), selected_id ='1' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function saveSeoH1New($data, $seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_h1 SET date_added = NOW(), name_seo_template ='". $this->db->escape($data['name_seo_template']) ."', data_seo_h1 ='". $this->db->escape(json_encode($data['product_description'])) ."' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function deleteSeoH1($seo_id, $seo_category_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "edit_seo_h1 WHERE seo_id='". (int)$seo_id ."' AND category_id ='". (int)$seo_category_id ."'");
	}
	public function getSeoH1($data = array()) {
		$sql = "SELECT * FROM ". DB_PREFIX ."edit_seo_h1 WHERE category_id='". (int)$data['seo_category_id'] ."' GROUP BY seo_id ORDER BY date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalSeoH1($seo_category_id) {
		$sql = "SELECT COUNT(*) AS total FROM ". DB_PREFIX ."edit_seo_h1 WHERE category_id='". (int)$seo_category_id ."'";
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	/*END SEO H1*/
	
	
	public function groupMetaKeywordChange($data, $product_id){
		if($data['seo_desc_method']=='seo_desc_del'){
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_meta_keyword'] = $value['meta_keyword'];
				$seo['prod_meta_keyword'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_keyword']);
				$seo['prod_meta_keyword'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_keyword']);
				$seo['prod_meta_keyword'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_keyword']);
				$seo['prod_meta_keyword'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_keyword']);
				$seo['prod_meta_keyword'] = str_replace('[c]', $category, $seo['prod_meta_keyword']);
				$seo['prod_meta_keyword'] = str_replace('[m]', $manufacturer, $seo['prod_meta_keyword']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_meta_keyword'], "[");			
					$pe = strpos($seo['prod_meta_keyword'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_meta_keyword'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_meta_keyword'] = str_replace($n, $text, $seo['prod_meta_keyword']);
						} 
					}
				}	
					
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keyword='". $this->db->escape($seo['prod_meta_keyword']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}
		} else {
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				if(empty($seo_data['meta_keyword'])){
					$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
					
					$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
					
					$rows = $this->getProductCategory($product_id);
					
					if (!empty($rows)) {
						$child = 0;
						for ($j=0; $j<100; $j++) {					
							if (!isset($rows[$j]['category_id'])) break;
							else if ((int)$rows[$j]['category_id'] > $child) {
								$child = $rows[$j]['category_id'];					
							}	
						}
						$rows = $this->getCategoryName($child,$language_id);
						if (!empty($rows)) $category = $rows[0]['name'];				
					}
					
					$seo['prod_meta_keyword'] = $value['meta_keyword'];
					$seo['prod_meta_keyword'] = str_replace('[n]', $seo_data['name'], $seo['prod_meta_keyword']);
					$seo['prod_meta_keyword'] = str_replace('[p]', $seo_data['price'], $seo['prod_meta_keyword']);
					$seo['prod_meta_keyword'] = str_replace('[b]', $seo_data['model'], $seo['prod_meta_keyword']);
					$seo['prod_meta_keyword'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_meta_keyword']);
					$seo['prod_meta_keyword'] = str_replace('[c]', $category, $seo['prod_meta_keyword']);
					$seo['prod_meta_keyword'] = str_replace('[m]', $manufacturer, $seo['prod_meta_keyword']);
					
					$br = 1;
					for ($i=0; $i<200; $i++) {	
						$pb = strpos($seo['prod_meta_keyword'], "[");			
						$pe = strpos($seo['prod_meta_keyword'], "]");
						if ($pe) {
							$br = 1;
							$n = substr($seo['prod_meta_keyword'], $pb, $pe-$pb+1);
							if (substr_count($n, "|")) {
								$m = substr($n, 1, strlen($n)-2);
								$mm = explode("|", $m);						
								$text = $mm[rand(0, count($mm)-1)];
								$seo['prod_meta_keyword'] = str_replace($n, $text, $seo['prod_meta_keyword']);
							} 
						}
					}	
						
					$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keyword='". $this->db->escape($seo['prod_meta_keyword']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
				}
			}
		}
		
			
	}
	public function getSeoKeywordSelected($seo_category_id){		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_seo_keyword WHERE category_id='". (int)$seo_category_id ."' AND selected_id='1'");
		
		return $query->row;
	}
	public function saveSeoKeyword($data, $seo_category_id){
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_seo_keyword SET 
		category_id ='". (int)$seo_category_id ."', 
		selected_id ='0', 
		name_seo_template ='". $this->db->escape($data['name_seo_template']) ."',
		date_added = NOW(),
		data_seo_keyword ='". $this->db->escape(json_encode($data['product_description'])) ."'");		
	}
	public function applySeoKeyword($seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_keyword SET selected_id ='0' WHERE category_id ='". (int)$seo_category_id ."'");
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_keyword SET date_added = NOW(), selected_id ='1' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function saveSeoKeywordNew($data, $seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_keyword SET date_added = NOW(), name_seo_template ='". $this->db->escape($data['name_seo_template']) ."', data_seo_keyword ='". $this->db->escape(json_encode($data['product_description'])) ."' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function deleteSeoKeyword($seo_id, $seo_category_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "edit_seo_keyword WHERE seo_id='". (int)$seo_id ."' AND category_id ='". (int)$seo_category_id ."'");
	}
	public function getSeoKeyword($data = array()) {
		$sql = "SELECT * FROM ". DB_PREFIX ."edit_seo_keyword WHERE category_id='". (int)$data['seo_category_id'] ."' GROUP BY seo_id ORDER BY date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalSeoKeyword($seo_category_id) {
		$sql = "SELECT COUNT(*) AS total FROM ". DB_PREFIX ."edit_seo_keyword WHERE category_id='". (int)$seo_category_id ."'";
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	
	public function groupMetaTagChange($data, $product_id){
		if($data['seo_desc_method']=='seo_desc_del'){
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				
				$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
				
				$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
				
				$rows = $this->getProductCategory($product_id);
				
				if (!empty($rows)) {
					$child = 0;
					for ($j=0; $j<100; $j++) {					
						if (!isset($rows[$j]['category_id'])) break;
						else if ((int)$rows[$j]['category_id'] > $child) {
							$child = $rows[$j]['category_id'];					
						}	
					}
					$rows = $this->getCategoryName($child,$language_id);
					if (!empty($rows)) $category = $rows[0]['name'];				
				}
				
				$seo['prod_tag'] = $value['tag'];
				$seo['prod_tag'] = str_replace('[n]', $seo_data['name'], $seo['prod_tag']);
				$seo['prod_tag'] = str_replace('[p]', $seo_data['price'], $seo['prod_tag']);
				$seo['prod_tag'] = str_replace('[b]', $seo_data['model'], $seo['prod_tag']);
				$seo['prod_tag'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_tag']);
				$seo['prod_tag'] = str_replace('[c]', $category, $seo['prod_tag']);
				$seo['prod_tag'] = str_replace('[m]', $manufacturer, $seo['prod_tag']);
				
				$br = 1;
				for ($i=0; $i<200; $i++) {	
					$pb = strpos($seo['prod_tag'], "[");			
					$pe = strpos($seo['prod_tag'], "]");
					if ($pe) {
						$br = 1;
						$n = substr($seo['prod_tag'], $pb, $pe-$pb+1);
						if (substr_count($n, "|")) {
							$m = substr($n, 1, strlen($n)-2);
							$mm = explode("|", $m);						
							$text = $mm[rand(0, count($mm)-1)];
							$seo['prod_tag'] = str_replace($n, $text, $seo['prod_tag']);
						} 
					}
				}	
					
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET tag='". $this->db->escape($seo['prod_tag']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
			}
		} else {
			foreach ($data['product_description'] as $language_id => $value) {
				$seo_data = $this->getProductSeo($product_id,$language_id);			
				if(empty($seo_data['tag'])){
					$rows_manufacturer = $this->getManufacturerName($seo_data['manufacturer_id']);
					
					$manufacturer = str_replace('&quot;', '', $rows_manufacturer);		
					
					$rows = $this->getProductCategory($product_id);
					
					if (!empty($rows)) {
						$child = 0;
						for ($j=0; $j<100; $j++) {					
							if (!isset($rows[$j]['category_id'])) break;
							else if ((int)$rows[$j]['category_id'] > $child) {
								$child = $rows[$j]['category_id'];					
							}	
						}
						$rows = $this->getCategoryName($child,$language_id);
						if (!empty($rows)) $category = $rows[0]['name'];				
					}
					
					$seo['prod_tag'] = $value['tag'];
					$seo['prod_tag'] = str_replace('[n]', $seo_data['name'], $seo['prod_tag']);
					$seo['prod_tag'] = str_replace('[p]', $seo_data['price'], $seo['prod_tag']);
					$seo['prod_tag'] = str_replace('[b]', $seo_data['model'], $seo['prod_tag']);
					$seo['prod_tag'] = str_replace('[sku]', $seo_data['sku'], $seo['prod_tag']);
					$seo['prod_tag'] = str_replace('[c]', $category, $seo['prod_tag']);
					$seo['prod_tag'] = str_replace('[m]', $manufacturer, $seo['prod_tag']);
					
					$br = 1;
					for ($i=0; $i<200; $i++) {	
						$pb = strpos($seo['prod_tag'], "[");			
						$pe = strpos($seo['prod_tag'], "]");
						if ($pe) {
							$br = 1;
							$n = substr($seo['prod_tag'], $pb, $pe-$pb+1);
							if (substr_count($n, "|")) {
								$m = substr($n, 1, strlen($n)-2);
								$mm = explode("|", $m);						
								$text = $mm[rand(0, count($mm)-1)];
								$seo['prod_tag'] = str_replace($n, $text, $seo['prod_tag']);
							} 
						}
					}	
						
					$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET tag='". $this->db->escape($seo['prod_tag']) ."' WHERE product_id = '" . $product_id . "' AND language_id='" . $language_id . "'");
				}
			}
		}
		
			
	}
	
	public function getSeoTagSelected($seo_category_id){		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_seo_tag WHERE category_id='". (int)$seo_category_id ."' AND selected_id='1'");
		
		return $query->row;
	}
	public function saveSeoTag($data, $seo_category_id){
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_seo_tag SET 
		category_id ='". (int)$seo_category_id ."', 
		selected_id ='0', 
		name_seo_template ='". $this->db->escape($data['name_seo_template']) ."',
		date_added = NOW(),
		data_seo_tag ='". $this->db->escape(json_encode($data['product_description'])) ."'");		
	}
	public function applySeoTag($seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_tag SET selected_id ='0' WHERE category_id ='". (int)$seo_category_id ."'");
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_tag SET date_added = NOW(), selected_id ='1' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function saveSeoTagNew($data, $seo_id, $seo_category_id){
		$this->db->query("UPDATE " . DB_PREFIX . "edit_seo_tag SET date_added = NOW(), name_seo_template ='". $this->db->escape($data['name_seo_template']) ."', data_seo_tag ='". $this->db->escape(json_encode($data['product_description'])) ."' WHERE category_id ='". (int)$seo_category_id ."' AND seo_id='". (int)$seo_id ."'");		
	}
	public function deleteSeoTag($seo_id, $seo_category_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "edit_seo_tag WHERE seo_id='". (int)$seo_id ."' AND category_id ='". (int)$seo_category_id ."'");
	}
	public function getSeoTag($data = array()) {
		$sql = "SELECT * FROM ". DB_PREFIX ."edit_seo_tag WHERE category_id='". (int)$data['seo_category_id'] ."' GROUP BY seo_id ORDER BY date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalSeoTag($seo_category_id) {
		$sql = "SELECT COUNT(*) AS total FROM ". DB_PREFIX ."edit_seo_tag WHERE category_id='". (int)$seo_category_id ."'";
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	public function getProductName($product_id) {
		$language_id = (int)$this->config->get('config_language_id');
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . $language_id . "'");
		if(isset($query->row['name'])){
			return $query->row['name'];
		}
	}
	public function getProductNameChangeUrl($product_id,$language_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . $language_id . "'");
		if(isset($query->row['name'])){
			return $query->row['name'];
		}
	}
	public function getProductModel($product_id) {
		$query = $this->db->query("SELECT model FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");
		
		return $query->row['model'];
	}
	public function getProductSku($product_id) {
		$query = $this->db->query("SELECT sku FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");
		
		return $query->row['sku'];
	}
	public function getUrl($product_id,$language_id) {
		$query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
				
		return $query->row;
	}
	public function getUrlAlias($keyword,$language_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $this->db->escape($keyword) . "' AND language_id = '" . (int)$language_id . "'");

		return $query->row;
	}
	
	
	
	public function groupUrlChange($data, $product_id, $language_id){
		
		
		$store_id = 0;
		$name = $this->getProductNameChangeUrl($product_id,$language_id);		
		$seo_url = $this->TransLit_URL($name);
		$seo_url = $this->srtreplace_URL($seo_url);	
		$seo_url = strtolower($seo_url);
		
		$url_alias_info = $this->getUrlAlias($seo_url,$language_id);
		$get_url = $this->getUrl($product_id,$language_id);
		if($data['url_method']=='url_skip'){
			if(empty($get_url)){
				if ($url_alias_info && isset($product_id) && $url_alias_info['query'] != 'product_id=' . $product_id) {
					if($data['url_already_use']=='add_id'){
						$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url).'-'.$product_id . "', language_id = '" . (int)$language_id . "'");
					} elseif($data['url_already_use']=='add_model'){
						$name_model = $this->getProductModel($product_id);
						if(!empty($name_model)){
							$seo_model = $this->TransLit_URL($name_model);
							$seo_model = $this->srtreplace_URL($seo_model);	
							$seo_model = strtolower($seo_model);
						} else { 
							$seo_model = $product_id;
						}
						$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url).'-'.$seo_model . "', language_id = '" . (int)$language_id . "'");
					} else {
						$name_sku = $this->getProductSku($product_id);
						if(!empty($name_sku)){
							$seo_sku = $this->TransLit_URL($name_sku);
							$seo_sku = $this->srtreplace_URL($seo_sku);	
							$seo_sku = strtolower($seo_sku);
						} else {
							$seo_sku = $product_id;
						}
						$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url).'-'.$seo_sku . "', language_id = '" . (int)$language_id . "'");			
					}
				} else {
					$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
					$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url) . "',language_id = '" . (int)$language_id . "'");
				}
			}
		} else {
			if ($url_alias_info && isset($product_id) && $url_alias_info['query'] != 'product_id=' . $product_id) {
				if($data['url_already_use']=='add_id'){
					$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
					$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url).'-'.$product_id . "', language_id = '" . (int)$language_id . "'");
				} elseif($data['url_already_use']=='add_model'){
					$name_model = $this->getProductModel($product_id);
					if(!empty($name_model)){
						$seo_model = $this->TransLit_URL($name_model);
						$seo_model = $this->srtreplace_URL($seo_model);	
						$seo_model = strtolower($seo_model);
					} else { 
						$seo_model = $product_id;
					}
					$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
					$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url).'-'.$seo_model . "', language_id = '" . (int)$language_id . "'");
				} else {
					$name_sku = $this->getProductSku($product_id);
					if(!empty($name_sku)){
						$seo_sku = $this->TransLit_URL($name_sku);
						$seo_sku = $this->srtreplace_URL($seo_sku);	
						$seo_sku = strtolower($seo_sku);
					} else {
						$seo_sku = $product_id;
					}
					$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
					$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url).'-'.$seo_sku . "', language_id = '" . (int)$language_id . "'");			
				}
			} else {
				$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");				
				$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url) . "', language_id = '" . (int)$language_id . "'");
			}
		}		
	}
	
	public function TransLit_URL($text) {
		$tr = array(
                "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
                "Д"=>"d","Е"=>"e","Ё"=>"e","Ж"=>"G","З"=>"z","И"=>"i",
                "Й"=>"J","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
                "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
                "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
                "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"y","Ь"=>"",
                "Э"=>"e","Ю"=>"yu","Я"=>"ya","Ї"=>"ji","Ґ" =>"g","І" =>"I","а"=>"a","б"=>"b",
                "в"=>"v","г"=>"g","д"=>"d","е"=>"e", "ё"=>"e","ж"=>"g",
                "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
                "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
                "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
                "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
                "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
                "ї"=> "ji", "і"=> "i", "ґ" =>"g", "Є" =>"e", "є" =>"e" );				
		$text = strtr($text, $tr);
		unset ($tr);
		return $text;
	}
	public function srtreplace_URL($text) {
		$text = strip_tags($text);
		
		$text = str_replace ('&#034;', '', $text);
		$text = str_replace ('&#039;', '', $text);
		$text = str_replace("'" , '-' , $text);
		$text = str_replace('"' , '-' , $text);
		$text = str_replace('«' , '' , $text);
		$text = str_replace('»' , '' , $text);
		$text = str_replace('.' , '-' , $text);
		$text = str_replace(':' , '-' , $text);
		$text = str_replace('|' , '-' , $text);
		$text = str_replace('*' , '-' , $text);
		$text = str_replace('=' , '-' , $text);
		$text = str_replace('^' , '-' , $text);
		$text = str_replace('%' , '-' , $text);
		$text = str_replace('$' , '-' , $text);
		$text = str_replace('?' , '-' , $text);
		$text = str_replace('@' , '-' , $text);
		$text = str_replace('+' , '-' , $text);
		$text = str_replace('!' , '-' , $text);
		$text = str_replace('<' , '' , $text);		
		$text = str_replace('>' , '' , $text);
		$text = str_replace('#' , '' , $text);
		$text = str_replace(',' , '-' , $text);		
		$text = str_replace('\\' , '-' , $text);
		$text = str_replace('\/' , '-' , $text);	
		$text = str_replace("/" , '-' , $text);		
		$text = str_replace("(" , '' , $text);
		$text = str_replace(")" , '' , $text);
		$text = str_replace("[" , '' , $text);
		$text = str_replace("]" , '' , $text);
		$text = str_replace('&' , '-' , $text);		
		$text = str_replace(" " , '-' , $text);
		$text = str_replace("№" , '' , $text);
		$text = str_replace("`" , '-' , $text);
		$text = str_replace("{" , '-' , $text);
		$text = str_replace("}" , '-' , $text);
		$text = str_replace(";" , '-' , $text);
		$text = str_replace("±" , '-' , $text);
		$text = preg_replace('|-+|', '-', $text);
		$l = strlen($text);
		if (substr($text, 0, 1) == "-") $text = substr($text, 1, $l-1);				
		if (substr($text, $l-1, 1) == "-") $text = substr($text, 0, $l-1);
		$text = trim($text);

		return $text;
	}
	
	
	
	
	
	public function groupPriceChange($data, $product_id){
	$price_old = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if($data['price_type'] == 'fix') { 
			if($data['price_method'] == 'plus') {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$data['price'] + (float)$price_old->row['price']) . "' WHERE product_id = '" . $product_id . "'");		
			} elseif($data['price_method'] == 'minus') {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'multiply'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'divide'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'equality') {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");	
			}
		} elseif($data['price_type'] == 'percent') {		
			if($data['price_method'] == 'plus') {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] + (float)$price_old->row['price']/100 * (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");		
			} elseif($data['price_method'] == 'minus'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$price_old->row['price']/100 *(float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");		
			} elseif($data['price_method'] == 'multiply'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$price_old->row['price']/100 *(float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'divide'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$price_old->row['price']/100 *(float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'equality') {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$data['price']/100) . "' WHERE product_id = '" . $product_id . "'");	
			}
			
		}
	}
	
	public function groupSpecialChange($product_id, $data){
		$price_old = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['product_special'])) {
				foreach ($data['product_special'] as $value) {
					if($value['price_type'] == 'fix') {
						if($value['price_method'] == 'plus') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$value['price'] + (float)$price_old->row['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'minus') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'multiply'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'divide'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'equality') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						}
					} elseif($value['price_type'] == 'percent') {
						if($value['price_method'] == 'plus') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] + (float)$price_old->row['price']/100 * (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'minus'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$price_old->row['price']/100 * (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						}  elseif($value['price_method'] == 'multiply'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$price_old->row['price']/100 * (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'divide'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$price_old->row['price']/100 * (float)$value['price']) . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						} elseif($value['price_method'] == 'equality') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$value['price']/100)  . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
						}			
					}
				}
			}
			
		$this->cache->delete('product');
	}
	public function groupDiscountChange($product_id, $data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$price_old = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['product_discount'])) {
				foreach ($data['product_discount'] as $product_discount) {
					if($product_discount['price_type'] == 'fix') {
						if($product_discount['price_method'] == 'plus') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$product_discount['price'] + (float)$price_old->row['price']) . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'minus') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$product_discount['price'])  . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'multiply'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$product_discount['price'])  . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'divide'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$product_discount['price'])  . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'equality') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . (float)$product_discount['price'] . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						}
					} elseif($product_discount['price_type'] == 'percent') {
						if($product_discount['price_method'] == 'plus') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] + (float)$price_old->row['price']/100 * (float)$product_discount['price']) . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'minus'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$price_old->row['price']/100 * (float)$product_discount['price']) . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						}  elseif($product_discount['price_method'] == 'multiply'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$price_old->row['price']/100 * (float)$product_discount['price']) . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'divide'){
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$price_old->row['price']/100 * (float)$product_discount['price']) . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						} elseif($product_discount['price_method'] == 'equality') {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$product_discount['price']/100)  . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "',  date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
						}			
					}
				}
			}
	}
	
	public function groupQuantityChange($data, $product_id){
	$quantity_old = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if($data['quantity_method'] == 'plus') {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . $this->db->escape($data['quantity'] + $quantity_old->row['quantity']) . "' WHERE product_id = '" . $product_id . "'");		
		} elseif($data['quantity_method'] == 'minus') {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . $this->db->escape($quantity_old->row['quantity'] - $data['quantity']) . "' WHERE product_id = '" . $product_id . "'");
		} elseif($data['quantity_method'] == 'multiply'){
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . $this->db->escape($quantity_old->row['quantity'] * $data['quantity']) . "' WHERE product_id = '" . $product_id . "'");
		} elseif($data['quantity_method'] == 'divide'){
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . $this->db->escape($quantity_old->row['quantity'] / $data['quantity']) . "' WHERE product_id = '" . $product_id . "'");
		} elseif($data['quantity_method'] == 'equality') {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . $this->db->escape($data['quantity']) . "' WHERE product_id = '" . $product_id . "'");	
		}
	}
	public function groupMinQuantityChange($data, $product_id){
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET minimum='". (int)$data['minimum']. "' WHERE product_id = '" . (int)$product_id . "'");
		
	}
	public function groupModelChange($data, $product_id){
		$data_not_update = $this->db->query("SELECT model,location,tax_class_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if(isset($data['status_model'])) {
			$model = $data['model'];
		} else {
			$model = isset($data_not_update->row['model']) ? $data_not_update->row['model'] : '1';
		}
		if(isset($data['status_location'])) {
			$location = $data['location'];
		} else {
			$location = isset($data_not_update->row['location']) ? $data_not_update->row['location'] : '1';
		}
		if(isset($data['status_tax'])) {
			$tax_class_id = $data['tax_class_id'];
		} else {
			$tax_class_id = isset($data_not_update->row['tax_class_id']) ? $data_not_update->row['tax_class_id'] : '1';
		}
		
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET
		model='". $this->db->escape($model) . "',
		location='". $this->db->escape($location) . "',
		tax_class_id='". $this->db->escape($tax_class_id) . "'
		WHERE product_id = '" . (int)$product_id . "'");
		
	}
	public function groupCodesChange($data, $product_id){
		$data_not_update = $this->db->query("SELECT sku,upc,ean,jan,isbn,mpn FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if(isset($data['status_sku'])) {
			$sku = $data['sku'];
		} else {
			$sku = isset($data_not_update->row['sku']) ? $data_not_update->row['sku'] : '1';
		}
		if(isset($data['status_upc'])){
			$upc = $data['upc'];
		} else {
			$upc = isset($data_not_update->row['upc']) ? $data_not_update->row['upc'] : '1';
		}
		if(isset($data['status_ean'])) {
			$ean = $data['ean'];
		} else {
			$ean = isset($data_not_update->row['ean']) ? $data_not_update->row['ean'] : '1';
		}
		if(isset($data['status_jan'])) {
			$jan = $data['jan'];
		} else {
			$jan = isset($data_not_update->row['jan']) ? $data_not_update->row['jan'] : '1';
		}
		if(isset($data['status_isbn'])) {
			$isbn = $data['isbn'];
		} else {
			$isbn = isset($data_not_update->row['isbn']) ? $data_not_update->row['isbn'] : '1';
		}
		if(isset($data['status_mpn'])) {
			$mpn = $data['mpn'];
		} else {
			$mpn = isset($data_not_update->row['mpn']) ? $data_not_update->row['mpn'] : '1';
		}
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET
		sku='". $this->db->escape($sku) . "',
		upc='". $this->db->escape($upc) . "',
		ean='". $this->db->escape($ean) . "',
		jan='". $this->db->escape($jan) . "',
		isbn='". $this->db->escape($isbn) . "',
		mpn='". $this->db->escape($mpn) . "'
		
		WHERE product_id = '" . (int)$product_id . "'");
		
	}
	
	public function changeDateavailableGroup($data, $product_id){
		$data_not_update = $this->db->query("SELECT date_available FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");		
		if(!empty($data['date_available'])) {
			$date_available = $data['date_available'];
		} else {
			$date_available = isset($data_not_update->row['date_available']) ? $data_not_update->row['date_available'] : '';
		}
		if(isset($data['product_status'])) {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET status='". $this->db->escape($data['status']) . "', date_available='". $this->db->escape($date_available) . "' WHERE product_id = '" . (int)$product_id . "'");
		} else {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET date_available='". $this->db->escape($date_available) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		
	}
	public function changeStockShippingGroup($data, $product_id){
		$subtract_not_update = $this->db->query("SELECT subtract FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");		
		if(isset($data['subtract_status'])) {
			$subtract = $data['subtract'];
		} else {
			$subtract = isset($subtract_not_update->row['subtract']) ? $subtract_not_update->row['subtract'] : '1';
		}
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET subtract='". (int)$subtract . "' WHERE product_id = '" . (int)$product_id . "'");
		
		$stock_status_not_update = $this->db->query("SELECT stock_status_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");		
		if(isset($data['stock_status'])) {
			$stock_status_id = $data['stock_status_id'];
		} else {
			$stock_status_id = isset($stock_status_not_update->row['stock_status_id']) ? $stock_status_not_update->row['stock_status_id'] : '1';
		}
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id='". (int)$stock_status_id . "' WHERE product_id = '" . (int)$product_id . "'");
		
		$shipping_not_update = $this->db->query("SELECT shipping FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");		
		if(isset($data['shipping_status'])) {
			$shipping = $data['shipping'];
		} else {
			$shipping = isset($shipping_not_update->row['shipping']) ? $shipping_not_update->row['shipping'] : '1';
		}
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET shipping='". (int)$shipping . "' WHERE product_id = '" . (int)$product_id . "'");
	}
	
	public function changeWeightDimensionsGroup($data, $product_id){
		$length_not_update = $this->db->query("SELECT length FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if(isset($data['length_status'])) {
			$length = $data['length'];
		} else {
			$length = isset($length_not_update->row['length']) ? $length_not_update->row['length'] : '';
		}	
		$this->db->query("UPDATE " . DB_PREFIX . "product SET length='". $this->db->escape($length) . "' WHERE product_id = '" . (int)$product_id . "'");
		
		$width_not_update = $this->db->query("SELECT width FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if(isset($data['width_status'])) {
			$width = $data['width'];
		} else {
			$width = isset($width_not_update->row['width']) ? $width_not_update->row['width'] : '';
		}	
		$this->db->query("UPDATE " . DB_PREFIX . "product SET width='". $this->db->escape($width) . "' WHERE product_id = '" . (int)$product_id . "'");
		
		$height_not_update = $this->db->query("SELECT height FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if(isset($data['height_status'])) {
			$height = $data['height'];
		} else {
			$height = isset($height_not_update->row['height']) ? $height_not_update->row['height'] : '';
		}	
		$this->db->query("UPDATE " . DB_PREFIX . "product SET height='". $this->db->escape($height) . "' WHERE product_id = '" . (int)$product_id . "'");
		
		$weight_not_update = $this->db->query("SELECT weight FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		if(isset($data['weight_status'])) {
			$weight = $data['weight'];
		} else {
			$weight = isset($weight_not_update->row['weight']) ? $weight_not_update->row['weight'] : '';
		}	
		$this->db->query("UPDATE " . DB_PREFIX . "product SET weight='". $this->db->escape($weight) . "' WHERE product_id = '" . (int)$product_id . "'");
	}
	public function changeManufacturerGroup($data, $product_id){
		$this->db->query("UPDATE " . DB_PREFIX . "product SET manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
	}
	public function getAllCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

		$category_data = array();
		foreach ($query->rows as $row) {
			$category_data[$row['parent_id']][$row['category_id']] = $row;
		}

		return $category_data;
	}
	public function getProductCategories($product_id) {
		$product_category_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}
		return $product_category_data;
	}
	public function changeCategoryGroup($data, $product_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
	}
	public function getFilter($filter_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getFilters($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND fd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " ORDER BY f.sort_order ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getProductFilters($product_id) {
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}
	public function changeFilterGroup($data, $product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}
	}
	public function getProductRelated($product_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}
	public function changeRelatedGroup($data, $product_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
	}
	public function getProductAttributes($product_id) {
		$product_attribute_data = array();
		
		$product_attribute_query = $this->db->query("SELECT pa.attribute_id, ad.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY pa.attribute_id");
		
		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();
			
			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
			
			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}
			
			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'name'                          => $product_attribute['name'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}
		
		return $product_attribute_data;
	}
	public function changeAttributeGroup($data,$product_id){
		if($data['product_attribute_method'] == 'deleteAttribute'){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		}
		if (!empty($data['product_attribute'])) {
			
							
			foreach ($data['product_attribute'] as $product_attribute) {
			
				
				if ($product_attribute['attribute_id']) {
					if($data['product_attribute_method'] == 'updateAttribute'){
						$attribute_check = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
						if(isset($attribute_check->row['attribute_id'])){
							foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
								$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET  text = '" .  $this->db->escape($product_attribute_description['text']) . "' WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");
							}
						} else {
							foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
								$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
							}
						}	
					}
					if($data['product_attribute_method'] == 'skipAttribute'){
						$attribute_check = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
						if(!isset($attribute_check->row['attribute_id'])){
							foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
								$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
							}
						} 
					}
					if($data['product_attribute_method'] == 'deleteAttribute'){
						foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
						}
					}
					
				}
			}
			
		}
	}
	public function changeAttributeOneProduct($data,$product_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		
		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}
	}
	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'required'             => $product_option['required']
			);
		}

		return $product_option_data;
	}
	public function getOptionValues($option_id) {
		$option_value_data = array();
		
		$option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '" . (int)$option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order ASC");
				
		foreach ($option_value_query->rows as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['option_value_id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}
		
		return $option_value_data;
	}
	public function changeOptionsGroup($data, $product_id){
		
		if($data['product_options_method']=='deleteOptions'){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
				
			if (isset($data['product_option'])) {
				foreach ($data['product_option'] as $product_option) {
					
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
					
						$product_option_id = $this->db->getLastId();
					
						if (isset($product_option['product_option_value'])) {
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
							}
						}
					} else { 
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
					}					
				}
			}
		}
		
		if($data['product_options_method']=='updateOptions'){
			if (isset($data['product_option'])) {
				foreach ($data['product_option'] as $product_option) {
					
					$product_option_check = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$product_option['option_id'] . "' AND product_id = '" . (int)$product_id . "'");
					
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {							
						if(isset($product_option_check->row['option_id'])){	
							if (isset($product_option['product_option_value'])) {	
									foreach ($product_option['product_option_value'] as $product_option_value) {	
										$product_option_value_check = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE option_value_id = '" . (int)$product_option_value['option_value_id'] . "' AND product_id = '" . (int)$product_id . "'");
										if(isset($product_option_value_check->row['option_value_id'])){	
											$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET 
												quantity = '" . (int)$product_option_value['quantity'] . "',
												subtract = '" . (int)$product_option_value['subtract'] . "',
												price = '" . (float)$product_option_value['price'] . "',
												price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "',
												points = '" . (int)$product_option_value['points'] . "',
												points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "',
												weight = '" . (float)$product_option_value['weight'] . "',
												weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'
												WHERE product_id = '" . (int)$product_id . "' 
												AND option_id = '" . (int)$product_option['option_id'] . "'
												AND option_value_id = '" . (int)$product_option_value['option_value_id'] . "'");
										} else {
											$product_option_id = $product_option_check->row['product_option_id'];
											$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
										}
									}
							}
							
							
						} else {
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
					
							$product_option_id = $this->db->getLastId();
					
							if (isset($product_option['product_option_value'])) {
								foreach ($product_option['product_option_value'] as $product_option_value) {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
								}
							}
						}
					} else { 
						if(isset($product_option_check->row['option_id'])){	
							$this->db->query("UPDATE " . DB_PREFIX . "product_option SET value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "' WHERE product_id = '" . (int)$product_id . "' AND option_id = '" . (int)$product_option['option_id'] . "'");		
						} else {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
	
						}
					}	
				}
			}	
		}
		
		if($data['product_options_method']=='skipOptions'){
			if (isset($data['product_option'])) {
				foreach ($data['product_option'] as $product_option) {
					
					$product_option_check = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$product_option['option_id'] . "' AND product_id = '" . (int)$product_id . "'");

					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {							
						if(!isset($product_option_check->row['option_id'])){	
							if (isset($product_option['product_option_value'])) {	
								$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
					
								$product_option_id = $this->db->getLastId();
						
								if (isset($product_option['product_option_value'])) {
									foreach ($product_option['product_option_value'] as $product_option_value) {
										$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
									}
								}	
							}
						}
					} else { 
						if(!isset($product_option_check->row['option_id'])){	
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
						} 
					}	
				}
			}	
		}
		
		$this->cache->delete('product');
	}
	
	
}