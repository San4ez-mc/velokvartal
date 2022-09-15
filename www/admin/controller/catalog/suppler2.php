<?php

class ControllerCatalogSuppler2 extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->model('catalog/suppler2');
        $this->model_catalog_suppler2->createTables();
        $this->load->language('catalog/suppler2');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/suppler2');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('catalog/suppler2');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/suppler2');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {


            $this->model_catalog_suppler2->addSuppler($this->request->post, 0);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function upload()
    {
        $this->load->language('catalog/suppler2');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/suppler2');
        $data = [];

        $data['supplers'] = array();

        $results = $this->model_catalog_suppler2->getSupplers();

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('edit'),
                'href' => $this->url->link('catalog/suppler2/update', 'user_token=' . $this->session->data['user_token'] . '&form_id=' . $result['form_id'] . $url, true),
                'load' => $this->url->link('catalog/suppler2/load', 'user_token=' . $this->session->data['user_token'] . '&form_id=' . $result['form_id'] . $url, true)
            );

            $data['supplers'][] = array(
                'suppler_id' => $result['id'],
                'selected' => $result['status'] == 1,
                'name' => $result['name'],
                'link' => $result['link'],
                'description' => $result['description'],
                'status' => $result['status'],
                'sort_order' => $result['sort_order'],
                'action' => $action
            );
        }

        $this->document->addScript('view/javascript/suppler2/suppler2.js', 'header');
        $this->document->addStyle('view/stylesheet/suppler2/suppler2.css');

        $data['token'] = $this->request->get['user_token'];
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/upload', $data));
    }

//    public function insert()
//    {
//        $this->load->language('catalog/suppler2');
//
//        $this->document->setTitle($this->language->get('heading_title'));
//
//        $this->load->model('catalog/suppler2');
//
//        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
//            $this->model_catalog_suppler2->addSuppler($this->request->post, 0);
//
//            $this->session->data['success'] = $this->language->get('text_success');
//
//            $url = '';
//
//            if (isset($this->request->get['filter_name'])) {
//                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
//            }
//
//            if (isset($this->request->get['order'])) {
//                $url .= '&order=' . $this->request->get['order'];
//            }
//
//            if (isset($this->request->get['page'])) {
//                $url .= '&page=' . $this->request->get['page'];
//            }
//
//            $this->response->redirect($this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . $url, true));
//        }
//
//        $this->getForm();
//    }

    public function update()
    {
        $this->load->language('catalog/suppler2');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/suppler2');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_suppler2->editSuppler($this->request->get['id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('catalog/suppler2');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/suppler2');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $form_id) {
                $this->model_catalog_suppler2->deleteSuppler($form_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    private function getList()
    {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        $this->request->get['page'] = 1;

//        if (isset($this->request->get['page'])) {
//            $page = $this->request->get['page'];
//        } else {
//            $page = 1;
//        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
//        $this->load->model('catalog/suppler2');
//        $results = $this->model_catalog_suppler2->createTables();

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . $url, true),
            'separator' => ' :: '
        );

        $data['cstart'] = $this->url->link('catalog/suppler2/cstart', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['ccontinue'] = $this->url->link('catalog/suppler2/ccontinue', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['cstop'] = $this->url->link('catalog/suppler2/cstop', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['insert'] = $this->url->link('catalog/suppler2/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('catalog/suppler2/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['supplers'] = array();
//        $this->load->model('catalog/suppler2');

        $suppler_total = $this->model_catalog_suppler2->getTotalSupplers();

        $results = $this->model_catalog_suppler2->getSupplers($order);

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('edit'),
                'href' => $this->url->link('catalog/suppler2/update', 'user_token=' . $this->session->data['user_token'] . '&id=' . $result['id'] . $url, true),
                'load' => $this->url->link('catalog/suppler2/load', 'user_token=' . $this->session->data['user_token'] . '&id=' . $result['id'] . $url, true)
            );

            $data['supplers'][] = array(
                'suppler_id' => $result['id'],
                'name' => $result['name'],
                'link' => $result['link'],
                'description' => $result['description'],
                'status' => $result['status'] == 1 ? $this->language->get('text_on') : $this->language->get('text_off'),
                'sort_order' => $result['sort_order'],
                'sku_set' => !empty($this->model_catalog_suppler2->getSupplerDataSKU($result['id'])),
                'action' => $action
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_name'] = $this->language->get('column_name');
        $data['user_token'] = $this->session->data['user_token'];
        $data['text_confirm'] = $this->language->get('text_confirm');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
        $data['sort_sort_order'] = $this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $suppler_total;
        $pagination->page = 1;
        $pagination->limit = 100;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('catalog/suppler2', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = '';

        $data['sort'] = $sort;
        $data['order'] = $order;

        $this->template = 'catalog/suppler_list.twig';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->document->addStyle('view/stylesheet/suppler2/suppler2.css');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/suppler2_list', $data));
    }

    private function getForm()
    {
        $data = [];

        if (!empty($_GET['id'])) {
            $this->load->model('catalog/suppler2');
            $data['suppler'] = $this->model_catalog_suppler2->getSuppler($_GET['id']);
        }
        $this->document->addStyle('view/stylesheet/suppler2/suppler2.css');
        $this->document->addStyle('view/stylesheet/suppler2/bootstrap-alerts.css');

        $this->document->addScript('view/javascript/suppler2/suppler2.js', 'header');
        $this->document->addScript('view/javascript/suppler2/jstree.js', 'header');

        $data['token'] = $this->request->get['user_token'];
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/suppler_short_form', $data));
    }

    public function check_xml_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        if (!empty($_POST['link'])) {
            $link = $_POST['link'];

            $this->load->model('catalog/suppler2');
            $observe_result = $this->model_catalog_suppler2->observe_xml($link, !empty($_POST['id']) ? $_POST['id'] : null, !empty($_POST['route']) ? $_POST['route'] : null);

            if ($observe_result['status'] == 'ok') {
                $routes = $observe_result['routes'];
                echo json_encode([
                        'status' => 'ok',
                        'routes' => $routes,
                        'message' => 'В древе ниже виберите каталог в котором по вашему мнению нужно искать товары для выгрузки',
                        'html' => $this->load->view('catalog/suppler2/xml_table_check', [])
                    ]
                );
//                }
            } else {
                echo json_encode($observe_result);
            }

        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public function get_xml_vars_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        if (!empty($_POST['link']) && !empty($_POST['route'])) {
            $link = $_POST['link'];

            $this->load->model('catalog/suppler2');
            $xml_vars = $this->model_catalog_suppler2->get_xml_vars_from_url($link, $_POST['route']);

            if ($xml_vars['status'] == 'ok') {
                if (!empty($xml_vars['rows'])) {
                    $rows = $xml_vars['rows'];

                    // провірка чи товари одразу доступні чи як ключ - значення
                    if (!empty($rows) && !empty($_POST['id'])) {
                        // Отримуємо попередні налаштування
                        $id = $_POST['id'];

                        $suppler_data = $this->model_catalog_suppler2->getSupplerData($id);
                        foreach ($rows as &$row) {
                            foreach ($suppler_data as $saved_item) {
                                if ($row['key'] == $saved_item['key']) {
                                    $row['site_key'] = $saved_item['site_key'];
                                    $row['status'] = $saved_item['status'];
                                }
                            }
                        }
                    }

                    $data['rows'] = $rows;
                    $this->load->language('catalog/suppler2');

                    echo json_encode([
                            'status' => 'ok',
                            'rows' => $rows,
                            'html' => $this->load->view('catalog/suppler2/xml_table_check', $data)
                        ]
                    );
                }
            } else {
                echo json_encode($xml_vars);
            }

//            $this->response->setOutput();
        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public function start_xml_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        if (!empty($_POST['id'])) {

            $this->load->model('catalog/suppler2');

            $logs = $this->model_catalog_suppler2->parse_xml($_POST['id']);
            echo json_encode([
                    'status' => 'ok',
                    'logs' => $logs
                ]
            );

//            $this->response->setOutput();
        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public function save_xml_route_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        if (!empty($_POST['id']) && !empty($_POST['route'])) {

            $this->load->model('catalog/suppler2');

            $suppler = $this->model_catalog_suppler2->getSuppler($_POST['id']);
            $suppler['route'] = $_POST['route'];
            $this->model_catalog_suppler2->editSuppler($_POST['id'], $suppler);
            echo json_encode([
                    'status' => 'ok',
                ]
            );

//            $this->response->setOutput();
        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public function log()
    {
        $this->load->model('catalog/suppler2');
        $this->model_catalog_suppler2->createTables();
        $this->load->language('catalog/suppler2');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/suppler2');

        $data['logs'] = $this->model_catalog_suppler2->getLogs($_POST['id']);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/log_list', $data));
    }


//    public function parse_xml($id)
//    {
//        $log = [];
//        $token = !empty($this->request->get['user_token']) ? $this->request->get['user_token'] : '';
//        $this->load->model('catalog/suppler2');
////        $this->load->model('catalog/product');
//        $suppler = $this->model_catalog_suppler2->getSuppler($id);
//        if ($suppler) {
//            $log[] = [
//                'type' => 'info',
//                'message' => 'Начинается работа с поставщиком "' . $suppler['name'] . '"'
//            ];
//            $suppler_data = $this->model_catalog_suppler2->getSupplerData($id);
//            $sku_data = $this->model_catalog_suppler2->getSupplerDataSKU($id);
//            $xml = file_get_contents($suppler['link']);
//            $xml = simplexml_load_string($xml);
//
//            if (!empty($xml)) {
//                $log[] = [
//                    'type' => 'success',
//                    'message' => 'XML получен по указанной ссылке'
//                ];
//
//                if (!empty($suppler_data)) {
//                    $log[] = [
//                        'type' => 'success',
//                        'message' => 'Настройки поставщика найдены'
//                    ];
//
//                    if (!empty($sku_data)) {
//                        $log[] = [
//                            'type' => 'info',
//                            'message' => 'Настройка SKU найдено, начинается поиск товаров...'
//                        ];
//                        $not_found = 0;
//                        $readed = 0;
//                        foreach ($xml as $xml_product) {
//                            $readed++;
//                            if (strripos($sku_data['route'], '_') === false) {
////                                $sku = (string)$xml_product->{$sku_data['route']};
//                                $sku = 'BTRC-000';
//                                $product = $this->model_catalog_suppler2->getProductBySKU($sku);
//
//                            } else {
//                                // todo доробити, якщо будуть ключі багаторівневі
//                                $product = null;
//                                $sku = '';
//                            }
//
//                            if ($product) {
//
//                                $log[] = [
//                                    'type' => 'info',
//                                    'message' => 'Найден товар <a href="/admin/index.php?route=catalog/product/edit&user_token=' . $token . '&product_id=' . $product['product_id'] . '" >' . $product['name'] . ' (' . $product['sku'] . ') </a>'
//                                ];
//
//                                foreach ($suppler_data as $key) {
//
//                                    if (strripos($key['route'], '_') === false) {
//                                        $value = (string)$xml_product->{$key['route']};
//                                    } else {
//                                        // todo доробити, якщо будуть ключі багаторівневі
//                                        $value = '';
//                                    }
//
//                                    switch ($key['site_key']) {
//
//                                        case 'name':
//                                            $log[] = [
//                                                'type' => 'success',
//                                                'message' => 'Имя успешно заменено на ' . $value
//                                            ];
//                                            break;
//                                        case 'category':
//                                            $log[] = [
//                                                'type' => 'success',
//                                                'message' => 'Категория успешно заменена на ' . $value
//                                            ];
//                                            break;
//                                        case 'description':
//                                            $log[] = [
//                                                'type' => 'success',
//                                                'message' => 'Описание успешно заменено на: ' . $value
//                                            ];
//                                            break;
//                                        case 'price':
//                                            $log[] = [
//                                                'type' => 'success',
//                                                'message' => 'Цена успешно заменена на: ' . $value
//                                            ];
//                                            break;
//                                        case 'image':
//                                            copy($value, 'local/folder/flower.jpg');
//                                            $product['image'] = $value;
//                                            $this->model_catalog_suppler2->editProductField($product['product_id'], 'image', $value);
//                                            $log[] = [
//                                                'type' => 'success',
//                                                'message' => 'Изображение успешно заменено на: ' . $value
//                                            ];
////                                            } else {
////                                                $log[] = [
////                                                    'type' => 'warning',
////                                                    'message' => 'Не удалось заменить изображение'
////                                                ];
////                                            }
//                                            break;
//                                    }
//                                }
//                                break;
//                            } else {
//                                $not_found++;
////                                $log[] = [
////                                    'type' => 'warning',
////                                    'message' => 'Товар с SKU ' . $sku . ' не найден'
////                                ];
//                            }
//                        }
//                        $log[] = [
//                            'type' => 'info',
//                            'message' => 'Обработано строк: ' . $readed . ''
//                        ];
//                        if ($not_found > 0) {
//                            $log[] = [
//                                'type' => 'warning',
//                                'message' => 'SKU не найдено: ' . $not_found . ''
//                            ];
//                        }
//                        $log[] = [
//                            'type' => 'info',
//                            'message' => 'Чтение файла поставщика "' . $suppler['name'] . '" завершено'
//                        ];
//                    } else {
//                        $log[] = [
//                            'type' => 'danger',
//                            'message' => 'В настройках поставщика не указано поле SKU'
//                        ];
//                    }
//                } else {
//                    $log[] = [
//                        'type' => 'danger',
//                        'message' => 'Поставщик не настроен. Перейдите в список поставщиков и закончите, пожалуйста, настройку'
//                    ];
//                }
//            } else {
//                $log[] = [
//                    'type' => 'danger',
//                    'message' => 'Не удалось спарсить xml по указанной ссылке'
//                ];
//            }
//        } else {
//            $log[] = [
//                'type' => 'danger',
//                'message' => 'Поставщик не найден'
//            ];
//        }
//        return $log;
////        return [];
//    }



    private
    function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/suppler2')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private
    function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'catalog/suppler2')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}

?>