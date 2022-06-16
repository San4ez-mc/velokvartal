<?php
class ControllerCommonFooter extends Controller {

                    public function addToNewsletter(){

                        $email = $this->request->post['email'];
                        $this->load->language('cyberstore/lang');
                        $this->load->language('common/footer');
                        $this->load->model('account/customer');

                        $this->createNewsletterTables();

                        $count = $this->checkEmailSubscribe($email);

                        if($count == 0){
                            $newsletter_id = $this->model_account_customer->addToNewsletter($email);
                            $json['success'] = $this->language->get('text_success_subcribe');
                        } else {
                            $json['warning'] = $this->language->get('text_error_subcribe');
                        }

                      return $this->response->setOutput(json_encode($json));
                    }

                    public function createNewsletterTables() {

                        $query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "newsletter (
                        `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
                        `email` VARCHAR( 255 ) NOT NULL ,
                        `group` VARCHAR( 25 ) NOT NULL ,
                        `date_added` DATETIME NOT NULL ,
                        PRIMARY KEY ( `id` )
                        )");
                    }

                    public function checkEmailSubscribe($email){

                        $this->load->model('account/customer');

                        $count = $this->model_account_customer->checkEmailSubscribe($email);

                        return $count;

                    }
                
	public function index() {

				$data['agreedata'] = $this->config->get('agreedata');
				if(isset($_COOKIE['PopupAgree'])){
				$data['PopupAgreecookie'] = $_COOKIE['PopupAgree'];
				}
			
		$this->load->language('common/footer');

					$this->load->language('cyberstore/lang');
                    $data['text_placeholder_subcribe'] = $this->language->get('text_placeholder_subcribe');
                    $data['text_subcribe'] = $this->language->get('text_subcribe');
					$data['text_subcribe_type2'] = $this->language->get('text_subcribe_type2');
                    $data['text_btn_subcribe'] = $this->language->get('text_btn_subcribe');
                    $data['text_error_subcribe'] = $this->language->get('text_error_subcribe');
                    $data['text_success_subcribe'] = $this->language->get('text_success_subcribe');
                    $data['text_empty_email'] = $this->language->get('text_empty_email');
                    $data['text_validate_email'] = $this->language->get('text_validate_email');
                

				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}
				if (is_file(DIR_IMAGE . $this->config->get('cs_logo_footer'))) {
					$data['cs_logo_footer'] = $server . 'image/' . $this->config->get('cs_logo_footer');
				} else {
					$data['cs_logo_footer'] = '';
				}
				$var_currency = array();
				$var_currency['value'] = $this->currency->getValue($this->session->data['currency']);
				$var_currency['symbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
				$var_currency['symbol_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
				$var_currency['currency_code'] = $this->session->data['currency'];
				$var_currency['decimals'] = $this->currency->getDecimalPlace($this->session->data['currency']);
				$var_currency['decimal_point'] = $this->language->get('decimal_point');
				$var_currency['thousand_point'] = $this->language->get('thousand_point');
				$data['currency'] = $var_currency;
				$this->load->language('cyberstore/lang');
				$data['footer_map_status'] = $this->config->get('footer_map_status');
				$data['footer_desc_status'] = (!empty($this->config->get('footer_desc_status')) ? 1 : 0);
				$data['type_footer'] = (!empty($this->config->get('type_footer')) ? $this->config->get('type_footer') : 1);
				$data['code_map'] = $this->config->get('code_map');
				$data['footer_map_status'] = $this->config->get('footer_map_status');
				$data['google_api_map_key'] = $this->config->get('config_google_api_map_key');
				$data['text_contact_footer'] = $this->language->get('text_contact_footer');
				$data['text_social_link'] = $this->language->get('text_social_link');
				$data['ns_email_footer_contact'] = $this->config->get('config_email_footer_contact');
				$data['ns_skype_footer_contact'] = $this->config->get('config_skype_footer_contact');
				$data['config_ns_footer_counters'] = $this->config->get('config_ns_footer_counters');
				$data['lang_id'] = $this->config->get('config_language_id');
				$data['powered_new'] = sprintf('%s &copy; %s', $this->config->get('config_name'), date('Y', time()));
				$this->load->model('tool/image');
				$data['config_phones_footer'] = $this->config->get('config_phones_footer');
				$footer_phones = $this->config->get('config_phones_footer');
				$data['phones_footer'] = array();
				if(!empty($footer_phones)){
					foreach ($footer_phones as $phone_footer) {
					$data['phones_footer'][] = array(
							'type'			=> $phone_footer['type'][$data['lang_id']],
							'phone_footer'	=> html_entity_decode($phone_footer['phone_footer'][$data['lang_id']], ENT_QUOTES, 'UTF-8'),
							'icon_footer_phone'	=> $phone_footer['icon_footer_phone'],
						);
					}
				}
				$banner_items_footer_array = $this->config->get('banner_items_footer');
				if(isset($banner_items_footer_array)) {
					$banner_items_footer = $this->config->get('banner_items_footer');
				} else {
					$banner_items_footer = array();
				}
				$data['banner_items_footers'] = array();

				foreach ($banner_items_footer as $result) {
					if(isset($result['popup'])){
						$result_popup = $result['popup'];
					} else {
						$result_popup = '0';
					}
					if (isset($result['image']) && is_file(DIR_IMAGE . $result['image'])) {
						$bfimage = $this->model_tool_image->resize($result['image'], 50, 50);
					} else {
						$bfimage = '';
					}
					$data['banner_items_footers'][] = array(
						'image'      => $bfimage,
						'icon_type' 	=> (!empty($result['icon_type']) ? $result['icon_type'] : 0),
						'icon_image' 	=> $result['icon_image'],
						'title' 		=> $result['title'],
						'description' 	=> $result['description'],
						'link'  		=> $result['link'][$this->config->get('config_language_id')],
						'popup'  		=> $result_popup,

					);
				}

				$footer_social = $this->config->get('config_social_footer');
				$data['social_footer'] = array();
				if(!empty($footer_social)){

				foreach ($footer_social as $social_footer) {
					if (isset($social_footer['image_footer_social']) && is_file(DIR_IMAGE . $social_footer['image_footer_social'])) {
						$data['ifs'] = $this->model_tool_image->resize($social_footer['image_footer_social'], 25, 25);
					} else {
						$data['ifs'] = $this->model_tool_image->resize('no_image.png', 25, 25);
					}
				$data['social_footer'][] = array(
						'ifs'      		=> $data['ifs'],
						'social_link_footer' => $social_footer['social_link_footer'],
						'social_icon_footer' => $social_footer['social_icon_footer'],
						'bg_hover_icon' => $social_footer['bg_hover_icon'],
					);
				}

				}
				$data['config_payments_footer'] = $this->config->get('config_payments_footer');
				$payments_social = $this->config->get('config_payments_footer');
				if(!empty($payments_social)){
					$data['config_payments_array_footer'] = array();

					foreach ($payments_social as $payments_footer) {
						if (isset($payments_footer['image_footer_payments']) && is_file(DIR_IMAGE . $payments_footer['image_footer_payments'])) {
							$data['icon_footer_payments'] = $this->model_tool_image->resize($payments_footer['image_footer_payments'], 45, 35);
						} else {
							$data['icon_footer_payments'] = $this->model_tool_image->resize('no_image.png', 45, 35);
						}

					$data['config_payments_array_footer'][] = array(
							'image_footer_payments'      		=> $payments_footer['image_footer_payments'],
							'icon_footer_payments'      		=> $data['icon_footer_payments'],
							'payments_link_footer'      		=> $payments_footer['payments_link_footer'],
						);
					}

				}
				$data['about_us'] = $this->language->get('about_us');
				$data['gmap_full_screen'] = $this->language->get('gmap_full_screen');
				$data['gmap_normal_screen'] = $this->language->get('gmap_normal_screen');


				$description_store_footer = $this->config->get('config_description_store_footer');

				$data['description_store_footer'] = html_entity_decode($this->config->get('config_description_store_footer')[$data['lang_id']]['config_description_store_footer'], ENT_QUOTES, 'UTF-8');
				$data['zoom_google_map'] = $this->config->get('config_zoom_google_map');
				$data['center_google_map'] = $this->config->get('config_center_google_map');
				$data['lang_id'] = $this->config->get('config_language_id');
				$data['setting_google'] = $this->config->get('google_maps_module_map');
				$data['gmap_setting'] = array();
				if(!empty($data['setting_google'])){
					foreach ($data['setting_google'] as $map_setting){
						$data['gmap_setting'][] = array(
							'latlong' => html_entity_decode($map_setting['latlong'], ENT_QUOTES, 'UTF-8'),
							'maptext' => $map_setting['maptext'],
							'onelinetext' => $map_setting['onelinetext'],
						);
					}
				}
			$data['config_footer_design'] = $this->config->get('config_footer_design');
			$data['fcols'] = $this->config->get('footer_column_setting_ns');
			$data['footer_links'] = array();
			if (isset($data['fcols'][$data['lang_id']]['footer_links'])) {
				$data['footer_links'] = $data['fcols'][$data['lang_id']]['footer_links'];
			}
			

			$data['lang_id'] = $this->config->get('config_language_id');
			$data['callbackpro'] = $this->config->get('callbackpro');	
			


		$data['fb_widget'] = $this->config->get('fb_widget');
		$data['fb_data'] = array();
		if(isset($data['fb_widget']['status']) && $data['fb_widget']['status'] == 1) {
		$this->document->addStyle('catalog/view/theme/cyberstore/stylesheet/feedback_widget/style.css');
			if(!empty($data['fb_widget']['items'])){
			foreach ($data['fb_widget']['items'] as $result) {
				$data['fb_data'][] = array(
					'fbw_icon' 	=> $result['fbw_icon'],
					'fbw_type' => (isset($result['fbw_type'][$this->config->get('config_language_id')]) ? html_entity_decode($result['fbw_type'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8') : ''),
					'fbw_text' => (isset($result['fbw_text'][$this->config->get('config_language_id')]) ? $result['fbw_text'][$this->config->get('config_language_id')] : ''),
				);
			}
			}
		}	
			
		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		$data['scripts'] = $this->document->getScripts('footer');
		$data['styles'] = $this->document->getStyles('footer');
		
		return $this->load->view('common/footer', $data);
	}
}
