<?php
class ModelDesignLayout extends Model {
	public function getLayout($route) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape($route) . "' LIKE route AND store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY route DESC LIMIT 1");

		if ($query->num_rows) {
			return (int)$query->row['layout_id'];
		} else {
			return 0;
		}
	}
	
	public function getLayoutModules($layout_id, $position) {

		$detect = new Mobile_Detect();
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if($deviceType == 'phone') {
			$mob_device = "AND mob_device !='1'";
		} else {
			$mob_device = "";
		}
		if($deviceType == 'tablet') {
			$tablet_device = " AND tablet_device != '1'";
		} else {
			$tablet_device = ""; 
		}
		if($deviceType == 'computer') {
			$pc_device = " AND pc_device != '1'";
		} else {
			$pc_device = ""; 
		}
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' AND position = '" . $this->db->escape($position) . "' ". $mob_device ."". $pc_device ."". $tablet_device ."  ORDER BY sort_order");
		
		return $query->rows;
	}
}