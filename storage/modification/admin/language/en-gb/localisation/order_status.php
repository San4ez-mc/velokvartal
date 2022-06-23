<?php
// Heading
$_['heading_title']    = 'Order Statuses';

// Text
$_['text_success']     = 'Success: You have modified order statuses!';
 
		$_['column_select_bg_os']          			= 'Select background color';
		$_['column_select_color_text_os']          	= 'select color text';
		$_['column_on_off_send_mail']          		= 'On Off Send Mail';
		
$_['text_list']        = 'Order Status List';
$_['text_add']         = 'Add Order Status';
$_['text_edit']        = 'Edit Order Status';

// Column
$_['column_name']      = 'Order Status Name';
$_['column_action']    = 'Action';

// Entry
						
$_['text_email_template'] 	= ' letters Template';
$_['it_supports_variable_or_html_tags'] 	= ' It supports variables and html tags';
$_['text_close'] 							= 'close';
$_['ttn_subject_text'] 						= 'Letter subject';
$_['ttn_subject_text_variables'] = 'It supports variables';
$_['list_of_variables'] 					= 'List of Variables';
$_['list_of_variables_text'] 				= 'List of Variables';
$_['list_of_variables_entry'] 				= '<table><tr><td>
<br/><b>~number_ttn~</b> - number ttn
<br/><b>~order_id~</b> - order id
<br/><b>~totals~</b> - totals
<br/><b>~invoice_no~</b> - invoice no     
<br/><b>~invoice_prefix~</b> - invoice prefix    
<br/><b>~store_id~</b> - store id         
<br/><b>~store_name~</b> - store name          
<br/><b>~store_url~</b> - store url          			
<br/><b>~customer_id~</b> - customer id 
<br/><b>~firstname~</b> - firstname
<br/><b>~lastname~</b> - lastname               
<br/><b>~telephone~</b> - telephone      
<br/><b>~fax~</b> - fax
<br/><b>~email~</b> - email              
<br/><b>~payment_firstname~</b> - payment firstname    
<br/><b>~payment_lastname~</b> - payment lastname
<br/><b>~payment_company~</b> - payment company
<br/><b>~payment_address_1~</b> - payment address_1
<br/><b>~payment_address_2~</b> - payment address_2
<br/><b>~payment_postcode~</b> - payment postcode
<br/><b>~payment_city~</b> - payment city
<br/><b>~payment_zone_id~</b> - payment zone id
<br/><b>~payment_zone~</b> - payment zone
<br/><b>~payment_zone_code~</b> - payment zone code
<br/><b>~payment_country_id~</b> - payment country id
<br/><b>~payment_country~</b> - payment country
<br/><b>~payment_iso_code_2~</b> - payment iso code 2
<br/><b>~payment_iso_code_3~</b>  - payment iso code 3  
<br/><b>~payment_address_format~</b> - payment address format
<br/><b>~payment_method~</b> - payment method
<br/><b>~payment_code~</b> - payment code
</td><td>
<br/><b>~shipping_firstname~</b> - shipping firstname
<br/><b>~shipping_lastname~</b> - shipping lastname
<br/><b>~shipping_company~</b> - shipping company 
<br/><b>~shipping_address_1~</b> - shipping address 1
<br/><b>~shipping_address_2~</b> - shipping address 2
<br/><b>~shipping_postcode~</b> - shipping postcode
<br/><b>~shipping_city~</b> - shipping city       
<br/><b>~shipping_zone_id~</b> - shipping zone id
<br/><b>~shipping_zone~</b> - shipping zone
<br/><b>~shipping_zone_code~</b>  - shipping zone code
<br/><b>~shipping_country_id~</b> - shipping country id
<br/><b>~shipping_country~</b> - shipping country
<br/><b>~shipping_iso_code_2~</b> - shipping iso code 2
<br/><b>~shipping_iso_code_3~</b> - shipping iso code 3 
<br/><b>~shipping_address_format~</b> - shipping address format
<br/><b>~shipping_method~</b> - shipping method
<br/><b>~shipping_code~</b> - shipping code     
<br/><b>~comment~</b> - comment        
<br/><b>~total~</b> - total         
<br/><b>~order_status_id~</b> - order status id         
<br/><b>~order_status~</b> - order status
<br/><b>~language_id~</b> - language id
<br/><b>~language_code~</b> - language code  
<br/><b>~language_filename~</b> - language filename
<br/><b>~language_directory~</b> - language directory
<br/><b>~currency_id~</b> - currency id
<br/><b>~currency_code~</b> - currency code 
<br/><b>~currency_value~</b> - currency value
<br/><b>~ip~</b> - ip
<br/><b>~forwarded_ip~</b> - forwarded ip            
<br/><b>~user_agent~</b> - user agent         
<br/><b>~accept_language~</b> - accept language		
<br/><b>~date_modified~</b> - date modified   
<br/><b>~date_added~</b> - date added
</td></tr></table><br/>
Some variables may not work, depending on the version store.
';
                
$_['entry_name']       = 'Order Status Name';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify order statuses!';
$_['error_name']       = 'Order Status Name must be between 3 and 32 characters!';
$_['error_default']    = 'Warning: This order status cannot be deleted as it is currently assigned as the default store order status!';
$_['error_download']   = 'Warning: This order status cannot be deleted as it is currently assigned as the default download status!';
$_['error_store']      = 'Warning: This order status cannot be deleted as it is currently assigned to %s stores!';
$_['error_order']      = 'Warning: This order status cannot be deleted as it is currently assigned to %s orders!';