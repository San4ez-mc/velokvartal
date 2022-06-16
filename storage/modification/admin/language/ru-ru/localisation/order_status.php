<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

// Heading
$_['heading_title']    = 'Статус заказов';

// Text
$_['text_success']     = 'Настройки успешно изменены!';
 
		$_['column_select_bg_os']          			= 'Выбрать Фон';
		$_['column_select_color_text_os']          	= 'Выбрать Цвет текста';
		$_['column_on_off_send_mail']          		= 'Вкл / Выкл отправку письма на почту';
		
$_['text_list']        = 'Список статусов заказов';
$_['text_add']         = 'Добавить';
$_['text_edit']        = 'Редактирование';

// Column
$_['column_name']      = 'Название статуса заказов';
$_['column_action']    = 'Действие';

// Entry
						
$_['text_email_template'] = ' Шаблон письма';
$_['it_supports_variable_or_html_tags'] = ' Поддерживает переменные и html теги';
$_['text_close'] = 'Закрыть';
$_['ttn_subject_text'] = 'Тема письма';
$_['ttn_subject_text_variables'] = 'Поддерживает переменные';
$_['list_of_variables'] = 'Список Переменных';
$_['list_of_variables_text'] = 'Список Переменных';
$_['list_of_variables_entry'] = '<table><tr><td>
<br/><b>~number_ttn~</b> - номер ТТН
<br/><b>~order_id~</b> - номер заказа
<br/><b>~totals~</b> - сумма заказа в текущей валюте
<br/><b>~invoice_no~</b> - номер счета      
<br/><b>~invoice_prefix~</b> - префикс счета    
<br/><b>~store_id~</b> - id магазина          
<br/><b>~store_name~</b> - название магазина          
<br/><b>~store_url~</b> - url магазина           			
<br/><b>~customer_id~</b> - id покупателя 
<br/><b>~firstname~</b> - имя
<br/><b>~lastname~</b> - фамилия               
<br/><b>~telephone~</b> - телефон      
<br/><b>~fax~</b> - факс
<br/><b>~email~</b> - почта              
<br/><b>~payment_firstname~</b> - имя плательщика      
<br/><b>~payment_lastname~</b> - фамилия плательщика
<br/><b>~payment_company~</b> - компания плательщика
<br/><b>~payment_address_1~</b> - адрес плательщика
<br/><b>~payment_address_2~</b> - адрес2 плательщика
<br/><b>~payment_postcode~</b> - индекс плательщика
<br/><b>~payment_city~</b> - город плательщика
<br/><b>~payment_zone_id~</b> - id гео зоны плательщика
<br/><b>~payment_zone~</b> - гео зона плательщика
<br/><b>~payment_zone_code~</b> - код зоны плательщика
<br/><b>~payment_country_id~</b> - id страны плательщика 
<br/><b>~payment_country~</b> - страна плательщика
<br/><b>~payment_iso_code_2~</b> - iso код плательщика
<br/><b>~payment_iso_code_3~</b>  - iso код плательщика    
<br/><b>~payment_address_format~</b> - формат адреса плательщика
<br/><b>~payment_method~</b> - метод оплаты
<br/><b>~payment_code~</b> - код оплаты
</td><td>
<br/><b>~shipping_firstname~</b> - имя для доставки
<br/><b>~shipping_lastname~</b> - фамилия для доставки
<br/><b>~shipping_company~</b> - компания для доставки  
<br/><b>~shipping_address_1~</b> - адрес доставки
<br/><b>~shipping_address_2~</b> - адрес2 доставки
<br/><b>~shipping_postcode~</b> - индекс для доставки
<br/><b>~shipping_city~</b> - город доставки       
<br/><b>~shipping_zone_id~</b> - id гео зоны доставки
<br/><b>~shipping_zone~</b> - гео зона доставки
<br/><b>~shipping_zone_code~</b>  - код зоны доставки
<br/><b>~shipping_country_id~</b> - id страны доставки
<br/><b>~shipping_country~</b> - страна доставки
<br/><b>~shipping_iso_code_2~</b> - iso код доставки
<br/><b>~shipping_iso_code_3~</b> - iso код доставки 
<br/><b>~shipping_address_format~</b> - формат адреса доставки
<br/><b>~shipping_method~</b> - метод доставки
<br/><b>~shipping_code~</b> - код метода доставки     
<br/><b>~comment~</b> - комментарий        
<br/><b>~total~</b> - итого (в валюте по умолчанию)         
<br/><b>~order_status_id~</b> - id статуса заказа         
<br/><b>~order_status~</b> - статус заказа
<br/><b>~language_id~</b> - id языка
<br/><b>~language_code~</b> - код языка  
<br/><b>~language_filename~</b> - файл языка
<br/><b>~language_directory~</b> - дирректория языка
<br/><b>~currency_id~</b> - id валюты
<br/><b>~currency_code~</b> - код валюты 
<br/><b>~currency_value~</b> - курс валюты
<br/><b>~ip~</b> - ip
<br/><b>~forwarded_ip~</b> - переадресованный ip            
<br/><b>~user_agent~</b> - юзер агент          
<br/><b>~accept_language~</b> - язык 		
<br/><b>~date_modified~</b> - дата изменения заказа   
<br/><b>~date_added~</b> - дата создания заказа
</td></tr></table><br/>
Некоторые переменные могут не работать, зависит от версии магазина.
';
                
$_['entry_name']       = 'Название статуса заказов';

// Error
$_['error_permission'] = 'У вас недостаточно прав для внесения изменений!';
$_['error_name']       = 'Название должно содержать от 3 до 32 символов!';
$_['error_default']    = 'Этот статус заказа нельзя удалить, поскольку он используется как статус заказа по умолчанию!';
$_['error_download']   = 'Этот статус заказа нельзя удалить, поскольку он используется в статусе скачивания по умолчанию!';
$_['error_store']      = 'Этот статус заказа нельзя удалить, поскольку он используется в %s магазинах!';
$_['error_order']      = 'Этот статус заказа нельзя удалить, поскольку он используется в %s заказах!';