/*Обратный звонок*/
DELETE FROM `oc_setting` WHERE `code` = 'callbackpro';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'callbackpro', 'callbackpro', '{\"config_on_off_fields_firstname_cb\":\"1\",\"config_fields_firstname_requared_cb\":\"1\",\"config_placeholder_fields_firstname_cb\":{\"1\":{\"config_placeholder_fields_firstname_cb\":\"\\u0412\\u0430\\u0448\\u0435 \\u0438\\u043c\\u044f\"},\"2\":{\"config_placeholder_fields_firstname_cb\":\"You name\"}},\"config_on_off_fields_phone_cb\":\"1\",\"config_fields_phone_requared_cb\":\"1\",\"config_placeholder_fields_phone_cb\":{\"1\":{\"config_placeholder_fields_phone_cb\":\"\\u0412\\u0430\\u0448 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\"},\"2\":{\"config_placeholder_fields_phone_cb\":\"Phone\"}},\"config_mask_phone_number_cb\":\"\",\"config_on_off_fields_comment_cb\":\"1\",\"config_placeholder_fields_comment_cb\":{\"1\":{\"config_placeholder_fields_comment_cb\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\\u0430\\u0440\\u0438\\u0439\"},\"2\":{\"config_placeholder_fields_comment_cb\":\"Comment\"}},\"config_on_off_fields_email_cb\":\"1\",\"config_placeholder_fields_email_cb\":{\"1\":{\"config_placeholder_fields_email_cb\":\"E-mail\"},\"2\":{\"config_placeholder_fields_email_cb\":\"E-mail\"}},\"csscallback\":{\"background_callbackpro_header\":\"\",\"text_color_callbackpro_header\":\"\",\"background_callback_center\":\"\",\"background_contact_content\":\"\",\"color_contact_content\":\"\",\"boxshadow_img_callback\":\"\",\"config_background_callback\":\"\",\"config_background_callback_hover\":\"\",\"config_background_button_callback\":\"\",\"config_background_button_callback_hover\":\"\",\"config_border_color_button_callback\":\"\",\"config_border_color_button_callback_hover\":\"\",\"background_callback_footer\":\"\"},\"icon_callbackpro_header\":\"\",\"title_callback\":{\"1\":{\"text\":\"\\u0417\\u0430\\u043a\\u0430\\u0437\\u0430\\u0442\\u044c \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a\"},\"2\":{\"text\":\"Request a call\"}},\"config_any_text_bottom_before_button\":{\"1\":{\"config_any_text_bottom_before_button\":\"\"},\"2\":{\"config_any_text_bottom_before_button\":\"\"}},\"main_image_callback\":\"catalog\\/cs_files\\/callback.jpg\",\"block_name_phone\":{\"1\":{\"block_name_phone\":\"\"},\"2\":{\"block_name_phone\":\"\"}},\"config_email_1\":\"\",\"skype\":\"\",\"skype_date_start\":\"\",\"skype_date_end\":\"\",\"title_schedule\":{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}},\"daily\":{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}},\"weekend\":{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}},\"select_design_theme_callback\":\"1\",\"select_design_theme_callback_left_or_right\":\"1\",\"position_animate_btn_1\":\"\\u0412\\u044b\\u0431\\u0440\\u0430\\u0442\\u044c \\u0440\\u0430\\u0441\\u043f\\u043e\\u043b\\u043e\\u0436\\u0435\\u043d\\u0438\\u0435\",\"position_animate_btn_2\":\"\\u0412\\u044b\\u0431\\u0440\\u0430\\u0442\\u044c \\u0440\\u0430\\u0441\\u043f\\u043e\\u043b\\u043e\\u0436\\u0435\\u043d\\u0438\\u0435\",\"position_animate_btn_3\":\"\\u0412\\u044b\\u0431\\u0440\\u0430\\u0442\\u044c \\u0440\\u0430\\u0441\\u043f\\u043e\\u043b\\u043e\\u0436\\u0435\\u043d\\u0438\\u0435\",\"status_animate_btn_4\":\"1\",\"position_animate_btn_4\":\"6\",\"config_phone_number_send_sms\":\"\",\"config_login_send_sms\":\"\",\"config_pass_send_sms\":\"\",\"quickorder_subject_me_callback1\":\"\",\"quickorder_description_me_callback1\":\"\",\"quickorder_subject_me_callback2\":\"\",\"quickorder_description_me_callback2\":\"\",\"config_you_email_callback\":\"\"}', 1);

/*Быстрый заказ*/
DELETE FROM `oc_setting` WHERE `code` = 'fastorder';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'fastorder', 'config_on_off_fields_firstname', '1', 0),
('', 0, 'fastorder', 'config_fields_firstname_requared', '1', 0),
('', 0, 'fastorder', 'config_placeholder_fields_firstname', '{\"1\":{\"config_placeholder_fields_firstname\":\"\\u0412\\u0430\\u0448\\u0435 \\u0438\\u043c\\u044f\"},\"2\":{\"config_placeholder_fields_firstname\":\"You name\"}}', 1),
('', 0, 'fastorder', 'config_on_off_fields_phone', '1', 0),
('', 0, 'fastorder', 'config_placeholder_fields_phone', '{\"1\":{\"config_placeholder_fields_phone\":\"\\u0412\\u0430\\u0448 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\"},\"2\":{\"config_placeholder_fields_phone\":\"You telephone\"}}', 1),
('', 0, 'fastorder', 'config_mask_phone_number', '', 0),
('', 0, 'fastorder', 'config_on_off_fields_comment', '1', 0),
('', 0, 'fastorder', 'config_placeholder_fields_comment', '{\"1\":{\"config_placeholder_fields_comment\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\\u0430\\u0440\\u0438\\u0439\"},\"2\":{\"config_placeholder_fields_comment\":\"Comment\"}}', 1),
('', 0, 'fastorder', 'config_on_off_fields_email', '1', 0),
('', 0, 'fastorder', 'config_placeholder_fields_email', '{\"1\":{\"config_placeholder_fields_email\":\"E-mail\"},\"2\":{\"config_placeholder_fields_email\":\"E-mail\"}}', 1),
('', 0, 'fastorder', 'config_general_image_product_popup', '1', 0),
('', 0, 'fastorder', 'config_title_popup_quickorder', '{\"1\":{\"config_title_popup_quickorder\":\"\\u041a\\u0443\\u043f\\u0438\\u0442\\u044c \\u0432 1 \\u043a\\u043b\\u0438\\u043a\"},\"2\":{\"config_title_popup_quickorder\":\"Byu 1 click\"}}', 1),
('', 0, 'fastorder', 'config_icon_open_form_send_order', '', 0),
('', 0, 'fastorder', 'config_icon_send_fastorder', '', 0),
('', 0, 'fastorder', 'config_background_button_send_fastorder', '', 0),
('', 0, 'fastorder', 'config_background_button_send_fastorder_hover', '', 0),
('', 0, 'fastorder', 'config_background_button_open_form_send_order', '', 0),
('', 0, 'fastorder', 'config_background_button_open_form_send_order_hover', '', 0),
('', 0, 'fastorder', 'config_color_button_open_form_send_order', '', 0),
('', 0, 'fastorder', 'config_text_open_form_send_order', '{\"1\":{\"config_text_open_form_send_order\":\"\\u0412 1 \\u043a\\u043b\\u0438\\u043a\"},\"2\":{\"config_text_open_form_send_order\":\"\\u0412 1 \\u043a\\u043b\\u0438\\u043a\"}}', 1),
('', 0, 'fastorder', 'config_text_before_button_send', '{\"1\":{\"config_text_before_button_send\":\"\"},\"2\":{\"config_text_before_button_send\":\"\"}}', 1),
('', 0, 'fastorder', 'config_any_text_at_the_bottom', '{\"1\":{\"config_any_text_at_the_bottom\":\"\"},\"2\":{\"config_any_text_at_the_bottom\":\"\"}}', 1),
('', 0, 'fastorder', 'config_any_text_at_the_bottom_color', '', 0),
('', 0, 'fastorder', 'config_complete_quickorder', '{\"1\":{\"config_complete_quickorder\":\"\"},\"2\":{\"config_complete_quickorder\":\"\"}}', 1),
('', 0, 'fastorder', 'config_select_design_fastorder', '1', 0),
('', 0, 'fastorder', 'config_phone_number_send_sms_fastorder', '', 0),
('', 0, 'fastorder', 'config_login_send_sms_fastorder', '', 0),
('', 0, 'fastorder', 'config_pass_send_sms_fastorder', '', 0),
('', 0, 'fastorder', 'quickorder_subject1', '', 0),
('', 0, 'fastorder', 'quickorder_description1', '', 0),
('', 0, 'fastorder', 'quickorder_subject2', '', 0),
('', 0, 'fastorder', 'quickorder_description2', '', 0),
('', 0, 'fastorder', 'quickorder_subject_me1', '', 0),
('', 0, 'fastorder', 'quickorder_description_me1', '', 0),
('', 0, 'fastorder', 'quickorder_subject_me2', '', 0),
('', 0, 'fastorder', 'quickorder_description_me2', '', 0),
('', 0, 'fastorder', 'config_you_email_quickorder', '', 0),
('', 0, 'fastorder', 'config_on_off_send_buyer_mail', '0', 0),
('', 0, 'fastorder', 'config_on_off_send_me_mail', '0', 0),
('', 0, 'fastorder', 'config_me_html_products', '0', 0),
('', 0, 'fastorder', 'config_buyer_html_products', '0', 0),
('', 0, 'fastorder', 'config_on_off_shipping_method', '0', 0),
('', 0, 'fastorder', 'config_on_off_payment_method', '0', 0),
('', 0, 'fastorder', 'config_fields_phone_requared', '0', 0),
('', 0, 'fastorder', 'config_fields_comment_requared', '0', 0),
('', 0, 'fastorder', 'config_fields_email_requared', '0', 0);
/*Отзывы о магазине*/
TRUNCATE TABLE `oc_reviews_store_theme`;
INSERT INTO `oc_reviews_store_theme` (`reviews_store_theme_id`, `status`, `sort_order`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

TRUNCATE TABLE `oc_reviews_store_theme_desc`;
INSERT INTO `oc_reviews_store_theme_desc` (`reviews_store_theme_id`, `language_id`, `theme_text`) VALUES
(1, 1, 'Цена'),
(1, 2, 'Price'),
(2, 1, 'Качество товара'),
(2, 2, 'Quality product'),
(3, 1, 'Доставка'),
(3, 2, 'Delivery'),
(4, 1, 'Оценка магазина'),
(4, 2, 'Store rating');
TRUNCATE TABLE `oc_reviews_store_rating`;
INSERT INTO `oc_reviews_store_rating` (`reviews_store_id`, `reviews_store_theme_id`, `rating`) VALUES
(1, 1, 5),
(1, 2, 5),
(1, 3, 5),
(1, 4, 5),
(2, 1, 5),
(2, 2, 5),
(2, 3, 5),
(2, 4, 5),
(3, 1, 5),
(3, 2, 5),
(3, 3, 5),
(3, 4, 5),
(4, 1, 5),
(4, 2, 5),
(4, 3, 5),
(4, 4, 5),
(5, 1, 5),
(5, 2, 5),
(5, 3, 5),
(5, 4, 5),
(6, 1, 5),
(6, 2, 5),
(6, 3, 5),
(6, 4, 5);
TRUNCATE TABLE `oc_reviews_store`;
INSERT INTO `oc_reviews_store` (`reviews_store_id`, `author`, `description`, `admin_response`, `rating`, `like`, `dislike`, `status`, `status_check`, `date_added`, `date_modified`) VALUES
(1, 'Елена', 'супер зашла в интернет -магазин CyberStore увидела нужный товар положила в корзину и вуаля доставили домой по укр почте-совершенно бесплатно супер условия покупки -доставки товара ', '', 0, 0, 0, 1, 0, '2020-01-05 21:02:00', '0000-00-00 00:00:00'),
(2, 'Світлана', 'Делаю не первую покупку в CyberStore . В этот раз заказала набор контейнеров LUMINARC 3 шт. + сумка, доставили быстро, всё целое, нигде ни царапинки. Спасибо! ', '', 0, 0, 0, 1, 0, '2020-01-05 21:02:25', '0000-00-00 00:00:00'),
(3, 'Татьяна', ' Очень довольна покупкой.Доставили быстро,курьер все на месте проверил,подсказал,молодец.Всем рекомендую! ', '', 0, 0, 0, 1, 0, '2020-01-05 21:02:43', '0000-00-00 00:00:00'),
(4, 'Марина', ' Благодаря квалифицированной консультации менеджера магазина, приобрели отличную стиральную машину с хорошей скидкой. Доставка тоже была осуществлена в оговоренные сроки. Спасибо магазину! Будем обращаться с удовольствием еще! ', '', 0, 0, 0, 1, 0, '2020-01-05 21:02:58', '0000-00-00 00:00:00'),
(5, 'Алексей', ' Товар получил , качество супер цена могла быть и дешевле )) по магазину вопросов нет, все удобно и понятно .. Спасибо ', '', 0, 0, 0, 1, 0, '2020-01-05 21:03:10', '0000-00-00 00:00:00'),
(6, 'Ирина', ' Купила варочную поверхность BEKO HIZG 64120 В в интернет магазине CyberStore по отличной цене, за 1600 грн по акции. В то время как в магазинах цены от 3000 грн были. Поверхностью очень довольна, работает отлично, качество хорошее. Еще заказывала вытяжку и телевизор, но пока не проверяла, позже напишу отзывы на них. Всю технику покупаю только в CyberStore , пока нареканий не было. Большой плюс, что рассрочка в CyberStore дается на 2 года на многие товары, в то время как в других магазинах на эти же товары только на 10 месяцев. ', '', 0, 0, 0, 1, 0, '2020-01-05 21:03:22', '0000-00-00 00:00:00');

DELETE FROM `oc_setting` WHERE `code` = 'reviews_store_setting';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'reviews_store_setting', 'reviews_store_setting', '{\"status\":\"1\",\"automoderation\":\"1\",\"show_like_dislike\":\"1\",\"review_guest\":\"1\"}', 1);
/*ONEPAGECHECKOUT*/
DELETE FROM `oc_setting` WHERE `code` = 'cyber_myonepagecheckout';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'cyber_myonepagecheckout', 'config_show_onepcheckout', '1', 0),
('', 0, 'cyber_myonepagecheckout', 'details_last_name', 'required', 0),
('', 0, 'cyber_myonepagecheckout', 'details_payment_email', 'required', 0),
('', 0, 'cyber_myonepagecheckout', 'details_telephone', 'required', 0),
('', 0, 'cyber_myonepagecheckout', 'details_payment_fax', '0', 0),
('', 0, 'cyber_myonepagecheckout', 'address_payment_company', '0', 0),
('', 0, 'cyber_myonepagecheckout', 'address_payment_address_1', '0', 0),
('', 0, 'cyber_myonepagecheckout', 'address_payment_city', '0', 0),
('', 0, 'cyber_myonepagecheckout', 'address_payment_postcode', '0', 0),
('', 0, 'cyber_myonepagecheckout', 'address_shipping_address', '0', 0);

/*UT5*/
DELETE FROM `oc_setting` WHERE `code` = 'ut5setting';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'ut5setting', 'ttn_subject1', '', 0),
('', 0, 'ut5setting', 'ttn_description1', '', 0),
('', 0, 'ut5setting', 'ttn_subject2', '', 0),
('', 0, 'ut5setting', 'ttn_description2', '', 0),
('', 0, 'ut5setting', 'config_on_off_order_payment_method', '1', 0),
('', 0, 'ut5setting', 'config_on_off_order_shipping_method', '1', 0),
('', 0, 'ut5setting', 'config_on_off_model_product', '1', 0),
('', 0, 'ut5setting', 'config_on_off_sku_product', '1', 0),
('', 0, 'ut5setting', 'config_on_off_upc_product', '1', 0),
('', 0, 'ut5setting', 'config_on_off_column_product', '1', 0),
('', 0, 'ut5setting', 'config_on_off_column_comment_manager', '1', 0),
('', 0, 'ut5setting', 'config_on_off_column_send_ttn_email', '0', 0),
('', 0, 'ut5setting', 'config_on_off_column_price_purchase', '0', 0),
('', 0, 'ut5setting', 'config_on_off_column_total_profit', '0', 0),
('', 0, 'ut5setting', 'config_on_off_column_manager_process_orders', '0', 0),
('', 0, 'ut5setting', 'config_on_off_column_delivery_price', '0', 0),
('', 0, 'ut5setting', 'config_on_off_column_build', '0', 0),
('', 0, 'ut5setting', 'config_on_off_column_rise_product', '0', 0);

DELETE FROM `oc_setting` WHERE `code` = 'tabs_product';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'tabs_product', 'tabs_product_on_off', '{\"status\":\"1\"}', 1);
/*Быстрый просмотр*/
DELETE FROM `oc_setting` WHERE `code` = 'quickviewpro';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'quickviewpro', 'config_quickview_show_nextprev_product', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_additional_image', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_addtocart', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_wishlist', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_compare', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_tab_description', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_tab_specification', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_tab_review_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_options_count', '10', 0),
('', 0, 'quickviewpro', 'config_quickview_manufacturer', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_model', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_quantity', '1', 0),
('', 0, 'quickviewpro', 'config_quickview_btn_name', '{\"1\":{\"config_quickview_btn_name\":\"\\u041f\\u0440\\u043e\\u0441\\u043c\\u043e\\u0442\\u0440\"},\"2\":{\"config_quickview_btn_name\":\"\\u041f\\u0440\\u043e\\u0441\\u043c\\u043e\\u0442\\u0440\"}}', 1),
('', 0, 'quickviewpro', 'config_quickview_background_btnaddtocart', '', 0),
('', 0, 'quickviewpro', 'config_quickview_textcolor_btnaddtocart', '', 0),
('', 0, 'quickviewpro', 'config_quickview_background_btnaddtocart_hover', '', 0),
('', 0, 'quickviewpro', 'config_quickview_textcolor_btnaddtocart_hover', '', 0),
('', 0, 'quickviewpro', 'config_quickview_background_btnwishlist', '', 0),
('', 0, 'quickviewpro', 'config_quickview_textcolor_btnwishlist', '', 0),
('', 0, 'quickviewpro', 'config_quickview_background_btnwishlist_hover', '', 0),
('', 0, 'quickviewpro', 'config_quickview_textcolor_btnwishlist_hover', '', 0),
('', 0, 'quickviewpro', 'config_quickview_background_btncompare', '', 0),
('', 0, 'quickviewpro', 'config_quickview_textcolor_btncompare', '', 0),
('', 0, 'quickviewpro', 'config_quickview_background_btncompare_hover', '', 0),
('', 0, 'quickviewpro', 'config_quickview_textcolor_btncompare_hover', '', 0),
('', 0, 'quickviewpro', 'config_on_off_featured_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_latest_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_bestseller_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_special_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_category_page_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_search_page_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_manufacturer_page_quickview', '1', 0),
('', 0, 'quickviewpro', 'config_on_off_special_page_quickview', '1', 0);


/*Автопоиск*/
DELETE FROM `oc_setting` WHERE `code` = 'autosearch';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'ns_autosearch_data', 'ns_autosearch_data', '{\"status\":\"1\",\"search_model_on_off\":\"1\",\"search_tag_on_off\":\"0\",\"search_manufacturer_on_off\":\"0\",\"search_upc_on_off\":\"0\",\"search_sku_on_off\":\"0\",\"display_image_on_off\":\"1\",\"image_search_width\":\"50\",\"image_search_height\":\"50\",\"display_model_on_off\":\"0\",\"display_manufacturer_on_off\":\"0\",\"display_price_on_off\":\"1\",\"display_rating_on_off\":\"0\",\"display_stock_on_off\":\"0\"}', 1);

/*Нашли дешевле*/
DELETE FROM `oc_setting` WHERE `code` = 'fcpdata';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'fcpdata', 'fcpdata', '{\"status\":\"1\",\"send_email_status\":\"0\",\"email_found_cheaper\":\"\",\"name_field\":\"1\",\"name_field_required\":\"1\",\"name_field_placeholder\":{\"1\":{\"text\":\"\\u0412\\u0430\\u0448\\u0435 \\u0418\\u043c\\u044f\"},\"2\":{\"text\":\"You name\"}},\"telephone_field\":\"1\",\"telephone_field_mask\":\"\",\"telephone_field_required\":\"1\",\"telephone_field_placeholder\":{\"1\":{\"text\":\"\\u0412\\u0430\\u0448 \\u0442\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\"},\"2\":{\"text\":\"Phone\"}},\"comment_field\":\"1\",\"comment_field_required\":\"0\",\"comment_field_placeholder\":{\"1\":{\"text\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\\u0430\\u0440\\u0438\\u0439\"},\"2\":{\"text\":\"Comment\"}},\"email_field\":\"1\",\"email_field_required\":\"1\",\"email_field_placeholder\":{\"1\":{\"text\":\"E-mail\"},\"2\":{\"text\":\"E-mail\"}},\"link_field\":\"1\",\"link_field_required\":\"1\",\"link_field_placeholder\":{\"1\":{\"text\":\"\\u0421\\u0441\\u044b\\u043b\\u043a\\u0430\"},\"2\":{\"text\":\"Link\"}},\"title_popup_found_cheaper\":{\"1\":{\"text\":\"\\u041d\\u0430\\u0448\\u043b\\u0438 \\u0434\\u0435\\u0448\\u0435\\u0432\\u043b\\u0435 ?\"},\"2\":{\"text\":\"Found cheaper?\"}},\"found_cheaper_info_text\":{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}},\"found_cheaper_botton_text\":{\"1\":{\"text\":\"\\u041d\\u0430\\u0448\\u043b\\u0438 \\u0434\\u0435\\u0448\\u0435\\u0432\\u043b\\u0435 ?\"},\"2\":{\"text\":\"Found cheaper?\"}},\"found_cheaper_botton_icon\":\"fa fa-lightbulb-o\",\"color_send_button\":\"\",\"background_send_button\":\"\",\"background_send_button_hover\":\"\",\"border_send_button\":\"\",\"border_send_button_hover\":\"\",\"color_found_cheaper_button\":\"\",\"background_found_cheaper_button\":\"\",\"background_found_cheaper_button_hover\":\"\",\"border_found_cheaper_button\":\"\",\"border_found_cheaper_button_hover\":\"\"}', 1);
/*Вопрос - ответ*/
DELETE FROM `oc_setting` WHERE `code` = 'qadata';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'qadata', 'qadata', '{\"status\":\"1\",\"email_question_answer\":\"\",\"name_field\":\"1\",\"name_field_required\":\"1\",\"name_field_placeholder\":{\"1\":{\"text\":\"\\u0412\\u0430\\u0448\\u0435 \\u0438\\u043c\\u044f\"},\"2\":{\"text\":\"You name\"}},\"telephone_field\":\"1\",\"telephone_field_mask\":\"\",\"telephone_field_required\":\"1\",\"telephone_field_placeholder\":{\"1\":{\"text\":\"\\u0422\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\"},\"2\":{\"text\":\"Phone\"}},\"email_field\":\"1\",\"email_field_required\":\"1\",\"email_field_placeholder\":{\"1\":{\"text\":\"E-mail\"},\"2\":{\"text\":\"E-mail\"}}}', 1);
DELETE FROM `oc_setting` WHERE `code` = 'theme_cyberstore';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'theme_cyberstore', 'theme_cyberstore_status', '1', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_product_limit', '15', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_product_description_length', '100', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_category_width', '80', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_category_height', '80', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_thumb_width', '400', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_thumb_height', '400', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_popup_width', '700', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_popup_height', '700', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_product_width', '400', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_product_height', '400', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_additional_width', '74', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_additional_height', '74', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_related_width', '80', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_related_height', '80', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_compare_width', '90', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_compare_height', '90', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_wishlist_width', '47', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_wishlist_height', '47', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_cart_width', '47', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_cart_height', '47', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_location_width', '268', 0),
('', 0, 'theme_cyberstore', 'theme_cyberstore_image_location_height', '50', 0);
DELETE FROM `oc_setting` WHERE `code` = 'cyber_store_theme';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'cyber_store_theme', 'config_disable_cart_button', '1', 0),
('', 0, 'cyber_store_theme', 'config_change_text_cart_button_out_of_stock', '1', 0),
('', 0, 'cyber_store_theme', 'config_disable_cart_button_text', '{\"1\":{\"disable_cart_button_text\":\"\\u041f\\u0440\\u043e\\u0434\\u0430\\u043d\\u043e\"},\"2\":{\"disable_cart_button_text\":\"Sold out\"}}', 1),
('', 0, 'cyber_store_theme', 'config_disable_fastorder_button', '1', 0),
('', 0, 'cyber_store_theme', 'config_additional_settings_newstore', '{\"quantity_btn_module\":\"1\",\"quantity_btn_page\":\"1\"}', 1),
('', 0, 'cyber_store_theme', 'nst_data', '{\"defaut_display_view\":\"grid\",\"page_mobile_qrp\":\"1\",\"lazyload_page\":\"1\",\"lazyload_module\":\"1\",\"lazyload_image\":\"catalog\\/lazyload\\/lazyload.png\",\"header_bg_mode\":\"0\",\"header_bg_img\":\"\",\"header_bg_mode_color\":\"#FFFFFF\",\"header_bg_position\":\"top left\",\"header_bg_repeat\":\"repeat\",\"bg_mode_pos_2\":\"0\",\"img_pos_2\":\"\",\"bg_mode_color_pos_2\":\"\",\"title_color_pos_2\":\"\",\"bg_mode_pos_11\":\"0\",\"img_pos_11\":\"\",\"bg_mode_color_pos_11\":\"\",\"title_color_pos_11\":\"\",\"bg_mode_pos_15\":\"0\",\"img_pos_15\":\"\",\"bg_mode_color_pos_15\":\"\",\"title_color_pos_15\":\"\",\"bg_mode_pos_22\":\"2\",\"img_pos_22\":\"\",\"bg_mode_color_pos_22\":\"#F5F5F5\",\"title_color_pos_22\":\"\"}', 1),
('', 0, 'cyber_store_theme', 'config_design_special_timer', '2', 0),
('', 0, 'cyber_store_theme', 'config_show_review_plus', '1', 0),
('', 0, 'cyber_store_theme', 'config_show_review_minus', '1', 0),
('', 0, 'cyber_store_theme', 'config_show_review_minus_requared', '1', 0),
('', 0, 'cyber_store_theme', 'config_ns_themes_custom_bg_mode', 'off', 0),
('', 0, 'cyber_store_theme', 'config_themes_custom_bg_img_preview', '', 0),
('', 0, 'cyber_store_theme', 'scroll', 'scroll', 0),
('', 0, 'cyber_store_theme', 'config_themes_custom_bg_position', 'top left', 0),
('', 0, 'cyber_store_theme', 'config_themes_custom_bg_repeat', 'repeat', 0),
('', 0, 'cyber_store_theme', 'config_ns_themes_custom_bg_mode_color', '', 0),
('', 0, 'cyber_store_theme', 'setting_module', '{\"mobile_qrp\":\"1\",\"status_model\":\"1\",\"status_description\":\"1\",\"status_additional_image_hover\":\"1\",\"status_rating\":\"1\",\"status_quantity_reviews\":\"1\",\"status_fastorder\":\"1\",\"status_wishlist\":\"1\",\"status_compare\":\"1\",\"hidden_desc\":\"1\",\"hidden_model\":\"1\",\"hidden_rating\":\"1\",\"hidden_actions\":\"1\"}', 1),
('', 0, 'cyber_store_theme', 'ns_new_home_layout_module', '[{\"code\":\"cyber_megasliderpro.45\",\"position\":\"position_1\",\"sort_order\":\"\",\"mob_device\":\"1\",\"tablet_device\":\"1\"},{\"code\":\"cyber_latest_grid.46\",\"position\":\"position_22\",\"sort_order\":\"\",\"mob_device\":\"1\",\"tablet_device\":\"1\"},{\"code\":\"featured.28\",\"position\":\"position_11\",\"sort_order\":\"\"},{\"code\":\"latest.44\",\"position\":\"position_12\",\"sort_order\":\"\"},{\"code\":\"special.42\",\"position\":\"position_13\",\"sort_order\":\"\"},{\"code\":\"bestseller.43\",\"position\":\"position_14\",\"sort_order\":\"\"},{\"code\":\"cyber_wallcategory.41\",\"position\":\"position_15\",\"sort_order\":\"1\"},{\"code\":\"cyber_reviews_store.38\",\"position\":\"position_15\",\"sort_order\":\"2\"},{\"code\":\"cyber_reviewscustomer.39\",\"position\":\"position_15\",\"sort_order\":\"3\"}]', 1),
('', 0, 'cyber_store_theme', 'show_subcategories', '1', 0),
('', 0, 'cyber_store_theme', 'show_subcategories_image', '1', 0),
('', 0, 'cyber_store_theme', 'ns_subcat_width', '150', 0),
('', 0, 'cyber_store_theme', 'ns_subcat_height', '150', 0),
('', 0, 'cyber_store_theme', 'cpage_attr_group_count', '3', 0),
('', 0, 'cyber_store_theme', 'cpage_attr_group_item_count', '3', 0),
('', 0, 'cyber_store_theme', 'config_price_list_view_on_off', '1', 0),
('', 0, 'cyber_store_theme', 'config_catalog_category_description_dropped', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_model_product', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_description', '1', 0),
('', 0, 'cyber_store_theme', 'status_additional_image_hover_cp', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_rating', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_quantity_reviews', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_fastorder', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_wishlist', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_category_page_compare', '1', 0),
('', 0, 'cyber_store_theme', 'config_price_list_view_on_off_special_page', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_model_product', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_description', '1', 0),
('', 0, 'cyber_store_theme', 'status_additional_image_hover_sp', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_rating', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_quantity_reviews', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_fastorder', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_wishlist', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_special_page_compare', '1', 0),
('', 0, 'cyber_store_theme', 'config_price_list_view_on_off_manufacturer_page', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_model_product', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_description', '1', 0),
('', 0, 'cyber_store_theme', 'status_additional_image_hover_mp', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_rating', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_quantity_reviews', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_fastorder', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_wishlist', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_manufacturer_page_compare', '1', 0),
('', 0, 'cyber_store_theme', 'config_price_list_view_on_off_search_page', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_model_product', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_description', '1', 0),
('', 0, 'cyber_store_theme', 'status_additional_image_hover_sep', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_rating', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_quantity_reviews', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_fastorder', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_wishlist', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_search_page_compare', '1', 0),
('', 0, 'cyber_store_theme', 'setting_lp', '{\"status_latest_page\":\"1\",\"status_receipt_date\":\"1\",\"status_active_last_date\":\"1\",\"status_lp_price_list\":\"1\",\"status_lp_model\":\"1\",\"status_lp_description\":\"1\",\"status_lp_dop_image_hover_cp\":\"1\",\"status_lp_rating\":\"1\",\"status_lp_quantity_reviews\":\"1\",\"status_lp_fastorder\":\"1\",\"status_lp_wishlis\":\"1\",\"status_lp_compare\":\"1\"}', 1),
('', 0, 'cyber_store_theme', 'config_day_latest_product', '30', 0),
('', 0, 'cyber_store_theme', 'ns_show_nextprev_prod', '1', 0),
('', 0, 'cyber_store_theme', 'ns_show_brand_image', '1', 0),
('', 0, 'cyber_store_theme', 'config_fix_left_block', '1', 0),
('', 0, 'cyber_store_theme', 'config_short_description_status', '1', 0),
('', 0, 'cyber_store_theme', 'config_short_attribut_status', '1', 0),
('', 0, 'cyber_store_theme', 'config_short_attribute_show_name', '1', 0),
('', 0, 'cyber_store_theme', 'config_short_attribute_group_product', '10', 0),
('', 0, 'cyber_store_theme', 'config_short_attribute_group_product_item', '10', 0),
('', 0, 'cyber_store_theme', 'config_show_nsproduct_btn_fastorder', '1', 0),
('', 0, 'cyber_store_theme', 'config_show_nsproduct_btn_wishlist', '1', 0),
('', 0, 'cyber_store_theme', 'config_show_nsproduct_btn_compare', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_countdown_product', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_product_sharing_facebock', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_product_sharing_twitter', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_product_sharing_mailru', '1', 0),
('', 0, 'cyber_store_theme', 'config_on_off_product_sharing_vk', '1', 0),
('', 0, 'cyber_store_theme', 'config_status_zoom_image', '1', 0),
('', 0, 'cyber_store_theme', 'config_delivery_options_title', '{\"1\":{\"config_delivery_options_title\":\"\"},\"2\":{\"config_delivery_options_title\":\"\"}}', 1),
('', 0, 'cyber_store_theme', 'config_design_template_color_theme', '4', 0),
('', 0, 'cyber_store_theme', 'cs_type_btn', '1', 0),
('', 0, 'cyber_store_theme', 'item_setting', '{\"prod_name_align\":\"2\",\"model_align\":\"2\",\"rating_align\":\"2\",\"title_mod\":\"1\"}', 1),
('', 0, 'cyber_store_theme', 'status_border_radius', '1', 0),
('', 0, 'cyber_store_theme', 'config_custom_style_newstore', '', 0),
('', 0, 'cyber_store_theme', 'site_screen_width', '3', 0),
('', 0, 'cyber_store_theme', 'on_off_sticker_special', '1', 0),
('', 0, 'cyber_store_theme', 'config_change_background_sticker_special', '#FF4F2B', 0),
('', 0, 'cyber_store_theme', 'config_change_color_text_sticker_special', '#FFFFFF', 0),
('', 0, 'cyber_store_theme', 'config_change_text_sticker_special', '{\"1\":{\"config_change_text_sticker_special\":\"\\u0410\\u043a\\u0446\\u0438\\u044f\"},\"2\":{\"config_change_text_sticker_special\":\"\\u0410\\u043a\\u0446\\u0438\\u044f\"}}', 1),
('', 0, 'cyber_store_theme', 'config_change_icon_sticker_special', '', 0),
('', 0, 'cyber_store_theme', 'config_change_color_icon_sticker_special', '', 0),
('', 0, 'cyber_store_theme', 'on_off_sticker_newproduct', '1', 0),
('', 0, 'cyber_store_theme', 'config_limit_day_newproduct', '30', 0),
('', 0, 'cyber_store_theme', 'config_change_background_sticker_newproduct', '#8E8AFF', 0),
('', 0, 'cyber_store_theme', 'config_change_text_sticker_newproduct', '{\"1\":{\"config_change_text_sticker_newproduct\":\"\\u041d\\u043e\\u0432\\u0438\\u043d\\u043a\\u0430\"},\"2\":{\"config_change_text_sticker_newproduct\":\"\\u041d\\u043e\\u0432\\u0438\\u043d\\u043a\\u0430\"}}', 1),
('', 0, 'cyber_store_theme', 'config_change_color_text_sticker_newproduct', '', 0),
('', 0, 'cyber_store_theme', 'config_change_icon_sticker_newproduct', '', 0),
('', 0, 'cyber_store_theme', 'config_change_color_icon_sticker_newproduct', '', 0),
('', 0, 'cyber_store_theme', 'on_off_sticker_popular', '1', 0),
('', 0, 'cyber_store_theme', 'config_min_quantity_popular', '100', 0),
('', 0, 'cyber_store_theme', 'config_change_background_sticker_popular', '#63E043', 0),
('', 0, 'cyber_store_theme', 'config_change_text_sticker_popular', '{\"1\":{\"config_change_text_sticker_popular\":\"\\u041f\\u043e\\u043f\\u0443\\u043b\\u044f\\u0440\\u043d\\u044b\\u0439\"},\"2\":{\"config_change_text_sticker_popular\":\"Most Viewed\"}}', 1),
('', 0, 'cyber_store_theme', 'config_change_color_text_sticker_popular', '', 0),
('', 0, 'cyber_store_theme', 'config_change_icon_sticker_popular', '', 0),
('', 0, 'cyber_store_theme', 'config_change_color_icon_sticker_popular', '', 0),
('', 0, 'cyber_store_theme', 'on_off_sticker_topbestseller', '1', 0),
('', 0, 'cyber_store_theme', 'config_limit_order_product_topbestseller', '10', 0),
('', 0, 'cyber_store_theme', 'config_change_background_sticker_topbestseller', '#FFDD36', 0),
('', 0, 'cyber_store_theme', 'config_change_text_sticker_topbestseller', '{\"1\":{\"config_change_text_sticker_topbestseller\":\"\\u0422\\u043e\\u043f\"},\"2\":{\"config_change_text_sticker_topbestseller\":\"Top\"}}', 1),
('', 0, 'cyber_store_theme', 'config_change_color_text_sticker_topbestseller', '#000000', 0),
('', 0, 'cyber_store_theme', 'config_change_icon_sticker_topbestseller', '', 0),
('', 0, 'cyber_store_theme', 'config_change_color_icon_sticker_topbestseller', '', 0),
('', 0, 'cyber_store_theme', 'show_h_compare', '1', 0),
('', 0, 'cyber_store_theme', 'show_h_wishlist', '1', 0),
('', 0, 'cyber_store_theme', 'language_description_info_mob', '{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}}', 1),
('', 0, 'cyber_store_theme', 'header_nav_menu_link', '[{\"icon_image\":\"\",\"title\":{\"1\":\"\\u0414\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0430\",\"2\":\"Delivery\"},\"link\":{\"1\":\"delivery\",\"2\":\"delivery\"},\"popup\":\"0\"},{\"icon_image\":\"\",\"title\":{\"1\":\"\\u041e\\u043f\\u043b\\u0430\\u0442\\u0430\",\"2\":\"Payment\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"}]', 1),
('', 0, 'cyber_store_theme', 'search_word', '{\"1\":{\"text\":\"Samsung, Iphone, Nokia, LG, HTC\"},\"2\":{\"text\":\"Samsung, Iphone, Nokia, LG, HTC\"}}', 1),
('', 0, 'cyber_store_theme', 'config_phones_header', '[{\"image\":\"\",\"icon\":\"\",\"type\":{\"1\":\"href=\\\"tel:+74951244501\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"tel:+74951244501\\\" target=\\\"_blank\\\"\"},\"phone\":{\"1\":\" +7 (495) 124-45-01\",\"2\":\" +7 (495) 124-45-01\"},\"dropdown\":\"1\"},{\"image\":\"\",\"icon\":\"\",\"type\":{\"1\":\"href=\\\"tel:+74951244502\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"tel:+74951244502\\\" target=\\\"_blank\\\"\"},\"phone\":{\"1\":\" +7 (495) 124-45-02\",\"2\":\" +7 (495) 124-45-02\"},\"dropdown\":\"1\"},{\"image\":\"\",\"icon\":\"fa fa-paper-plane-o\",\"type\":{\"1\":\"href=\\\"tel:+74951244503\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"tel:+74951244503\\\" target=\\\"_blank\\\"\"},\"phone\":{\"1\":\" +7 (495) 124-45-03\",\"2\":\" +7 (495) 124-45-03\"},\"dropdown\":\"0\"},{\"image\":\"\",\"icon\":\"fa fa-whatsapp\",\"type\":{\"1\":\"href=\\\"tel:+74951244504\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"tel:+74951244504\\\" target=\\\"_blank\\\"\"},\"phone\":{\"1\":\" +7 (495) 124-45-04\",\"2\":\" +7 (495) 124-45-04\"},\"dropdown\":\"0\"},{\"image\":\"\",\"icon\":\"fa fa-envelope-o\",\"type\":{\"1\":\"target=\\\"_blank\\\" href=\\\"mailto:cyberstore@gmail.com\\\"\",\"2\":\"target=\\\"_blank\\\" href=\\\"mailto:cyberstore@gmail.com\\\"\"},\"phone\":{\"1\":\"cyberstore@gmail.com\",\"2\":\"cyberstore@gmail.com\"},\"dropdown\":\"0\"},{\"image\":\"\",\"icon\":\"\",\"type\":{\"1\":\"\",\"2\":\"\"},\"phone\":{\"1\":\"\\u0433.\\u0425\\u0430\\u0440\\u044c\\u043a\\u043e\\u0432 \\u0443\\u043b. \\u0421\\u0443\\u043c\\u0441\\u043a\\u0430\\u044f 21\",\"2\":\"Kharkiv st. Sumskaya 21 \"},\"dropdown\":\"0\"},{\"image\":\"\",\"icon\":\"fa fa-vk\",\"type\":{\"1\":\"href=\\\"https:\\/\\/vk.com\\/\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"https:\\/\\/vk.com\\/\\\" target=\\\"_blank\\\"\"},\"phone\":{\"1\":\"\\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435\",\"2\":\"Group Vkontakte\"},\"dropdown\":\"0\"},{\"image\":\"\",\"icon\":\"fa fa-youtube-square\",\"type\":{\"1\":\"href=\\\"https:\\/\\/www.youtube.com\\/\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"https:\\/\\/www.youtube.com\\/\\\" target=\\\"_blank\\\"\"},\"phone\":{\"1\":\"Youtube \\u043a\\u0430\\u043d\\u0430\\u043b\",\"2\":\"Youtube channel \"},\"dropdown\":\"0\"}]', 1),
('', 0, 'cyber_store_theme', 'text_after_phone', '{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}}', 1),
('', 0, 'cyber_store_theme', 'arbitrary_text', '{\"1\":{\"text\":\"\"},\"2\":{\"text\":\"\"}}', 1),
('', 0, 'cyber_store_theme', 'config_ns_footer_counters', '', 0),
('', 0, 'cyber_store_theme', 'footer_desc_status', '1', 0),
('', 0, 'cyber_store_theme', 'config_description_store_footer', '{\"1\":{\"config_description_store_footer\":\"<p><strong>OpenCart<\\/strong> \\u2013 CMS, \\u043f\\u0440\\u0435\\u0434\\u043d\\u0430\\u0437\\u043d\\u0430\\u0447\\u0435\\u043d\\u043d\\u0430\\u044f \\u043d\\u0435\\u043f\\u043e\\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e \\u0434\\u043b\\u044f \\u0441\\u043e\\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u0438\\u043d\\u0442\\u0435\\u0440\\u043d\\u0435\\u0442-\\u043c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d\\u0430, \\u0442\\u0440\\u0435\\u0431\\u0443\\u044e\\u0449\\u0430\\u044f \\u043c\\u0438\\u043d\\u0438\\u043c\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0443\\u0441\\u0438\\u043b\\u0438\\u0439 \\u043f\\u0440\\u0438 \\u0443\\u0441\\u0442\\u0430\\u043d\\u043e\\u0432\\u043a\\u0435 \\u0438 \\u043d\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0435.\\r\\n<\\/p><p>\\u041c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d\\u044b \\u043d\\u0430 OpenCart \\u0438\\u043c\\u0435\\u044e\\u0442 \\u043e\\u0434\\u043d\\u043e \\u043d\\u0435\\u0441\\u043e\\u043c\\u043d\\u0435\\u043d\\u043d\\u043e\\u0435 \\u043f\\u0440\\u0435\\u0438\\u043c\\u0443\\u0449\\u0435\\u0441\\u0442\\u0432\\u043e \\u2013 \\u043e\\u0447\\u0435\\u043d\\u044c \\r\\n\\u0432\\u044b\\u0441\\u043e\\u043a\\u0443\\u044e \\u0441\\u043a\\u043e\\u0440\\u043e\\u0441\\u0442\\u044c \\u0437\\u0430\\u0433\\u0440\\u0443\\u0437\\u043a\\u0438 \\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u0446, \\u0434\\u0430\\u0436\\u0435 \\u043f\\u0440\\u0438 \\u0431\\u043e\\u043b\\u044c\\u0448\\u043e\\u043c \\u043a\\u0430\\u0442\\u0430\\u043b\\u043e\\u0433\\u0435 \\u0441 \\r\\n\\u0433\\u0440\\u043e\\u043c\\u043e\\u0437\\u0434\\u043a\\u043e\\u0439 \\u0433\\u0440\\u0430\\u0444\\u0438\\u0447\\u0435\\u0441\\u043a\\u043e\\u0439 \\u0441\\u043e\\u0441\\u0442\\u0430\\u0432\\u043b\\u044f\\u044e\\u0449\\u0435\\u0439.<\\/p><p>\\u0421\\u0438\\u0441\\u0442\\u0435\\u043c\\u0430 \\u0438\\u043c\\u0435\\u0435\\u0442 \\u0431\\u043e\\u043b\\u044c\\u0448\\u043e\\u0435 \\u043a\\u043e\\u043b\\u0438\\u0447\\u0435\\u0441\\u0442\\u0432\\u043e \\u0448\\u0430\\u0431\\u043b\\u043e\\u043d\\u043e\\u0432, \\u043f\\u0440\\u0438\\u0447\\u0435\\u043c \\u0430\\u043d\\u0433\\u043b\\u043e\\u044f\\u0437\\u044b\\u0447\\u043d\\u044b\\u0435 \\r\\n\\u0448\\u0430\\u0431\\u043b\\u043e\\u043d\\u044b \\u0438\\u0441\\u043f\\u043e\\u043b\\u044c\\u0437\\u0443\\u044e\\u0442\\u0441\\u044f \\u0432 \\u0440\\u0430\\u0432\\u043d\\u043e\\u0439 \\u0441\\u0442\\u0435\\u043f\\u0435\\u043d\\u0438: \\u043f\\u0440\\u0438 \\u0438\\u0445 \\u0443\\u0441\\u0442\\u0430\\u043d\\u043e\\u0432\\u043a\\u0435 \\u0433\\u043b\\u0430\\u0432\\u043d\\u044b\\u0435 \\u043f\\u0443\\u043d\\u043a\\u0442\\u044b \\r\\n\\u043c\\u0435\\u043d\\u044e \\u043c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d\\u0430 \\u0431\\u0443\\u0434\\u0443\\u0442 \\u043f\\u0440\\u043e\\u043f\\u0438\\u0441\\u0430\\u043d\\u044b \\u043d\\u0430 \\u0440\\u0443\\u0441\\u0441\\u043a\\u043e\\u043c \\u044f\\u0437\\u044b\\u043a\\u0435. CMS \\u0438\\u043c\\u0435\\u0435\\u0442 \\u0442\\u0430\\u043a\\u0436\\u0435 \\r\\n\\u043c\\u043d\\u043e\\u0433\\u043e\\u044f\\u0437\\u044b\\u043a\\u043e\\u0432\\u043e\\u0439 \\u0438\\u043d\\u0442\\u0435\\u0440\\u0444\\u0435\\u0439\\u0441,\\r\\n \\u0447\\u0442\\u043e \\u043f\\u043e\\u0437\\u0432\\u043e\\u043b\\u044f\\u0435\\u0442 \\u0441\\u043e\\u0437\\u0434\\u0430\\u0432\\u0430\\u0442\\u044c \\u043d\\u0430 \\u0434\\u0432\\u0438\\u0436\\u043a\\u0435 \\u043c\\u043d\\u043e\\u0433\\u043e\\u044f\\u0437\\u044b\\u0447\\u043d\\u044b\\u0435 \\u0441\\u0430\\u0439\\u0442\\u044b.<br><\\/p>\"},\"2\":{\"config_description_store_footer\":\"<div class=\\\"text-wrap tlid-copy-target\\\"><div class=\\\"result-shield-container tlid-copy-target\\\" tabindex=\\\"0\\\"><span class=\\\"tlid-translation translation\\\" lang=\\\"en\\\">OpenCart - CMS, designed directly to create an online store, requiring minimal effort during installation and configuration.<\\/span><\\/div><div class=\\\"result-shield-container tlid-copy-target\\\" tabindex=\\\"0\\\"><span class=\\\"tlid-translation translation\\\" lang=\\\"en\\\"><br>OpenCart stores have one definite advantage - a very high page loading speed, even with a large catalog with a cumbersome graphic component.<br><br>The system has a large number of templates, and English-language templates are used equally: when they are installed, the main menu items of the store will be written in Russian. CMS also has a multilingual interface, which allows you to create multilingual sites on the engine.<\\/span><span class=\\\"tlid-translation-gender-indicator translation-gender-indicator\\\"><\\/span><\\/div><\\/div><p><br><\\/p>\"}}', 1),
('', 0, 'cyber_store_theme', 'footer_map_status', 'codemap', 0),
('', 0, 'cyber_store_theme', 'config_google_api_map_key', '', 0),
('', 0, 'cyber_store_theme', 'config_center_google_map', '', 0),
('', 0, 'cyber_store_theme', 'config_zoom_google_map', '8', 0),
('', 0, 'cyber_store_theme', 'code_map', '<iframe width=\"100%\" height=\"200\" src=\"https://maps.google.com/maps?width=100%&height=200&hl=en&coord=49.99107029936076,36.23241662979127&q=%D0%A5%D0%B0%D1%80%D1%8C%D0%BA%D0%BE%D0%B2+(CyberStore%20-%20%D0%B4%D0%B5%D0%BC%D0%BE%D0%BD%D1%81%D1%82%D1%80%D0%B0%D1%86%D0%B8%D1%8F%20%D1%88%D0%B0%D0%B1%D0%BB%D0%BE%D0%BD%D0%B0)&ie=UTF8&t=&z=15&iwloc=A&output=embed\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"><a href=\"https://www.maps.ie/coordinates.html\">gps coordinates</a></iframe>', 0),
('', 0, 'cyber_store_theme', 'type_header', '2', 0),
('', 0, 'cyber_store_theme', 'type_footer', '2', 0),
('', 0, 'cyber_store_theme', 'swap_header_blocks', '1', 0),
('', 0, 'cyber_store_theme', 'config_phones_footer', '[{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"\",\"2\":\"\"},\"phone_footer\":{\"1\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u0438\\u0442\\u044c \\u0437\\u0430\\u043a\\u0430\\u0437\",\"2\":\"Checkout\"}},{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"href=\\\"tel:+74951244501\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"tel:+74951244501\\\" target=\\\"_blank\\\"\"},\"phone_footer\":{\"1\":\"<span style=\\\"font-size:20px;color:#fff;font-weight:600;\\\"> +7 (495) 124 45 01<\\/span>\",\"2\":\"<span style=\\\"font-size:20px;color:#fff;font-weight:600;\\\"> +7 (495) 124 45 01<\\/span>\"}},{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"\",\"2\":\"\"},\"phone_footer\":{\"1\":\"\\u0417\\u0432\\u043e\\u043d\\u0438\\u0442\\u0435 \\u043d\\u0430\\u043c \\u0441 9:00 \\u0434\\u043e 21:00 <\\/br> \\u0411\\u0435\\u0437 \\u0432\\u044b\\u0445\\u043e\\u0434\\u043d\\u044b\\u0445 \",\"2\":\"Call us from 9:00 to 21:00 <\\/br> 7 days a week\"}},{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"href=\\\"tel:+74951244502\\\" target=\\\"_blank\\\"\",\"2\":\"href=\\\"tel:+74951244502\\\" target=\\\"_blank\\\"\"},\"phone_footer\":{\"1\":\"<span style=\\\"font-size:20px;color:#fff;font-weight:600;\\\"> +7 (495) 124 45 02<\\/span>\",\"2\":\"<span style=\\\"font-size:20px;color:#fff;font-weight:600;\\\"> +7 (495) 124 45 02<\\/span>\"}},{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"\",\"2\":\"\"},\"phone_footer\":{\"1\":\"\\u0417\\u0432\\u043e\\u043d\\u0438\\u0442\\u0435 \\u043d\\u0430\\u043c \\u0441 9:00 \\u0434\\u043e 21:00 <\\/br> \\u0411\\u0435\\u0437 \\u0432\\u044b\\u0445\\u043e\\u0434\\u043d\\u044b\\u0445 \",\"2\":\"Call us from 9:00 to 21:00 <\\/br> 7 days a week\"}},{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"target=\\\"_blank\\\" href=\\\"mailto:help.cyberstore@gmail.com\\\"\",\"2\":\"target=\\\"_blank\\\" href=\\\"mailto:help.cyberstore@gmail.com\\\"\"},\"phone_footer\":{\"1\":\"help.cyberstore@gmail.com\",\"2\":\"help.cyberstore@gmail.com\"}},{\"icon_footer_phone\":\"\",\"type\":{\"1\":\"\",\"2\":\"\"},\"phone_footer\":{\"1\":\"<a style=\\\"display:inline-block;padding:4px 12px;border-radius:25px;color:#fff;font-size:16px;border:1px solid #fff;\\\" href=\\\"javascript:void(0)\\\" onclick=\\\"get_modal_callbacking()\\\">\\u0417\\u0430\\u043a\\u0430\\u0437\\u0430\\u0442\\u044c \\u0437\\u0432\\u043e\\u043d\\u043e\\u043a<\\/a>\",\"2\":\"<a style=\\\"display:inline-block;padding:4px 12px;border-radius:25px;color:#fff;font-size:16px;border:1px solid #fff;\\\" href=\\\"javascript:void(0)\\\" onclick=\\\"get_modal_callbacking()\\\">Request a call<\\/a>\"}}]', 1),
('', 0, 'cyber_store_theme', 'banner_items_footer', '[{\"icon_type\":\"1\",\"icon_image\":\"fa fa-shopping-basket\",\"image\":\"catalog\\/cs_files\\/advantage1.png\",\"title\":{\"1\":\"\\u0411\\u0435\\u0441\\u043f\\u043b\\u0430\\u0442\\u043d\\u0430\\u044f \\u0434\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0430\",\"2\":\"\\u0411\\u0435\\u0441\\u043f\\u043b\\u0430\\u0442\\u043d\\u0430\\u044f \\u0434\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0430\"},\"description\":{\"1\":\"\\u043e\\u0442 1000 \\u0433\\u0440\\u043d\",\"2\":\"\\u043e\\u0442 1000 \\u0433\\u0440\\u043d\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"},{\"icon_type\":\"1\",\"icon_image\":\"fa fa-clock-o\",\"image\":\"catalog\\/cs_files\\/advantage2.png\",\"title\":{\"1\":\"\\u0411\\u043e\\u043d\\u0443\\u0441\\u044b \\u0437\\u0430 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0443\",\"2\":\"\\u0411\\u043e\\u043d\\u0443\\u0441\\u044b \\u0437\\u0430 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0443\"},\"description\":{\"1\":\"5% \\u043d\\u0430 \\u0412\\u0430\\u0448 \\u0441\\u0447\\u0435\\u0442\",\"2\":\"5% \\u043d\\u0430 \\u0412\\u0430\\u0448 \\u0441\\u0447\\u0435\\u0442\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"},{\"icon_type\":\"1\",\"icon_image\":\"fa fa-credit-card-alt\",\"image\":\"catalog\\/cs_files\\/advantage3.png\",\"title\":{\"1\":\"\\u0413\\u0430\\u0440\\u0430\\u043d\\u0442\\u0438\\u0439\\u043d\\u043e\\u0435 \\u043e\\u0431\\u0441\\u043b\\u0443\\u0436\\u0438\\u0432\\u0430\\u043d\\u0438\\u0435\",\"2\":\"\\u0413\\u0430\\u0440\\u0430\\u043d\\u0442\\u0438\\u0439\\u043d\\u043e\\u0435 \\u043e\\u0431\\u0441\\u043b\\u0443\\u0436\\u0438\\u0432\\u0430\\u043d\\u0438\\u0435\"},\"description\":{\"1\":\"\",\"2\":\"\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"},{\"icon_type\":\"1\",\"icon_image\":\"fa fa-plane\",\"image\":\"catalog\\/cs_files\\/advantage4.png\",\"title\":{\"1\":\"\\u0412\\u043e\\u0437\\u0432\\u0440\\u0430\\u0442 \\u0438 \\u043e\\u0431\\u043c\\u0435\\u043d\",\"2\":\"\\u0412\\u043e\\u0437\\u0432\\u0440\\u0430\\u0442 \\u0438 \\u043e\\u0431\\u043c\\u0435\\u043d\"},\"description\":{\"1\":\"\\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 14 \\u0434\\u043d\\u0435\\u0439\",\"2\":\"\\u0432 \\u0442\\u0435\\u0447\\u0435\\u043d\\u0438\\u0438 14 \\u0434\\u043d\\u0435\\u0439\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"},{\"icon_type\":\"1\",\"icon_image\":\"\",\"image\":\"catalog\\/cs_files\\/advantage5.png\",\"title\":{\"1\":\"\\u0421\\u0435\\u0440\\u0442\\u0438\\u0444\\u0438\\u0446\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u043d\\u044b\\u0435 \\u0442\\u043e\\u0432\\u0430\\u0440\\u044b\",\"2\":\"\\u0421\\u0435\\u0440\\u0442\\u0438\\u0444\\u0438\\u0446\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u043d\\u044b\\u0435 \\u0442\\u043e\\u0432\\u0430\\u0440\\u044b\"},\"description\":{\"1\":\"\",\"2\":\"\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"},{\"icon_type\":\"1\",\"icon_image\":\"\",\"image\":\"catalog\\/cs_files\\/advantage6.png\",\"title\":{\"1\":\"\\u0421\\u043a\\u0438\\u0434\\u043a\\u0438 \\u043f\\u043e \\u043f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043c\\u0435 \",\"2\":\"\\u0421\\u043a\\u0438\\u0434\\u043a\\u0438 \\u043f\\u043e \\u043f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043c\\u0435 \"},\"description\":{\"1\":\"~OLD to New~\",\"2\":\"~OLD to New~\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\"}]', 1),
('', 0, 'cyber_store_theme', 'footer_column_setting_ns', '{\"column_1\":{\"1\":{\"icon_image\":\"\",\"name_column\":\"\\u0418\\u043d\\u0444\\u043e\\u0440\\u043c\\u0430\\u0446\\u0438\\u044f\"},\"2\":{\"icon_image\":\"\",\"name_column\":\"Information\"}},\"column_2\":{\"1\":{\"icon_image\":\"fa fa-tasks\",\"name_column\":\"\\u041a\\u0430\\u0442\\u0435\\u0433\\u043e\\u0440\\u0438\\u0438\"},\"2\":{\"icon_image\":\"fa fa-tasks\",\"name_column\":\"Categories\"}},\"column_3\":{\"1\":{\"icon_image\":\"\",\"name_column\":\"\\u041b\\u0438\\u0447\\u043d\\u044b\\u0439 \\u043a\\u0430\\u0431\\u0438\\u043d\\u0435\\u0442\"},\"2\":{\"icon_image\":\"\",\"name_column\":\"Personal Area\"}},\"link_account\":\"1\",\"link_order\":\"1\",\"link_wishlist\":\"1\",\"link_contact\":\"1\",\"link_sitemap\":\"1\",\"link_manufacturer\":\"1\",\"link_special\":\"1\",\"1\":{\"footer_links\":{\"1\":{\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u044c\\u044e\\u0442\\u0435\\u0440\\u044b\",\"link\":\"\",\"column_link\":\"2\"},\"2\":{\"title\":\"\\u041d\\u043e\\u0443\\u0442\\u0431\\u0443\\u043a\\u0438\",\"link\":\"\",\"column_link\":\"2\"},\"3\":{\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043e\\u043d\\u0435\\u043d\\u0442\\u044b\",\"link\":\"\",\"column_link\":\"2\"},\"4\":{\"title\":\"\\u041f\\u043b\\u0430\\u043d\\u0448\\u0435\\u0442\\u044b\",\"link\":\"\",\"column_link\":\"2\"},\"5\":{\"title\":\"\\u041f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043c\\u043d\\u043e\\u0435 \\u043e\\u0431\\u0435\\u0441\\u043f\\u0435\\u0447\\u0435\\u043d\\u0438\\u0435\",\"link\":\"\",\"column_link\":\"2\"},\"6\":{\"title\":\"\\u0422\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u044b\",\"link\":\"\",\"column_link\":\"2\"},\"7\":{\"title\":\"\\u041a\\u0430\\u043c\\u0435\\u0440\\u044b\",\"link\":\"\",\"column_link\":\"2\"}}},\"2\":{\"footer_links\":{\"1\":{\"title\":\"Computers\",\"link\":\"\",\"column_link\":\"2\"},\"2\":{\"title\":\"Laptops\",\"link\":\"\",\"column_link\":\"2\"},\"3\":{\"title\":\"Components\",\"link\":\"\",\"column_link\":\"2\"},\"4\":{\"title\":\"Tablets\",\"link\":\"\",\"column_link\":\"2\"},\"5\":{\"title\":\"Software\",\"link\":\"\",\"column_link\":\"2\"},\"6\":{\"title\":\"Phones\",\"link\":\"\",\"column_link\":\"2\"},\"7\":{\"title\":\"Cameras\",\"link\":\"\",\"column_link\":\"2\"}}}}', 1),
('', 0, 'cyber_store_theme', 'config_social_footer', '[{\"image_footer_social\":\"\",\"social_icon_footer\":\"fa fa-vk\",\"bg_hover_icon\":\"#666BFF\",\"social_link_footer\":\"\"},{\"image_footer_social\":\"\",\"social_icon_footer\":\"fa fa-facebook\",\"bg_hover_icon\":\"#4E2FB5\",\"social_link_footer\":\"\"},{\"image_footer_social\":\"\",\"social_icon_footer\":\"fa fa-whatsapp\",\"bg_hover_icon\":\"#4BD428\",\"social_link_footer\":\"\"},{\"image_footer_social\":\"\",\"social_icon_footer\":\"fa fa-youtube-square\",\"bg_hover_icon\":\"#FF2121\",\"social_link_footer\":\"\"},{\"image_footer_social\":\"\",\"social_icon_footer\":\"fa fa-odnoklassniki-square\",\"bg_hover_icon\":\"#FF792B\",\"social_link_footer\":\"\"}]', 1),
('', 0, 'cyber_store_theme', 'config_on_off_shopping_cart_click', '0', 0),
('', 0, 'cyber_store_theme', 'config_shopping_cart_after_add', '2', 0),
('', 0, 'cyber_store_theme', 'icon_shopcart', '', 0),
('', 0, 'cyber_store_theme', 'newstore_data', '', 0);

TRUNCATE TABLE `oc_module`;
INSERT INTO `oc_module` (`module_id`, `name`, `code`, `setting`) VALUES
(30, 'Баннер на странице категорий', 'banner', '{\"name\":\"Баннер на странице категорий\",\"banner_id\":\"6\",\"width\":\"182\",\"height\":\"182\",\"status\":\"1\"}'),
(29, 'Карусель на главной странице', 'carousel', '{\"name\":\"Карусель на главной странице\",\"banner_id\":\"8\",\"width\":\"130\",\"height\":\"100\",\"status\":\"1\"}'),
(28, 'Рекомендуемые на главной странице', 'featured', '{\"name\":\"\\u0420\\u0435\\u043a\\u043e\\u043c\\u0435\\u043d\\u0434\\u0443\\u0435\\u043c\\u044b\\u0435 \\u043d\\u0430 \\u0433\\u043b\\u0430\\u0432\\u043d\\u043e\\u0439 \\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u0446\\u0435\",\"product_name\":\"\",\"product\":[\"43\",\"40\",\"42\",\"30\",\"41\",\"49\"],\"limit\":\"6\",\"width\":\"75\",\"height\":\"75\",\"status\":\"1\"}'),
(27, 'Слайдшоу на главной странице', 'slideshow', '{\"name\":\"Слайдшоу на главной странице\",\"banner_id\":\"7\",\"width\":\"1140\",\"height\":\"380\",\"status\":\"1\"}'),
(31, 'Баннер Продукция HP', 'banner', '{\"name\":\"Баннер Продукция HP\",\"banner_id\":\"6\",\"width\":\"182\",\"height\":\"182\",\"status\":\"1\"}'),
(32, 'Вы Смотрели', 'cyber_productviewed', '{\"name\":\"\\u0412\\u044b \\u0421\\u043c\\u043e\\u0442\\u0440\\u0435\\u043b\\u0438\",\"limit\":\"5\",\"width\":\"200\",\"height\":\"200\",\"status\":\"1\"}'),
(33, 'Успей купить', 'cyber_productany', '{\"name\":\"\\u0423\\u0441\\u043f\\u0435\\u0439 \\u043a\\u0443\\u043f\\u0438\\u0442\\u044c\",\"config_productany_title\":{\"1\":{\"config_productany_title\":\"\\u0423\\u0441\\u043f\\u0435\\u0439 \\u043a\\u0443\\u043f\\u0438\\u0442\\u044c\"},\"2\":{\"config_productany_title\":\"\\u0423\\u0441\\u043f\\u0435\\u0439 \\u043a\\u0443\\u043f\\u0438\\u0442\\u044c\"}},\"config_title_color_text_productany\":\"#3BE827\",\"config_title_background\":\"#3BE827\",\"product\":[\"42\",\"30\",\"47\",\"28\",\"41\"],\"limit\":\"5\",\"width\":\"200\",\"height\":\"200\",\"status_timer_special\":\"1\",\"status\":\"1\"}'),
(46, 'Ноутбуки', 'cyber_latest_grid', '{\"name\":\"\\u041d\\u043e\\u0443\\u0442\\u0431\\u0443\\u043a\\u0438\",\"title_module\":{\"1\":\"\\u041d\\u043e\\u0443\\u0442\\u0431\\u0443\\u043a\\u0438\",\"2\":\"\\u041d\\u043e\\u0443\\u0442\\u0431\\u0443\\u043a\\u0438\"},\"category_id\":\"18\",\"filter_sub_category\":\"1\",\"status_showmore\":\"1\",\"limit_max\":\"10\",\"limit\":\"5\",\"limit_tablet\":\"3\",\"limit_mob\":\"2\",\"width\":\"200\",\"height\":\"200\",\"status\":\"1\"}'),
(35, 'Акции SLIDE Deals', 'cyber_slidedeals', '{\"name\":\"\\u0410\\u043a\\u0446\\u0438\\u0438 SLIDE Deals\",\"verdeals\":\"1\",\"title\":{\"1\":{\"text\":\"\\u0410\\u043a\\u0446\\u0438\\u043e\\u043d\\u043d\\u043e\\u0435 \\u043f\\u0440\\u0435\\u0434\\u043b\\u043e\\u0436\\u0435\\u043d\\u0438\\u0435\"},\"2\":{\"text\":\"Special offer\"}},\"description\":{\"1\":{\"text\":\"\\u0421\\u043a\\u0438\\u0434\\u043a\\u0438 \\u0434\\u043e 30 % \\u043d\\u0430 \\u0432\\u0441\\u0435 \\u0442\\u043e\\u0432\\u0430\\u0440\\u044b \"},\"2\":{\"text\":\"Discounts up to 30% on all products\"}},\"on_off_model_product\":\"1\",\"on_off_description\":\"1\",\"on_off_slider_additional_image\":\"0\",\"on_off_rating\":\"1\",\"on_off_quantity_reviews\":\"1\",\"on_off_fastorder\":\"1\",\"on_off_wishlist\":\"1\",\"on_off_compare\":\"1\",\"bg_timer\":\"#A38CFF\",\"limit\":\"5\",\"width\":\"200\",\"height\":\"200\",\"status_timer_special\":\"1\",\"status\":\"1\"}'),
(36, 'Баннеры Блоки Главная', 'cyber_banner_blocks', '{\"name\":\"\\u0411\\u0430\\u043d\\u043d\\u0435\\u0440\\u044b \\u0411\\u043b\\u043e\\u043a\\u0438 \\u0413\\u043b\\u0430\\u0432\\u043d\\u0430\\u044f\",\"status\":\"1\",\"banner_column\":\"3\",\"banner_item\":[{\"image\":\"catalog\\/cs_files\\/cms1.png\",\"title\":{\"1\":\"\\u0411\\u0435\\u0441\\u043f\\u043b\\u0430\\u0442\\u043d\\u0430\\u044f \\u0434\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0430\",\"2\":\"Free shipping\"},\"description\":{\"1\":\"\\u0411\\u0435\\u0441\\u043f\\u043b\\u0430\\u0442\\u043d\\u0430\\u044f \\u0434\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0430 \\u043d\\u0430 \\u0432\\u0441\\u0435 \\u0437\\u0430\\u043a\\u0430\\u0437\\u044b \\u0432\\u044b\\u0448\\u0435 5000\\u0440\",\"2\":\"Free shipping on all orders above 5000r\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\",\"sort\":\"\"},{\"image\":\"catalog\\/cs_files\\/cms2.png\",\"title\":{\"1\":\"\\u041f\\u043e\\u0434\\u0434\\u0435\\u0440\\u0436\\u043a\\u0430 24\\/7\",\"2\":\" Support 24\\/7\"},\"description\":{\"1\":\"\\u041c\\u044b \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u0435\\u0442 24 \\u0447\\u0430\\u0441\\u0430 7 \\u0434\\u043d\\u0435\\u0439 \\u0432 \\u043d\\u0435\\u0434\\u0435\\u043b\\u044e\",\"2\":\"We work 24 hours 7 days a week.\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\",\"sort\":\"\"},{\"image\":\"catalog\\/cs_files\\/cms3.png\",\"title\":{\"1\":\"60-\\u0434\\u043d\\u0435\\u0432\\u043d\\u044b\\u0439 \\u0432\\u043e\\u0437\\u0432\\u0440\\u0430\\u0442\",\"2\":\"60 day return\"},\"description\":{\"1\":\"\\u0415\\u0441\\u043b\\u0438 \\u0432\\u0430\\u043c \\u044d\\u0442\\u043e \\u043d\\u0435 \\u043d\\u0440\\u0430\\u0432\\u0438\\u0442\\u0441\\u044f, \\u0443 \\u0432\\u0430\\u0441 \\u0435\\u0441\\u0442\\u044c 60 \\u0434\\u043d\\u0435\\u0439, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0432\\u0435\\u0440\\u043d\\u0443\\u0442\\u044c \\u0435\\u0433\\u043e.\",\"2\":\"If you do not like it, you have 60 days to return it.\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\",\"sort\":\"\"},{\"image\":\"catalog\\/cs_files\\/cms4.png\",\"title\":{\"1\":\"100% \\u0411\\u0435\\u0437\\u043e\\u043f\\u0430\\u0441\\u043d\\u0430\\u044f \\u043e\\u043f\\u043b\\u0430\\u0442\\u0430\",\"2\":\"100% Secure Payment\"},\"description\":{\"1\":\"\\u041c\\u044b \\u0433\\u0430\\u0440\\u0430\\u043d\\u0442\\u0438\\u0440\\u0443\\u0435\\u043c \\u0431\\u0435\\u0437\\u043e\\u043f\\u0430\\u0441\\u043d\\u0443\\u044e \\u043e\\u043f\\u043b\\u0430\\u0442\\u0443\",\"2\":\"We guarantee secure payment.\"},\"link\":{\"1\":\"\",\"2\":\"\"},\"popup\":\"0\",\"sort\":\"\"}]}'),
(37, 'Компьютеры', 'cyber_latest_grid', '{\"name\":\"\\u041a\\u043e\\u043c\\u043f\\u044c\\u044e\\u0442\\u0435\\u0440\\u044b\",\"title_module\":{\"1\":\"\\u041a\\u043e\\u043c\\u043f\\u044c\\u044e\\u0442\\u0435\\u0440\\u044b\",\"2\":\"Computers\"},\"category_id\":\"20\",\"filter_sub_category\":\"1\",\"status_showmore\":\"1\",\"limit_max\":\"25\",\"limit\":\"5\",\"limit_tablet\":\"3\",\"limit_mob\":\"2\",\"width\":\"200\",\"height\":\"200\",\"status\":\"1\"}'),
(38, 'Отзывы о магазине', 'cyber_reviews_store', '{\"name\":\"\\u041e\\u0442\\u0437\\u044b\\u0432\\u044b \\u043e \\u043c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d\\u0435\",\"limit\":\"3\",\"limit_tablet\":\"3\",\"limit_mob\":\"1\",\"status_showmore\":\"1\",\"limit_max\":\"6\",\"status\":\"1\"}'),
(39, 'Отзывы покупателей', 'cyber_reviewscustomer', '{\"name\":\"\\u041e\\u0442\\u0437\\u044b\\u0432\\u044b \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439\",\"reviewscustomer\":{\"order_type\":\"last\",\"module_header\":{\"1\":\"\\u041e\\u0442\\u0437\\u044b\\u0432\\u044b \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439\",\"2\":\"\\u041e\\u0442\\u0437\\u044b\\u0432\\u044b \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439\"},\"status_showmore\":\"1\",\"limit_max\":\"12\",\"limit\":\"10\",\"limit_tablet\":\"2\",\"limit_mob\":\"1\",\"category_sensitive\":\"1\",\"show_all_button\":\"1\"},\"status\":\"1\"}'),
(40, 'Главная PCT', 'cyber_product_categorytabs', '{\"name\":\"\\u0413\\u043b\\u0430\\u0432\\u043d\\u0430\\u044f PCT\",\"category_sel\":[\"34\",\"33\",\"25\",\"20\",\"18\"],\"sorts_product\":\"p.date_added DESC, p.sort_order DESC, LCASE(p.name) DESC\",\"filter_sub_category\":\"1\",\"status_showmore\":\"1\",\"limit_max\":\"20\",\"limit\":\"5\",\"limit_tablet\":\"3\",\"limit_mob\":\"1\",\"width\":\"200\",\"height\":\"200\",\"status\":\"1\"}'),
(41, 'Магазин по отделам', 'cyber_wallcategory', '{\"name\":\"\\u041c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d \\u043f\\u043e \\u043e\\u0442\\u0434\\u0435\\u043b\\u0430\\u043c\",\"title_name\":{\"1\":{\"title_name\":\"\\u041c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d \\u043f\\u043e \\u043e\\u0442\\u0434\\u0435\\u043b\\u0430\\u043c\"},\"2\":{\"title_name\":\"\\u041c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d \\u043f\\u043e \\u043e\\u0442\\u0434\\u0435\\u043b\\u0430\\u043c\"}},\"status_slider\":\"0\",\"width\":\"150\",\"height\":\"150\",\"limit\":\"10\",\"limit3lv\":\"6\",\"status_sub_image\":\"1\",\"status\":\"1\",\"wall_category\":[{\"category\":\"18\",\"image\":\"catalog\\/cs_files\\/4.png\",\"sort_order\":\"0\"},{\"category\":\"20\",\"image\":\"catalog\\/cs_files\\/3.png\",\"sort_order\":\"0\"},{\"category\":\"24\",\"image\":\"catalog\\/cs_files\\/5.png\",\"sort_order\":\"0\"},{\"category\":\"33\",\"image\":\"catalog\\/cs_files\\/1.png\",\"sort_order\":\"0\"},{\"category\":\"34\",\"image\":\"catalog\\/cs_files\\/1.png\",\"sort_order\":\"0\"},{\"category\":\"57\",\"image\":\"catalog\\/cs_files\\/6.png\",\"sort_order\":\"0\"},{\"category\":\"17\",\"image\":\"catalog\\/cs_files\\/8.png\",\"sort_order\":\"0\"},{\"category\":\"25\",\"image\":\"catalog\\/cs_files\\/7.jpg\",\"sort_order\":\"0\"}]}'),
(42, 'Акция главная', 'special', '{\"name\":\"\\u0410\\u043a\\u0446\\u0438\\u044f \\u0433\\u043b\\u0430\\u0432\\u043d\\u0430\\u044f\",\"limit\":\"3\",\"width\":\"75\",\"height\":\"75\",\"status\":\"1\"}'),
(43, 'Хит продаж', 'bestseller', '{\"name\":\"\\u0425\\u0438\\u0442 \\u043f\\u0440\\u043e\\u0434\\u0430\\u0436\",\"limit\":\"3\",\"width\":\"75\",\"height\":\"75\",\"status\":\"1\"}'),
(44, 'Новинки', 'latest', '{\"name\":\"\\u041d\\u043e\\u0432\\u0438\\u043d\\u043a\\u0438\",\"limit\":\"3\",\"width\":\"75\",\"height\":\"75\",\"status\":\"1\"}'),
(45, 'Главная MSPRO', 'cyber_megasliderpro', '{\"name\":\"\\u0413\\u043b\\u0430\\u0432\\u043d\\u0430\\u044f MSPRO\",\"status\":\"1\",\"banner\":\"14\",\"width\":\"1920\",\"height\":\"464\"}');

TRUNCATE TABLE `oc_layout_module`;
INSERT INTO `oc_layout_module` (`layout_module_id`, `layout_id`, `code`, `position`, `sort_order`, `pc_device`, `tablet_device`, `mob_device`) VALUES
(2, 4, '0', 'content_top', 0, 0, 0, 0),
(3, 4, '0', 'content_top', 1, 0, 0, 0),
(20, 5, '0', 'column_left', 2, 0, 0, 0),
(69, 10, 'affiliate', 'column_right', 1, 0, 0, 0),
(68, 6, 'account', 'column_right', 1, 0, 0, 0),
(78, 1, 'cyber_banner_blocks.36', 'content_top', 0, 0, 0, 0),
(83, 3, 'latest.44', 'column_left', 1, 0, 0, 0),
(82, 3, 'featured.28', 'column_left', 0, 0, 0, 0),
(74, 2, 'cyber_productviewed.32', 'content_bottom', 0, 0, 0, 0),
(79, 1, 'cyber_productany.33', 'content_bottom', 0, 0, 0, 0),
(80, 1, 'cyber_latest_grid.37', 'content_bottom', 1, 0, 0, 0),
(81, 1, 'cyber_product_categorytabs.40', 'content_bottom', 2, 0, 0, 0),
(84, 3, 'special.42', 'column_left', 2, 0, 0, 0);


TRUNCATE TABLE `oc_extension`;
INSERT INTO `oc_extension` (`extension_id`, `type`, `code`) VALUES
(1, 'payment', 'cod'),
(2, 'total', 'shipping'),
(3, 'total', 'sub_total'),
(4, 'total', 'tax'),
(5, 'total', 'total'),
(6, 'module', 'banner'),
(7, 'module', 'carousel'),
(8, 'total', 'credit'),
(9, 'shipping', 'flat'),
(10, 'total', 'handling'),
(11, 'total', 'low_order_fee'),
(12, 'total', 'coupon'),
(13, 'module', 'category'),
(14, 'module', 'account'),
(15, 'total', 'reward'),
(16, 'total', 'voucher'),
(17, 'payment', 'free_checkout'),
(18, 'module', 'featured'),
(19, 'module', 'slideshow'),
(20, 'theme', 'theme_default'),
(21, 'dashboard', 'activity'),
(22, 'dashboard', 'sale'),
(23, 'dashboard', 'recent'),
(24, 'dashboard', 'order'),
(25, 'dashboard', 'online'),
(26, 'dashboard', 'map'),
(27, 'dashboard', 'customer'),
(28, 'dashboard', 'chart'),
(29, 'theme', 'cyberstore'),
(30, 'module', 'cyber_setting_theme'),
(31, 'module', 'cyber_megamenuvh'),
(32, 'module', 'cyber_question_answer'),
(33, 'module', 'cyber_found_cheaper_product'),
(34, 'module', 'cyber_productviewed'),
(35, 'module', 'cyber_productany'),
(36, 'module', 'cyber_slidedeals'),
(37, 'module', 'cyber_autosearch'),
(38, 'module', 'cyber_banner_blocks'),
(39, 'module', 'cyber_quickviewpro'),
(40, 'module', 'cyber_product_tabs'),
(41, 'module', 'cyber_ut5setting'),
(42, 'module', 'cyber_latest_grid'),
(43, 'module', 'cyber_reviews_store'),
(44, 'module', 'cyber_reviewscustomer'),
(45, 'module', 'cyber_product_categorytabs'),
(46, 'module', 'cyber_editproduct'),
(48, 'module', 'cyber_wallcategory'),
(49, 'module', 'cyber_myonepagecheckout'),
(50, 'module', 'special'),
(51, 'module', 'bestseller'),
(52, 'module', 'latest'),
(53, 'module', 'cyber_megasliderpro');


CREATE TABLE IF NOT EXISTS `oc_megasliderpro`(
`megasliderpro_id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(64) NOT NULL,
`status` tinyint(1) NOT NULL,
`delay` int(11) DEFAULT NULL,
`hover` tinyint(1) DEFAULT NULL,
`nextback` tinyint(1) DEFAULT NULL,
`contrl` tinyint(1) DEFAULT NULL,
`effect` varchar(64) NOT NULL,
PRIMARY KEY (`megasliderpro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

TRUNCATE TABLE `oc_megasliderpro`;
INSERT INTO `oc_megasliderpro` (`megasliderpro_id`, `name`, `status`, `delay`, `hover`, `nextback`, `contrl`, `effect`) VALUES
(14, 'Главная MSPRO', 1, 4000, 1, 1, 1, 'random');

CREATE TABLE IF NOT EXISTS `oc_megasliderpro_image` (
`megasliderpro_image_id` int(11) NOT NULL AUTO_INCREMENT,
`megasliderpro_id` int(11) NOT NULL,
`link` varchar(255) NOT NULL,
`type` int(11) NOT NULL,
`image` varchar(255) NOT NULL,
`small_image` varchar(255) NOT NULL,
`sort_order` int(11) NOT NULL,
PRIMARY KEY (`megasliderpro_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

TRUNCATE TABLE `oc_megasliderpro_image`;
INSERT INTO `oc_megasliderpro_image` (`megasliderpro_image_id`, `megasliderpro_id`, `link`, `type`, `image`, `small_image`, `sort_order`) VALUES
(141, 14, '', 2, 'catalog/cs_files/ms_slide_1.png', '', 1),
(142, 14, '', 1, 'catalog/cs_files/ms_slide_3.png', '', 0);


CREATE TABLE IF NOT EXISTS `oc_megasliderpro_image_description` (
`megasliderpro_image_id` int(11) NOT NULL,
`language_id` int(11) NOT NULL,
`megasliderpro_id` int(11) NOT NULL,
`title` varchar(255) NOT NULL,
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
`price` DECIMAL(15,4),
`price_bg` VARCHAR(64),
PRIMARY KEY (`megasliderpro_image_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

TRUNCATE TABLE `oc_megasliderpro_image_description`;
INSERT INTO `oc_megasliderpro_image_description` (`megasliderpro_image_id`, `language_id`, `megasliderpro_id`, `title`, `sub_title`, `bg_title`, `color_title`, `bg_sub_title`, `color_sub_title`, `opacity_bg_title`, `opacity_bg_sub_title`, `effect_title`, `effect_sub_title`, `effect_description_title`, `description`, `price`, `price_bg`) VALUES
(142, 2, 14, 'MacBook Pro', '13-inch MacBook Pro gets blazing fast performance and speed with M1 chip ', '', '', '', '', '1', '1', 'no_select', 'no_select', 'no_select', '', 39199.0000, ''),
(141, 2, 14, 'Iphone 12', 'iPhone 12 and iPhone 12 mini - A14 Bionic, advanced cameras and Super Retina XDR with Ceramic Shield ', '', '', '', '', '1', '1', 'no_select', 'no_select', 'no_select', '', 28999.0000, ''),
(142, 1, 14, 'MacBook Pro', 'С появлением чипа M1 MacBook Pro 13 дюймов становится невероятно про­из­во­ди­тель­ным и быстрым', '', '', '', '', '1', '1', 'no_select', 'no_select', 'no_select', '', 39199.0000, ''),
(141, 1, 14, 'Iphone 12', 'iPhone 12 и iPhone 12 mini — A14 Bionic, передовые камеры и Super Retina XDR с Ceramic Shield', '', '', '', '', '1', '1', 'no_select', 'no_select', 'no_select', '&lt;br&gt;', 28999.0000, '');


CREATE TABLE IF NOT EXISTS `oc_megamenuvh` (
`megamenu_id` int(11) NOT NULL AUTO_INCREMENT,
`namemenu` text NOT NULL,
`dop_info_vm` text NOT NULL,
`additional_menu` varchar(45) NOT NULL,
`link` text NOT NULL,
`menu_type` varchar(45) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '1',
`sticker_parent` varchar(255) NOT NULL,
`sticker_parent_bg` varchar(255) NOT NULL,
`spctext` varchar(255) NOT NULL,
`sort_menu` int(3) NOT NULL DEFAULT '0',
`image` varchar(255) NOT NULL,
`image_hover` varchar(255) NOT NULL,
`informations_list` longtext NOT NULL,
`manufacturers_setting` longtext NOT NULL,
`products_setting` longtext NOT NULL,
`link_setting` tinyint(1) NOT NULL,
`category_setting` longtext NOT NULL,
`html_setting` longtext NOT NULL,
`freelinks_setting` longtext NOT NULL,
`use_add_html` tinyint(1) NOT NULL,
`add_html` longtext NOT NULL,
PRIMARY KEY (`megamenu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

TRUNCATE TABLE `oc_megamenuvh`;
INSERT INTO `oc_megamenuvh` (`megamenu_id`, `namemenu`, `dop_info_vm`, `additional_menu`, `link`, `menu_type`, `status`, `sticker_parent`, `sticker_parent_bg`, `spctext`, `sort_menu`, `image`, `image_hover`, `informations_list`, `manufacturers_setting`, `products_setting`, `link_setting`, `category_setting`, `html_setting`, `freelinks_setting`, `use_add_html`, `add_html`) VALUES
(1, '{\"1\":\"\\u041a\\u043e\\u043c\\u043f\\u044c\\u044e\\u0442\\u0435\\u0440\\u044b\",\"2\":\"Desktops\"}', '', 'left', '{\"1\":\"desktops\",\"2\":\"desktops\"}', 'category', 1, '{\"1\":\"\\u0422\\u043e\\u043f\",\"2\":\"\"}', 'F6E61C', '000000', 0, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[\"26\",\"27\"]}', '', '', 0, ''),
(2, '{\"1\":\"\\u041d\\u043e\\u0443\\u0442\\u0431\\u0443\\u043a\\u0438\",\"2\":\"Laptops &amp; Notebooks\"}', '', 'left', '{\"1\":\"laptop-notebook\",\"2\":\"laptop-notebook\"}', 'category', 1, '\"\"', '', '', 1, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[\"45\",\"46\"]}', '', '', 0, ''),
(3, '{\"1\":\"\\u041a\\u043e\\u043c\\u043f\\u043e\\u043d\\u0435\\u043d\\u0442\\u044b\",\"2\":\"Components\"}', '', 'left', '{\"1\":\"component\",\"2\":\"component\"}', 'category', 1, '\"\"', '', '', 2, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[\"28\",\"29\",\"30\",\"31\",\"32\"]}', '', '', 0, ''),
(4, '{\"1\":\"\\u041f\\u043b\\u0430\\u043d\\u0448\\u0435\\u0442\\u044b\",\"2\":\"Tablets\"}', '', 'left', '{\"1\":\"tablet\",\"2\":\"tablet\"}', 'category', 1, '\"\"', '', '', 3, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[]}', '', '', 0, ''),
(5, '{\"1\":\"\\u041f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043d\\u043e\\u0435 \\u043e\\u0431\\u0435\\u0441\\u043f\\u0435\\u0447\\u0435\\u043d\\u0438\\u0435\",\"2\":\"Software\"}', '', 'left', '{\"1\":\"software\",\"2\":\"software\"}', 'category', 1, '\"\"', '', '', 4, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[]}', '', '', 0, ''),
(6, '{\"1\":\"\\u0422\\u0435\\u043b\\u0435\\u0444\\u043e\\u043d\\u044b \\u0438 PDA\",\"2\":\"Phones &amp; PDAs\"}', '', 'left', '{\"1\":\"smartphone\",\"2\":\"smartphone\"}', 'category', 1, '\"\"', '', '', 5, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[]}', '', '', 0, ''),
(7, '{\"1\":\"\\u041a\\u0430\\u043c\\u0435\\u0440\\u044b\",\"2\":\"Cameras\"}', '', 'left', '{\"1\":\"camera\",\"2\":\"camera\"}', 'category', 1, '\"\"', '', '', 6, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[]}', '', '', 0, ''),
(8, '{\"1\":\"MP3 \\u041f\\u043b\\u0435\\u0435\\u0440\\u044b\",\"2\":\"MP3 Players\"}', '', 'left', '{\"1\":\"mp3-players\",\"2\":\"mp3-players\"}', 'category', 1, '\"\"', '', '', 7, '', '', '', '', '', 0, '{\"variant_category\":\"simple\",\"show_sub_category\":\"1\",\"category_img_width\":\"50\",\"category_img_height\":\"50\",\"category_list\":[\"37\",\"55\",\"54\",\"53\",\"52\",\"51\",\"50\",\"49\",\"48\",\"47\",\"44\",\"43\",\"42\",\"41\",\"40\",\"39\",\"38\",\"56\"]}', '', '', 0, ''),
(9, '{\"1\":\"\\u041d\\u043e\\u0432\\u0438\\u043d\\u043a\\u0438\",\"2\":\"latest\"}', '{\"1\":\"\",\"2\":\"\"}', 'additional', '{\"1\":\"index.php?route=product\\/cyber_latestpage\",\"2\":\"index.php?route=product\\/cyber_latestpage\"}', 'link', 1, '{\"1\":\"\",\"2\":\"\"}', 'FFFFFF', 'FFFFFF', 8, '', '', '', '', '', 0, '', '', '', 0, '{\"1\":\"\",\"2\":\"\"}'),
(10, '{\"1\":\"\\u041e\\u0442\\u0437\\u044b\\u0432\\u044b \\u043e \\u043c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d\\u0435\",\"2\":\"Store reviews\"}', '{\"1\":\"\",\"2\":\"\"}', 'additional', '{\"1\":\"index.php?route=product\\/cyber_reviews_store\",\"2\":\"index.php?route=product\\/cyber_reviews_store\"}', 'link', 1, '{\"1\":\"\",\"2\":\"\"}', 'FFFFFF', 'FFFFFF', 10, '', '', '', '', '', 0, '', '', '', 0, '{\"1\":\"\",\"2\":\"\"}'),
(11, '{\"1\":\"\\u041e\\u0442\\u0437\\u044b\\u0432\\u044b \\u043e \\u0442\\u043e\\u0432\\u0430\\u0440\\u0435\",\"2\":\"Product Reviews\"}', '{\"1\":\"\",\"2\":\"\"}', 'additional', '{\"1\":\"index.php?route=product\\/cyber_reviewscustomer\",\"2\":\"index.php?route=product\\/cyber_reviewscustomer\"}', 'link', 1, '{\"1\":\"\",\"2\":\"\"}', 'FFFFFF', 'FFFFFF', 11, '', '', '', '', '', 0, '', '', '', 0, '{\"1\":\"\",\"2\":\"\"}'),
(12, '{\"1\":\"\\u0414\\u043e\\u0441\\u0442\\u0430\\u0432\\u043a\\u0430\",\"2\":\"Delivery\"}', '{\"1\":\"\",\"2\":\"\"}', 'additional', '{\"1\":\"delivery\",\"2\":\"delivery\"}', 'link', 1, '{\"1\":\"\",\"2\":\"\"}', 'FFFFFF', 'FFFFFF', 12, '', '', '', '', '', 0, '', '', '', 0, '{\"1\":\"\",\"2\":\"\"}'),
(13, '{\"1\":\"\\u041e\\u043f\\u043b\\u0430\\u0442\\u0430\",\"2\":\"Payment\"}', '{\"1\":\"\",\"2\":\"\"}', 'additional', '{\"1\":\"oplata\",\"2\":\"oplata\"}', 'link', 1, '{\"1\":\"\",\"2\":\"\"}', 'FFFFFF', 'FFFFFF', 13, '', '', '', '', '', 0, '', '', '', 0, '{\"1\":\"\",\"2\":\"\"}');
DELETE FROM `oc_setting` WHERE `code` = 'megamenu_setting';
INSERT INTO `oc_setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
('', 0, 'megamenu_setting', 'megamenu_setting', '{\"status\":\"1\",\"main_menu_selection\":\"1\",\"main_menu_fix_mobile\":\"0\",\"type_mobile_menu\":\"1\",\"main_menu_mask\":\"0\",\"config_fixed_panel_top\":\"1\",\"horizontal_menu_width\":\"1\"}', 1);
