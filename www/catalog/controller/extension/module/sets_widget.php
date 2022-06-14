<?php

class ControllerExtensionModuleSetsWidget extends Controller
{
    public function addToHarr($arr, $key)
    {

        if ($arr) {
            foreach ($arr as $pr) {
                $sets         = $this->load->controller('extension/module/sets/getSet', $pr[$key]);
                if($sets)
                    $this->harr[] = $sets;
            }
        }
    }

    public function goHarr($one)
    {
        $all_sets = array();
        if ($one) {
            $all_sets[0] = array();
            foreach ($this->harr as $set) {
                $all_sets[0] = array_merge($set, $all_sets[0]);
            }

        } else {
            $all_sets = $this->harr;
        }

        return $all_sets;
    }
    public $harr = array();

    public function index($setting)
    {

        if (!$setting['status']) {
            return;
        }

        $this->load->language('extension/module/set');
        $this->load->model('catalog/product');

        $data['text_sets']     = $this->language->get('text_sets');
        $data['text_buy_sets'] = $this->language->get('text_buy_sets');
        $data['text_economy']  = $this->language->get('text_economy');

        if ($setting['cart']) {
            $arr = $this->cart->getProducts();
            $key = 'product_id';

            $res = $this->addToHarr($arr, $key);

        }

        if (isset($setting['product'])) {
            $arr = $setting['product'];
            $key = 'id';

            $res = $this->addToHarr($arr, $key);
        }

        $all_sets = $this->goHarr($setting['one_slider']);

        $data['sets_array'] = $all_sets;

        if (!$data['sets_array']) {
            return;
        }

        $this->document->addScript('catalog/view/javascript/sets/script.js');

        $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
        $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
        $this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');

        $this->document->addStyle('catalog/view/javascript/sets/style.css');

        $this->load->controller('extension/module/sets/loadMedia');

        $js          = html_entity_decode($this->config->get('module_sets_js_cart_add'));
        $add_to_cart = "<script>function kjsetAddSetToCartSuccess(json) { $js }</script>";

        $data['decimal_place']    = $this->currency->getDecimalPlace($this->session->data['currency']);
        $data['show_disc_prec']   = $this->config->get('module_sets_show_disc_prec');
        $data['show_qty']         = $this->config->get('module_sets_show_qty');
        $data['display_num_sets'] = $this->config->get('module_sets_display_num_sets');

        $data['orientation'] = $setting['orientation'];

        $data['module_sets_product_link_newtab'] = $this->config->get('module_sets_product_link_newtab') ? 'target="_blank"' : '';

        if (floatval(VERSION) >= 2.2) {
            return $this->load->view('extension/module/sets_widget', $data) . $add_to_cart;
        } else {
            return $this->load->view('default/template/extension/module/sets_widget.tpl', $data) . $add_to_cart;
        }

    }

}
