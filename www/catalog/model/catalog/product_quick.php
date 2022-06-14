<?php
class ModelCatalogProductQuick extends Model {
	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

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
	}


	public function getUserGroupsEditView($user_group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_group_id . "'");

		if(isset($query->row['editor_permission'])){
			$user_group_editor = array(
				'editor_permission' => json_decode($query->row['editor_permission'], true)
			);
			return $user_group_editor['editor_permission'];
		}
	}
	public function getProductDescriptions($product_id) {
		$product_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'tag'              => $result['tag'],
				'meta_title'       => $result['meta_title']
			);
		}

		return $product_description_data;
	}

	public function getProductName($product_id) {
		$selected_language = (int)$this->config->get('config_language_id');
		$row = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . $selected_language . "'");
		if(isset($row->row['name'])){
			return $row->row['name'];
		}
	}

	public function changeName($product_id, $name){
		$selected_language = (int)$this->config->get('config_language_id');
		if ($this->user->hasPermission('modify', 'catalog/product_quick')) {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET name='".$this->db->escape($name)."' WHERE product_id = '" . (int)$product_id . "' AND language_id='" . $selected_language . "'");
		}
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' AND language_id= '" . $selected_language . "'");

		$this->cache->delete('product_description');
		return $query->row['name'];
	}


	public function changeDescriptions($product_id, $data){

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET
			name = '" . $this->db->escape($value['name']) . "',
			meta_title = '" . $this->db->escape($value['meta_title']) . "',
			meta_description = '" . $this->db->escape($value['meta_description']) . "',
			meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "',
			tag = '" . $this->db->escape($value['tag']) . "',
			description = '" . $this->db->escape($value['description']) . "'
			WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");

		}

		$this->cache->delete('product');

	}
	public function getProductSeoUrls($product_id) {
		$product_seo_url_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $product_seo_url_data;
	}
	public function saveEditDescription($product_id,$user_add, $meta_title,$product_name,$meta_keyword,$meta_description,$description,$tag){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countdesc FROM `".DB_PREFIX."edit_description` WHERE product_id = '". $product_id ."'");
		if($count_row->row['countdesc'] >= 10){
			$query_edit_desc = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_description WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_description SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "',seo_title = '" . $meta_title  . "', product_name = '". $product_name ."',  meta_keyword = '". $meta_keyword ."', meta_description = '". $meta_description ."', description = '". $description ."', tag = '". $tag ."',  date_modified = NOW() WHERE date_modified = '". $query_edit_desc->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_description SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "',seo_title = '" . $meta_title  . "', product_name = '". $product_name ."', meta_keyword = '". $meta_keyword ."', meta_description = '". $meta_description ."', description = '". $description ."', tag = '". $tag ."', date_modified = NOW()");
		}
	}
	public function changePrice($data, $product_id) {
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
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] - (float)$price_old->row['price']/100 * (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'multiply'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$price_old->row['price']/100 * (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'divide'){
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] / (float)$price_old->row['price']/100 * (float)$data['price']) . "' WHERE product_id = '" . $product_id . "'");
			} elseif($data['price_method'] == 'equality') {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $this->db->escape((float)$price_old->row['price'] * (float)$data['price']/100) . "' WHERE product_id = '" . $product_id . "'");
			}

		}
    }
	public function getUserGroups($user_g_id) {
		$sql = "SELECT `user_group_id`, `status` FROM " . DB_PREFIX . "user_group where user_group_id = '".$user_g_id."'";

		$query = $this->db->query($sql);

		return $query->row;
	}


	public function getProductIMG($product_id) {
		$row = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");
		if(isset($row->row['image'])){
			return $row->row['image'];
		}
	}
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}
	public function changeProductImages($product_id, $data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		$this->cache->delete('product');
	}
	public function editImage($product_id, $image){
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET image='".$this->db->escape($image)."' WHERE product_id = '" . (int)$product_id . "'");
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

		$this->cache->delete('product');
		return $query->row['image'];
	}
	/*******************************/
	/*SPECIAL*/
	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		return $query->rows;
	}
	public function getCustomerGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'cgd.name',
			'cg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cgd.name";
		}

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
	}
	public function changeSpecialPrices($product_id, $data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
			}
		}

		$this->cache->delete('product');
	}


	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}
	public function changeProductDiscount($product_id, $data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}
	}
	/*RELATED*/
	public function getProductRelated($product_id) {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}
	public function changeProductRelated($product_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		if(isset($data)) {
			foreach ($data as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
			}
		}
	}
	public function getOption($option_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE o.option_id = '" . (int)$option_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getOptionValue($option_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_value_id = '" . (int)$option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}


	/***/
	public function getProducts($data = array()) {

			$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

			if (!empty($data['filter_category'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
			}

			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($data['filter_name'])) {
				$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}

			if (!empty($data['filter_model'])) {
				$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
			}

			if (!empty($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}

			if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
				$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
			}

			if (isset($data['filter_status']) && $data['filter_status'] !== null) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}

			if (!empty($data['filter_category'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();

					$implode_data[] = "category_id = '" . (int)$data['filter_category'] . "'";

					$this->load->model('catalog/category');

					$categories = $this->model_catalog_category->getCategories($data['filter_category']);

					foreach ($categories as $category) {
						$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
					}

					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
				}
			}

			$sql .= " GROUP BY p.product_id";

			$sort_data = array(
				'pd.name',
				'p2c.category_id',
				'p.model',
				'p.price',
				'p.quantity',
				'p.status',
				'p.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY pd.name";
			}

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

	}

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function changeCodes($product_id, $data){
		$this->db->query("UPDATE " . DB_PREFIX . "product SET
		model = '" . $this->db->escape($data['model']) . "',
		sku = '" . $this->db->escape($data['sku']) . "',
		upc = '" . $this->db->escape($data['upc']) . "',
		tax_class_id = '" . (int)$data['tax_class_id'] . "',
		sort_order = '" . (int)$data['sort_order'] . "',
		quantity = '" . (int)$data['quantity'] . "',
		minimum = '" . (int)$data['minimum'] . "',
		subtract = '" . (int)$data['subtract'] . "',
		stock_status_id = '" . (int)$data['stock_status_id'] . "',
		length = '" . (float)$data['length'] . "',
		width = '" . (float)$data['width'] . "',
		height = '" . (float)$data['height'] . "',
		weight = '" . (float)$data['weight'] . "',
		length_class_id = '" . (int)$data['length_class_id'] . "',
		weight_class_id = '" . (int)$data['weight_class_id'] . "',
		location = '" . $this->db->escape($data['location']) . "',
		date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");

		$this->cache->delete('product');
	}
	public function getWeightClassesEditor($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) WHERE wcd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'title',
				'unit',
				'value'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY title";
			}

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
			$weight_class_data = $this->cache->get('weight_class.' . (int)$this->config->get('config_language_id'));

			if (!$weight_class_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) WHERE wcd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				$weight_class_data = $query->rows;

				$this->cache->set('weight_class.' . (int)$this->config->get('config_language_id'), $weight_class_data);
			}

			return $weight_class_data;
		}
	}
	public function getLengthClassesEditor($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "length_class lc LEFT JOIN " . DB_PREFIX . "length_class_description lcd ON (lc.length_class_id = lcd.length_class_id) WHERE lcd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'title',
				'unit',
				'value'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY title";
			}

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
			$length_class_data = $this->cache->get('length_class.' . (int)$this->config->get('config_language_id'));

			if (!$length_class_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "length_class lc LEFT JOIN " . DB_PREFIX . "length_class_description lcd ON (lc.length_class_id = lcd.length_class_id) WHERE lcd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				$length_class_data = $query->rows;

				$this->cache->set('length_class.' . (int)$this->config->get('config_language_id'), $length_class_data);
			}

			return $length_class_data;
		}
	}
	public function getStockStatusesEditor($data = array()) {
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
	public function getTaxClassesEditor($data = array()) {
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
	public function getProductAttributescode($product_id) {
		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");

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
	public function changeAttributes($product_id, $data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->cache->delete('product');
	}

	public function getAttributes($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY attribute_group, ad.name";
		}

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

	public function getProductOptionsSavechanges($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN `" . DB_PREFIX . "option_value` ov ON (pov.option_value_id = ov.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY ov.sort_order ASC ");

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
	public function getOptions($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND od.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'od.name',
			'o.type',
			'o.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY od.name";
		}

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
	}
	public function changeOptions($product_id, $data){
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

		$this->cache->delete('product');
	}
	public function getAllCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

		$category_data = array();
		foreach ($query->rows as $row) {
			$category_data[$row['parent_id']][$row['category_id']] = $row;
		}

		return $category_data;
	}
	public function getProductMainCategoryId($product_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND main_category = '1' LIMIT 1");

		return ($query->num_rows ? (int)$query->row['category_id'] : 0);
	}
	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getCategoryEditor($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
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
	public function changeProductCategories($product_id, $data){

		$this->db->query("UPDATE " . DB_PREFIX . "product SET manufacturer_id = '" . (int)$data['manufacturer_id'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
	}

	public function getDirectoryTree( $outerDir = '', $level = 0 ){

    if ($level == 0) {
      if (!$outerDir) {
        $outerDir = DIR_IMAGE . 'catalog';
      }
     $dir_array = array();
      if ($dir_array && is_array($dir_array)) {
        return $dir_array;
      }
    }

    $level++;
    $dirs = array_diff( scandir( $outerDir ), array( ".", ".." ) );
    $dir_array = array();
    foreach( $dirs as $d ){
        if( is_dir($outerDir . "/" . $d)  ){
            $dir_array[] = array (
              'path'  => str_replace(DIR_IMAGE, '', $outerDir . "/" . $d),
              'dir_name'  => str_replace(DIR_IMAGE . 'catalog', '', $outerDir . "/" . $d),
              'name'  => $d,
              'level' => $level
            );

            $dir_array = array_merge($dir_array, $this->getDirectoryTree( $outerDir . "/" . $d, $level));
        }
    }

    return $dir_array;
  }
 public function getCategoriesThis($product_id) {

	$query = $this->db->query("SELECT `category_id` FROM " . DB_PREFIX . "product_to_category WHERE `product_id` = '". (int)$product_id ."'");

		if ($query->num_rows > 0) {
			foreach ($query->rows as $result) {
				$category_this_id = $result['category_id'];
			}
			return $category_this_id;
		} else {
			return '';
		}
	}

	public function addProdEdit($data) {
		$data_select_product_id = $this->db->query("SELECT `product_id` FROM " . DB_PREFIX . "edit_price_product");
		$prod_id_data_array = array();
			if($data_select_product_id->num_rows > 0){
				foreach ($data_select_product_id->rows as $newprod){
					$prod_id_data_array[] = $newprod['product_id'];
				}
			}
		$array_new_prod = array();
		foreach($data as $find_id){
			$array_new_prod[] = $find_id['product_id'];
		}

		$id_product_new = (array_diff($array_new_prod, $prod_id_data_array));

		if(isset($id_product_new)){
			foreach ($id_product_new as $new_id){

				$query = $this->db->query("SELECT pd.product_id, pd.name, p.model, p.sku, p.quantity, pd.language_id FROM  " . DB_PREFIX . "product AS p LEFT JOIN " . DB_PREFIX . "product_description AS pd ON pd.product_id = p.product_id AND pd.language_id = '1' where pd.product_id = '". $new_id ."'");

				foreach($query->rows as $product_add_new){
					if($product_add_new['sku'] == ''){
						$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_price_product SET product_id = '" . $product_add_new['product_id']  . "', product_name = '" . $this->db->escape($product_add_new['name']) . "', product_model = '" . $this->db->escape($product_add_new['model']) . "', product_sku = '" . $this->db->escape($product_add_new['model']) . "', quantity = '" . $product_add_new['quantity'] . "', date_modified = NOW()");
					} else {
						$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_price_product SET product_id = '" . $product_add_new['product_id']  . "', product_name = '" . $this->db->escape($product_add_new['name']) . "', product_model = '" . $this->db->escape($product_add_new['model']) . "', product_sku = '" . $this->db->escape($product_add_new['sku']) . "', quantity = '" . $product_add_new['quantity'] . "', date_modified = NOW()");
					}
				}

			}
		}
	}
	/*РУЧНАЯ ЦЕНА*/
	public function getProductManual($product_id) {
		$manual_price = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_manual_price WHERE product_id = '" . (int)$product_id . "'");
		 foreach ($query->rows as $result){
			$manual_price = array(
				'manual_price' => $result['manual_price'],
				'date_end' => $result['date_end'],
			);
		 }
		return $manual_price;
	}


	public function changeManualPrice($product_id, $data, $edit_price, $price_old){

	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_manual_price WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $sel_pr_db){
			if(isset($sel_pr_db['product_id']) ||$sel_pr_db['product_id'] == $product_id){
				$this->db->query("DELETE FROM ". DB_PREFIX ."edit_manual_price WHERE product_id = '" . $product_id . "'");
			}
		}

			$this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$data['price'] . "' WHERE product_id = '". $product_id . "'");
		if(!empty($price_old)) {
			$this->db->query("INSERT " . DB_PREFIX . "edit_manual_price SET product_id = '". $product_id ."', manual_price = '" . $price_old . "', date_end = '". $data['date_end'] ."'");
		} else {
			$this->db->query("INSERT " . DB_PREFIX . "edit_manual_price SET product_id = '". $product_id ."', manual_price = '" . $edit_price . "', date_end = '". $data['date_end'] ."'");
		}

		$special_select = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		foreach($special_select->rows as $special){
			if($special){
				$this->db->query("INSERT " . DB_PREFIX . "edit_manual_price_save_special SET product_id = '". $product_id ."',
				price = '" . $special['price'] . "',
				priority = '" . $special['priority'] . "',
				customer_group_id = '" . $special['customer_group_id'] . "',
				date_start = '" . $special['date_start'] . "',
				date_end = '". $special['date_end'] ."'");
			}
		}
		$this->db->query("DELETE FROM ". DB_PREFIX ."product_special WHERE product_id = '" . $product_id . "'");
	}
	public function JoinProductSku($product_merge, $product_additional, $user_add){

			$query_product_general = $this->db->query("SELECT ss.sku_id, pd.product_id, pd.name, p.model, p.sku, p.quantity, pd.language_id FROM  " . DB_PREFIX . "product AS p
			LEFT JOIN " . DB_PREFIX . "product_description AS pd ON (pd.product_id = p.product_id AND pd.language_id = '1')
			LEFT JOIN ".  DB_PREFIX ."suppler_sku AS ss ON (pd.product_id = ss.product_id)
			WHERE p.product_id = '". $product_merge ."'");
			$query_product_additional = $this->db->query("SELECT ss.sku_id, sbp.bprice, pd.product_id, pd.name, p.model, p.price, p.sku, p.quantity, pd.language_id FROM  " . DB_PREFIX . "product AS p
			LEFT JOIN " . DB_PREFIX . "product_description AS pd ON (pd.product_id = p.product_id AND pd.language_id = '1')
			LEFT JOIN ".  DB_PREFIX ."suppler_sku AS ss ON (pd.product_id = ss.product_id)
			LEFT JOIN " . DB_PREFIX . "suppler_base_price AS sbp ON (pd.product_id = sbp.product_id)
			WHERE p.product_id = '". $product_additional ."'");

			$general_product = $query_product_general->row;
			$additional_product = $query_product_additional->row;

			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_username_join_product SET product_id = '" . $product_merge  . "',
			product_additional_name = '" . $this->db->escape($additional_product['name'])  . "',
			product_additional_model = '" . $this->db->escape($additional_product['model'])  . "',
			product_additional_sku = '" . $this->db->escape($additional_product['sku'])  . "',
			product_additional_price = '" . $additional_product['price']  . "',
			user_name = '" . $user_add  . "', date_join = NOW()");


			if(!empty($query_product_general->row)) {

			$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."edit_join_sku WHERE product_id = '". $additional_product['product_id'] ."'");

				if(!empty($query->rows)){
					foreach($query->rows as $result){
					$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_join_sku SET
					product_id = '" . $general_product['product_id']  . "',
					date_modified = NOW() WHERE product_id = '". $result['product_id'] ."'");
					}
					$query = $this->db->query("UPDATE " . DB_PREFIX . "suppler_sku_description SET sku_id = '" . $general_product['sku_id'] . "' WHERE sku_id = '". $additional_product['sku_id'] ."'");

					$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_join_sku SET
					product_id = '" . $general_product['product_id']  . "',
					product_name = '" . $this->db->escape($additional_product['name']) . "',
					product_model = '" . $this->db->escape($additional_product['model']) . "',
					product_sku = '" . $this->db->escape($additional_product['sku']) . "',
					price = '" . $additional_product['price'] . "',
					bprice = '" . $additional_product['bprice'] . "',
					quantity = '" . $additional_product['quantity'] . "',
					date_modified = NOW()");

				} else {

					$query = $this->db->query("UPDATE " . DB_PREFIX . "suppler_sku_description SET sku_id = '" . $general_product['sku_id'] . "' WHERE sku_id = '". $additional_product['sku_id'] ."'");

					$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_join_sku SET
					product_id = '" . $general_product['product_id']  . "',
					product_name = '" . $this->db->escape($additional_product['name']) . "',
					product_model = '" . $this->db->escape($additional_product['model']) . "',
					product_sku = '" . $this->db->escape($additional_product['sku']) . "',
					price = '" . $additional_product['price'] . "',
					bprice = '" . $additional_product['bprice'] . "',
					quantity = '" . $additional_product['quantity'] . "',
					date_modified = NOW()");
				}

				$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$additional_product["product_id"] . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$additional_product["product_id"]. "'");
				$this->cache->delete('product');

			}

	}


	/*---------------------------------------*/
	/*Изминение основного товара*/
	public function ChangesGeneralProduct($sku_product_additional){
					/*Вытянул доп.товара который будет основным*/
					$query_addi_pr_array = $this->db->query("SELECT * FROM ". DB_PREFIX ."edit_join_sku WHERE product_sku = '" . $sku_product_additional . "'");
					$query_addi_pr = $query_addi_pr_array->row;

					/*Вытянул товар который сейчас основной*/
					$delete_join_sku_suppler_array = $this->db->query("SELECT * FROM ". DB_PREFIX ."edit_price_product WHERE product_id = '" . $query_addi_pr['product_id'] . "'");
					$delete_join_sku_suppler_array = $delete_join_sku_suppler_array->row;


					/*Удалил записи sku (разъединил)*/
					$this->db->query("DELETE FROM ". DB_PREFIX ."suppler_sku_description WHERE sku = '" . $delete_join_sku_suppler_array['product_sku'] . "'");

					/*Обновил основной товар в edit_price_product!*/
					$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_price_product SET  product_name = '" . $query_addi_pr['product_name'] . "',
					product_model = '" . $this->db->escape($query_addi_pr['product_model']) . "',
					product_sku = '" . $this->db->escape($query_addi_pr['product_sku']) . "',
					quantity = '" . $query_addi_pr['quantity'] . "',
					date_modified = NOW() WHERE product_id = '" . $query_addi_pr['product_id']  . "'");

					/*Обновил карточку товара*/
					$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET
					model = '" . $this->db->escape($query_addi_pr['product_model']) . "',
					sku = '" . $this->db->escape($query_addi_pr['product_sku']) . "',
					quantity = '" . $query_addi_pr['quantity'] . "',
					price = '" . $query_addi_pr['price'] . "' WHERE product_id = '" . $query_addi_pr['product_id']  . "'");

					/*Меняем Цену закупки Закупки !!! */
					$query = $this->db->query("SHOW TABLES LIKE '".DB_PREFIX ."suppler_base_price'");
						if($query->num_rows > 0){
							$bprice = $this->db->query("SELECT bprice FROM  " . DB_PREFIX . "suppler_base_price WHERE product_id = '". $query_addi_pr['product_id'] ."'");
							if($bprice->num_rows > 0){
								$query = $this->db->query("UPDATE " . DB_PREFIX . "suppler_base_price SET  bprice = '" . $query_addi_pr['bprice'] . "' WHERE product_id = '" . $query_addi_pr['product_id']  . "'");
							}
						}

					/*--------------------------------------------------*/

					/*Удаляем дополнительный товар, потому что он теперь основной */
					$this->db->query("DELETE FROM ". DB_PREFIX ."edit_join_sku WHERE product_sku = '" . $this->db->escape($sku_product_additional) . "'");

	}

	public function ChangeDescription($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_description WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}

	public function ChangeSpecial($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_special WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}

	public function SaveChangedSpecial($special_changes, $product_id, $user_add){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countspecial FROM ".DB_PREFIX."edit_special WHERE product_id = '". $product_id ."'");
		if($count_row->row['countspecial'] >= 10){
			$query_edit_special = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_special WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_special SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', special_changes = '". $special_changes ."',  date_modified = NOW() WHERE date_modified = '". $query_edit_special->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_special SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', special_changes = '". $special_changes ."', date_modified = NOW()");
		}
	}
	public function SaveChangedDiscount($discount_changes, $product_id, $user_add){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countdiscount FROM ".DB_PREFIX."edit_discount WHERE product_id = '". $product_id ."'");
		if($count_row->row['countdiscount'] >= 10){
			$query_edit_discount = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_discount WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_discount SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', discount_changes = '". $discount_changes ."',  date_modified = NOW() WHERE date_modified = '". $query_edit_discount->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_discount SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', discount_changes = '". $discount_changes ."', date_modified = NOW()");
		}
	}
	public function ChangeDiscount($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_discount WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}
	/*CATEGORY*/
	public function ChangeCategory($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_category WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}
	public function SaveChangedCategory($manufacturer_id, $product_category, $product_id, $user_add){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countcategory FROM `".DB_PREFIX."edit_category` WHERE product_id = '". $product_id ."'");
		if($count_row->row['countcategory'] >= 10){
			$query_edit_category = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_category WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_category SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', manufacture = '". $manufacturer_id ."', subcategory = '". $product_category ."',  date_modified = NOW() WHERE date_modified = '". $query_edit_category->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_category SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', manufacture = '". $manufacturer_id ."', subcategory = '". $product_category ."',  date_modified = NOW()");
		}
	}
	/**/
	/*IMAGE */
	public function ChangeImage($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_image WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}
	public function SaveChangedImage($general_image, $product_id,$additional_image,$user_add,$sort_addtitional_image){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countimage FROM ".DB_PREFIX."edit_image WHERE product_id = '". $product_id ."'");
		if($count_row->row['countimage'] >= 10){
			$query_edit_image = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_image WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_image SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', general_image = '". $general_image ."', additional_image = '". $additional_image ."', sort_addtitional_image = '". $sort_addtitional_image ."',  date_modified = NOW() WHERE date_modified = '". $query_edit_image->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_image SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', general_image = '". $general_image ."',additional_image = '". $additional_image ."', sort_addtitional_image = '". $sort_addtitional_image ."',  date_modified = NOW()");
		}
	}

	/*AND IMAGE*/

	/*IMAGE URL*/
	public function SaveChangesImageUrl($general_image, $product_id,$additional_image,$user_add){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countimageurl FROM ".DB_PREFIX."edit_image_url WHERE product_id = '". $product_id ."'");
		if($count_row->row['countimageurl'] >= 10){
			$query_edit_image = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_image_url WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_image_url SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', general_image = '". $general_image ."', additional_image = '". $additional_image ."', date_modified = NOW() WHERE date_modified = '". $query_edit_image->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_image_url SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', general_image = '". $general_image ."',additional_image = '". $additional_image ."', date_modified = NOW()");
		}
	}
	public function SaveGeneralImageUrl($filepath, $product_id){
		$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($filepath) . "' WHERE product_id = '" . $product_id . "'");
	}
	public function SaveAdditionalImageUrl($filepath, $product_id){
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . $product_id . "', image = '" . $filepath . "'");
	}
	public function ChangeImageUrl($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_image_url WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}
	/*AND IMAGE URL*/

	/*IMAGE GOOGLE*/
	public function SaveChangesImageGoogle($general_image_google, $product_id,$additional_image_google,$user_add){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countimage_google FROM ".DB_PREFIX."edit_image_google WHERE product_id = '". $product_id ."'");
			if($count_row->row['countimage_google'] >= 10){
				$query_edit_image = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_image_google WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
				$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_image_google SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', general_image = '". $general_image_google ."', additional_image = '". $additional_image_google ."', date_modified = NOW() WHERE date_modified = '". $query_edit_image->rows['0']['date_modified'] ."' ");
			} else {
				$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_image_google SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', general_image = '". $general_image_google ."',additional_image = '". $additional_image_google ."', date_modified = NOW()");
			}
	}

	public function ChangeImageGoogle($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_image_google WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}
	/*AND IMAGE GOOGLE*/
	public function SaveChangesRelatedProduct($product_id,$user_add, $related_changes){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countrelated FROM ".DB_PREFIX."edit_related WHERE product_id = '". $product_id ."'");
		if($count_row->row['countrelated'] >= 10){
			$query_edit_related = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_related WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_related SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', related_changes = '". $related_changes ."', date_modified = NOW() WHERE date_modified = '". $query_edit_related->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_related SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', related_changes = '". $related_changes ."', date_modified = NOW()");
		}
	}

	public function ChangeRelatedProduct($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_related WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}


	/*Data Code product*/
	public function SaveChangeDataProduct($product_id, $user_add, $model_product, $sku_product, $upc_product, $location_product, $tax_class_product,$quantity_product, $minimum_product,$subtract_product, $stock_status_product,$length_class_product,$weight_product,$weight_class_product,$lwh_product){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS countcode FROM ".DB_PREFIX."edit_code WHERE product_id = '". $product_id ."'");
		if($count_row->row['countcode'] >= 10){
			$query_edit_code = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_code WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_code SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', model_product = '". $model_product ."', sku_product = '". $sku_product ."', upc_product = '". $upc_product ."', location = '". $location_product ."', tax_class = '". $tax_class_product ."', quantity = '". $quantity_product ."', minimum = '". $minimum_product ."', subtract = '". $subtract_product ."',stock_status = '". $stock_status_product ."', length_class = '". $length_class_product ."',weight = '". $weight_product ."',weight_class = '". $weight_class_product ."',lwh = '". $lwh_product ."', date_modified = NOW() WHERE date_modified = '". $query_edit_code->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_code SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', model_product = '". $model_product ."', sku_product = '". $sku_product ."', upc_product = '". $upc_product ."', location = '". $location_product ."', tax_class = '". $tax_class_product ."', quantity = '". $quantity_product ."', minimum = '". $minimum_product ."', subtract = '". $subtract_product ."', stock_status = '". $stock_status_product ."', length_class = '". $length_class_product ."',weight = '". $weight_product ."', weight_class = '". $weight_class_product ."',lwh = '". $lwh_product ."', date_modified = NOW()");
		}
	}
	public function ChangeDataProducts($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_code WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}

	public function SaveChangeAttributeProduct($product_id, $user_add, $attributes){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS count_attributes FROM ".DB_PREFIX."edit_attributes WHERE product_id = '". $product_id ."'");
			if($count_row->row['count_attributes'] >= 5){
				$query_edit_attributes = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_attributes WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
				$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_attributes SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', attributes = '". $attributes ."', date_modified = NOW() WHERE date_modified = '". $query_edit_attributes->rows['0']['date_modified'] ."' ");
			} else {
				$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_attributes SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', attributes = '". $attributes ."', date_modified = NOW()");
			}
	}
	public function ChangeAttributeProducts($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_attributes WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}

	public function SaveChangeoptionProduct($product_id, $user_add, $options_save){
		$count_row = $this->db->query("SELECT COUNT(product_id) AS count_options FROM ".DB_PREFIX."edit_options WHERE product_id = '". $product_id ."'");
		if($count_row->row['count_options'] >= 10){
			$query_edit_attributes = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_options WHERE product_id = '". $product_id ."' GROUP BY date_modified  ");
			$query = $this->db->query("UPDATE " . DB_PREFIX . "edit_options SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', options = '". $options_save ."', date_modified = NOW() WHERE date_modified = '". $query_edit_attributes->rows['0']['date_modified'] ."' ");
		} else {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "edit_options SET product_id = '" . $product_id  . "', user_name = '" . $user_add  . "', options = '". $options_save ."', date_modified = NOW()");
		}
	}
	public function ChangeOptionProducts($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "edit_options WHERE product_id = '". $product_id ."' GROUP BY date_modified DESC");
		return $query->rows;
	}
}
?>