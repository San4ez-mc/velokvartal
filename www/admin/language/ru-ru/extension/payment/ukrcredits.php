<?php
// Heading
$_['heading_title']    					= 'Кредиты от Приватбанка и Монобанка';

$_['text_extension']					= 'Платежи';
$_['text_success']						= 'Настройки модуля успешно обновлены!';
$_['text_edit']							= 'Редактирование модуля';
$_['text_ukrcredits'] 					= '<a target="_blank" href="https://payparts2.privatbank.ua/ipp/"><img src="view/image/payment/pp_logo.png" alt="Оплата частями" title="Оплата частями" style="width: 35px;" /></a> <a target="_blank" href="https://payparts2.privatbank.ua/ipp/"><img src="view/image/payment/ip_logo.png" alt="Мгновенная рассрочка" title="Мгновенная рассрочка" style="width: 35px;" /></a> <a target="_blank" href="https://t.me/chast_mbbankbot"><img src="view/image/payment/mb_logo.png" alt="Покупка частями" title="Покупка частями" style="width: 35px;" /></a>';
$_['text_paymentparts_url']				= '<p>Для получения идентификатора и пароля, необходимо зарегистрировать магазин в <a target="_blank" href="https://payparts2.privatbank.ua/ipp/">Личном кабинете Приват банка</a></p>';
$_['text_paymentparts_url_mono']		= '<p>Для получения идентификатора и пароля, необходимо зарегистрировать магазин помощью телеграм-бота <a target="_blank" href="https://chast.monobank.ua/vendors">подробнее..</a></p>';
$_['text_merchant_type_url']			= '<p for="input-merchant">Наибольшей популярностью пользуются стандартные виды. <a target="_blank" href="https://chast.privatbank.ua/ru/business-online#section2">Подробнее</a></p>';

$_['text_ukrcredits_license']			= 'Ключ активации';
$_['text_ukrcredits_license_error']		= 'Не верный ключ активации';
$_['text_ukrcredits_license_help']		= 'Если Вы столкнулись с проблемами при активации модуля, напишите нам в службу поддержки на e-mail ims@ukr.net или скайп stealth_od с указанием места покупки, даты покупки, номера заказа и Вашего домена';

//Entry
$_['entry_shop_id']						= 'Идентификатор магазина:';
$_['entry_shop_password']				= 'Пароль магазина:';
$_['entry_payment_type']				= 'Тип платежа:';
$_['entry_payment_type_standart']		= 'Стандартный платеж';
$_['entry_payment_type_hold']			= 'Платеж с холдом';
$_['entry_pq']							= 'Максимум месяцев:';
$_['entry_discount']					= 'Запретить скидки';
$_['entry_special']						= 'Запретить акции';
$_['entry_stock']						= 'Запретить оформление отсутствующих товаров';
$_['entry_merchant_type']				= 'Тип рассрочки';



$_['entry_merchant_type']				= 'Тип рассрочки';


$_['entry_pp_merchantType_standart']	= 'Оплата частями <b>«Стандартная»</b>';
$_['entry_pp_merchantType_period']		= 'Оплата частями <b>«Деньги в периоде»</b>';
$_['entry_ii_merchantType_standart']	= '<b>«Мгновенная рассрочка»</b>';
$_['entry_ii_merchantType_special']		= 'Мгновенная рассрочка <b>«Акционная»</b>';
$_['entry_mb_merchantType_standart']	= '<b>«Покупка частями»</b>';

$_['entry_markup']						= 'Коэффициент наценки:';
$_['entry_markup_custom']				= 'Помесячная наценка:';
$_['entry_markup_type']					= 'Тип наценки:';
$_['entry_markup_type_fixed']			= 'Фиксированная';
$_['entry_markup_type_custom']			= 'Помесячная';
$_['entry_acquiring']					= '+ комиссия эквайринга';

$_['entry_min_total']					= 'Минимальная цена:';
$_['entry_max_total']					= 'Максимальная цена:';
$_['entry_status']						= 'Статус:';
$_['entry_sort_order']					= 'Порядок сортировки:';
$_['entry_geo_zone']    				= 'Географическая зона:';

$_['entry_button_name'] 				= 'Текст в кнопке';
$_['entry_css_button'] 					= 'CSS класс кнопки';
$_['entry_selector_button'] 			= 'Элемент сайта, после которого выводится кнопка';
$_['entry_selector_block'] 				= 'Товарный блок';
$_['entry_show_icons'] 					= 'Показывать иноки в кнопке';
$_['entry_icons_size'] 					= 'Размер иконок в пикселях';
$_['entry_css_custom'] 					= 'Свои стили CSS';

$_['entry_enabled']    					= 'Допустимые товары:';
$_['entry_enabled_cat']    				= 'Категории допустимых товаров:';
$_['entry_enabled_productcard']    		= 'Включенные в карточке товара и/или добавленные в список ниже';
$_['entry_enabled_all']    				= 'Все товары';

//Payment State order Statuses
$_['entry_completed_status']    		= 'Статус "платеж успешно совершен"';
$_['entry_failed_status']       		= 'Статус "ошибка при создании платежа"';
$_['entry_canceled_status']     		= 'Статус "платеж отменен"';
$_['entry_rejected_status']     		= 'Статус "платеж отклонен"';
$_['entry_clientwait_status']   		= 'Статус "ожидание"';
$_['entry_created_status']      		= 'Статус "платеж создан"';

//Error
$_['error_warning']                     = 'Внимательно проверьте форму на ошибки!';
$_['error_permission']                  = 'У Вас нет прав для изменения настроек!';
$_['error_shop_id']						= 'Необходимо ввести ID магазина!';
$_['error_shop_password']				= 'Необходимо ввести пароль магазина!';
$_['error_pq']							= 'Необходимо указать максимальное количество месяцев, не более 24!';

$_['text_success']		 				= 'Настройки модуля успешно обновлены!';

//Payment order status tab
$_['tab_pp']							= '<img src="view/image/payment/pp_logo.png" alt="Оплата частями" title="Оплата частями" style="width: 25px;" /> Оплата частями (Приватбанк)';
$_['tab_ii']							= '<img src="view/image/payment/ip_logo.png" alt="Мгновенная рассрочка" title="Мгновенная рассрочка" style="width: 25px;" /> Мгновенная рассрочка (Приватбанк)';
$_['tab_mb']							= '<img src="view/image/payment/mb_logo.png" alt="Покупка частями" title="Покупка частями" style="width: 25px;" /> Покупка частями (Монобанк)';
$_['tab_order_status']					= 'Статус Заказа';

//Help
$_['help_pq']							= 'Введите максимальный срок кредитования';
$_['help_discount']						= 'При включении данной опции, цены товаров, при количестве более 1, при оформлении кредита будут без учета скидок';
$_['help_special']						= 'При включении данной опции, цены товаров при оформлении кредита будут без учета акций';
$_['help_stock']						= 'Отсутствующие товары (количество 0) невозможно будет оформить в кредит';
$_['help_merchant_type']				= 'Приватбанк предлагает несколько видов рассрочки';
$_['help_markup']						= 'Если необходимо, установите наценку на стоимость товара, например 1.027, 1 - без наценки';
$_['help_markup_custom']				= 'Установите наценку в процентах на каждый срок кредитования, разделитель точка, например: 7.5';
$_['help_markup_type']					= 'Фиксированая наценка, либо для разных сроков кредитования свой процент наценки';
$_['help_enabled']						= 'Если необходимо ограничить доступные для оформления товары, выберите их тут или активируйте в карточке товара во вкладке Приватбанк';
$_['help_min_total']					= 'Введите минимальную стоимость товара(ов), выше которой будет доступен кредит';
$_['help_max_total']					= 'Введите максимальную стоимость товара(ов), ниже которой будет доступен кредит';
$_['help_payment_type']					= 'При выборе стандартного платежа, сумма первого платежа будет сразу переведена на Ваш счет, при выборе плажета с холдом, сумма первого платежа будет заблокирована на счете клиента до подтверждения заказа менеджером';

$_['help_show_icons'] 					= 'Отображать иконки доступных видов кредитования в кнопке';
$_['help_css_button'] 					= 'Меняет стиль отображения кнопки, рекомендуется установить классы как и у кнопки Купить. По умолчанию - btn btn-primary btn-lg btn-block';
$_['help_selector_button'] 				= 'Если хотите чтоб кнопка выводилась в другом месте, измените это поле. Не меняйте если не имеете базовых знаний JS';
$_['help_selector_block'] 				= 'Наиболее часто используется в шаблонах #product и .product-info, для шаблона Revolution укажите .product_informationss';
$_['help_css_custom'] 					= 'Добавьте свои стили, если изменение класса кнопки не привело в желаемому результату, элемент кнопки - #button-ukrcredits';