<?php  
class ControllerExtensionModuleSocnetauth2 extends Controller {
	public $socnets = array(
		"vkontakte" => array(
			"key" => "vkontakte",
			"short" => "vk"
		),
		"odnoklassniki" => array(
			"key" => "odnoklassniki",
			"short" => "od"
		),
		"facebook" => array(
			"key" => "facebook",
			"short" => "fb"
		),
		"twitter" => array(
			"key" => "twitter",
			"short" => "tw"
		),
		"gmail" => array(
			"key" => "gmail",
			"short" => "gm"
		),
		"mailru" => array(
			"key" => "mailru",
			"short" => "mr"
		),
	);
	
	public function index() {
		
		if( $this->customer->isLogged() && $this->config->get('socnetauth2_widget_after')=='hide' ) return;
		
		$this->load->language('extension/module/socnetauth2');
		
		$socnetauth2_widget_name = $this->config->get('socnetauth2_widget_name');		
		
		if( !is_array($socnetauth2_widget_name) && 
				stristr($this->config->get('socnetauth2_label'), '{' ) != false &&
				stristr($this->config->get('socnetauth2_label'), '}' ) != false &&
				stristr($this->config->get('socnetauth2_label'), ';' ) != false &&
				stristr($this->config->get('socnetauth2_label'), ':' ) != false )
		{
			$socnetauth2_widget_name = unserialize($socnetauth2_widget_name);
		}
		
    	$data['heading_title'] = $socnetauth2_widget_name[ $this->config->get('config_language_id') ];
		
		$data['entry_email'] = $this->language->get('entry_email');		
		$data['entry_password'] = $this->language->get('entry_password');		
		$data['text_login'] = $this->language->get('text_login');		
		$data['text_register'] = $this->language->get('text_register');		
		$data['text_forgotten'] = $this->language->get('text_forgotten');		
		
		$data['text_register'] = $this->language->get('text_register');
    	$data['text_login'] = $this->language->get('text_login');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		
		$data['register'] = $this->url->link('account/register', '', true);
    	$data['login'] = $this->url->link('account/login', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['forgotten'] = $this->url->link('account/forgotten', '', true);
		$data['account'] = $this->url->link('account/account', '', true);
		$data['edit'] = $this->url->link('account/edit', '', true);
		$data['password'] = $this->url->link('account/password', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist');
		$data['order'] = $this->url->link('account/order', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['return'] = $this->url->link('account/return', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
		$data['action'] = $this->url->link('account/login', '', true);
		
		$data['socnetauth2_widget_format'] = $this->config->get('socnetauth2_widget_format');	
		
		$data['socnetauth2_widget_default'] = $this->config->get('socnetauth2_widget_default');	
		
		$data['socnetauth2_shop_folder'] = $this->config->get('socnetauth2_shop_folder');	
		
		if( $data['socnetauth2_shop_folder'] ) 
		$data['socnetauth2_shop_folder'] = $data['socnetauth2_shop_folder'].'/';
		
		if( $this->config->get('socnetauth2_showtype')=='window' )
		{
			$data['classname'] = 'socnetauth';	
		}
		else
		{
			$data['classname'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		$this->session->data['socnetauth2_lastlink'] = $this->request->server['REQUEST_URI'];

      	$data['socnetauth2_vkontakte_status'] = $this->config->get('socnetauth2_vkontakte_status');
      	$data['socnetauth2_odnoklassniki_status'] = $this->config->get('socnetauth2_odnoklassniki_status');
      	$data['socnetauth2_facebook_status'] = $this->config->get('socnetauth2_facebook_status');
      	$data['socnetauth2_twitter_status'] = $this->config->get('socnetauth2_twitter_status');

      	$data['socnetauth2_widget_format'] = $this->config->get('socnetauth2_widget_format');

		foreach($this->socnets as $socnet)
		{
			if( !$this->config->get('socnetauth2_'.$socnet['key'].'_status') ) continue;
			
			$data['socnetauth2_socnets'][] = $socnet;
		}

		$data['socnetauth2_confirm_block'] = '';
		
		if( !$this->customer->isLogged() ) 
		{			
			if( !empty($this->session->data['socnetauth2_confirmdata']) && 
				!empty($this->session->data['socnetauth2_confirmdata_show']) )
			{
				$data = unserialize( $this->session->data['socnetauth2_confirmdata'] );
				$socnetauth2_confirm_block = $this->config->get('socnetauth2_confirm_block');
				$socnetauth2_confirm_block = str_replace("#divframe_height#", (300-(32*(5-(count(unserialize($this->session->data['socnetauth2_confirmdata'])))))), $socnetauth2_confirm_block );
	
				$socnetauth2_confirm_block = str_replace("#frame_height#", (320-(32*(5-(count(unserialize($this->session->data['socnetauth2_confirmdata'])))))), $socnetauth2_confirm_block);
	
				if( strstr($this->session->data['socnetauth2_lastlink'], "?") )
				$socnetauth2_confirm_block = str_replace("#lastlink#", $this->session->data['socnetauth2_lastlink'].'&socnetauth2close=1', $socnetauth2_confirm_block);
				else
				$socnetauth2_confirm_block = str_replace("#lastlink#", $this->session->data['socnetauth2_lastlink'].'?socnetauth2close=1', $socnetauth2_confirm_block);
	
				$socnetauth2_confirm_block = str_replace("#frame_url#", $this->url->link( 'account/socnetauth2/frame','',true ), $socnetauth2_confirm_block);
	
				$data['socnetauth2_confirm_block'] = $socnetauth2_confirm_block;
			}
		} 
		
		if( isset($this->session->data['socnetauth2_confirmdata_show']) )
		{
			$data['socnetauth2_confirmdata_show'] = $this->session->data['socnetauth2_confirmdata_show'];
			unset($this->session->data['socnetauth2_confirmdata_show']);
		}
		
		return $this->load->view('extension/module/socnetauth2', $data);
		
	}
	
	public function sortMethods($socnetauth2_methods)
	{
		$sortable_arr = array();
		
		foreach($socnetauth2_methods as $key=>$val)
		{
			$val['k'] = $key;
			$sortable_arr[] = $val;
		}
		
		usort($sortable_arr, array($this, "cmp"));
		
		$sorted_socnetauth2_methods = array();
		
		foreach($sortable_arr as $key=>$val)
		{
			$sorted_socnetauth2_methods[ $val['k'] ] = $val;
		}
		
		return $sorted_socnetauth2_methods;
	}
	
	protected function cmp($a, $b)
	{
		if($a['sort'] == $b['sort']) {
			return 0;
		}
	
		return ($a['sort'] < $b['sort']) ? -1 : 1;
	}
	
	public function country() 
	{
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}

	private function getDomain() {
		if( ( isset($this->request->server['SERVER_PORT']) && $this->request->server['SERVER_PORT'] == '443' ) || !empty($this->request->server['HTTPS']) ) {
			return HTTPS_SERVER;
		} else {
			return HTTP_SERVER;
		}
	}
	
	public function facebook() {

		$this->load->model('extension/module/socnetauth2');

		$domain = $this->getDomain();

		$IS_DEBUG = $this->config->get('socnetauth2_facebook_debug');


		if( !$this->config->get('socnetauth2_facebook_status') )
		{
			$url = "Location: ".$this->request->server['HTTP_REFERER'];
			
			if($IS_DEBUG)
			{
				if( strstr($url, "?") )
				{
					$url .= '&error=1';
				}
				else
				{
					$url .= '?error=1';
				}
			}
			
			header($url);
			exit();
		}

		if( !empty($this->request->get['first']) )
		{
			$STATE = 'facebook_socnetauth2_'.rand();
			
			$CURRENT_URI = $this->request->server['HTTP_REFERER'];

			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/facebook';
				
			$CLIENT_ID = $this->config->get('socnetauth2_facebook_appid');
				
			setcookie("fb_state", $STATE);
			
			$url = 'https://www.facebook.com/dialog/oauth?'.
				'client_id='.$CLIENT_ID.
				'&redirect_uri='.urlencode($REDIRECT_URI).
				'&scope=public_profile,email&state='.$STATE;
			
			if($IS_DEBUG)
			{
				echo "M1: ".$url."<hr>";
			}
			
			$this->model_extension_module_socnetauth2->setRecord($STATE, $CURRENT_URI);
			header("Location: ".$url);
			exit();
		}

		if( !empty($this->request->get['error']) && !empty( $this->request->cookie['fb_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['fb_state'] ) )
		{
			if($IS_DEBUG)
			{
				if( strstr($recordData['redirect'], "?") )
				{
					$recordData['redirect'] .= '&error=2';
				}
				else
				{
					$recordData['redirect'] .= '?error=2';
				}
			}
			
			header("Location: ".$recordData['redirect']);
		}

		if( !empty( $this->request->get['state'] ) && !empty( $this->request->get['code'] ) &&
				$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->get['state'] ) )
		{
			$CODE = $this->request->get['code'];
			
			if($IS_DEBUG)
			{
				echo "M2:".$CODE."<hr>";
			}

			$CURRENT_URI = $recordData['redirect'];
			$CURRENT_URI = str_replace("?socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);
			
			$REDIRECT_URI = $domain.'index.php?route='.urlencode('extension/module/socnetauth2/facebook');

			if($IS_DEBUG)
			{
				echo "M3: ".$REDIRECT_URI."<hr>";
			}
			
			$CLIENT_ID = $this->config->get('socnetauth2_facebook_appid');
			$CLIENT_SECRET = $this->config->get('socnetauth2_facebook_appsecret');
			
			$url = "https://graph.facebook.com/oauth/access_token?".
						   "client_id=".$CLIENT_ID.
						   "&client_secret=".$CLIENT_SECRET.
						   "&code=".$CODE.
						   "&redirect_uri=".urlencode($REDIRECT_URI);
			if( $IS_DEBUG ) echo "M4: ".$url."<hr>";

			if( extension_loaded('curl') )
			{
				$c = curl_init($url);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($c, CURLOPT_VERBOSE, true);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($c);
				curl_close($c);
			}
			else
			{
				$response = file_get_contents($url);
			}
			
			if( $IS_DEBUG ) echo "M5: ".$response."<hr>";
			$data = null;
			$data = json_decode($response, true);	
			
			if( !empty($data['access_token']) )
			{
				$graph_url = "https://graph.facebook.com/me?access_token=".$data['access_token'].
				"&fields=first_name,last_name,email";
				if( $IS_DEBUG ) echo "M6: ".$graph_url."<hr>";
				
				if( extension_loaded('curl') )
				{
					$c = curl_init($graph_url);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($c, CURLOPT_VERBOSE, true);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($c);
					curl_close($c);
				}
				else
				{
					$json = file_get_contents($graph_url);
				}
				
				if( $IS_DEBUG ) echo "M7: ".$json."<hr>";
				$userdata = json_decode($json, TRUE);
				
				
				$arr = $userdata;
				
				$provider = 'facebook';
				
				$arr = array(
					'identity'  => $arr['id'],
					'firstname' => $arr['first_name'],
					'lastname'  => $arr['last_name'],
					'email'     => $arr['email'],
					'link'      => '',
					'telephone'	=> ''
				);
				
				$data = array(
					'identity'  => $arr['identity'],
					'link' 		=> '',
					'firstname' => '',
					'lastname'  => '',
					'email'     => '',
					'telephone'	=> '',
					'data'		=> serialize($arr),
					'provider'  => $provider
				);
				
				if( !empty( $arr['firstname'] ) )
				{
					$data['firstname'] = $arr['firstname'];
				}
				
				if( !empty( $arr['lastname'] ) )
				{
					$data['lastname'] = $arr['lastname'];
				}
				
				if( !empty( $arr['email'] ) )
				{
					$data['email'] = $arr['email'];
				}
				
				if( !empty( $arr['telephone'] ) )
				{
					$data['telephone'] = $ar['telephone'];
				}
				
				$data['company'] = '';
				$data['address_1'] = '';
				$data['postcode'] = '';
				$data['city'] = '';
				$data['zone'] = '';
				$data['country'] = '';
				
				$this->model_extension_module_socnetauth2->checkDB();
				
				$CURRENT_URI .= '#';
				
				if( $customer_id = $this->model_extension_module_socnetauth2->checkNew($data) )
				{
					$this->load->model('account/customer');
					$customer_data = $this->model_account_customer->getCustomer($customer_id);
					foreach ($customer_data as $cdkey => $cdvalue) {
						$data[$cdkey] = $cdvalue;
					}
					if( $this->config->get('socnetauth2_dobortype') != 'every' )
					{
						$this->session->data['customer_id'] = $customer_id;
						$this->session->data['socnetauth2_confirmdata_show'] = 0;
						
						if( $IS_DEBUG ) exit( "END-1 ".$CURRENT_URI."<hr>");
						
						header("Location: ".$CURRENT_URI ); 
					}
					else
					{
						if( $confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data ) )
						{
							$data['customer_id'] = $customer_id;
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
					
							if( $IS_DEBUG ) exit( "END-2 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['customer_id'] = $customer_id;
							$this->session->data['socnetauth2_confirmdata_show'] = 0;
							
							if( $IS_DEBUG ) exit( "END-3 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
					}
				}
				else
				{
					$confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data );
					
					if( !$this->config->get('socnetauth2_email_auth') || $this->config->get('socnetauth2_email_auth') == 'none' )
					{
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-4 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-5 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'confirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-6 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail и включено проверка email письмом
						elseif( !empty( $data['email'] ) && $this->model_extension_module_socnetauth2->checkByEmail($data, 0) )
						{
							$this->model_extension_module_socnetauth2->sendConfirmEmail($data);
							$this->session->data['socnetauth2_confirmdata'] = serialize(array(1, 2, 3, 4, $data['email'], $data['identity'], $data['link'], $data['provider'], $data));
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-7 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-8 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'noconfirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-9 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail 
						elseif( !empty( $data['email'] ) && $customer_id = $this->model_extension_module_socnetauth2->checkByEmail($data, 1) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-10 ".$CURRENT_URI."<hr>" );
						
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный 
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-11 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}	
					}
				}
			}
			
		}

	}

	public function vkontakte() {
		$this->load->model('extension/module/socnetauth2');

		$domain = $this->getDomain();

		$IS_DEBUG = $this->config->get('socnetauth2_vkontakte_debug');

		if( !$this->config->get('socnetauth2_vkontakte_status') )
		{
			$url = "Location: ".$this->request->server['HTTP_REFERER'];
			
			if($IS_DEBUG)
			{
				if( strstr($url, "?") )
				{
					$url .= '&error=1';
				}
				else
				{
					$url .= '?error=1';
				}
			}
			
			header($url);
			exit();
		}

		if( !empty($this->request->get['first']) )
		{
			$APP_ID = $this->config->get('socnetauth2_vkontakte_appid');
			$CURRENT_URI = $this->request->server['HTTP_REFERER'];
			
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("&amp;socnetauth2close=1", "", $CURRENT_URI);

			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/vkontakte';
				
			$STATE = 'vkontakte_socnetauth2_'.rand();
			$this->model_extension_module_socnetauth2->setRecord($STATE, $CURRENT_URI);

			setcookie("vk_state", $STATE);
			
			$url = 'https://oauth.vk.com/authorize?client_id='.$APP_ID.
				'&scope=SETTINGS,email'.
				'&redirect_uri='.$REDIRECT_URI.
				'&display=page&'.
				'response_type=code';
			
			header("Location: ".$url);
		}

		if( !empty($this->request->get['error']) && !empty( $this->request->cookie['vk_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['vk_state'] ) )
		{
			if($IS_DEBUG)
			{
				if( strstr($recordData['redirect'], "?") )
				{
					$recordData['redirect'] .= '&error=2';
				}
				else
				{
					$recordData['redirect'] .= '?error=2';
				}
			}
			
			header("Location: ".$recordData['redirect']);
		}

		if( !empty( $this->request->get['code'] ) && !empty( $this->request->cookie['vk_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['vk_state'] ) )
		{
			if($IS_DEBUG)
			{
				echo "M2<hr>";
			}
			$CODE = $this->request->get['code'];
			
			$CURRENT_URI = $recordData['redirect'];
			$CURRENT_URI = str_replace("?socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);

			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/vkontakte';
			
			$CLIENT_ID = $this->config->get('socnetauth2_vkontakte_appid');
			$CLIENT_SECRET = $this->config->get('socnetauth2_vkontakte_appsecret');
			
			$url = "https://oauth.vk.com/access_token?client_id=".$CLIENT_ID.
				   "&client_secret=".$CLIENT_SECRET.
				   "&code=".$CODE.'&redirect_uri='.$REDIRECT_URI.'&';
				   
			if($IS_DEBUG)
			{
				echo "M3: ".$url."<hr>";
			}
			
			if( extension_loaded('curl') )
			{
				$c = curl_init($url);
				curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);     
				curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2); 
				curl_setopt ($c, CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($c);
				curl_close($c);
			}
			else
			{
			
				$response = file_get_contents($url);
			}
		 
			if( $IS_DEBUG ) echo "M4: ".$response."<hr>";
			
			$data = json_decode($response, true);
			$email = '';
			if( !empty($data['email']) ) $email = $data['email'];
			
			if( !empty($data['access_token']) )
			{
				$graph_url = "https://api.vk.com/method/users.get?user_ids=".$data['user_id'].
				"&fields=uid,first_name,last_name,city,country&v=3.0&access_token=".$data['access_token'];
				
				if( $IS_DEBUG ) echo "M5: ".$graph_url."<hr>";
				
				if( extension_loaded('curl') )
				{
					$c = curl_init($graph_url);
					curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);     
					curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($c);
					curl_close($c);
				}
				else
				{
					$json = file_get_contents($graph_url);
				}

				if( $IS_DEBUG ) echo "M7: ".$json."<hr>";
				$userdata = json_decode($json, TRUE);
				
				$arr = $userdata['response'][0];
				
				$provider = 'vkontakte';
				
				$arr = array(
					'identity' => $arr['uid'],
					'firstname' => $arr['first_name'],
					'lastname'  => $arr['last_name'],
					'email'     => $email,
					'telephone'	=> ''
				);
				
				$data = array(
					'identity'  => $arr['identity'],
					'link' 		=> 'http://vk.com/id'.$arr['identity'],
					'firstname' => '',
					'lastname'  => '',
					'email'     => $email,
					'telephone'	=> '',
					'data'		=> serialize($arr),
					'provider'  => $provider
				);
				
				if( !empty( $arr['firstname'] ) )
				{
					$data['firstname'] = $arr['firstname'];
				}
				
				if( !empty( $arr['lastname'] ) )
				{
					$data['lastname'] = $arr['lastname'];
				}
				
				if( !empty( $arr['email'] ) )
				{
					$data['email'] = $arr['email'];
				}
				
				if( !empty( $arr['telephone'] ) )
				{
					$data['telephone'] = $ar['telephone'];
				}
				
				$data['company'] = '';
				$data['address_1'] = '';
				$data['postcode'] = '';
				$data['city'] = '';
				$data['zone'] = '';
				$data['country'] = '';
						
				$this->model_extension_module_socnetauth2->checkDB();
				
				if( $customer_id = $this->model_extension_module_socnetauth2->checkNew($data) )
				{
					$this->load->model('account/customer');
					$customer_data = $this->model_account_customer->getCustomer($customer_id);
					foreach ($customer_data as $cdkey => $cdvalue) {
						$data[$cdkey] = $cdvalue;
					}
					if( $this->config->get('socnetauth2_dobortype') != 'every' )
					{
						$this->session->data['customer_id'] = $customer_id;
						$this->session->data['socnetauth2_confirmdata_show'] = 0;
						
						if( $IS_DEBUG ) exit( "END-1 ".$CURRENT_URI."<hr>");
						header("Location: ".$CURRENT_URI ); 
					}
					else
					{
						if( $confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data ) )
						{
							$data['customer_id'] = $customer_id;
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-2 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['customer_id'] = $customer_id;
							$this->session->data['socnetauth2_confirmdata_show'] = 0;
							
							if( $IS_DEBUG ) exit( "END-3 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
				}
				else
				{
					$confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data );
					
					if( !$this->config->get('socnetauth2_email_auth') || $this->config->get('socnetauth2_email_auth') == 'none' )
					{
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-4 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	

							if( $IS_DEBUG ) exit( "END-5 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'confirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-6 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail и включено проверка email письмом
						elseif( !empty( $data['email'] ) && $this->model_extension_module_socnetauth2->checkByEmail($data, 0) )
						{							
							$this->model_extension_module_socnetauth2->sendConfirmEmail($data);
							$this->session->data['socnetauth2_confirmdata'] = serialize(array(1, 2, 3, 4, $data['email'], $data['identity'], $data['link'], $data['provider'], $data));
							$this->session->data['socnetauth2_confirmdata_show'] = 1;

							if( $IS_DEBUG ) exit( "END-7 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	

							if( $IS_DEBUG ) exit( "END-8 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'noconfirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-9 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail 
						elseif( !empty( $data['email'] ) && $customer_id = $this->model_extension_module_socnetauth2->checkByEmail($data, 1) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
							$this->session->data['customer_id'] = $customer_id;	

							if( $IS_DEBUG ) exit( "END-10 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный 
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-11 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}	
					}
				}
			}
			
		}
	}

	public function twitter() {
		$this->load->model('extension/module/socnetauth2');
		require_once(DIR_SYSTEM.'library/socnetauth2/twitter/twitteroauth.php');

		$domain = $this->getDomain();

		$IS_DEBUG = $this->config->get('socnetauth2_twitter_debug');

		if( !$this->config->get('socnetauth2_twitter_status') )
		{
			$url = "Location: ".$this->request->server['HTTP_REFERER'];
			
			if($IS_DEBUG)
			{
				if( strstr($url, "?") )
				{
					$url .= '&error=1';
				}
				else
				{
					$url .= '?error=1';
				}
			}
			
			header($url);
			exit();
		}

		$CONSUMER_KEY = $this->config->get('socnetauth2_twitter_consumer_key');
		$CONSUMER_SECRET = $this->config->get('socnetauth2_twitter_consumer_secret');
		$CALLBACK_URL = $domain.'index.php?route=extension/module/socnetauth2/twitter';

		if( $IS_DEBUG  )
		{
			echo $CALLBACK_URL."<hr>";
		}

		define("CONSUMER_KEY", $CONSUMER_KEY);
		define("CONSUMER_SECRET", $CONSUMER_SECRET);
		define("CALLBACK_URL", $CALLBACK_URL);

		if( !empty($this->request->get['error']) && !empty( $this->request->cookie['tw_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['tw_state'] ) )
		{
			if($IS_DEBUG)
			{
				if( strstr($recordData['redirect'], "?") )
				{
					$recordData['redirect'] .= '&error=2';
				}
				else
				{
					$recordData['redirect'] .= '?error=2';
				}
			}
			
			header("Location: ".$recordData['redirect']);
		}

		if( empty($_REQUEST['oauth_token']) )
		{
			if($IS_DEBUG)
			{
				echo "M2<hr>";
			}
			
		    $twitteroauth = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);    
		    $request_token = $twitteroauth->getRequestToken($CALLBACK_URL);
		    
		    $this->session->data['oauth_token'] = $request_token['oauth_token'];  
		    $this->session->data['oauth_token_secret'] = $request_token['oauth_token_secret'];  
		    
			$STATE = md5($request_token['oauth_token'].$request_token['oauth_token_secret']);
			setcookie("tw_state", $STATE);
			
			$this->model_extension_module_socnetauth2->setRecord($STATE, $this->request->server['HTTP_REFERER']);
			
		    if($twitteroauth->http_code==200){  
		        $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 

				if($IS_DEBUG)
				{
					if( strstr($url, "?") )
					{
						$url .= '&error=2';
					}
					else
					{
						$url .= '?error=2';
					}
				}
				
		        header('Location: '. $url); 
		    } else {          
		        die('Something wrong happened.');  
		    }  

		}
		elseif( $recordData = $this->model_extension_module_socnetauth2->getRecord( md5($this->session->data['oauth_token'].$this->session->data['oauth_token_secret']) ) ) 
		{
			if($IS_DEBUG)
			{
				echo "M3<hr>";
			}
			
			$twitteroauth = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $this->session->data['oauth_token'], $this->session->data['oauth_token_secret']);
		    $access_token = $twitteroauth->getAccessToken($this->request->get['oauth_verifier']);      
		    $this->session->data['access_token'] = $access_token; 
		    $userdata = $twitteroauth->get('account/verify_credentials', array('include_email'=>'true'));
			
			$CURRENT_URI = $recordData['redirect'];
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("?socnetauth2close=1", "", $CURRENT_URI);
			
			if($IS_DEBUG)
			{
				echo "M4: ".$CURRENT_URI."<hr>";
			}

			$provider = 'twitter';
			
			$ar1 = explode(" ", $userdata->name);
			$first_name = $ar1[0];
			$last_name = $ar1[1];
			
			$arr = array(
					'identity' => $userdata->id,
					'firstname' => $ar1[0],
					'lastname'  => $ar1[1],
					'email'     => $userdata->email,
					'telephone'	=> '',
					'link'		=> "https://twitter.com/".$userdata->screen_name
				);
			
			$data = array(
					'identity'  => $arr['identity'],
					'link' 		=> $arr['link'],
					'firstname' => '',
					'lastname'  => '',
					'email'     => '',
					'telephone'	=> '',
					'data'		=> serialize($arr),
					'provider'  => $provider
			);
				
			if( !empty( $arr['firstname'] ) )
			{
				$data['firstname'] = $arr['firstname'];
			}
				
			if( !empty( $arr['lastname'] ) )
			{
				$data['lastname'] = $arr['lastname'];
			}
				
			if( !empty( $arr['email'] ) )
			{
				$data['email'] = $arr['email'];
			}
				
			if( !empty( $arr['telephone'] ) )
			{
				$data['telephone'] = $ar['telephone'];
			}
				
			$data['company'] = '';
			$data['address_1'] = '';
			$data['postcode'] = '';
			$data['city'] = '';
			$data['zone'] = '';
			$data['country'] = '';
	
			$this->model_extension_module_socnetauth2->checkDB();
				
				if( $customer_id = $this->model_extension_module_socnetauth2->checkNew($data) )
				{
					$this->load->model('account/customer');
					$customer_data = $this->model_account_customer->getCustomer($customer_id);
					foreach ($customer_data as $cdkey => $cdvalue) {
						$data[$cdkey] = $cdvalue;
					}
					if( $this->config->get('socnetauth2_dobortype') != 'every' )
					{
						$this->session->data['customer_id'] = $customer_id;
						$this->session->data['socnetauth2_confirmdata_show'] = 0;
						
						if( $IS_DEBUG ) exit( "END-1 ".$CURRENT_URI."<hr>");
						header("Location: ".$CURRENT_URI ); 
					}
					else
					{
						if( $confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data ) )
						{
							$data['customer_id'] = $customer_id;
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-2 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['customer_id'] = $customer_id;
							$this->session->data['socnetauth2_confirmdata_show'] = 0;
							
							if( $IS_DEBUG ) exit( "END-3 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
				}
				else
				{
					$confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data );
					
					if( !$this->config->get('socnetauth2_email_auth') || $this->config->get('socnetauth2_email_auth') == 'none' )
					{
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-4 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
							
							if( $IS_DEBUG ) exit( "END-5 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'confirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-6 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail и включено проверка email письмом
						elseif( !empty( $data['email'] ) && $this->model_extension_module_socnetauth2->checkByEmail($data, 0) )
						{							
							$this->model_extension_module_socnetauth2->sendConfirmEmail($data);
							$this->session->data['socnetauth2_confirmdata'] = serialize(array(1, 2, 3, 4, $data['email'], $data['identity'], $data['link'], $data['provider'], $data));
							$this->session->data['socnetauth2_confirmdata_show'] = 1;

							if( $IS_DEBUG ) exit( "END-7 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	

							if( $IS_DEBUG ) exit( "END-8 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'noconfirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-9 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail 
						elseif( !empty( $data['email'] ) && $customer_id = $this->model_extension_module_socnetauth2->checkByEmail($data, 1) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
							$this->session->data['customer_id'] = $customer_id;	

							if( $IS_DEBUG ) exit( "END-10 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный 
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	

							if( $IS_DEBUG ) exit( "END-11 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}	
					}
				}
		}
	}

	public function gmail() {
		$this->load->model('extension/module/socnetauth2');
		$domain = $this->getDomain();

		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Client.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Config.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Auth/Abstract.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Auth/OAuth2.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Service.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Exception.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Auth/Exception.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Model.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Utils.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/IO/Abstract.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/IO/Curl.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Http/Request.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Http/CacheParser.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Service/Resource.php');
		require_once(DIR_SYSTEM.'library/socnetauth2/gmail/src/Google/Service/Oauth2.php');

		$IS_DEBUG = $this->config->get('socnetauth2_gmail_debug');

		if( !$this->config->get('socnetauth2_gmail_status') )
		{
			$url = "Location: ".$this->request->server['HTTP_REFERER'];
			
			if($IS_DEBUG)
			{
				if( strstr($url, "?") )
				{
					$url .= '&error=1';
				}
				else
				{
					$url .= '?error=1';
				}
			}
			
			header($url);
			exit();
		}

		if( !empty($this->request->get['first']) )
		{
			$STATE = 'gmail_socnetauth2_'.rand();
			
			$CURRENT_URI = $this->request->server['HTTP_REFERER'];
			
			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/gmail';
			
			if($IS_DEBUG)
			{
				echo "M1: ".$REDIRECT_URI."<hr>";
			}
			
			$CLIENT_ID = $this->config->get('socnetauth2_gmail_client_id');
			$CLIENT_SECRET = $this->config->get('socnetauth2_gmail_client_secret');
	
			$this->model_extension_module_socnetauth2->setRecord($STATE, $CURRENT_URI);
			setcookie("gm_state", $STATE);

			$client = new Google_Client();
			$client->setClientId($CLIENT_ID);
			$client->setClientSecret($CLIENT_SECRET);
			$client->setRedirectUri($REDIRECT_URI);
			$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");
			
			$url = $client->createAuthUrl().'&';

			
			header("Location: ".$url);
			
			exit();
		}

		if( !empty($this->request->get['error']) && !empty( $this->request->cookie['gm_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['gm_state'] ) )
		{
			if($IS_DEBUG)
			{
				if( strstr($recordData['redirect'], "?") )
				{
					$recordData['redirect'] .= '&error=2';
				}
				else
				{
					$recordData['redirect'] .= '?error=2';
				}
			}
			
			
			header("Location: ".$recordData['redirect']);
		}

		if( !empty( $this->request->get['code'] ) && !empty( $this->request->cookie['gm_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['gm_state'] ) )
		{
			$CODE = $this->request->get['code'];
			
			if($IS_DEBUG)
			{
				echo "M2<hr>";
			}
			
			$CURRENT_URI = $recordData['redirect'];
			$CURRENT_URI = str_replace("?socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);
			
			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/gmail';
			
			if($IS_DEBUG)
			{
				echo "M3: ".$REDIRECT_URI."<hr>";
			}
			
			$CLIENT_ID = $this->config->get('socnetauth2_gmail_client_id');
			$CLIENT_SECRET = $this->config->get('socnetauth2_gmail_client_secret');
			
			$client = new Google_Client();
			$client->setClientId($CLIENT_ID);
			$client->setClientSecret($CLIENT_SECRET);
			$client->setRedirectUri($REDIRECT_URI);
			$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");

			$service = new Google_Service_Oauth2($client);
			
			$client->authenticate($this->request->get['code']);
			
			if( !$client->getAccessToken() ) exit('error1');
			
			$data = json_decode($client->getAccessToken(), 1);
			
			if( $IS_DEBUG ) echo "M4<hr>";
			
			if( !empty($data['access_token']) )
			{	
				$graph_url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$data['access_token'];
				
				if( $IS_DEBUG ) echo "M5: ".$graph_url."<hr>";
				
				if( extension_loaded('curl') )
				{
					$c = curl_init($graph_url);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($c);
					curl_close($c);
				}
				else
				{
					$json = file_get_contents($graph_url);
				}
				
				if( $IS_DEBUG ) echo "M7: ".$json."<hr>";
				
				$userdata = json_decode($json, TRUE);
				
				
				$arr = $userdata;
				
				$provider = 'gmail';
				
				$arr = array(
					'identity' => $arr['id'],
					'firstname' => $arr['given_name'],
					'lastname'  => $arr['family_name'],
					'email'     => $arr['email'],
					'telephone'	=> ''
				);
				
				$data = array(
					'identity'  => $arr['identity'],
					'link' 		=> '',
					'firstname' => '',
					'lastname'  => '',
					'email'     => '',
					'telephone'	=> '',
					'data'		=> serialize($arr),
					'provider'  => $provider
				);
				
				if( !empty( $arr['firstname'] ) )
				{
					$data['firstname'] = $arr['firstname'];
				}
				
				if( !empty( $arr['lastname'] ) )
				{
					$data['lastname'] = $arr['lastname'];
				}
				
				if( !empty( $arr['email'] ) )
				{
					$data['email'] = $arr['email'];
				}
				
				if( !empty( $arr['telephone'] ) )
				{
					$data['telephone'] = $ar['telephone'];
				}
				
				$data['company'] = '';
				$data['address_1'] = '';
				$data['postcode'] = '';
				$data['city'] = '';
				$data['zone'] = '';
				$data['country'] = '';			
				
				$this->model_extension_module_socnetauth2->checkDB();
				
				if( $customer_id = $this->model_extension_module_socnetauth2->checkNew($data) )
				{
					$this->load->model('account/customer');
					$customer_data = $this->model_account_customer->getCustomer($customer_id);
					foreach ($customer_data as $cdkey => $cdvalue) {
						$data[$cdkey] = $cdvalue;
					}
					if( $this->config->get('socnetauth2_dobortype') != 'every' )
					{
						$this->session->data['customer_id'] = $customer_id;
						$this->session->data['socnetauth2_confirmdata_show'] = 0;
						
						if( $IS_DEBUG ) exit( "END-1 ".$CURRENT_URI."<hr>");
						header("Location: ".$CURRENT_URI ); 
					}
					else
					{
						if( $confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data ) )
						{
							$data['customer_id'] = $customer_id;
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-2 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['customer_id'] = $customer_id;
							$this->session->data['socnetauth2_confirmdata_show'] = 0;
							
							if( $IS_DEBUG ) exit( "END-3 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
				}
				else
				{
					$confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data );
					
					if( !$this->config->get('socnetauth2_email_auth') || $this->config->get('socnetauth2_email_auth') == 'none' )
					{
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-4 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
							
							if( $IS_DEBUG ) exit( "END-5 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'confirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
				
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-6 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail и включено проверка email письмом
						elseif( !empty( $data['email'] ) && $this->model_extension_module_socnetauth2->checkByEmail($data, 0) )
						{				
							$this->model_extension_module_socnetauth2->sendConfirmEmail($data);
							$this->session->data['socnetauth2_confirmdata'] = serialize(array(1, 2, 3, 4, $data['email'], $data['identity'], $data['link'], $data['provider'], $data));
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-7 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
						
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-8 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'noconfirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-9 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail 
						elseif( !empty( $data['email'] ) && $customer_id = $this->model_extension_module_socnetauth2->checkByEmail($data, 1) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-10 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный 
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							if( $IS_DEBUG ) exit( "END-11 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}	
					}
				}
				
			}
			
		}

	}

	public function mailru() {
		$this->load->model('extension/module/socnetauth2');
		$domain = $this->getDomain();

		$IS_DEBUG = $this->config->get('socnetauth2_mailru_debug');

		if( !$this->config->get('socnetauth2_mailru_status') )
		{
			$url = "Location: ".$this->request->server['HTTP_REFERER'];
			
			if($IS_DEBUG)
			{
				if( strstr($url, "?") )
				{
					$url .= '&error=1';
				}
				else
				{
					$url .= '?error=1';
				}
			}
			
			header($url);
			exit();
		}

		if( !empty($this->request->get['first']) )
		{
			$STATE = 'mailru_socnetauth2_'.rand();
			
			$CURRENT_URI = $this->request->server['HTTP_REFERER'];
			
			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/mailru';
			
			$CLIENT_ID = $this->config->get('socnetauth2_mailru_id');
					
			$this->model_extension_module_socnetauth2->setRecord($STATE, $CURRENT_URI);
			setcookie("mr_state", $STATE);
			
			$url = 	'https://connect.mail.ru/oauth/authorize?client_id='.$CLIENT_ID.
					'&response_type=code&scope=&redirect_uri='.urlencode($REDIRECT_URI);

			header("Location: ".$url);
			
			exit();
		}

		if( !empty($this->request->get['error']) && !empty( $this->request->cookie['mr_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['mr_state'] ) )
		{
			if($IS_DEBUG)
			{
				if( strstr($recordData['redirect'], "?") )
				{
					$recordData['redirect'] .= '&error=2';
				}
				else
				{
					$recordData['redirect'] .= '?error=2';
				}
			}
			
			header("Location: ".$recordData['redirect']);
		}

		if( !empty( $this->request->get['code'] ) && !empty( $this->request->cookie['mr_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['mr_state'] ) )
		{
			if($IS_DEBUG)
			{
				echo "M2<hr>";
			}
			$CODE = $this->request->get['code'];
			
			$CURRENT_URI = $recordData['redirect'];
			$CURRENT_URI = str_replace("?socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);

			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/mailru';

			if($IS_DEBUG)
			{
				echo "M3: ".$REDIRECT_URI."<hr>";
			}

			$CLIENT_ID = $this->config->get('socnetauth2_mailru_id');
			$CLIENT_SECRET = $this->config->get('socnetauth2_mailru_secret');
			$CLIENT_PRIVATE = $this->config->get('socnetauth2_mailru_private');

			$url = 'https://connect.mail.ru/oauth/token';
			$fields = array(
								'client_id' => urlencode($CLIENT_ID),
								'client_secret' => urlencode($CLIENT_SECRET),
								'grant_type' => 'authorization_code',
								'code' => urlencode($this->request->get['code']),
								'redirect_uri' => urlencode($REDIRECT_URI)
						);
			//url-ify the data for the POST
			$fields_string = '';
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
			
			$data = json_decode($result, 1);
			 
			if( $IS_DEBUG ) echo "M4<hr>";
			
			if( !empty($data['access_token']) )
			{	
				$request_params = array(
					'app_id' => $CLIENT_ID,
					'method' => 'users.getInfo',
					'secure' => 1,
					'session_key' => $data['access_token'],
					'uids' => $data['x_mailru_vid'],
				);
		 
				$params = '';
				
				foreach ($request_params as $key => $value)
				$params .= "$key=$value";
		 
				
				$graph_url = 'http://www.appsmail.ru/platform/api'.'?'.http_build_query($request_params).
					   '&sig='.md5($params.$CLIENT_SECRET);
		 
				
				if( $IS_DEBUG ) echo "M5: ".$graph_url."<hr>";
				
				if( extension_loaded('curl') )
				{
					$c = curl_init($graph_url);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($c);
					curl_close($c);
				}
				else
				{
					$json = file_get_contents($graph_url);
				}
				
				if( $IS_DEBUG ) echo "M7: ".$json."<hr>";
				
				$userdata = json_decode($json, TRUE);
				
				$arr = $userdata[0];
				
				$provider = 'mailru';
				
				$arr = array(
					'identity' => $arr['uid'],
					'firstname' => $arr['first_name'],
					'lastname'  => $arr['last_name'],
					'email'     => isset($arr['email']) ? $arr['email'] : '',
					'telephone'	=> ''
				);
				
				$data = array(
					'identity'  => $arr['identity'],
					'link' 		=> '',
					'firstname' => '',
					'lastname'  => '',
					'email'     => '',
					'telephone'	=> '',
					'data'		=> serialize($arr),
					'provider'  => $provider
				);
				
				if( !empty( $arr['firstname'] ) )
				{
					$data['firstname'] = $arr['firstname'];
				}
				
				if( !empty( $arr['lastname'] ) )
				{
					$data['lastname'] = $arr['lastname'];
				}
				
				if( !empty( $arr['email'] ) )
				{
					$data['email'] = $arr['email'];
				}
				
				if( !empty( $arr['telephone'] ) )
				{
					$data['telephone'] = $ar['telephone'];
				}
				
				$data['company'] = '';
				$data['address_1'] = '';
				$data['postcode'] = '';
				$data['city'] = '';
				$data['zone'] = '';
				$data['country'] = '';
						
				$this->model_extension_module_socnetauth2->checkDB();
				
				if( $customer_id = $this->model_extension_module_socnetauth2->checkNew($data) )
				{
					$this->load->model('account/customer');
					$customer_data = $this->model_account_customer->getCustomer($customer_id);
					foreach ($customer_data as $cdkey => $cdvalue) {
						$data[$cdkey] = $cdvalue;
					}
					if( $this->config->get('socnetauth2_dobortype') != 'every' )
					{
						$this->session->data['customer_id'] = $customer_id;
						$this->session->data['socnetauth2_confirmdata_show'] = 0;
						
						if( $IS_DEBUG ) exit( "END-1 ".$CURRENT_URI."<hr>");
						header("Location: ".$CURRENT_URI ); 
					}
					else
					{
						if( $confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data ) )
						{
							$data['customer_id'] = $customer_id;
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-2 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['customer_id'] = $customer_id;
							$this->session->data['socnetauth2_confirmdata_show'] = 0;
							
							if( $IS_DEBUG ) exit( "END-3 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
				}
				else
				{
					$confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data );
					
					if( !$this->config->get('socnetauth2_email_auth') || $this->config->get('socnetauth2_email_auth') == 'none' )
					{
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-4 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							
							if( $IS_DEBUG ) exit( "END-5 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'confirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-6 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail и включено проверка email письмом
						elseif( !empty( $data['email'] ) && $this->model_extension_module_socnetauth2->checkByEmail($data, 0) )
						{							
							$this->model_extension_module_socnetauth2->sendConfirmEmail($data);
							$this->session->data['socnetauth2_confirmdata'] = serialize(array(1, 2, 3, 4, $data['email'], $data['identity'], $data['link'], $data['provider'], $data));
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							
							if( $IS_DEBUG ) exit( "END-7 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							
							if( $IS_DEBUG ) exit( "END-8 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'noconfirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-9 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail 
						elseif( !empty( $data['email'] ) && $customer_id = $this->model_extension_module_socnetauth2->checkByEmail($data, 1) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
							$this->session->data['customer_id'] = $customer_id;	
						
							
							if( $IS_DEBUG ) exit( "END-10 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный 
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							
							if( $IS_DEBUG ) exit( "END-11 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}	
					}
				}
			}
			
		}

	}

	public function odnoklassniki() {
		$this->load->model('extension/module/socnetauth2');
		$domain = $this->getDomain();
		$IS_DEBUG = $this->config->get('socnetauth2_odnoklassniki_debug');

		if( !$this->config->get('socnetauth2_odnoklassniki_status') )
		{
			$url = "Location: ".$this->request->server['HTTP_REFERER'];
			
			if($IS_DEBUG)
			{
				if( strstr($url, "?") )
				{
					$url .= '&error=1';
				}
				else
				{
					$url .= '?error=1';
				}
			}
			
			header($url);
			exit();
		}

		if( !empty($this->request->get['first']) )
		{
			$APPLICATION_ID = $this->config->get('socnetauth2_odnoklassniki_application_id');

			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/odnoklassniki';
			
			$CURRENT_URI = $this->request->server['HTTP_REFERER'];
				
			$STATE = 'odnoklassniki_socnetauth2_'.rand();
			$this->model_extension_module_socnetauth2->setRecord($STATE, $CURRENT_URI);
				
			setcookie("od_state", $STATE);
				
			$url = 'http://www.odnoklassniki.ru/oauth/authorize?client_id='.
			$APPLICATION_ID.'&response_type=code&redirect_uri='.urlencode($REDIRECT_URI);
			
			header("Location: ".$url);
		}

		if( !empty($this->request->get['error']) && !empty( $this->request->cookie['od_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['od_state'] ) )
		{
			if($IS_DEBUG)
			{
				if( strstr($recordData['redirect'], "?") )
				{
					$recordData['redirect'] .= '&error=2';
				}
				else
				{
					$recordData['redirect'] .= '?error=2';
				}
			}
			
			header("Location: ".$recordData['redirect']);
		}

		if( !empty( $this->request->get['code'] ) && !empty( $this->request->cookie['od_state'] ) &&
			$recordData = $this->model_extension_module_socnetauth2->getRecord( $this->request->cookie['od_state'] ) )
		{
			if($IS_DEBUG)
			{
				echo "M2<hr>";
			}
			$CODE = $this->request->get['code'];
			
			$CURRENT_URI = $recordData['redirect'];
			$CURRENT_URI = str_replace("?socnetauth2close=1", "", $CURRENT_URI);
			$CURRENT_URI = str_replace("&socnetauth2close=1", "", $CURRENT_URI);
			
			$REDIRECT_URI = $domain.'index.php?route=extension/module/socnetauth2/odnoklassniki';
			
			if($IS_DEBUG)
			{
				echo "M3: ".$REDIRECT_URI."<hr>";
			}
			
			$CLIENT_ID = $this->config->get('socnetauth2_odnoklassniki_application_id');
			$CLIENT_SECRET = $this->config->get('socnetauth2_odnoklassniki_secret_key');
			$CLIENT_PUBLIC = $this->config->get('socnetauth2_odnoklassniki_public_key');
			
			$POSTURL  = 'http://api.odnoklassniki.ru/oauth/token.do';
			$POSTVARS = 'code='.$CODE.'&redirect_uri='.$REDIRECT_URI.'&grant_type=authorization_code'.
			'&client_id='.$CLIENT_ID.'&client_secret='.$CLIENT_SECRET;
			
			$ch = curl_init($POSTURL);
			curl_setopt($ch, CURLOPT_POST      ,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS    , $POSTVARS);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
			curl_setopt($ch, CURLOPT_HEADER      ,0); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1); 
			$response = curl_exec($ch);
			curl_close($ch);
		 
			if( $IS_DEBUG ) echo "M4: ".$response."<hr>";
			
			$data = json_decode($response, true);
			
			if( !empty($data['access_token']) )
			{
				$SIGN = md5('application_key='.$CLIENT_PUBLIC.'method=users.getCurrentUser'.md5($data['access_token'].$CLIENT_SECRET));
				
				$graph_url = "http://api.odnoklassniki.ru/fb.do?method=users.getCurrentUser".
				"&access_token=".$data['access_token'].
				"&application_key=".$CLIENT_PUBLIC.
				"&sig=".$SIGN;
				
				if( $IS_DEBUG ) echo "M5: ".$graph_url."<hr>";
				
				if( extension_loaded('curl') )
				{
					$c = curl_init($graph_url);
					curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
					$json = curl_exec($c);
					curl_close($c);
				}
				else
				{
					$json = file_get_contents($graph_url);
				}
				
				if( $IS_DEBUG ) echo "M7: ".$json."<hr>";
				
				$userdata = json_decode($json, TRUE);
				
				$arr = $userdata;
				
				$provider = 'odnoklassniki';
				
				$arr = array(
					'identity' => $arr['uid'],
					'firstname' => $arr['first_name'],
					'lastname'  => $arr['last_name'],
					'email'     => $arr['email'],
					'telephone'	=> ''
				);
				
				$data = array(
					'identity'  => $arr['identity'],
					'link' 		=> "http://ok.ru/profile/".$arr['identity'],
					'firstname' => '',
					'lastname'  => '',
					'email'     => '',
					'telephone'	=> '',
					'data'		=> serialize($arr),
					'provider'  => $provider
				);
				
				if( !empty( $arr['firstname'] ) )
				{
					$data['firstname'] = $arr['firstname'];
				}
				
				if( !empty( $arr['lastname'] ) )
				{
					$data['lastname'] = $arr['lastname'];
				}
				
				if( !empty( $arr['email'] ) )
				{
					$data['email'] = $arr['email'];
				}
				
				if( !empty( $arr['telephone'] ) )
				{
					$data['telephone'] = $ar['telephone'];
				}
				
				$data['company'] = '';
				$data['address_1'] = '';
				$data['postcode'] = '';
				$data['city'] = '';
				$data['zone'] = '';
				$data['country'] = '';
				
				$this->model_extension_module_socnetauth2->checkDB();
				
				if( $customer_id = $this->model_extension_module_socnetauth2->checkNew($data) )
				{
					$this->load->model('account/customer');
					$customer_data = $this->model_account_customer->getCustomer($customer_id);
					foreach ($customer_data as $cdkey => $cdvalue) {
						$data[$cdkey] = $cdvalue;
					}
					if( $this->config->get('socnetauth2_dobortype') != 'every' )
					{
						$this->session->data['customer_id'] = $customer_id;
						$this->session->data['socnetauth2_confirmdata_show'] = 0;
						
						if( $IS_DEBUG ) exit( "END-1 ".$CURRENT_URI."<hr>");
						header("Location: ".$CURRENT_URI ); 
					}
					else
					{
						if( $confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data ) )
						{
							$data['customer_id'] = $customer_id;
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-2 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['customer_id'] = $customer_id;
							$this->session->data['socnetauth2_confirmdata_show'] = 0;
							
							if( $IS_DEBUG ) exit( "END-3 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
				}
				else
				{
					$confirm_data = $this->model_extension_module_socnetauth2->isNeedConfirm( $data );
					
					if( !$this->config->get('socnetauth2_email_auth') || $this->config->get('socnetauth2_email_auth') == 'none' )
					{
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-4 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						else
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
							
							if( $IS_DEBUG ) exit( "END-5 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'confirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-6 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail и включено проверка email письмом
						elseif( !empty( $data['email'] ) && $this->model_extension_module_socnetauth2->checkByEmail($data, 0) )
						{							
							$this->model_extension_module_socnetauth2->sendConfirmEmail($data);
							$this->session->data['socnetauth2_confirmdata'] = serialize(array(1, 2, 3, 4, $data['email'], $data['identity'], $data['link'], $data['provider'], $data));
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							
							if( $IS_DEBUG ) exit( "END-7 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;
							
							if( $IS_DEBUG ) exit( "END-8 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
					}
					elseif( $this->config->get('socnetauth2_email_auth') == 'noconfirm'  )
					{
						// требуется добор данных
						if( $confirm_data )
						{
							$confirm_data['data'] = $data;
							$this->session->data['socnetauth2_confirmdata'] = serialize($confirm_data);
							$this->session->data['socnetauth2_confirmdata_show'] = 1;
							
							if( $IS_DEBUG ) exit( "END-9 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}
						// Получен E-mail 
						elseif( !empty( $data['email'] ) && $customer_id = $this->model_extension_module_socnetauth2->checkByEmail($data, 1) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
							$this->session->data['customer_id'] = $customer_id;	
							
							if( $IS_DEBUG ) exit( "END-10 ".$CURRENT_URI."<hr>");
						
							header("Location: ".$CURRENT_URI );
						}
						//Получен e-mail и он уникальный 
						elseif( empty( $data['email'] ) ||
							 ( !empty( $data['email'] ) && !$this->model_extension_module_socnetauth2->checkByEmail($data, 0) ) )
						{
							$this->session->data['socnetauth2_confirmdata'] = '';
							$this->session->data['socnetauth2_confirmdata_show'] = '';
						
							$customer_id = $this->model_extension_module_socnetauth2->addCustomer( $data );
							$this->session->data['customer_id'] = $customer_id;	
						
							
							if( $IS_DEBUG ) exit( "END-11 ".$CURRENT_URI."<hr>");
							header("Location: ".$CURRENT_URI ); 
						}	
					}
				}
			}
			
		}
	}

}
?>