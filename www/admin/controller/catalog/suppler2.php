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

        $selected_total = 0;
        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('edit'),
                'href' => $this->url->link('catalog/suppler2/update', 'user_token=' . $this->session->data['user_token'] . '&form_id=' . $result['form_id'] . $url, true),
                'load' => $this->url->link('catalog/suppler2/load', 'user_token=' . $this->session->data['user_token'] . '&form_id=' . $result['form_id'] . $url, true)
            );

            $selected = !empty($this->model_catalog_suppler2->getSupplerDataSKU($result['id']));


            $data['supplers'][] = array(
                'suppler_id' => $result['id'],
                'selected' => $selected,
                'name' => $result['name'],
                'link' => $result['link'],
                'description' => $result['description'],
                'status' => $result['status'],
                'sort_order' => $result['sort_order'],
                'action' => $action
            );

            if ($selected) {
                $selected_total++;
            }
        }

        $data['selected_all'] = $selected_total === count($results);

        $this->document->addScript('view/javascript/suppler2/suppler2.js', 'header');
        $this->document->addStyle('view/stylesheet/suppler2/suppler2.css');

        $data['token'] = $this->request->get['user_token'];
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/upload', $data));
    }

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

    public function delete_ajax()
    {
        $this->load->language('catalog/suppler2');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/suppler2');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {

            try {

                foreach ($this->request->post['selected'] as $id) {
                    $this->model_catalog_suppler2->deleteSuppler($id);
                }
                echo json_encode(['status' => 'ok', 'message' => $this->language->get('text_success')]);

            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            die();
        }
    }

    private
    function getList()
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

//        $this->request->get['page'] = 1;
//
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

        $data['insert'] = $this->url->link('catalog/suppler2/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('catalog/suppler2/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete_ajax'] = $this->url->link('catalog/suppler2/delete_ajax', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['supplers'] = array();

        $suppler_total = $this->model_catalog_suppler2->getTotalSupplers();

        $results = $this->model_catalog_suppler2->getSupplers($order);

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('edit'),
                'href' => $this->url->link('catalog/suppler2/update', 'user_token=' . $this->session->data['user_token'] . '&id=' . $result['id'] . $url, true),
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
        $this->document->addScript('view/javascript/suppler2/suppler2.js', 'header');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/suppler2_list', $data));
    }

    private
    function getForm()
    {
        $data = [];

        if (!empty($_GET['id'])) {
            $this->load->model('catalog/suppler2');
            $data['suppler'] = $this->model_catalog_suppler2->getSuppler($_GET['id']);
        }
        $this->document->addStyle('view/stylesheet/suppler2/suppler2.css');
        $this->document->addStyle('view/stylesheet/suppler2/bootstrap-alerts.css');

        $this->document->addScript('view/javascript/suppler2/suppler2.js', 'header');

        $data['token'] = $this->request->get['user_token'];
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/suppler_short_form', $data));
    }

    public
    function check_xml_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        if (!empty($_POST['link'])) {
            $link = $_POST['link'];

            $this->load->model('catalog/suppler2');
            $observe_result = $this->model_catalog_suppler2->observe_xml($link, !empty($_POST['need_authorization']), !empty($_POST['login']) ? $_POST['login'] : null, !empty($_POST['password']) ? $_POST['password'] : null);

            if ($observe_result['status'] == 'ok') {
                $routes = $observe_result['routes'];
                echo json_encode([
                        'status' => 'ok',
                        'routes' => $routes,
                        'message' => 'В древе ниже виберите каталог в котором по вашему мнению нужно искать товары для выгрузки',
//                        'html' => $this->load->view('catalog/suppler2/xml_table_check')
                    ]
                );
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

    public
    function get_xml_vars_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        if (!empty($_POST['link']) && !empty($_POST['route'])) {
            $link = $_POST['link'];

            $this->load->model('catalog/suppler2');
            $xml_vars = $this->model_catalog_suppler2->get_xml_vars_from_url(
                $link,
                $_POST['route'],
                !empty($_POST['product_number']) ? $_POST['product_number'] : 0,
                !empty($_POST['need_authorization']),
                !empty($_POST['login']) ? $_POST['login'] : null,
                !empty($_POST['password']) ? $_POST['password'] : null
            );

            $next_product_number = !empty($_POST['product_number']) ? $_POST['product_number'] + 2 : 2;
            if ($xml_vars['status'] == 'ok') {
                if (!empty($xml_vars['rows'])) {
                    $rows = $xml_vars['rows'];

                    // провірка чи товари одразу доступні чи як ключ - значення
                    if (!empty($rows) && !empty($_POST['id'])) {
                        // Отримуємо попередні налаштування
                        $id = $_POST['id'];

                        if (empty($_POST['product_number'])) {
                            $suppler = $this->model_catalog_suppler2->getSuppler($id);
                            $next_product_number = $suppler['product_number'] + 1;
                        }

                        $suppler_data = $this->model_catalog_suppler2->getSupplerData($id);
                        foreach ($rows as &$row) {
                            foreach ($suppler_data as $saved_item) {
                                if ($row['key'] == htmlspecialchars_decode($saved_item['key'])) {
                                    $row['site_key'] = $saved_item['site_key'];
                                    $row['status'] = $saved_item['status'];
                                }
                            }
                        }
                    }

                    $data['rows'] = $rows;
                    $data['product_number'] = $next_product_number;

                    $data['quantity_setting_url'] = $this->url->link('catalog/suppler2/get_quantity_settings_html_ajax', 'user_token=' . $this->session->data['user_token'], true);
                    $data['quantity_settings'] = $this->model_catalog_suppler2->getQuantitySettings($id);

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

        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public
    function start_xml_ajax()
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

        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public
    function save_xml_route_ajax()
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
        } else {
            echo json_encode([
                    'status' => 'error',
                    'error' => 'empty'
                ]
            );
        }
        die();
    }

    public
    function log()
    {
        $this->load->language('catalog/suppler2');
        $this->document->setTitle($this->language->get('logs_heading_title'));
        $this->load->model('catalog/suppler2');

        $logs = [];
        $logs_ = $this->model_catalog_suppler2->getLogs();
        if (!empty($logs_)) {
            foreach ($logs_ as $log) {
                $logs[] = [
                    'id' => $log['id'],
                    'date' => date('d.m.Y H:i:s', $log['date']),
                    'name' => $log['suppler_name'],
                    'link' => $this->url->link('catalog/suppler2/log_data', 'user_token=' . $this->session->data['user_token'] . '&id=' . $log['id'], true),
                    'status' => $log['status'] == 1 ? $this->language->get('text_successfully') : $this->language->get('text_errors')
                ];
            }
        }
        $data['logs'] = $logs;

        $data['log_info'] = sprintf($this->language->get('log_info'), 'https://' . $_SERVER['SERVER_NAME'] . "/index.php?route=suppler2/api");

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/suppler2/log_list', $data));
    }

    public
    function log_data()
    {
        $this->load->language('catalog/suppler2');
        $this->document->setTitle($this->language->get('logs_heading_title'));
        $this->load->model('catalog/suppler2');

        $log = $this->model_catalog_suppler2->getLog($_GET['id']);
        if (!empty($log)) {
            if (!empty($log['rows'])) {
                foreach ($log['rows'] as &$row) {
                    $row['message'] = htmlspecialchars_decode($row['message']);
                }
            }

            $data['log'] = [
                'id' => $log['id'],
                'date' => date('d.m.Y H:i:s', $log['date']),
                'suppler_name' => $log['suppler_name'],
                'rows' => $log['rows']
            ];

            $this->document->addScript('view/javascript/suppler2/suppler2.js', 'header');
            $this->document->addStyle('view/stylesheet/suppler2/suppler2.css');

            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view('catalog/suppler2/log_details', $data));
        } else {
            $this->error['warning'] = $this->language->get('error_not_found');
        }
    }

    public
    function product_price_table($product_id)
    {
        $this->load->language('catalog/suppler2');
        $this->document->setTitle($this->language->get('logs_heading_title'));
        $this->load->model('catalog/suppler2');

        $rows = $this->model_catalog_suppler2->getProductPrices($product_id);
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['date'] = date('d.m.Y H:i:s', $row['datetime']);
                $row['suppler_name'] = !empty($row['suppler_name']) ? $row['suppler_name'] : $row['suppler_desc'];
            }
        }
        $data['rows'] = $rows;

        return $this->load->view('catalog/suppler2/price_table', $data);
    }

    public
    function get_quantity_settings_html_ajax()
    {
        $this->response->addHeader('Content-Type: application/json');
        $this->load->language('catalog/suppler2');
        echo json_encode([
                'status' => 'ok',
                'html' => $this->load->view('catalog/suppler2/quantity_settings', [])
            ]
        );
    }

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