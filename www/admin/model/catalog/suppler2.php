<?php

class ModelCatalogSuppler2 extends Model
{
    public function createTables()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler2 (id INT(10) AUTO_INCREMENT, name varchar(64), link text, status INT(1), need_authorization INT(1) DEFAULT 0, login varchar(256), password varchar(256),  description TEXT, route varchar(256), product_number INT(10), order_num INT(3), PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppler2_data` ( `id` INT NOT NULL AUTO_INCREMENT , `suppler_id` INT NOT NULL , `key` VARCHAR(100) NOT NULL , `example_value` TEXT NOT NULL , `route` VARCHAR(256) NOT NULL , `site_key` VARCHAR(100) NOT NULL , `status` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppler2_logs` (id INT(10) AUTO_INCREMENT, `suppler_id` INT NOT NULL, date varchar(64), status INT(1), PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppler2_log_details` ( `id` INT NOT NULL AUTO_INCREMENT , `log_id` INT NOT NULL , `type` VARCHAR(20) NOT NULL , `message` TEXT NOT NULL , `break` INT(1) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppler2_amount_settings` ( `id` INT NOT NULL AUTO_INCREMENT , `suppler_id` INT NOT NULL , `amount_key` VARCHAR(20) NOT NULL , `sign` VARCHAR(10) NOT NULL , `value` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM DEFAULT CHARSET=utf8");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "suppler2_amount_to_source` ( `id` INT NOT NULL AUTO_INCREMENT , `suppler_id` INT NOT NULL , `suppler_desc` VARCHAR(255), `product_id` INT NOT NULL , `quantity` INT NOT NULL , `price` INT NOT NULL , `stock_price` INT NOT NULL , `price_desc` VARCHAR(255), `source` VARCHAR(20) NOT NULL , `datetime` VARCHAR(20), PRIMARY KEY (`id`)) ENGINE = MyISAM;");

        $this->cache->delete('suppler');
    }

    public function getSuppler($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2 WHERE id=" . $id);
        return !empty($query->rows) ? $query->rows[0] : null;
    }

    public function getSupplers($where = null)
    {
        $where_string = '';
        if (!empty($where)) {
            $where_string = ' WHERE ';
            foreach ($where as $where_param) {
                $where_string .= $where_param . ' AND ';
            }
            $where_string = substr($where_string, 0, 5);
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2" . $where_string);
        return $query->rows;
    }

    public function addSuppler($data)
    {
        if (isset($data['name']) and isset($data['link'])) {

            $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2` (`name`, `link`, `need_authorization`, `login`, `password`, `status`, `description`, `route`, `product_number`, `order_num`) VALUES ('" . $this->db->escape($data['name']) . "', '" . $this->db->escape($data['link']) . "', '" . $this->db->escape($data['need_authorization']) . "', '" . $this->db->escape($data['login']) . "', '" . $this->db->escape($data['password']) . "' '" . $this->db->escape($data['status']) . "', '" . $this->db->escape($data['description']) . "', '" . $this->db->escape($data['route']) . "', 1,  '" . $this->db->escape($data['order_name']) . "')");

            if (!empty($data['rows'])) {
                $last_inserted_id = $this->db->getLastId();
                foreach ($data['rows'] as $row) {
                    if (strlen($row['site_key']) > 0) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_data` ( `suppler_id`, `key`, `example_value`, `route`, `site_key`, `status`) VALUES (" . $last_inserted_id . ", '" . $this->db->escape($row['key']) . "', '" . $this->db->escape($row['value']) . "', '" . $this->db->escape($row['route']) . "', '" . $this->db->escape($row['site_key']) . "', '" . $this->db->escape($row['status']) . "');");
                    }
                }
            }

            if (!empty($data['quantity_settings'])) {
                foreach ($data['quantity_settings'] as $key => $row) {
                    if (strlen($row['sign']) > 0) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_amount_settings` ( `suppler_id`, `amount_key`, `sign`, `value`) VALUES (" . $id . ", '" . $key . "', '" . $this->db->escape($row['sign']) . "', '" . $this->db->escape($row['number']) . "');");
                    }
                }
            }

            $this->cache->delete('suppler');
        }
    }

    public function editSuppler($id, $data)
    {
        if (isset($data['name']) and isset($data['link'])) {

            $this->db->query("UPDATE `" . DB_PREFIX . "suppler2` SET 
                 `name` = '" . $this->db->escape($data['name']) . "',
                 `link` =  '" . $this->db->escape($data['link']) . "',
                 `need_authorization` =  '" . $this->db->escape($data['need_authorization']) . "',
                 `login` =  '" . $this->db->escape($data['login']) . "',
                 `password` =  '" . $this->db->escape($data['password']) . "',
                 `description` = '" . $this->db->escape($data['description']) . "',
                 `product_number` = '" . $this->db->escape($data['product_number']) . "',
                 `route` = '" . $this->db->escape($data['route']) . "',
                 `status` =  '" . $this->db->escape($data['status']) . "',
                 `order_num` =  '" . $this->db->escape($data['order_num']) .
                "' WHERE `" . DB_PREFIX . "suppler2`.`id` = {$id}");

            $this->db->query("DELETE FROM `" . DB_PREFIX . "suppler2_data` WHERE suppler_id = {$id}");

            if (!empty($data['rows'])) {
                foreach ($data['rows'] as $row) {
                    if (strlen($row['site_key']) > 0) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_data` ( `suppler_id`, `key`, `example_value`, `route`, `site_key`, `status`) VALUES (" . $id . ", '" . $this->db->escape($row['key']) . "', '" . $this->db->escape($row['value']) . "', '" . $this->db->escape($row['route']) . "', '" . $this->db->escape($row['site_key']) . "', '" . $this->db->escape($row['status']) . "');");
                    }
                }
            }

            $this->db->query("DELETE FROM `" . DB_PREFIX . "suppler2_amount_settings` WHERE suppler_id = {$id}");

            if (!empty($data['quantity_settings'])) {
                foreach ($data['quantity_settings'] as $key => $row) {
                    if (strlen($row['sign']) > 0) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_amount_settings` ( `suppler_id`, `amount_key`, `sign`, `value`) VALUES (" . $id . ", '" . $key . "', '" . $this->db->escape($row['sign']) . "', '" . $this->db->escape($row['number']) . "');");
                    }
                }
            }

            $this->cache->delete('suppler');
        }
    }

    public function deleteSuppler($id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "suppler2 WHERE `id` = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "suppler2_data WHERE `id` = '" . (int)$id . "'");

        $this->cache->delete('suppler');
    }

    public function getLog($log_id)
    {
        $log = [];
        $query = $this->db->query("SELECT 
                                    sl2.`id`,
                                     sl2.`date`,
                                      s2.`name` as suppler_name,
                                       sl2.`status` 
                FROM `oc_suppler2_logs` sl2 
                LEFT JOIN `oc_suppler2` s2 ON s2.id = sl2.suppler_id 
                WHERE sl2.id=" . $log_id . "
                ORDER BY `id` DESC;
        ");

        if (!empty($query->rows)) {
            $log = $query->rows[0];

            $query = $this->db->query("SELECT * FROM `oc_suppler2_log_details`
                WHERE log_id=" . $log_id . "
                ORDER BY `id` ASC;");
            if (!empty($query->rows)) {
                $log['rows'] = $query->rows;
            }
        }
        return $log;
    }

    public function getLogs()
    {
        $query = $this->db->query("SELECT sl2.`id`,
                                    sl2.`date`,
                                     s2.`name` as suppler_name,
                                      sl2.`status` 
                FROM `oc_suppler2_logs` sl2 
                LEFT JOIN `oc_suppler2` s2 ON s2.id = sl2.suppler_id 
                ORDER BY `id` DESC;
        ");
        return $query->rows;
    }

    public function getQuantitySettings($suppler_id)
    {
        $settings = [];
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2_amount_settings WHERE `suppler_id` = " . $suppler_id);
        if (!empty($query->rows)) {
            foreach ($query->rows as $row) {
                $settings[$row['amount_key']]['sign'] = $row['sign'];
                $settings[$row['amount_key']]['value'] = $row['value'];
            }
        }

        return $settings;
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
                'message' => 'Начинается работа с поставщиком \'' . $suppler['name'] . '\''
            ];
            $suppler_data = $this->getSupplerData($id);
            $sku_data = $this->getSupplerDataSKU($id);
            $quantity_data = $this->getSupplerDataQuantity($id);
            $quantity_settings = $this->getQuantitySettings($id);

            $xml = $this->get_xml_from_url($suppler['link'], $suppler['need_authorization'], $suppler['login'], $suppler['password']);

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
                                $sku = $this->get_xml_field_by_route($sku_data['route'], $xml_product_array);
                                $product = $this->getProductBySKU(trim($sku));

                                // знаходимо в рядку xml кількість
                                $quantity = $this->get_xml_field_by_route($quantity_data['route'], $xml_product_array);
                                // замінюємо кількість, яка є в xml зі спеціальних позначок
                                if (!empty($quantity_settings)) {
                                    foreach ($quantity_settings as $quantity_setting) {
                                        if ($quantity == $quantity_setting['sign']) {
                                            $quantity = $quantity_setting['value'];
                                        }
                                    }
                                }

                                if ($product) {
                                    $params_changed = 0;

                                    $log[] = [
                                        'type' => 'info',
                                        'message' => 'Найден товар <a target=\'_blank\' href=\'/admin/index.php?route=catalog/product/edit&user_token=' . $token . '&product_id=' . $product['product_id'] . '\' >' . $product['name'] . ' (' . $product['sku'] . ') </a>'
                                    ];

                                    $extra_images = [];
                                    $price_info = [
                                        'product_id' => $product['product_id'],
                                        'suppler_id' => $id,
                                        'quantity' => $quantity,
                                        'source' => 'xml'
                                    ];
                                    foreach ($suppler_data as $suppler_row) {
                                        $route = htmlspecialchars_decode($suppler_row['route']);

                                        if (strripos($route, '->') === false) {
                                            $value = (string)$xml_product_array[$route];
                                        } else {
                                            $parts = explode('->', $route);
                                            if (count($parts) == 2) {
                                                $value = (array)$xml_product_array[$parts[0]];
                                                if (is_object($xml_product_array[$parts[0]]) && count((array)$xml_product_array[$parts[0]]) == 1) {
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
                                                    if (!empty((int)$quantity)) {
//                                                        $this->addPriceToSource([
//                                                            'product_id' => $product['product_id'],
//                                                            'price' => $value,
//                                                            'suppler_id' => $id,
//                                                            'quantity' => $quantity,
//                                                            'source' => 'xml'
//                                                        ]);

                                                        $price_info['price'] = $value;

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
//                                                            $this->editProductDiscount($product['product_id'], $value, $quantity);
                                                            $price_info['stock_price'] = $value;

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

                                            $params_changed++;
                                        }
                                    }

                                    $this->addPriceToSource([
                                        'product_id' => $product['product_id'],
                                        'suppler_id' => $id,
                                        'quantity' => $quantity,
                                        'source' => 'xml'
                                    ]);


                                    if (!empty($extra_images)) {
                                        $this->updateExtraImages($product['product_id'], $sku, $extra_images, $log);
                                    }

                                    if (empty($params_changed)) {
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

    function get_xml_field_by_route($route, $xml_product_array)
    {
        $route = htmlspecialchars_decode($route);
        $value = '';
        if (strripos($route, '->') === false) {
            $value = (string)$xml_product_array[$route];
        } else {
            $parts = explode('->', $route);
            if (count($parts) == 2) {
                $data = (array)$xml_product_array[$parts[0]];
                $value = $data[$parts[1]];
            } else if (count($parts) == 3) {
                $data = (array)$xml_product_array[$parts[0]];
                $data = (array)$data[$parts[1]];
                $value = $data[$parts[2]];
            }
        }
        return $value;
    }

    public function observe_xml($link, $need_authorization = false, $login = null, $password = null)
    {
        $xml = $this->get_xml_from_url($link, $need_authorization, $login, $password);

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

    public function get_xml_vars_from_url($link, $main_key, $product_number, $need_authorization = false, $login = null, $password = null)
    {
        $xml = $this->get_xml_from_url($link, $need_authorization, $login, $password);
        return $this->get_xml_vars($xml, $main_key, $product_number);
    }

    public function get_xml_vars($xml, $main_key, $product_number = 0)
    {
        $rows = [];

        $product_number = (int)$product_number;

        if ($product_number < 0) {
            $product_number = 0;
        }

        $first_key = array_key_first((array)$xml);
        $xml_array = (array)$xml;
        if (count($xml_array) === 1 && is_array($xml_array[$first_key])) {
            $product = (array)$xml_array[$first_key][$product_number];
        } else {
            $products = $xml_array[$main_key];

            if (strripos($main_key, '->') !== false) {
                $parts = explode('->', $main_key);
                if (count($parts) == 2) {
                    $products = $xml->{$parts[0]}->{$parts[1]};
                }
            }

            $products_array = (array)$products;

            if (!empty($products_array[$product_number])) {
                $product = $products[$product_number];
            } else {
                if (count($products_array) === 1) {
                    $products_array = (array)$products_array[array_key_first($products_array)];
                    $product = $products_array[$product_number];
                }
            }
        }

        if (!empty($product)) {
            $product_array = (array)$product;

            foreach ($product_array as $key => $row) {
                if (is_array($row)) {
                    foreach ($row as $key2 => $item) {
                        $rows[] = [
                            'key' => $key . ' -> ' . $key2,
                            'value' => $item,
                            'route' => $key . '->' . $key2
                        ];
                    }
                } elseif (is_object($row)) {
                    if (count((array)$row) > 0) {
                        $row_array = (array)$row;
                        if (count($row_array) === 1) {
                            $row_array = $row_array[array_key_first($row_array)];
                        }
                        if (!empty($row_array[0])) {
                            for ($i = 0; $i < count($row_array); $i++) {
                                $rows[] = [
                                    'key' => $key . ' -> ' . $i,
                                    'value' => $row_array[$i],
                                    'route' => $key . '->' . $i
                                ];
                            }
                        } else {
                            foreach ($row_array as $key2 => $item) {
                                $rows[] = [
                                    'key' => $key . ' -> ' . $key2,
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

    function get_xml_from_url($link, $need_authorization = false, $login = null, $password = null)
    {
        if ($need_authorization) {
            define("COOKIE_FILE", "cookie.txt");
            $post = [
                "FrontendUsers" => [
                    'login' => $login,
                    'password' => $password
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://paul-lange-ukraine.com/login");
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
            curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE);
            curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $retValue = curl_exec($ch);

            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $retValue, $matches);
            $cookies = array();
            foreach ($matches[1] as $item) {
                parse_str($item, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }

            $headers = array();
            $cookies_str = '';
            if (!empty($cookies)) {
                foreach ($cookies as $cookie_key => $cookie) {
                    $cookies_str .= $cookie_key . '=' . $cookie . '; ';
                }
            }
            $headers[] = 'Cookie: ' . $cookies_str;

            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $retValue = curl_exec($ch);
            curl_close($ch);

            $xml = simplexml_load_string($retValue);
        } else {
            $xml = file_get_contents($link);
            $xml = simplexml_load_string($xml);
            if (!$xml) {
                $xml = simplexml_load_file($link);
            }
        }
        return $xml;
    }

    function saveImageFormUrl($url, $sku)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . 'image/catalog/xml/';
        $ext = end(explode('.', $url));
        $path = $dir . $sku . '.' . $ext;
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
    function editProductDiscount($product_id, $price = null, $quantity = null)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

        if (isset($product_id) && !empty($price)) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "product_discount` (`product_id`, `quantity`, `price`) VALUES ('" . (int)$product_id . "', '" . (int)$quantity . "',  '" . (int)$price . "')");
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
    function getSupplerDataQuantity($id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler2_data WHERE `suppler_id` = '" . (int)$id . "' AND site_key = 'quantity'");

        return !empty($query->rows) ? $query->rows[0] : null;
    }

    public
    function getTotalSupplers()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "suppler");

        return $query->row['total'];
    }

    public
    function addPriceToSource($data)
    {
        if (!empty($data['suppler_id']) && !empty($data['product_id']) && (!empty($data['price']) || !empty($data['stock_price']))) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "suppler2_amount_to_source WHERE product_id = '" . (int)$data['product_id'] . "' AND  suppler_id = '" . (int)$data['suppler_id'] . "'");

            $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_amount_to_source` ( `suppler_id`, `product_id`, `quantity`, `price`, `stock_price`, `source`, `datetime`) VALUES  ('" . $this->db->escape($data['suppler_id']) . "', '" . $this->db->escape($data['product_id']) . "', '" . $this->db->escape($data['quantity']) . "', '" . $this->db->escape($data['price']) . "', '" . $this->db->escape($data['stock_price']) . "', '" . $this->db->escape($data['source']) . "', " . time() . ")");
        }

        if (!empty($data['suppler_desc']) && !empty($data['product_id']) && (!empty($data['price']) || !empty($data['stock_price']))) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "suppler2_amount_to_source WHERE product_id = '" . (int)$data['product_id'] . "' AND  suppler_desc = '" . $data['suppler_desc'] . "'");

            $this->db->query("INSERT INTO `" . DB_PREFIX . "suppler2_amount_to_source` ( `suppler_desc`, `product_id`, `quantity`, `price`, `price_desc`, `stock_price`, `source`, `datetime`) VALUES  ('" . $this->db->escape($data['suppler_desc']) . "', '" . $this->db->escape($data['product_id']) . "', '" . $this->db->escape($data['quantity']) . "', '" . $this->db->escape($data['price']) . "', '" . $this->db->escape($data['price_desc']) . "', '" . $this->db->escape($data['stock_price']) . "', '" . $this->db->escape($data['source']) . "', " . time() . ")");
        }

        $this->updatePrices($data['product_id']);
    }

    public function updatePrices($product_id = null)
    {
        $prices = $this->getProductPrices($product_id);

        if (!empty($prices)) {
//            $final_price = 10000000000;
            $total_quantity = 0;
            // мінімальна ціна і кількість сумується
//            $from_1c = 0;
//            foreach ($prices as $price_row) {
//                if (!empty($price_row['price']) && (int)$price_row['price'] < (int)$final_price) {
//                    $final_price = $price_row['price'];
//                }
//                if ($price_row['source'] == 'xml' || empty($from_1c)) {
//                    $total_quantity += (int)$price_row['quantity'];
//                    if ($price_row['source'] != 'xml') {
//                        $from_1c++;
//                    }
//                }
//            }

            $store_price_found = false;
            $store_price = 0;
            $store_stock_price = 0;

            $xml_price_found = false;
            $xml_price = 0;
            $xml_stock_price = 0;

            $ones_price_found = false;
            $ones_price = 0;
            $ones_stock_price = 0;

            $from_1c = 0;
            foreach ($prices as $price_row) {
                if ($price_row['source'] === '1c' && trim($price_row['suppler_desc']) === 'Склад магазина') {
                    if (!empty($price_row['price'])) {
                        $store_price_found = true;
                        $store_price = $price_row['price'];
                    }
                    if (!empty($price_row['stock_price'])) {
                        $store_stock_price = $price_row['stock_price'];
                    }
                }

                if ($price_row['source'] === 'xml') {
                    if (!empty($price_row['price'])) {
                        $xml_price_found = true;
                        $xml_price = $price_row['price'];
                    }
                    if (!empty($price_row['stock_price'])) {
                        $xml_stock_price = $price_row['stock_price'];
                    }
                }

                if ($price_row['source'] === '1c' && trim($price_row['suppler_desc']) === 'Склад поставщика') {
                    if (!empty($price_row['price'])) {
                        $ones_price_found = true;
                        $ones_price = $price_row['price'];
                    }
                    if (!empty($price_row['stock_price'])) {
                        $ones_stock_price = $price_row['stock_price'];
                    }
                }

                if ($price_row['source'] == 'xml' || empty($from_1c)) {
                    $total_quantity += (int)$price_row['quantity'];
                    if ($price_row['source'] != 'xml') {
                        $from_1c++;
                    }
                }
            }

            if ($store_price_found) {
                $this->editProductField($product_id, 'price', $store_price);
                $this->editProductDiscount($product_id, $store_stock_price, $total_quantity);
            } elseif ($xml_price_found) {
                $this->editProductField($product_id, 'price', $xml_price);
                $this->editProductDiscount($product_id, $xml_stock_price, $total_quantity);
            } elseif ($ones_price_found) {
                $this->editProductField($product_id, 'price', $ones_price);
                $this->editProductDiscount($product_id, $ones_stock_price, $total_quantity);
            } else {
//                $this->editProductField($product_id, 'price', 0);
                $this->editProductDiscount($product_id);
            }

//            $this->editProductField($product_id, 'price', $final_price);
            $this->editProductField($product_id, 'quantity', $total_quantity);
//        $this->editProductField($product['product_id'], 'price_zak', $value);
        }
    }

    public function updateAllPrices()
    {
        $query = $this->db->query("SELECT `product_id` FROM " . DB_PREFIX . "suppler2_amount_to_source s2ats GROUP BY product_id");

        if (!empty($query->rows)) {
            foreach ($query->rows as $row) {
                $this->updatePrices($row['product_id']);
            }
        }
    }

    public
    function getProductPrices($product_id)
    {
        if (!empty($product_id)) {
            $query = $this->db->query("SELECT s2ats.`id`, s2.`name` as suppler_name, `suppler_desc`, `price_desc`, `product_id`, `quantity`, `price`, `stock_price`, `source`, `datetime` FROM " . DB_PREFIX . "suppler2_amount_to_source s2ats
            LEFT JOIN  " . DB_PREFIX . "suppler2 s2 ON s2.id = s2ats.suppler_id 
            WHERE `product_id` = '" . (int)$product_id . "'");

            return $query->rows;
        }
        return null;
    }
}

?>