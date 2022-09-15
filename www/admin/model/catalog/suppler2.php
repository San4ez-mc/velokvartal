<?php

class ModelCatalogSuppler2 extends Model
{
    public function createTables()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler2 (id INT(10) AUTO_INCREMENT, name varchar(64), link text, status INT(1), description TEXT, route varchar(256), order_num INT(3), PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppler2_data` ( `id` INT NOT NULL AUTO_INCREMENT , `suppler_id` INT NOT NULL , `key` VARCHAR(100) NOT NULL , `example_value` TEXT NOT NULL , `route` VARCHAR(256) NOT NULL , `site_key` VARCHAR(100) NOT NULL , `status` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler2_logs (id INT(10) AUTO_INCREMENT, date varchar(64), data text, status INT(1), PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->cache->delete('suppler');
    }

    public function getSuppler($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2 WHERE id=" . $id);
        return !empty($query->rows) ? $query->rows[0] : null;
    }

    public function getSupplers()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2");
        return $query->rows;
    }

    public function addSuppler($data)
    {
        if (isset($data['name']) and isset($data['link'])) {

            $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2` (`name`, `link`, `status`, `description`, `route`, `order_num`) VALUES ('" . $this->db->escape($data['name']) . "', '" . $this->db->escape($data['link']) . "', '" . $this->db->escape($data['status']) . "', '" . $this->db->escape($data['description']) . "', '" . $this->db->escape($data['route']) . "', '" . $this->db->escape($data['order_name']) . "')");

            if (!empty($data['rows'])) {

                $last_inserted_id = $this->db->getLastId();
                foreach ($data['rows'] as $row) {
                    if (strlen($row['site_key']) > 0) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_data` ( `suppler_id`, `key`, `example_value`, `route`, `site_key`, `status`) VALUES (" . $last_inserted_id . ", '" . $this->db->escape($row['key']) . "', '" . $this->db->escape($row['value']) . "', '" . $this->db->escape($row['route']) . "', '" . $this->db->escape($row['site_key']) . "', '" . $this->db->escape($row['status']) . "');");
                    }
                }
            }
            $this->cache->delete('suppler');
        }
    }

    public function editSuppler($id, $data)
    {
        if (isset($data['name']) and isset($data['link'])) {

            $this->db->query("UPDATE `" . DB_PREFIX . "suppler2` SET `name` = '" . $this->db->escape($data['name']) . "', `link` =  '" . $this->db->escape($data['link']) . "',  `description` = '" . $this->db->escape($data['description']) . "',   `route` = '" . $this->db->escape($data['route']) . "', `status` =  '" . $this->db->escape($data['status']) . "', `order_num` =  '" . $this->db->escape($data['order_num']) . "' WHERE `" . DB_PREFIX . "suppler2`.`id` = {$id}");

            $this->db->query("DELETE FROM `" . DB_PREFIX . "suppler2_data` WHERE suppler_id = {$id}");

            if (!empty($data['rows'])) {

                foreach ($data['rows'] as $row) {
                    if (strlen($row['site_key']) > 0) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_data` ( `suppler_id`, `key`, `example_value`, `route`, `site_key`, `status`) VALUES (" . $id . ", '" . $this->db->escape($row['key']) . "', '" . $this->db->escape($row['value']) . "', '" . $this->db->escape($row['route']) . "', '" . $this->db->escape($row['site_key']) . "', '" . $this->db->escape($row['status']) . "');");
                    }
                }
            }
            $this->cache->delete('suppler');
        }
    }

    public function deleteSuppler($form_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "suppler2 WHERE `form_id` = '" . (int)$form_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "suppler2_data WHERE `form_id` = '" . (int)$form_id . "'");

        $this->cache->delete('suppler');
    }

    public function getLogs()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2_logs");
        return $query->rows;
    }

    public function parse_xml($id)
    {
        $log = [];
        $token = !empty($this->request->get['user_token']) ? $this->request->get['user_token'] : '';
        $this->load->model('catalog/suppler2');

        $suppler = $this->getSuppler($id);
        if ($suppler) {
            $log[] = [
                'type' => 'info',
                'message' => 'Начинается работа с поставщиком "' . $suppler['name'] . '"'
            ];
            $suppler_data = $this->getSupplerData($id);
            $sku_data = $this->getSupplerDataSKU($id);

            $xml = $this->get_xml_from_url($suppler['link']);

            if (!empty($xml)) {
                $log[] = [
                    'type' => 'success',
                    'message' => 'XML получен по указанной ссылке'
                ];

                if (!empty($suppler_data) && !empty($suppler['route'])) {
                    $main_route = $suppler['route'];
                    $log[] = [
                        'type' => 'success',
                        'message' => 'Настройки поставщика найдены'
                    ];

                    if (!empty($sku_data)) {
                        $log[] = [
                            'type' => 'info',
                            'message' => 'Настройка SKU найдено, начинается поиск товаров...'
                        ];

                        // отримуємо продукти з xml
                        if (strripos(htmlspecialchars_decode($main_route), '->') !== false) {
                            $parts = explode('->', htmlspecialchars_decode($main_route));
                            if (count($parts) == 2) {
                                $xml_products = $xml->{$parts[0]}->{$parts[1]};
                                if (is_object($xml_products)) {
                                    $part1 = $xml->{$parts[0]};
                                    $xml_arr = (array)$part1;
                                    $xml_products = $xml_arr[$parts[1]];
                                    if (is_object($xml_products)) {
                                        $xml_arr = (array)$xml_products;
                                        $first_key = array_key_first($xml_arr);

                                        $xml_products = $xml_arr[$first_key];
                                    }
                                }
                            }
                        } else {
                            $xml_array = (array)$xml;
//                            $xml_products = $xml->{$main_route};
                            $xml_products = $xml_array[$main_route];

                            if (is_object($xml_products)) {
                                $xml_arr = (array)$xml;
                                $xml_products = $xml_arr[$main_route];
                            }
                        }

                        if (!empty($xml_products)) {
                            $not_found = 0;
                            $readed = 0;
                            $skus = [];
                            foreach ($xml_products as $xml_product) {
                                $readed++;

                                $xml_product_array = (array)$xml_product;

                                // знаходимо в рядку xml SKU і по ньому шукаємо продукт
                                if (strripos(htmlspecialchars_decode($sku_data['route']), '->') === false) {
//                                    $sku = (string)$xml_product->{$sku_data['route']};
                                    $sku = (string)$xml_product_array[$sku_data['route']];
                                    //                                    $quantity = (string)$xml_product->{$sku_data['quantity']};
                                    $quantity = (string)$xml_product_array[$sku_data['quantity']];
                                    $product = $this->getProductBySKU(trim($sku));
                                } else {
                                    // todo допрацювати
//                                    $parts = explode('->', $sku_data['route']);
//                                    if (count($parts) == 2) {
//                                        $products = $xml_product->{$parts[0]}->{$parts[1]};
//                                    }
//                                    $product = null;
//                                    $sku = '';
                                }

                                if ($product) {
                                    $params_changed = 0;

                                    $log[] = [
                                        'type' => 'info',
                                        'message' => 'Найден товар <a target="_blank" href="/admin/index.php?route=catalog/product/edit&user_token=' . $token . '&product_id=' . $product['product_id'] . '" >' . $product['name'] . ' (' . $product['sku'] . ') </a>'
                                    ];

                                    $extra_images = [];
                                    foreach ($suppler_data as $suppler_row) {
                                        $route = htmlspecialchars_decode($suppler_row['route']);

                                        if (strripos($route, '->') === false) {
//                                            $value = (string)$xml_product->{$suppler_row['route']};
                                            $value = (string)$xml_product_array[$route];
                                        } else {
                                            $parts = explode('->', $route);
                                            if (count($parts) == 2) {
                                                $value = (array)$xml_product_array[$parts[0]];
                                                if(is_object($xml_product_array[$parts[0]]) && count((array)$xml_product_array[$parts[0]]) == 1){
                                                    $value = $value[array_key_first($value)];
                                                }
                                                $value = $value[$parts[1]];

                                            } elseif (count($parts) == 3) {
                                                $value = $xml_product_array[$parts[0]][$parts[1]][$parts[2]];
                                            }
                                        }

                                        if (!empty($value) && strlen($value) > 0) {

                                            switch ($suppler_row['site_key']) {
                                                case 'name':
                                                    $log[] = [
                                                        'type' => 'success',
                                                        'message' => 'Имя успешно заменено на ' . $value
                                                    ];
                                                    break;
                                                case 'category':
                                                    $log[] = [
                                                        'type' => 'success',
                                                        'message' => 'Категория успешно заменена на ' . $value
                                                    ];
                                                    break;
                                                case 'description':
                                                    $this->editProductDescriptionField($product['product_id'], 'description', $value);

                                                    $log[] = [
                                                        'type' => 'success',
                                                        'message' => 'Описание успешно заменено на: ' . $value
                                                    ];
                                                    break;
                                                case 'price':
                                                    if (!empty($availability)) {
                                                        $this->editProductField($product['product_id'], 'price', $value);
                                                        $this->editProductField($product['product_id'], 'price_zak', $value);

                                                        $log[] = [
                                                            'type' => 'success',
                                                            'message' => 'Цена успешно заменена на: ' . $value
                                                        ];
                                                    } else {
                                                        $log[] = [
                                                            'type' => 'info',
                                                            'message' => 'Цена не заменена так как товара нет в наличии в xml'
                                                        ];
                                                    }
                                                    break;
                                                case 'price_stock':
                                                    if (!empty($quantity)) {
                                                        if (!empty($value)) {
                                                            $this->editProductDiscount($product['product_id'], $value, $quantity);

                                                            $log[] = [
                                                                'type' => 'success',
                                                                'message' => 'Цена успешно заменена на: ' . $value
                                                            ];
                                                        }
                                                    } else {
                                                        $log[] = [
                                                            'type' => 'info',
                                                            'message' => 'Цена со скидкой не заменена так как товара нет в наличии в xml'
                                                        ];
                                                    }
                                                    break;
                                                case 'image':
                                                    $local_path = $this->saveImageFormUrl($value, $sku);
                                                    if ($local_path) {
                                                        $this->editProductField($product['product_id'], 'image', $local_path);

                                                        $log[] = [
                                                            'type' => 'success',
                                                            'message' => 'Изображение успешно заменено на: <img width="200" src ="' . $value . '" />',
                                                            'temp_url' => $value,
                                                            'temp_route' => $_SERVER['DOCUMENT_ROOT'],
                                                            'temp_file_name' => $local_path
                                                        ];
                                                    } else {
                                                        $log[] = [
                                                            'type' => 'warning',
                                                            'message' => 'Не удалось заменить <a  target="_blank" href="' . $value . '">изображение</a>'
                                                        ];
                                                    }
                                                    break;
                                                case 'image_extra':
                                                    $extra_images[] = $value;
                                                    break;
                                            }

                                            $params_changed ++;
                                        }
                                    }

                                    if (!empty($extra_images)) {
                                        $this->updateExtraImages($product['product_id'], $sku, $extra_images, $log);
                                    }

                                    if(empty($params_changed)){
                                        $log[] = [
                                            'type' => 'warning',
                                            'message' => 'В товаре не заменен ни один параметр так как они пустые в xml',
                                        ];
                                    }
                                } else {
                                    $not_found++;
                                    $skus[] = $sku;
                                }
                            }
                        }
                        $log[] = [
                            'type' => 'info',
                            'message' => 'Обработано строк: ' . $readed . ''
                        ];
                        if ($not_found > 0) {
                            $log[] = [
                                'type' => 'warning',
                                'message' => 'SKU не найдено: ' . $not_found . '. <a class="show_more" href="#">Подробнее</a><span class="hidden">:<br/>' . implode(', ', $skus) . '</span> ',
                            ];
                        }
                        $log[] = [
                            'type' => 'info',
                            'message' => 'Чтение файла поставщика "' . $suppler['name'] . '" завершено',
                            'break' => true
                        ];
                    } else {
                        $log[] = [
                            'type' => 'danger',
                            'message' => 'В настройках поставщика не указано поле SKU',
                            'break' => true
                        ];
                    }
                } else {
                    $log[] = [
                        'type' => 'danger',
                        'message' => 'Поставщик не настроен. Перейдите в список поставщиков и закончите, пожалуйста, настройку',
                        'break' => true
                    ];
                }
            } else {
                $log[] = [
                    'type' => 'danger',
                    'message' => 'Не удалось спарсить xml по указанной ссылке <a href="' . $suppler['link'] . '">' . $suppler['link'] . '</a>',
                    'break' => true
                ];
            }
        } else {
            $log[] = [
                'type' => 'danger',
                'message' => 'Поставщик не найден',
                'break' => true
            ];
        }
        return $log;
    }

    public function observe_xml($link, $id = null, $route = null)
    {
        $xml = $this->get_xml_from_url($link);

        if ($xml) {
            return [
                'status' => 'ok',
                'routes' => $this->create_xml_tree($xml)
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'No rows found'
            ];
        }

    }

    public function get_xml_vars_from_url($link, $main_key)
    {
        $xml = $this->get_xml_from_url($link);
        return $this->get_xml_vars($xml, $main_key);
    }

    public function get_xml_vars($xml, $main_key)
    {
        $rows = [];

        $first_key = array_key_first((array)$xml);
        $xml_array = (array)$xml;
        if (count($xml_array) === 1 && is_array($xml_array[$first_key])) {
            $product = (array)$xml_array[$first_key][0];
        } else {
            $products = $xml_array[$main_key];

            if (strripos($main_key, '->') !== false) {
                $parts = explode('->', $main_key);
                if (count($parts) == 2) {
                    $products = $xml->{$parts[0]}->{$parts[1]};
                }
            }

            if (!empty($products[0])) {
                $product = $products[0];
            }
        }

        if (!empty($product)) {
            $product_array = (array)$product;

            if (count($product_array) === 1) {
                $product_array = $product_array[array_key_first($product_array)][0];
                $product_array = (array)$product_array;
            }

            foreach ($product_array as $key => $row) {
                if (is_array($row)) {

                    // поки не буду виводити параметри
//                    $rows[] = [
//                        'key' => $key,
//                        'value' => 'масив данных',
//                        'route' => $key
//                    ];
                } elseif (is_object($row)) {
                    if (count((array)$row) > 0) {
                        $row_array = (array)$row;
                        if (count($row_array) === 1) {
                            $row_array = $row_array[array_key_first($row_array)];
                        }
//                        foreach ($row as $key2 => $item) {

                        if (!empty($row_array[0])) {
                            for ($i = 0; $i < count($row_array); $i++) {
                                $rows[] = [
                                    'key' => $key . '->' . $i,
                                    'value' => $row_array[$i],
                                    'route' => $key . '->' . $i
                                ];
                            }
                        } else {
                            foreach ($row_array as $key2 => $item) {
                                $rows[] = [
                                    'key' => $key . '->' . $key2,
                                    'value' => $item->{array_key_first((array)$item)},
                                    'route' => $key . '->' . $key2
                                ];
                            }
                        }
                    } else {
                        $rows[] = [
                            'key' => $key,
                            'value' => (string)$row,
                            'route' => $key
                        ];
                    }
                } else {
                    $rows[] = [
                        'key' => $key,
                        'value' => $row,
                        'route' => $key
                    ];
                }
            }

            return [
                'status' => 'ok',
                'rows' => $rows
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'No rows found in selected folder'
            ];
        }
    }

    function create_xml_tree($xml)
    {
        $tree = [];
        if (!empty($xml)) {
            $first_key = array_key_first((array)$xml);
            $xml_array = (array)$xml;
            if (count($xml_array) === 1 && is_array($xml_array[$first_key])) {
                $tree[] = [
                    "id" => $first_key,
                    "text" => $first_key,
                    "children" => [],
                    "type" => "root",
                    "route" => $first_key
                ];
                return $tree;
            }

            foreach ($xml_array as $key => $xml_row) {

                $xml_row = (array)$xml_row;
                $first_key = array_key_first($xml_row);
                $children = [];
                if (is_int($first_key)) {
                    $children[] = [
                        "id" => $xml_row[0],
                        "text" => $xml_row[0],
                        "children" => false,
                        "type" => "file"
                    ];
                }

                if (is_string($first_key)) {

                    $rows = count($xml_row) > 1 ? $xml_row : $xml_row[$first_key];

                    $counter = 0;
                    foreach ($rows as $key2 => $xml_row2) {
                        $children2 = [];
                        foreach ($xml_row2[0] as $key3 => $xml_row3) {
                            $children3 = false;

                            $children2[] = [
                                "id" => $key3,
                                "text" => $key3,
                                "children" => $children3,
                                "type" => "file"
                            ];
                        }

                        if (is_int($key2)) {
                            if (is_string($xml_row2)) {
                                $text2 = $xml_row2;
                                $route = $key;
                            }
                            if (is_object($xml_row2)) {
                                $text2 = $xml_row2[0];
                                $route = $key;
                            }
                        } else {
                            $text2 = $key2;
                            $route = $key . '->' . $key2;
                        }

                        $children[] = [
                            "id" => $text2,
                            "text" => $text2,
                            "children" => $children2,
                            "type" => "file",
                            "route" => $route
                        ];

                        $counter++;
                        if ($counter == 10) {
                            break;
                        }
                    }
                }

                $tree[] = [
                    "id" => $key,
                    "text" => $key,
                    "children" => $children,
                    "type" => "root",
                    "route" => $key
                ];
            }
        }

        return [[
            "id" => '0',
            "text" => 'xml',
            "children" => $tree,
            "type" => "root",
            "route" => '/'
        ]];

    }

    function get_xml_from_url($link)
    {
        $xml = file_get_contents($link);
        $xml = simplexml_load_string($xml);
        if (!$xml) {
            $xml = simplexml_load_file($link);
        }
        return $xml;
    }

    function saveImageFormUrl($url, $sku)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . 'image/catalog/xml/';
        $ext = end(explode('.', $url));
        $path = $dir . $sku . '.' . $ext;
//        unlink($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (copy($url, $path)) {
            return 'catalog/xml/' . $sku . '.' . $ext;
        }
        return false;
    }

    public
    function editProductField($product_id, $field, $value)
    {
        if (isset($product_id) && isset($field) && isset($value)) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $field . " = '" . $this->db->escape($value) . "' WHERE product_id = '" . (int)$product_id . "'");
        }
    }

    public
    function editProductDescriptionField($product_id, $field, $value)
    {
        if (isset($product_id) && isset($field) && isset($value)) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET " . $field . " = '" . $this->db->escape($value) . "' WHERE product_id = '" . (int)$product_id . "'");
        }
    }

    public
    function updateExtraImages($product_id, $sku, $images, &$log)
    {
        $saved = [];
        $not_saved = [];
        if (!empty($images)) {
            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];

                $local_path = $this->saveImageFormUrl($image, $sku . '_' . $i);
                if ($local_path) {
                    $this->editExtraImagesField($product_id, $local_path, $i);
                    $saved[] = $image;
                } else {
                    $not_saved[] = $image;
                }
            }

            if (!empty($not_saved)) {
                $not_saved_str = '';
                foreach ($not_saved as $not_saved_image) {
                    $not_saved_str .= '<img width="200" src ="' . $not_saved_image . '" />';
                }
                $log[] = [
                    'type' => 'warning',
                    'message' => 'Не удалось добавить ' . count($not_saved) . ' дополнительных изображений. <a class="show_more" href="#">Подробнее</a><span class="hidden">:<br/>' . $not_saved_str . '</span>'
                ];
            }

            if (!empty($saved)) {
                $saved_str = '';
                foreach ($saved as $saved_image) {
                    $saved_str .= '<img width="200" src ="' . $saved_image . '" />';
                }
                $log[] = [
                    'type' => 'success',
                    'message' => 'Успешно добавлено ' . count($saved) . ' дополнительных изображений. <a class="show_more" href="#">Подробнее</a><span class="hidden">:<br/>' . $saved_str . '</span>'
                ];
            }
        }
    }

    public
    function editExtraImagesField($product_id, $image, $index)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

        if (isset($product_id) && isset($image)) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "product_image` (`product_id`, `image`, `sort_order`) VALUES ('" . (int)$product_id . "', '" . $image . "',  '" . ((int)$index + 1) . "')");
        }
    }

    public
    function editProductDiscount($product_id, $price, $quantity)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

        if (isset($product_id) && isset($price)) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "_product_discount` (`product_id`, `quantity`, `price`, `date_start`, `date_end`) VALUES ('" . (int)$product_id . "', '" . (int)$quantity . "',  '" . (int)$price . "')");
        }
    }

    public
    function getProductBySKU($sku, $store = 0)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p 
        LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
        LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
        WHERE p.sku = '" . $this->db->escape($sku) . "' 
        AND p2s.store_id = '" . (int)$store . "' group by p.product_id");

        return !empty($query->rows) ? $query->rows[0] : null;
    }

    public
    function getSupplerData($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2_data WHERE `suppler_id` = '" . (int)$id . "'");

        return $query->rows;
    }

    public
    function getSupplerDataSKU($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2_data WHERE `suppler_id` = '" . (int)$id . "' AND site_key = 'sku'");

        return !empty($query->rows) ? $query->rows[0] : null;
    }

    public
    function getTotalSupplers()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "suppler");

        return $query->row['total'];
    }
}

?>