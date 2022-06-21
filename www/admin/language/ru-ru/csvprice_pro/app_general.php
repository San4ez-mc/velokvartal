<?php

// Heading
$_['heading_title'] = 'Основное';
$_['heading_title_normal'] = 'CSV Price Pro import/export OC3';

// Text
$_['text_module'] = 'Модули';
$_['text_extension'] = 'Расширения';
$_['text_yes'] = 'Да';
$_['text_no'] = 'Нет';
$_['text_auto_ajax'] = 'Автоматический AJAX';
$_['text_auto'] = 'Автоматический';
$_['text_mirror'] = 'Зеркало';
$_['text_manual'] = 'Ручной';
$_['text_success'] = 'Настройки успешно обновлены!';
$_['text_product_backup'] = 'Товары';
$_['text_category_backup'] = 'Категории';
$_['text_manufacturer_backup'] = 'Производители';
$_['text_product_all_backup'] = 'Товары, Категории, Производители';
$_['text_full_backup'] = 'Полный бэкап';
$_['text_opencart_backup'] = 'OpenCart';
$_['text_raw_backup'] = 'MySQL Dump (DELETE TABLE, CREATE TABLE, INSERT)';
$_['text_core_update'] = 'Перезагрузить конфигурацию ядра';

// Tabs
$_['tab_setting'] = 'Основные настройки';
$_['tab_tool_image'] = 'Инструменты для изображений';
$_['tab_tool_backup'] = 'Резервное копирование';

// Buttons
$_['button_save'] = 'Сохранить';
$_['button_export'] = 'Экспорт';
$_['button_delete_image_cache'] = 'Очистить таблицу с кэшем изображений';

// Entry
$_['entry_csv_import_mod'] = 'Режим импорта товаров';
$_['entry_each_iteration_timeout'] = 'Тайм-аут для каждой итерации AJAX';
$_['entry_image_download_mod'] = 'Режим скачивания изображений';
$_['entry_save_img_table'] = 'Сохранить таблицу с изображениями';
$_['entry_work_directory'] = 'Рабочая директория';
$_['entry_product_log'] = 'Включить журнал импорта товаров';
$_['entry_clear_image_cache'] = 'Удалить кэш изображений';
$_['entry_backup_data'] = 'Данные';
$_['entry_backup_type'] = 'Тип';
$_['entry_backup_zip'] = 'Использовать архивацию ZIP';

// Error
$_['error_permission'] = 'У Вас нет прав для управления модулем CSV Price Pro import/export!';

// Prop
$_['prop_descr'] = ' 
prop_descr[1]="<p><b>Режим скачивания изображений</b></p><p><i>Автоматический</i> - Изображения будут скачиваться и сохраняться в автоматическом режиме, директории и имена изображений будут созданы модулем по своему собственному алгоритму.</p><p><i>Зеркало</i> - Имена изображений и директории (путь) по возможности будут сохранены в оиргинальном виде.</p>";
prop_descr[2]="<p><b>Сохранить таблицу с изображениями</b></p><p>Если данная опция включена, то таблица *csvprice_pro_images не удалена при удалении модуля, все данные о скаченных изображениях будут сохранены для дальнейшего использования.</p>";
prop_descr[3]="<p><b>Рабочая директория</b></p><p>Эта директория должна существовать и должна быть доступна для записи.</p>";
prop_descr[4]="<p>После установки расширения, который поддреживается CSV Price Pro import/export, необходимо обновить конфигурацию ядра.</p>";
prop_descr[5]="<p>Мы рекомендуем вам настроить параметр тайм-аута каждой итерации на 60–180 секунд, чтобы позволить каждой итерации завершиться и корректно завершить работу расширения.</p><p>Этот параметр должен быть меньше установленного max_execution_time в настройке PHP.</p>";
';
