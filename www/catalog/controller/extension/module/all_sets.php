<?php

class ControllerExtensionModuleAllSets extends Controller
{

    public function index()
    {

        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $this->load->language('extension/module/all_sets');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_sets'),
            'href' => $this->url->link('extension/module/all_sets'),
        );

        if (isset($this->request->get['limit'])) {
            $limit = (int) $this->request->get['limit'];
        } else {
            $limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
        }

        if (!$limit) {
            $limit = 10;
        }

        $start = ($page - 1) * $limit;

        $data['text_sets']     = $this->language->get('text_sets');
        $data['text_buy_sets'] = $this->language->get('text_buy_sets');
        $data['text_economy']  = $this->language->get('text_economy');

        $sets = false;

        $cid            = $this->customer->getGroupId();
        $did            = (int) $this->config->get('config_customer_group_id');
        $logged         = (int) $this->customer->isLogged();
        $query_customer = "(`customer_group_id`='0' OR ($logged<>0 AND `customer_group_id`='$cid')
            OR ($logged=0 AND `customer_group_id`='$did'))";
        $timer = "(enddate>UNIX_TIMESTAMP(NOW()) || enddate IS NULL || enddate = '')";
        $id_not_id = "(SELECT DISTINCT(k.id) FROM `" . DB_PREFIX . "kjset_product` kp LEFT JOIN `" . DB_PREFIX . "kjset` k ON kp.set_id = k.id LEFT JOIN `" . DB_PREFIX . "product` p ON p.product_id=kp.product_id WHERE p.quantity = 0 OR p.status = 0)";

        $sql       = "SELECT DISTINCT `product_id` FROM `" . DB_PREFIX . "kjset` WHERE $query_customer AND $timer AND `status`='1'";

        $sql_total = "SELECT COUNT(DISTINCT `product_id`) as count FROM `" . DB_PREFIX . "kjset` WHERE $query_customer AND $timer  AND `status`='1'";

        if (!$this->config->get('module_sets_show_if_empty')) {
                $sql .= " AND `id` NOT IN $id_not_id";
                $sql_total .= " AND `id` NOT IN $id_not_id";
        }
        $sql.=" LIMIT $start,$limit";

        $query=$this->db->query($sql);
        $query_total=$this->db->query($sql_total);



        $total = $query_total->rows[0]['count'];

        $all_sets = array();

        if ($query->num_rows) {
            foreach ($query->rows as $s) {
                $sets = $this->load->controller('extension/module/sets/getSet', $s['product_id']);
                if ($sets) {
                    $all_sets[] = $sets;
                }

            }
        }

        $data['sets_array'] = $all_sets;

        $add_to_cart='';
        if ($data['sets_array']) {
            $this->document->addScript('catalog/view/javascript/sets/script.js');

            $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
            $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
            $this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');

            $this->document->addStyle('catalog/view/javascript/sets/style.css');
            
            $this->load->controller('extension/module/sets/loadMedia');

            $js=html_entity_decode($this->config->get('module_sets_js_cart_add'));
            $add_to_cart="<script>function kjsetAddSetToCartSuccess(json) { $js }</script>";
        }

        $pagination        = new Pagination();
        $pagination->total = $total;
        $pagination->page  = $page;
        $pagination->limit = $limit;
        $pagination->url   = $this->url->link('extension/module/all_sets', 'page={page}');

        $data['pagination'] = $pagination->render();

        $data['decimal_place']    = $this->currency->getDecimalPlace($this->session->data['currency']);
        $data['show_disc_prec']   = $this->config->get('module_sets_show_disc_prec');
        $data['show_qty']         = $this->config->get('module_sets_show_qty');
        $data['display_num_sets'] = $this->config->get('module_sets_display_num_sets');
        $data['orientation']      = $this->config->get('module_sets_orientation');

        $data['module_sets_product_link_newtab'] = $this->config->get('module_sets_product_link_newtab') ? 'target="_blank"':'';

        $data['column_left']    = $this->load->controller('common/column_left');
        $data['column_right']   = $this->load->controller('common/column_right');
        $data['content_top']    = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer']         = $this->load->controller('common/footer');
        $data['header']         = $this->load->controller('common/header');
        $data['decimal_place']  = $this->currency->getDecimalPlace($this->session->data['currency']);

        if (floatval(VERSION) >= 2.2) {
            $this->response->setOutput($this->load->view('extension/module/all_sets', $data).$add_to_cart);
        } else {
            $this->response->setOutput($this->load->view('default/template/extension/module/all_sets.tpl', $data).$add_to_cart);
        }

    }

}
