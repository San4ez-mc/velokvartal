<?php
class ControllerCommonColumnLeft extends Controller {
	public function index() {
		if (isset($this->request->get['user_token']) && isset($this->session->data['user_token']) && ($this->request->get['user_token'] == $this->session->data['user_token'])) {
			$this->load->language('common/column_left');

			// Create a 3 level menu array
			// Level 2 can not have children

			// Menu
			$data['menus'][] = array(
				'id'       => 'menu-dashboard',
				'icon'	   => 'fa-dashboard',
				'name'	   => $this->language->get('text_dashboard'),
				'href'     => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
				'children' => array()
			);

			// Catalog

		$syberstore = array();
		$syberstore[] = array(
			'name'	   => $this->language->get('text_cyberstore_theme'),
			'href'     => $this->url->link('extension/module/cyber_setting_theme', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		$syberstore[] = array(
			'name'	   => $this->language->get('text_add_demo'),
			'href'     => $this->url->link('cyberstore/cyberstoredemo', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		$this->load->language('extension/module/cyber_question_answer');
		$question_answer = (array)$this->config->get('qadata');
		$syberstore[] = array(
			'name'	   => $this->language->get('title_icon_header_qa'),
			'href'     => $this->url->link('extension/module/cyber_question_answer', 'tablist=1&user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);


		$found_cheaper_product = (array)$this->config->get('fcpdata');
		if (isset($found_cheaper_product['status']) && $found_cheaper_product['status']) {
		$syberstore[] = array(
			'name'	   => $this->language->get('title_icon_header_fcp'),
			'href'     =>  $this->url->link('extension/module/cyber_found_cheaper_product', 'tablist=1&user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
		}
      

       
			$cyber_news = array();
			if ($this->user->hasPermission('access', 'cyberstore/cyber_news_settings')) {
				$cyber_news[] = array(
					'name'	   => $this->language->get('text_cyber_news_settings'),
					'href'     => $this->url->link('cyberstore/cyber_news_settings', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if($this->config->get('cyber_news_status')){
				if ($this->user->hasPermission('access', 'cyberstore/cyber_news')) {
					$cyber_news[] = array(
						'name'     => $this->language->get('text_cyber_news_category'),
						'href'     => $this->url->link('cyberstore/cyber_news', 'user_token=' . $this->session->data['user_token'], true),
						'children' => array()	
					);
				}
				
				if ($this->user->hasPermission('access', 'cyberstore/cyber_news_articles')) {
					$cyber_news[] = array(
						'name'	   => $this->language->get('text_cyber_news_articles'),
						'href'     => $this->url->link('cyberstore/cyber_news_articles', 'user_token=' . $this->session->data['user_token'], true),
						'children' => array()		
					);
				}
				
				if ($this->user->hasPermission('access', 'cyberstore/cyber_news_review')) {
					$cyber_news[] = array(
						'name'	   => $this->language->get('text_cyber_news_review'),
						'href'     => $this->url->link('cyberstore/cyber_news_review', 'user_token=' . $this->session->data['user_token'], true),
						'children' => array()		
					);
				}
			}
			
			if ($cyber_news) {
				$syberstore[] = array(
					'name'	   => $this->language->get('text_cyber_news'),
					'href'     => '',
					'children' => $cyber_news
				);
			}
      

        $tabs_product_on_off = $this->config->get('tabs_product_on_off');
			if (isset($tabs_product_on_off['status']) && $tabs_product_on_off['status']) {
				if ($this->user->hasPermission('access', 'catalog/product_tabs')) {
					$syberstore[] = array(
						'name'	   => $this->language->get('text_product_tabs'),
						'href'     => $this->url->link('catalog/product_tabs', 'user_token=' . $this->session->data['user_token'], true),
						'children' => array()		
					);
				}
			}
      

       
			$reviews_store = array();
			
			if ($this->user->hasPermission('access', 'catalog/reviews_store')) {
				$reviews_store[] = array(
					'name'     => $this->language->get('text_reviews_store_list'),
					'href'     => $this->url->link('catalog/reviews_store', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()	
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/reviews_store')) {
				$reviews_store[] = array(
					'name'	   => $this->language->get('text_reviews_store_setting'),
					'href'     => $this->url->link('catalog/reviews_store/setting', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($reviews_store) {
				$syberstore[] = array(
					'name'	   => $this->language->get('text_reviews_store'),
					'href'     => '',
					'children' => $reviews_store
				);
			}
      
			$catalog = array();

		$syberstore[] = array(
			'name'	   => $this->language->get('title_fastorder'),
			'href'     => $this->url->link('sale/newfastorder', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()
		);
      

		$syberstore[] = array(
			'name'	   => $this->language->get('text_callback'),
			'href'     => $this->url->link('sale/callback', 'user_token=' . $this->session->data['user_token'], true),
			'children' => array()		
		);
      


		if ($syberstore) {
				$data['menus'][] = array(
					'id'       => 'menu-cyberstore',
					'icon'	   => 'view/image/CyberStore_icon.svg',
					'name'	   => $this->language->get('text_cyberstore_menu'),
					'href'     => '',
					'children' => $syberstore
				);
		}
      
			if ($this->user->hasPermission('access', 'catalog/category')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_category'),
					'href'     => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/product')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_product'),
					'href'     => $this->url->link('catalog/product', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/recurring')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_recurring'),
					'href'     => $this->url->link('catalog/recurring', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}


      // OCFilter start
			$ocfilter = array();

			if ($this->user->hasPermission('access', 'extension/module/ocfilter')) {
				$ocfilter[] = array(
					'name'     => $this->language->get('text_ocfilter_option'),
					'href'     => $this->url->link('extension/module/ocfilter/filter', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);

				$ocfilter[] = array(
					'name'	   => $this->language->get('text_ocfilter_page'),
					'href'     => $this->url->link('extension/module/ocfilter/page', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);

				$ocfilter[] = array(
					'name'	   => $this->language->get('text_ocfilter_setting'),
					'href'     => $this->url->link('extension/module/ocfilter', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($ocfilter) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_ocfilter'),
					'href'     => '',
					'children' => $ocfilter
				);
			}
		  // OCFilter end
      
			if ($this->user->hasPermission('access', 'catalog/filter')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_filter'),
					'href'     => $this->url->link('catalog/filter', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			// Attributes
			$attribute = array();

			if ($this->user->hasPermission('access', 'catalog/attribute')) {
				$attribute[] = array(
					'name'     => $this->language->get('text_attribute'),
					'href'     => $this->url->link('catalog/attribute', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/attribute_group')) {
				$attribute[] = array(
					'name'	   => $this->language->get('text_attribute_group'),
					'href'     => $this->url->link('catalog/attribute_group', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($attribute) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_attribute'),
					'href'     => '',
					'children' => $attribute
				);
			}

			if ($this->user->hasPermission('access', 'catalog/option')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_option'),
					'href'     => $this->url->link('catalog/option', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_manufacturer'),
					'href'     => $this->url->link('catalog/manufacturer', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

if ($this->user->hasPermission('access', 'catalog/suppler')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_suppler'),
					'href'     => $this->url->link('catalog/suppler', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			if ($this->user->hasPermission('access', 'catalog/download')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_download'),
					'href'     => $this->url->link('catalog/download', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/review')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_review'),
					'href'     => $this->url->link('catalog/review', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/information')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_information'),
					'href'     => $this->url->link('catalog/information', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($catalog) {
				$data['menus'][] = array(
					'id'       => 'menu-catalog',
					'icon'	   => 'fa-tags',
					'name'	   => $this->language->get('text_catalog'),
					'href'     => '',
					'children' => $catalog
				);
			}

			// BLOG
			$blog = array();
			if ($this->user->hasPermission('access', 'blog/article')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_article'),
					'href'     => $this->url->link('blog/article', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'blog/category')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_category'),
					'href'     => $this->url->link('blog/category', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'blog/review')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_review'),
					'href'     => $this->url->link('blog/review', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'blog/setting')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_setting'),
					'href'     => $this->url->link('blog/setting', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($blog) {
				$data['menus'][] = array(
					'id'       => 'menu-blog',
					'icon'	   => 'fa-book',
					'name'	   => $this->language->get('text_blog'),
					'href'     => '',
					'children' => $blog
				);
			}

			// Extension
			$marketplace = array();
			
			if ($this->user->hasPermission('access', 'marketplace/opencartforum')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_opencartforum'),
					'href'     => $this->url->link('marketplace/opencartforum', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/marketplace')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_marketplace'),
					'href'     => $this->url->link('marketplace/marketplace', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/installer')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_installer'),
					'href'     => $this->url->link('marketplace/installer', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/extension')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_extension'),
					'href'     => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'].'&type=module', true),
					'children' => array()
				);
			}


      $this->load->model('setting/extension');

      if (!in_array('universal_import', $this->model_setting_extension->getInstalled('module'))) {
        $marketplace[] = array(
					'name'	   => '<img style="vertical-align:top" src="view/universal_import/img/icon.png"/> Install Universal Import Pro',
					'href'     => $this->url->link('extension/extension/module/install', 'extension=universal_import&redir=1&user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
      } else if ($this->user->hasPermission('access', 'module/universal_import')) {
				$marketplace[] = array(
					'name'	   => '<img style="vertical-align:top" src="view/universal_import/img/icon.png"/> Universal Import Pro',
					'href'     => $this->url->link('module/universal_import', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
      
			if ($this->user->hasPermission('access', 'marketplace/modification')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_modification'),
					'href'     => $this->url->link('marketplace/modification', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}


                        $this->load->model('setting/extension');
                        if ($this->user->hasPermission('access', 'extension/module/exchange1c') && in_array('exchange1c', $this->model_setting_extension->getInstalled('module'))) {
				$marketplace[] = array(
				     'name'	   => 'Exchange 1C v8.x',
				     'href'     => $this->url->link('extension/module/exchange1c', 'user_token=' . $this->session->data['user_token'], true),
				     'children' => array()		
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/event')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_event'),
					'href'     => $this->url->link('marketplace/event', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($marketplace) {
				$data['menus'][] = array(
					'id'       => 'menu-extension',
					'icon'	   => 'fa-puzzle-piece',
					'name'	   => $this->language->get('text_extension'),
					'href'     => '',
					'children' => $marketplace
				);
			}

			// Design
			$design = array();

			if ($this->user->hasPermission('access', 'design/layout')) {
				$design[] = array(
					'name'	   => $this->language->get('text_layout'),
					'href'     => $this->url->link('design/layout', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/theme')) {
				$design[] = array(
					'name'	   => $this->language->get('text_theme'),
					'href'     => $this->url->link('design/theme', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/translation')) {
				$design[] = array(
					'name'	   => $this->language->get('text_language_editor'),
					'href'     => $this->url->link('design/translation', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/banner')) {
				$design[] = array(
					'name'	   => $this->language->get('text_banner'),
					'href'     => $this->url->link('design/banner', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/seo_url')) {
				$design[] = array(
					'name'	   => $this->language->get('text_seo_url'),
					'href'     => $this->url->link('design/seo_url', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($design) {
				$data['menus'][] = array(
					'id'       => 'menu-design',
					'icon'	   => 'fa-television',
					'name'	   => $this->language->get('text_design'),
					'href'     => '',
					'children' => $design
				);
			}

			// Sales
			$sale = array();

			if ($this->user->hasPermission('access', 'sale/order')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_order'),
					'href'     => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'sale/recurring')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_order_recurring'),
					'href'     => $this->url->link('sale/recurring', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'sale/return')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_return'),
					'href'     => $this->url->link('sale/return', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			// Voucher
			$voucher = array();

			if ($this->user->hasPermission('access', 'sale/voucher')) {
				$voucher[] = array(
					'name'	   => $this->language->get('text_voucher'),
					'href'     => $this->url->link('sale/voucher', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'sale/voucher_theme')) {
				$voucher[] = array(
					'name'	   => $this->language->get('text_voucher_theme'),
					'href'     => $this->url->link('sale/voucher_theme', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($voucher) {
				$sale[] = array(
					'name'	   => $this->language->get('text_voucher'),
					'href'     => '',
					'children' => $voucher
				);
			}

			if ($sale) {
				$data['menus'][] = array(
					'id'       => 'menu-sale',
					'icon'	   => 'fa-shopping-cart',
					'name'	   => $this->language->get('text_sale'),
					'href'     => '',
					'children' => $sale
				);
			}

			// Customer
			$customer = array();

			if ($this->user->hasPermission('access', 'customer/customer')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_customer'),
					'href'     => $this->url->link('customer/customer', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'customer/customer_group')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_customer_group'),
					'href'     => $this->url->link('customer/customer_group', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'customer/customer_approval')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_customer_approval'),
					'href'     => $this->url->link('customer/customer_approval', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'customer/custom_field')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_custom_field'),
					'href'     => $this->url->link('customer/custom_field', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($customer) {
				$data['menus'][] = array(
					'id'       => 'menu-customer',
					'icon'	   => 'fa-user',
					'name'	   => $this->language->get('text_customer'),
					'href'     => '',
					'children' => $customer
				);
			}

			// Marketing
			$marketing = array();


				if ($this->user->hasPermission('access', 'marketing/newsletter')) {
					$marketing[] = array(
						'name'	   => $this->language->get('text_newsletter'),
						'href'     => $this->url->link('marketing/newsletter', 'user_token=' . $this->session->data['user_token'], true),
						'children' => array()
					);
				}
      
			if ($this->user->hasPermission('access', 'marketing/marketing')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_marketing'),
					'href'     => $this->url->link('marketing/marketing', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketing/coupon')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_coupon'),
					'href'     => $this->url->link('marketing/coupon', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketing/contact')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_contact'),
					'href'     => $this->url->link('marketing/contact', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($marketing) {
				$data['menus'][] = array(
					'id'       => 'menu-marketing',
					'icon'	   => 'fa-share-alt',
					'name'	   => $this->language->get('text_marketing'),
					'href'     => '',
					'children' => $marketing
				);
			}

			// System
			$system = array();

			if ($this->user->hasPermission('access', 'setting/setting')) {
				$system[] = array(
					'name'	   => $this->language->get('text_setting'),
					'href'     => $this->url->link('setting/store', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			// Users
			$user = array();

			if ($this->user->hasPermission('access', 'user/user')) {
				$user[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => $this->url->link('user/user', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'user/user_permission')) {
				$user[] = array(
					'name'	   => $this->language->get('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'user/api')) {
				$user[] = array(
					'name'	   => $this->language->get('text_api'),
					'href'     => $this->url->link('user/api', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($user) {
				$system[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => '',
					'children' => $user
				);
			}

			// Localisation
			$localisation = array();

			if ($this->user->hasPermission('access', 'localisation/location')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_location'),
					'href'     => $this->url->link('localisation/location', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/language')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_language'),
					'href'     => $this->url->link('localisation/language', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/currency')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_currency'),
					'href'     => $this->url->link('localisation/currency', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/stock_status')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_stock_status'),
					'href'     => $this->url->link('localisation/stock_status', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/order_status')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_order_status'),
					'href'     => $this->url->link('localisation/order_status', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			// Returns
			$return = array();

			if ($this->user->hasPermission('access', 'localisation/return_status')) {
				$return[] = array(
					'name'	   => $this->language->get('text_return_status'),
					'href'     => $this->url->link('localisation/return_status', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/return_action')) {
				$return[] = array(
					'name'	   => $this->language->get('text_return_action'),
					'href'     => $this->url->link('localisation/return_action', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/return_reason')) {
				$return[] = array(
					'name'	   => $this->language->get('text_return_reason'),
					'href'     => $this->url->link('localisation/return_reason', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($return) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_return'),
					'href'     => '',
					'children' => $return
				);
			}

			if ($this->user->hasPermission('access', 'localisation/country')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_country'),
					'href'     => $this->url->link('localisation/country', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/zone')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_zone'),
					'href'     => $this->url->link('localisation/zone', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			
			if ($this->user->hasPermission('access', 'localisation/city')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_city'),
					'href'     => $this->url->link('localisation/city', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			if ($this->user->hasPermission('access', 'localisation/geo_zone')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_geo_zone'),
					'href'     => $this->url->link('localisation/geo_zone', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			// Tax
			$tax = array();

			if ($this->user->hasPermission('access', 'localisation/tax_class')) {
				$tax[] = array(
					'name'	   => $this->language->get('text_tax_class'),
					'href'     => $this->url->link('localisation/tax_class', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/tax_rate')) {
				$tax[] = array(
					'name'	   => $this->language->get('text_tax_rate'),
					'href'     => $this->url->link('localisation/tax_rate', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($tax) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_tax'),
					'href'     => '',
					'children' => $tax
				);
			}

			if ($this->user->hasPermission('access', 'localisation/length_class')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_length_class'),
					'href'     => $this->url->link('localisation/length_class', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/weight_class')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_weight_class'),
					'href'     => $this->url->link('localisation/weight_class', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($localisation) {
				$system[] = array(
					'name'	   => $this->language->get('text_localisation'),
					'href'     => '',
					'children' => $localisation
				);
			}

			// Tools
			$maintenance = array();

			if ($this->user->hasPermission('access', 'tool/upgrade')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_upgrade'),
					'href'     => $this->url->link('tool/upgrade', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'tool/backup')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_backup'),
					'href'     => $this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}


			if ($this->user->hasPermission('access', 'extension/export_import')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_export_import'),
					'href'     => $this->url->link('extension/export_import', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'tool/upload')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_upload'),
					'href'     => $this->url->link('tool/upload', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'tool/log')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_log'),
					'href'     => $this->url->link('tool/log', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($maintenance) {
				$system[] = array(
					'id'       => 'menu-maintenance',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_maintenance'),
					'href'     => '',
					'children' => $maintenance
				);
			}

			if ($system) {
				$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_system'),
					'href'     => '',
					'children' => $system
				);
			}

			$report = array();

			if ($this->user->hasPermission('access', 'report/report')) {
				$report[] = array(
					'name'	   => $this->language->get('text_reports'),
					'href'     => $this->url->link('report/report', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/online')) {
				$report[] = array(
					'name'	   => $this->language->get('text_online'),
					'href'     => $this->url->link('report/online', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/statistics')) {
				$report[] = array(
					'name'	   => $this->language->get('text_statistics'),
					'href'     => $this->url->link('report/statistics', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($report) {
				$data['menus'][] = array(
					'id'       => 'menu-report',
					'icon'	   => 'fa-bar-chart',
					'name'	   => $this->language->get('text_reports'),
					'href'     => '',
					'children' => $report
				);
			}

			// Stats
			if ($this->user->hasPermission('access', 'report/statistics')) {
				$this->load->model('sale/order');

				$order_total = (float)$this->model_sale_order->getTotalOrders();

				$this->load->model('report/statistics');

				$complete_total = (float)$this->model_report_statistics->getValue('order_complete');

				if ($complete_total && $order_total) {
					$data['complete_status'] = round(($complete_total / $order_total) * 100);
				} else {
					$data['complete_status'] = 0;
				}

				$processing_total = (float)$this->model_report_statistics->getValue('order_processing');

				if ($processing_total && $order_total) {
					$data['processing_status'] = round(($processing_total / $order_total) * 100);
				} else {
					$data['processing_status'] = 0;
				}

				$other_total = (float)$this->model_report_statistics->getValue('order_other');

				if ($other_total && $order_total) {
					$data['other_status'] = round(($other_total / $order_total) * 100);
				} else {
					$data['other_status'] = 0;
				}

				$data['statistics_status'] = true;
			} else {
				$data['statistics_status'] = false;
			}

			return $this->load->view('common/column_left', $data);
		}
	}
}
