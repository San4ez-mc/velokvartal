<?php
class ModelMegasliderproMegaslider extends Model {
	public function addmegasliderpro($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "megasliderpro SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "',delay = '" . (int)$data['delay'] . "',hover = '" . (int)$data['hover'] . "',nextback = '" . (int)$data['nextback'] . "',contrl = '" . (int)$data['contrl'] . "',effect = '" . $data['effect'] . "'");

		$megasliderpro_id = $this->db->getLastId();

		if (isset($data['megaslider_image'])) {
			foreach ($data['megaslider_image'] as $megaslider_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "megasliderpro_image SET
				megasliderpro_id = '" . (int)$megasliderpro_id . "',
				link = '" .  $this->db->escape($megaslider_image['link']) . "',
				type = '" .  $this->db->escape($megaslider_image['type']) . "',
				image = '" .  $this->db->escape($megaslider_image['image']) . "',
				sort_order = '" . (int)$megaslider_image['sort_order'] . "',
				small_image = '" .  $this->db->escape($megaslider_image['small_image']) . "'");

				$megasliderpro_image_id = $this->db->getLastId();

				foreach ($megaslider_image['megaslider_image_description'] as $language_id => $value) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "megasliderpro_image_description SET
					megasliderpro_image_id = '" . (int)$megasliderpro_image_id . "',
					language_id = '" . (int)$language_id . "',
					megasliderpro_id = '" . (int)$megasliderpro_id . "',
					title = '" .  $this->db->escape($value['title']) . "',
					sub_title = '" .  $this->db->escape($value['sub_title']) . "',
					description = '" .  $this->db->escape($value['description']) . "',
					price = '" .  (float)$value['price'] . "',
					price_bg = '" .  $this->db->escape($value['price_bg']) . "',
					bg_title = '" .  $this->db->escape($value['bg_title']) . "',
					color_title = '" .  $this->db->escape($value['color_title']) . "',
					bg_sub_title = '" .  $this->db->escape($value['bg_sub_title']) . "',
					effect_title = '" .  $this->db->escape($value['effect_title']) . "',
					effect_sub_title = '" .  $this->db->escape($value['effect_sub_title']) . "',
					effect_description_title = '" .  $this->db->escape($value['effect_description_title']) . "',
					opacity_bg_title = '" .  (float)$value['opacity_bg_title'] . "',
					opacity_bg_sub_title = '" .  (float)$value['opacity_bg_sub_title'] . "',
					color_sub_title = '" .  $this->db->escape($value['color_sub_title']) . "'");
				}
			}
		}
	}

	public function editmegasliderpro($megasliderpro_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "megasliderpro SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "',delay = '" . (int)$data['delay'] . "',hover = '" . (int)$data['hover'] . "',nextback = '" . (int)$data['nextback'] . "',effect = '" . $data['effect'] . "',contrl = '" . (int)$data['contrl'] . "' WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "megasliderpro_image WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megasliderpro_image_description WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");

		if (isset($data['megaslider_image'])) {
			foreach ($data['megaslider_image'] as $megaslider_image) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "megasliderpro_image SET
				megasliderpro_id = '" . (int)$megasliderpro_id . "',
				link = '" .  $this->db->escape($megaslider_image['link']) . "',
				type = '" .  $this->db->escape($megaslider_image['type']) . "',
				image = '" .  $this->db->escape($megaslider_image['image']) . "',
				sort_order = '" . (int)$megaslider_image['sort_order'] . "',
				small_image = '" .  $this->db->escape($megaslider_image['small_image']) . "'");

				$megasliderpro_image_id = $this->db->getLastId();

				foreach ($megaslider_image['megaslider_image_description'] as $language_id => $value) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "megasliderpro_image_description SET
					megasliderpro_image_id = '" . (int)$megasliderpro_image_id . "',
					language_id = '" . (int)$language_id . "',
					megasliderpro_id = '" . (int)$megasliderpro_id . "',
					title = '" .  $this->db->escape($value['title']) . "',
					sub_title = '" .  $this->db->escape($value['sub_title']) . "',
					description = '" .  $this->db->escape($value['description']) . "',
					bg_title = '" .  $this->db->escape($value['bg_title']) . "',
					price = '" .  (float)$value['price'] . "',
					price_bg = '" .  $this->db->escape($value['price_bg']) . "',
					color_title = '" .  $this->db->escape($value['color_title']) . "',
					bg_sub_title = '" .  $this->db->escape($value['bg_sub_title']) . "',
					effect_title = '" .  $this->db->escape($value['effect_title']) . "',
					effect_sub_title = '" .  $this->db->escape($value['effect_sub_title']) . "',
					effect_description_title = '" .  $this->db->escape($value['effect_description_title']) . "',
					opacity_bg_title = '" .  (float)$value['opacity_bg_title'] . "',
					opacity_bg_sub_title = '" .  (float)$value['opacity_bg_sub_title'] . "',
					color_sub_title = '" .  $this->db->escape($value['color_sub_title']) . "'");
				}
			}
		}
	}

	public function deletemegasliderpro($megasliderpro_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "megasliderpro WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megasliderpro_image WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megasliderpro_image_description WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");
	}

	public function getmegasliderpro($megasliderpro_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "megasliderpro WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "'");

		return $query->row;
	}

	public function getmegasliderpros($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "megasliderpro";

		$sort_data = array(
			'name',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getmegasliderproImages($megasliderpro_id) {
		$megaslider_image_data = array();

		$megaslider_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "megasliderpro_image WHERE megasliderpro_id = '" . (int)$megasliderpro_id . "' ORDER BY megasliderpro_image_id ASC");

		foreach ($megaslider_image_query->rows as $megaslider_image) {
			$megaslider_image_description_data = array();

			$megaslider_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "megasliderpro_image_description WHERE megasliderpro_image_id = '" . (int)$megaslider_image['megasliderpro_image_id'] . "' AND megasliderpro_id = '" . (int)$megasliderpro_id . "'");

			foreach ($megaslider_image_description_query->rows as $megaslider_image_description) {
				$megaslider_image_description_data[$megaslider_image_description['language_id']] = array(
				'title' => $megaslider_image_description['title'],
				'sub_title' => $megaslider_image_description['sub_title'],
				'description' => $megaslider_image_description['description'],
				'price' => $megaslider_image_description['price'],
				'price_bg' => $megaslider_image_description['price_bg'],
				'bg_title' => $megaslider_image_description['bg_title'],
				'color_title' => $megaslider_image_description['color_title'],
				'bg_sub_title' => $megaslider_image_description['bg_sub_title'],
				'color_sub_title' => $megaslider_image_description['color_sub_title'],
				'opacity_bg_title' => $megaslider_image_description['opacity_bg_title'],
				'opacity_bg_sub_title' => $megaslider_image_description['opacity_bg_sub_title'],
				'effect_title' => $megaslider_image_description['effect_title'],
				'effect_sub_title' => $megaslider_image_description['effect_sub_title'],
				'effect_description_title' => $megaslider_image_description['effect_description_title'],

				);
			}

			$megaslider_image_data[] = array(
				'megaslider_image_description' => $megaslider_image_description_data,
				'link' => $megaslider_image['link'],
				'type' => $megaslider_image['type'],
				'image' => $megaslider_image['image'],
				'sort_order' => $megaslider_image['sort_order'],
				'small_image' => $megaslider_image['small_image']
			);
		}

		return $megaslider_image_data;
	}

	public function getTotalmegasliderpro() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "megasliderpro");

		return $query->row['total'];
	}

	public function CreateTable() {
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS  ". DB_PREFIX ."key_megasliderpro (
			`key` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
			license_key text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL)");

		$license_key = $this->db->query("SELECT `key` FROM ". DB_PREFIX ."key_megasliderpro WHERE `key`='local_key' LIMIT 1");
		if ($license_key->num_rows <= 0) { $this->db->query("INSERT INTO ". DB_PREFIX ."key_megasliderpro (`key`, `license_key`) VALUES( 'local_key', '');");}

		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `". DB_PREFIX ."megasliderpro`(
			`megasliderpro_id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`status` tinyint(1) NOT NULL,
			`delay` int(11) DEFAULT NULL,
			`hover` tinyint(1) DEFAULT NULL,
			`nextback` tinyint(1) DEFAULT NULL,
			`contrl` tinyint(1) DEFAULT NULL,
			`effect` varchar(64) NOT NULL,
			PRIMARY KEY (`megasliderpro_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `". DB_PREFIX ."megasliderpro_image` (
			`megasliderpro_image_id` int(11) NOT NULL AUTO_INCREMENT,
			`megasliderpro_id` int(11) NOT NULL,
			`link` varchar(255) NOT NULL,
			`type` int(11) NOT NULL,
			`image` varchar(255) NOT NULL,
			`small_image` varchar(255) NOT NULL,
			`sort_order` int(11) NOT NULL,
			PRIMARY KEY (`megasliderpro_image_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");


		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `". DB_PREFIX ."megasliderpro_image_description` (
			`megasliderpro_image_id` int(11) NOT NULL,
			`language_id` int(11) NOT NULL,
			`megasliderpro_id` int(11) NOT NULL,
			`title` text NOT NULL,
			`sub_title` text DEFAULT NULL,
			`bg_title` varchar(64) DEFAULT NULL,
			`color_title` varchar(64) DEFAULT NULL,
			`bg_sub_title` varchar(64) DEFAULT NULL,
			`color_sub_title` varchar(64) DEFAULT NULL,
			`opacity_bg_title` varchar(64) DEFAULT NULL,
			`opacity_bg_sub_title` varchar(64) DEFAULT NULL,
			`effect_title` varchar(64) DEFAULT NULL,
			`effect_sub_title` varchar(64) DEFAULT NULL,
			`effect_description_title` varchar(64) DEFAULT NULL,
			`description` text,
			`price` DECIMAL(15,4) DEFAULT 0,
			`price_bg` VARCHAR(64),
			PRIMARY KEY (`megasliderpro_image_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

	}
}
?>