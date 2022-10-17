<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('setting/extension');

		$data['analytics'] = array();

		$analytics = $this->model_setting_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get('analytics_' . $analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['robots'] = $this->document->getRobots();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}


		$data['deviceType'] = deviceType;
		$data['lang_id'] = $this->config->get('config_language_id');
		$data['header_doptext'] = '';
		if(!empty($this->config->get('header_doptext')[$data['lang_id']]['text'])){
			$data['header_doptext'] = html_entity_decode($this->config->get('header_doptext')[$data['lang_id']]['text'], ENT_QUOTES, 'UTF-8');
		}
		$data['site_screen_width'] = $this->config->get('site_screen_width');
		$data['cs_type_btn'] = $this->config->get('cs_type_btn');
		$data['type_header'] = (!empty($this->config->get('type_header')) ? $this->config->get('type_header') : 1);
		$data['swap_search_dmenu'] = (!empty($this->config->get('swap_search_dmenu')) ? $this->config->get('swap_search_dmenu') : 0);
		if($data['type_header'] == 2){
			$data['cs_dop_menu'] = $this->load->controller('common/cyber_dopmenu');
		}
		$data['item_setting'] = $this->config->get('item_setting');
		$data['setting_module'] = $this->config->get('setting_module');
		$megamenu_setting = $this->config->get('megamenu_setting');
		if($megamenu_setting['status']=='1'){
			$data['megamenu_status']=true;
			$data['menuvh'] = $this->load->controller('common/cyber_menuvh');
		} else {
			$data['megamenu_status']=false;
		}
		$data['hmenu_type'] = $megamenu_setting['horizontal_menu_width'];
		$data['main_menu_fix_mobile'] = $megamenu_setting['main_menu_fix_mobile'];
		$data['type_mobile_menu'] = $megamenu_setting['type_mobile_menu'];
		$data['first_name'] = ($this->customer->isLogged()) ? $this->customer->getFirstName() : '';
		$data['last_name'] = ($this->customer->isLogged()) ? $this->customer->getLastName() : '';
		$data['nst_data'] = $this->config->get('nst_data');
		$data['status_border_radius'] = (!empty($this->config->get('status_border_radius')) ? 1 : 0);
		$data['show_h_compare'] = $this->config->get('show_h_compare');
		$data['show_h_wishlist'] = $this->config->get('show_h_wishlist');
		$data['config_fixed_panel_top'] = $megamenu_setting['config_fixed_panel_top'];
		$data['config_main_menu_selection'] = $megamenu_setting['main_menu_selection'];
		$data['config_change_color_icon_sticker_popular'] = $this->config->get('config_change_color_icon_sticker_popular');
		$data['config_change_background_sticker_popular'] = $this->config->get('config_change_background_sticker_popular');
		$data['config_change_color_text_sticker_popular'] = $this->config->get('config_change_color_text_sticker_popular');
		$data['config_change_color_icon_sticker_special'] = $this->config->get('config_change_color_icon_sticker_special');
		$data['config_change_background_sticker_special'] = $this->config->get('config_change_background_sticker_special');
		$data['config_change_color_text_sticker_special'] = $this->config->get('config_change_color_text_sticker_special');
		$data['config_change_color_icon_sticker_topbestseller'] = $this->config->get('config_change_color_icon_sticker_topbestseller');
		$data['config_change_background_sticker_topbestseller'] = $this->config->get('config_change_background_sticker_topbestseller');
		$data['config_change_color_text_sticker_topbestseller'] = $this->config->get('config_change_color_text_sticker_topbestseller');
		$data['config_change_color_icon_sticker_newproduct'] = $this->config->get('config_change_color_icon_sticker_newproduct');
		$data['config_change_background_sticker_newproduct'] = $this->config->get('config_change_background_sticker_newproduct');
		$data['config_change_color_text_sticker_newproduct'] = $this->config->get('config_change_color_text_sticker_newproduct');
		$data['config_ns_themes_custom_bg_mode'] = $this->config->get('config_ns_themes_custom_bg_mode');
		$data['config_themes_custom_bg_img_preview'] = $this->config->get('config_themes_custom_bg_img_preview');
		$data['config_themes_custom_bg_repeat'] = $this->config->get('config_themes_custom_bg_repeat');
		$data['config_themes_custom_bg_attachment'] = $this->config->get('config_themes_custom_bg_attachment');
		$data['config_ns_themes_custom_bg_mode_color'] = $this->config->get('config_ns_themes_custom_bg_mode_color');
		$data['config_themes_custom_bg_attachment'] = $this->config->get('config_themes_custom_bg_attachment');
		$data['config_themes_custom_bg_position'] = $this->config->get('config_themes_custom_bg_position');
		$data['config_on_off_shopping_cart_hover'] = (!empty($this->config->get('config_on_off_shopping_cart_hover')) ? 1 : 0);
		$data['custom_style'] = $this->config->get('config_custom_style_newstore');
		$data['color_schem'] = $this->config->get('config_design_template_color_theme');
		$design_fastorder = $this->config->get('config_select_design_fastorder');
		$callbackpro = $this->config->get('callbackpro');
		$design_callback = $callbackpro['select_design_theme_callback'];
		$design_special_timer = $this->config->get('config_design_special_timer');
		$minify_css = (!empty($this->config->get('config_minify_css')) ? 1 : 0);
		$minify_js = (!empty($this->config->get('config_minify_js')) ? 1 : 0);

		if(isset($minify_css) && ($minify_css == 1) || (isset($minify_js) && ($minify_js == 1))){
		$developer_mode = 0;
		} else {
		$developer_mode = 1;
		}
		require_once(DIR_SYSTEM . 'minifyns/startup.php');
		$cyberstore2 = new Cyberstore();

		$this->registry->set('cyberstore', $cyberstore2);
		$cyberstore2->utils = new CyberstoreUtils($this->registry);
		$cyberstore2->cache = new CyberstoreCache($this->registry);
		$cyberstore2->minifier = new CyberstoreMinifier($cyberstore2->cache);
		$cyberstore2->cache->setDeveloperMode($developer_mode);
		$cyberstore2->minifier->setMinifyCss($this->config->get('config_minify_css'));
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/bootstrap/css/bootstrap.min.css');
		$cyberstore2->minifier->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/js/owl-carousel/owl.carousel.css');
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/js/owl-carousel/owl.transitions.css');
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/font-awesome/css/font-awesome.min.css');
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/stylesheet.css');
		if($data['config_main_menu_selection'] =='0') {
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/menu_h.css');
		} else {
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/menu_v.css');
		}

		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/stickers.css');
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/tabs.css');
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/quickview.css');

		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/csseditor.css');

		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/js/productany/js/countdown/jquery.countdown_1.css');

		if($design_fastorder){
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/popup-fastorder/fastorder'. $design_fastorder .'.css');
		} else {
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/popup-fastorder/fastorder1.css');
		}
		if($design_callback=='1'){
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/popup-callback/callback.css');
		} else {
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/popup-callback/callback2.css');
		}
		$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/csscallback.css');
		if ($data['custom_style'] !='') {
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/'. $data['custom_style'] .'.css');
		}
		$agreedata = $this->config->get('agreedata');
		if (isset($agreedata) && $agreedata['status'] != 0) {
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/agree_popup/style_agree.css');
		}
		if($data['color_schem'] !=1){
			$cyberstore2->minifier->addStyle('catalog/view/theme/cyberstore/stylesheet/theme_scheme/theme_'. $data['color_schem'] .'.css');
		}
		if(isset($minify_css) && ($minify_css == 1)){
			$data['minifycss'] = false;
			foreach ($data['styles'] as $style) {
				$cyberstore2->minifier->addStyle($style['href']);
			}
		} else {
			$data['minifycss'] = true;
		}
		$data['csscyberstore'] = $cyberstore2->minifier->css();

		$cyberstore2->minifier->setMinifyJs($this->config->get('config_minify_js'));
		$cyberstore2->minifier->addScript('catalog/view/javascript/jquery/jquery-2.1.1.min.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/owl-carousel/owl.carousel.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/javascript/bootstrap/js/bootstrap.min.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/jquery.menu-aim.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/showmore.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/common.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/popup.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/productany/js/countdown/jquery.countdown.js', 'header');
		$cyberstore2->minifier->addScript('catalog/view/theme/cyberstore/js/jquery_lazyload/lazyload.min.js', 'header');

		$data['script_remote_servers'] = array();
		if(isset($minify_js) && ($minify_js == 1)){
			$data['minifyjs'] = false;
			foreach ($data['scripts'] as $script) {
				$search_http = strpos($script, 'http');
				if ($search_http === false) {
					$cyberstore2->minifier->addScript($script, 'header');
				} else {
					$data['script_remote_servers'][] = $script;
				}
			}
		} else {
			$data['minifyjs'] = true;
		}
		$data['jscyberstore'] = $cyberstore2->minifier->js('header');


		$header_nav_menu_link_array = $this->config->get('header_nav_menu_link');
		if(isset($header_nav_menu_link_array)) {
			$header_nav_menu_link = $this->config->get('header_nav_menu_link');
		} else {
			$header_nav_menu_link = array();
		}
		$data['header_nav_menu_links'] = array();

		foreach ($header_nav_menu_link as $result) {
			$data['header_nav_menu_links'][] = array(
				'icon_image' 	=> $result['icon_image'],
				'title' 		=> $result['title'],
				'link'  		=> $result['link'][$this->config->get('config_language_id')],
				'popup'  		=> $result['popup'],
			);
		}
		$data['home_page'] = (isset($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
			$this->load->language('cyberstore/lang');
			$data['text_info_mob'] = $this->language->get('text_info_mob');
			$data['text_search'] = $this->language->get('text_search');
			$data['days'] = $this->language->get('days');
			$data['hours'] = $this->language->get('hours');
			$data['minutes'] = $this->language->get('minutes');
			$data['sec'] = $this->language->get('sec');
			$data['text_showmore'] = $this->language->get('text_showmore');
			$data['text_callback_header'] = $this->language->get('text_callback_header');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');
			$data['onepcheckout'] = $this->url->link('checkout/onepcheckout', '', true);
			$data['general_menu_on_off'] = $this->config->get('config_menu_always_open_on_the_left');
			$this->load->language('product/category');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['total_compare'] = isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0;
			if ($this->customer->isLogged()) {
				$this->load->model('account/wishlist');
				$data['total_wishlist'] = $this->model_account_wishlist->getTotalWishlist();
			} else {
				$data['total_wishlist'] = isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
			}
			$data['compare'] = $this->url->link('product/compare');
			$data['main_phone'] = $this->config->get('config_main_phone');
			$data['header_phones'] = $this->config->get('config_phones_header');
			$header_phones = $this->config->get('config_phones_header');
			$this->load->model('tool/image');

			$data['arbitrary_text'] = html_entity_decode($this->config->get('arbitrary_text')[$data['lang_id']]['text'], ENT_QUOTES, 'UTF-8');
			$text_after_phone = $this->config->get('text_after_phone');
			$data['text_after_phone'] = $text_after_phone[$data['lang_id']]['text'];
			$data['config_phones_array'] = array();
			$data['header_phones_dropdown'] = array();
			if(!empty($header_phones)){
				foreach ($header_phones as $phone_header) {
					if (isset($phone_header['image']) && is_file(DIR_IMAGE . $phone_header['image'])) {
							$data['icon_phone'] = $this->model_tool_image->resize($phone_header['image'], 25, 25);
						} else {
							$data['icon_phone'] = '';
					}
					if($phone_header['dropdown'] == '1'){
						$data['config_phones_array'][] = array(
							'icon_phone' => $data['icon_phone'],
							'phone'      => $phone_header['phone'][$data['lang_id']],
							'icon'       => (isset($phone_header['icon']) ? $phone_header['icon'] : ''),
							'type'      =>  (isset($phone_header['type'][$data['lang_id']]) ? $phone_header['type'][$data['lang_id']] : ''),
						);
					} else {
						$data['header_phones_dropdown'][] = array(
							'icon_phone' => $data['icon_phone'],
							'phone'      => $phone_header['phone'][$data['lang_id']],
							'icon'       => (isset($phone_header['icon']) ? $phone_header['icon'] : ''),
							'type'      =>  (isset($phone_header['type'][$data['lang_id']]) ? $phone_header['type'][$data['lang_id']] : ''),
						);
					}
				}
			}
			$data['swap_header_blocks'] = (!empty($this->config->get('swap_header_blocks')) ? 1 : 0);
			if (isset($data['nst_data']['hbannerpc'][$this->config->get('config_language_id')]['image']) && is_file(DIR_IMAGE . $data['nst_data']['hbannerpc'][$this->config->get('config_language_id')]['image'])) {
				$data['hbannerpc'][$this->config->get('config_language_id')]['image'] = 'image/' . $data['nst_data']['hbannerpc'][$this->config->get('config_language_id')]['image'];
			} else {
				$data['hbannerpc'][$this->config->get('config_language_id')]['image'] = '';
			}
			if (isset($data['nst_data']['hbannermob'][$this->config->get('config_language_id')]['image']) && is_file(DIR_IMAGE . $data['nst_data']['hbannermob'][$this->config->get('config_language_id')]['image'])) {
				$data['hbannermob'][$this->config->get('config_language_id')]['image'] = 'image/' . $data['nst_data']['hbannermob'][$this->config->get('config_language_id')]['image'];
			} else {
				$data['hbannermob'][$this->config->get('config_language_id')]['image'] = '';
			}
			$data['text_hello'] = $this->language->get('text_hello');
			$data['text_login_auth'] = $this->language->get('text_login_auth');
			$data['bg_product_image'] = $this->config->get('bg_product_image');
			$header_tel_bicon = $this->config->get('header_tel_bicon');
			if (isset($header_tel_bicon) && is_file(DIR_IMAGE . $header_tel_bicon)) {
				$data['header_tel_bicon_image'] = $this->model_tool_image->resize($header_tel_bicon, 35, 35);
			} else {
				$data['header_tel_bicon_image'] = '';
			}
		
		$this->load->language('common/header');
		
		
		$host = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER;
		if ($this->request->server['REQUEST_URI'] == '/') {
			$data['og_url'] = $this->url->link('common/home');
		} else {
			$data['og_url'] = $host . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		}
		
		$data['og_image'] = $this->document->getOgImage();
		


		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
		
		$data['home'] = $this->url->link('common/home');

			$data['lang_id'] = $this->config->get('config_language_id');
			$data['callbackpro'] = $this->config->get('callbackpro');	
			
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['currency'] = $this->load->controller('common/currency');
		if ($this->config->get('configblog_blog_menu')) {
			$data['blog_menu'] = $this->load->controller('blog/menu');
		} else {
			$data['blog_menu'] = '';
		}
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['menu'] = $this->load->controller('common/menu');

		return $this->load->view('common/header', $data);
	}
}
