<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$canonical = $this->url->link('common/home');
			if ($this->config->get('config_seo_pro') && !$this->config->get('config_seopro_addslash')) {
				$canonical = rtrim($canonical, '/');
			}
			$this->document->addLink($canonical, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');

		$megamenu_setting = $this->config->get('megamenu_setting');
		$data['main_menu'] = $megamenu_setting['main_menu_selection'];
		$data['general_menu_on_off'] = (!empty($megamenu_setting['menu_open_hpage']) ? $megamenu_setting['menu_open_hpage'] : 0);

		$config_theme = $this->config->get('config_theme');
		$theme_default_directory = $this->config->get('theme_default_directory');
		if(($config_theme == 'cyberstore') || ($theme_default_directory =='cyberstore')){
			$this->load->model('design/layout');
			$this->load->model('cyberstore/layout_home_page');
			if (isset($this->request->get['route'])) {
				$route = (string)$this->request->get['route'];
			} else {
				$route = 'common/home';
			}

			$layout_id = 0;

			if (!$layout_id) {
				$layout_id = $this->model_design_layout->getLayout($route);
			}
			$ns_theme_home_page_sheme = $this->config->get('ns_new_home_layout_module');
			$modules_cyberstore = array();
			if (isset($ns_theme_home_page_sheme)) {
				$modules_cyberstore = $this->config->get('ns_new_home_layout_module');
			} else {
				$modules_cyberstore = array();
			}

			$modules_default_layout = $this->model_cyberstore_layout_home_page->getLayoutModulesHomePage($layout_id);
			$hpmsheme = array();
			if(!empty($modules_default_layout)){
				foreach($modules_default_layout as $module_default_layout){
					$pos = strpos($module_default_layout['position'], 'position_');
					if ($pos !== false) {
						$hpmsheme[] = $module_default_layout;
					}
				}
			}
			$result_layout = array_merge($modules_cyberstore, $hpmsheme);
			$detect = new Mobile_Detect();
			$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
			if(!empty($result_layout)){
				$this->load->model('setting/module');
				foreach ($result_layout as $key => $pos_mod) {
					if($deviceType == 'phone') {
					$mob_device = isset($pos_mod['mob_device']) ? $pos_mod['mob_device']: 0;
						if($mob_device == 1){
							continue;
						}
					}
					if($deviceType == 'tablet') {
					$tablet_device = isset($pos_mod['tablet_device']) ? $pos_mod['tablet_device']: 0;
						if($tablet_device == 1){
							continue;
						}
					}
					if($deviceType == 'computer') {
					$pc_device = isset($pos_mod['pc_device']) ? $pos_mod['pc_device']: 0;
						if($pc_device == 1){
							continue;
						}
					}
					$part = explode('.', $pos_mod['code']);

					if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
						$data[$pos_mod['position']][] = $this->load->controller('extension/module/' . $part[0]);
					}

					if (isset($part[1])) {
						$setting_info = $this->model_setting_module->getModule($part[1]);

						if ($setting_info && $setting_info['status']) {
							$data[$pos_mod['position']][] = $this->load->controller('extension/module/' . $part[0], $setting_info);

						}
					}
				}
			}

		}
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$data['name'] = $this->config->get('config_name');
		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}
		$data['url'] = $server;
		$this->load->model('localisation/country');
		$country = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));
		$this->load->model('localisation/zone');
		$zone = $this->model_localisation_zone->getZone($this->config->get('config_zone_id'));
		if(!empty($zone)){
			$data['addresslocality'] = $zone['name'];
		} else {
			$data['addresslocality'] = '';
		}
		$data['streetaddress'] = nl2br($this->config->get('config_address'));
		if(!empty($country)){
			$data['addresscountry'] = $country['name'];
		} else {
			$data['addresscountry'] = '';
		}
		$data['telephone'] = $this->config->get('config_telephone');
		$data['email'] = $this->config->get('config_email');
		$data['open'] = nl2br($this->config->get('config_open'));
      
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}