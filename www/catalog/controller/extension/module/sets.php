<?php

class ControllerExtensionModuleSets extends Controller
{

    public $products;
    public $options;

    public function existReuqiredOption($ops)
    {
        foreach ($ops as $op) {
            if ($op['required']) {
                return true;
            }
        }

        return false;
    }
    public function setProductsAndOptions($product_ids)
    {
        $this->load->model('extension/module/kjseries_adapt');
        array_unique($product_ids);

        $this->products = $this->model_extension_module_kjseries_adapt->getProducts($product_ids);
        $this->options  = $this->model_extension_module_kjseries_adapt->getProductOptions($product_ids);

    }

    public function addSetToCart()
    {
        $this->load->language('checkout/cart');
        $this->load->model("catalog/product");
        $json=array();
        $last_success="";

        if(isset($this->request->post['products']) && is_array($this->request->post['products']))
        {
            foreach($this->request->post['products'] as $product)
            {
                $pid=$product['product_id'];
                $product_info = $this->model_catalog_product->getProduct($pid);

                if ($product_info) {

                    $quantity = $product['quantity'];

                    if (isset($product['option']) && $product['option'])
                    {
                        $opts=html_entity_decode(urldecode($product['option']));
                        parse_str($opts,$option);
                        $option=$option['sp_option'];
                    }
                    else 
                        $option = array();

                    $recurring_id = 0;
                    
                    $this->cart->add($pid, $quantity, $option, $recurring_id);

                    $json[$pid]['success'] = $last_success = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $pid), $product_info['name'], $this->url->link('checkout/cart'));
                }
            }

            $json['success'] = $last_success;
            $json['total'] = $this->getTotal();
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getTotal()
    {
        $this->load->model('setting/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;
        
                // Because __call can not keep var references so we put them into an array.             
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

                // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_setting_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get('total_' . $result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                            // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        return sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
    }

    public function loadMedia()
    {
        if (!$this->config->get('module_sets_include_media')) {
            return;
        }

        $media = explode("\n", $this->config->get('module_sets_include_media'));

        if ($media) {
            foreach ($media as $m) {
                if (strstr($m, '.css') !== false) {
                    $this->document->addStyle($m);
                } else {
                    $this->document->addScript($m);
                }

            }
        }
    }

    public function index()
    {

    }

    public function addSetToTotal()
    {

        if (!(isset($this->request->post['sp_product_id']) && isset($this->request->post['sp_iset']))) {
            return;
        }

        $product_id = $this->request->post['sp_product_id'];
        $i          = $this->request->post['sp_iset'];

        $this->load->model('catalog/product');
        $this->load->model('extension/module/sets');
        $sets = $this->model_extension_module_sets->getSets($product_id);

        if (!isset($this->session->data['sets'])) {
            $this->session->data['sets'] = array();
        }

        if(isset($sets[$i]))
            $this->session->data['sets'][] = $sets[$i];

        $json = array();
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function checkProductOption()
    {

        if (isset($this->request->post['sp_product_id'])) {
            $product_id = (int) $this->request->post['sp_product_id'];
        } else {
            $product_id = 0;
        }
        $option = array();

        if (isset($this->request->post['sp_option']) && $this->request->post['sp_option'] !== 'no') {
            $option = array_filter($this->request->post['sp_option']);
        }

        $arr = array(
            "product_id" => $product_id,
            "option"     => $option,
        );

        $this->load->controller('extension/module/kjseries_adapt/checkProductOption', $arr);

    }

    public function getMyPrOptions($id)
    {
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $my_pr_options = array();

        if (isset($this->options[$id])) {
            foreach ($this->options[$id] as $option) {
                $product_option_value_data = array();

                foreach ($option['product_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float) $option_value['price']) {
                            $cprice = $this->currency->format($option_value['price'], $this->session->data['currency'], '', false);
                            $price  = $this->currency->format($option_value['price'], $this->session->data['currency']);

                        } else {
                            $price  = 0;
                            $cprice = 0;
                        }

                        $product_option_value_data[$option_value['product_option_value_id']] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id'         => $option_value['option_value_id'],
                            'name'                    => $option_value['name'],
                            'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
                            'price'                   => $price,
                            'cprice'                  => $cprice,
                            'pprice'                  => $option_value['price'],
                            'price_prefix'            => $option_value['price_prefix'],
                        );
                    }
                }

                $my_pr_options[$option['product_option_id']] = array(
                    'product_option_value' => $product_option_value_data,
                    'option_id'            => $option['option_id'],
                    'product_option_id'    => $option['product_option_id'],
                    'name'                 => $option['name'],
                    'type'                 => $option['type'],
                    'value'                => $option['value'],
                    'required'             => $option['required'],
                );
            }
        }

        return $my_pr_options;
    }

    public function getDiscountPrice($id, $qty)
    {
        $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $id . "' AND customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int) $qty . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

        if ($product_discount_query->num_rows) {
            return $product_discount_query->row['price'];
        } else {
            return false;
        }

    }

    public function getSet($product_id)
    {

        $this->load->model('catalog/product');
        $this->load->model('extension/module/sets');

        $product_ids = array();

        $sets = $this->model_extension_module_sets->getSets($product_id);

        if ($sets) {

            foreach ($sets as $set) {
                foreach ($set['products'] as $p) {
                    $product_ids[] = $p['product_id'];
                }
            }

            $this->setProductsAndOptions($product_ids);

            $sort = array();

            foreach ($sets as $key => $row) {
                $sort[$key] = $row['sort'];
            }

            array_multisort($sort, SORT_ASC, $sets);
            $lang = (int) $this->config->get('config_language_id');
            foreach ($sets as $s_key => &$set) {
                $discount = 0;
                $total    = 0;

                $set['product_id'] = $product_id;
                $name              = json_decode($set['name'], true);
                $set['name']       = $name[$lang];

                foreach ($set['products'] as $pkey => &$product) {
                    $id = $product['product_id'];
                    //проверка на кол-во и статус
                    if (!isset($this->products[$id])) {
                        unset($sets[$s_key]);
                        continue 2;
                    }

                    $pr_info = $this->products[$id];

                    $my_pr_options           = $this->getMyPrOptions($id);
                    $product['all_options']  = $my_pr_options;
                    $product['product_name'] = $pr_info['name'];
                    $product['href']         = $this->url->link('product/product', 'product_id=' . $id);

                    if ($pr_info['image']) {

                        if (floatval(VERSION) >= 2.2) {
                            $product['thumb'] = $this->model_tool_image->resize($pr_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
                        } else {
                            $product['thumb'] = $this->model_tool_image->resize($pr_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                        }

                    } else {
                        $product['thumb'] = false;
                    }

                    $price       = $pr_info['price'];
                    $mydiscounts = array();
                    $oldprice    = false;

                    if ((float) $pr_info['special']) {
                        $oldprice = $price;
                        $price    = $pr_info['special'];
                    } else {

                        $discounts = $this->model_catalog_product->getProductDiscounts($id);

                        if ($discounts) {

                            $dprice = $this->getDiscountPrice($pr_info['product_id'], $pr_info['minimum']);
                            if ($dprice) {
                                $oldprice = $price;
                                $price    = $dprice;
                            }

                            foreach ($discounts as $dt) {
                                $mydiscounts[$dt['quantity']] = $this->currency->format($dt['price'], $this->session->data['currency'], '', false);
                            }

                            if (!isset($mydiscounts[1])) {
                                $mydiscounts[1] = $this->currency->format($price, $this->session->data['currency'], '', false);
                            }

                        }
                    }
                    $product['discounts']      = $mydiscounts;
                    $product['discounts_json'] = json_encode($mydiscounts);

                    if (isset($product['option_type'])) {

                        $product['html_options_button'] = '';
                        $product['html_options']        = '';
                        $product['inline_options']      = '';
                        if ($product['option_type'] == 'fixed' && isset($product['option_data'])) {
                            $options       = json_decode($product['option_data'], true);
                            $options_array = $this->getSelectedOptions(array('options' => $options, 'pr_options' => $my_pr_options));
                            // var_dump($options_array);

                            $data2['options']     = $options_array;
                            $data2['modal_id']    = $product_id . $s_key . $pkey;
                            $data2['modal_title'] = $product['product_name'];
                            $data2['product_thumb'] = $product['thumb'];

                            if (floatval(VERSION) >= 2.2) {

                                $data2['inline_options'] = $this->load->view('extension/module/sets_fixed_options', $data2);

                                $product['html_options_button'] = $this->load->view('extension/module/sets_fixed_options_button', $data2);
                                $product['html_options']        = $this->load->view('extension/module/sets_fixed_options_modal', $data2);
                            } else {

                                $data2['inline_options'] = $this->load->view('default/template/extension/module/sets_fixed_options.tpl', $data2);

                                $product['html_options_button'] = $this->load->view('default/template/extension/module/sets_fixed_options_button.tpl', $data2);
                                $product['html_options']        = $this->load->view('default/template/extension/module/sets_fixed_options_modal.tpl', $data2);
                            }

                            $product['inline_options'] = $data2['inline_options'];

                            $price = $this->getPriceOpts(array('options' => $options, 'pr_options' => $my_pr_options, 'price' => $price));

                        } else if ($product['option_type'] == 'popup' || $this->existReuqiredOption($my_pr_options)) {

                            $product['option_type'] = 'popup';

                            $data3['options']     = $my_pr_options;
                            $data3['modal_id']    = $product_id . $s_key . $pkey;
                            $data3['modal_title'] = $product['product_name'];
                            $data3['product_thumb'] = $product['thumb'];
                            $data3['apply_text'] = $this->language->get('apply_text');
                            $data3['text_select'] = $this->language->get('text_select');

                            if (floatval(VERSION) >= 2.2) {
                                $data3['inline_options']        = $this->load->view('extension/module/sets_popup_options', $data3);
                                $product['html_options_button'] = $this->load->view('extension/module/sets_popup_options_button', $data3);
                                $product['html_options']        = $this->load->view('extension/module/sets_popup_options_modal', $data3);
                            } else {
                                $data3['inline_options']        = $this->load->view('default/template/extension/module/sets_popup_options.tpl', $data3);
                                $product['html_options_button'] = $this->load->view('default/template/extension/module/sets_popup_options_button.tpl', $data3);
                                $product['html_options']        = $this->load->view('default/template/extension/module/sets_popup_options_modal.tpl', $data3);
                            }
                            $product['inline_options'] = $data3['inline_options'];
                        }
                    }

                    $product['old_price'] = $this->currency->format($price, $this->session->data['currency']);
                    $product['cprice']    = $this->currency->format($price, $this->session->data['currency'], '', false);

                    $product['old_price'] = $this->currency->format($price, $this->session->data['currency']);
                    $product['cprice']    = $this->currency->format($price, $this->session->data['currency'], '', false);

                    //    $calc_price = $price;
                    $discount_from               = $this->config->get('module_sets_discount_from');
                    $product['sp_oldcprice']     = $price;
                    $product['sp_discount_from'] = $discount_from;
                    if ($discount_from == 'old' && $oldprice) {
                        $price                   = $oldprice;
                        $product['sp_oldcprice'] = $oldprice;
                    }

                    if(!empty($product['discount'])) 
                    {
                        if (substr($product['discount'], -1) == "%") {
                            $pd                           = floatval(substr($product['discount'], 0, -1));
                            $d                            = ($price / 100) * $pd;
                            $td                           = $d * (int) $product['quantity'];
                            $product['discount_currency'] = $product['discount'];
                        } 
                        else 
                        {
                            $td = $product['discount'];
                            $d  = $product['discount'] / (int) $product['quantity'];

                            $product['discount']          = (float) $this->currency->format($product['discount'], $this->session->data['currency'], '', false);
                            $product['discount_currency'] = $this->currency->format($product['discount'], $this->session->data['currency'], 1);
                        }
                    }
                    else
                    {
                        $td = 0;
                        $d = 0;
                        $product['discount'] = '';
                        $product['discount_currency'] = '';
                    }

                    $price = $price - $d;
                    $discount += $td;

                    $product['price'] = $this->currency->format($price, $this->session->data['currency']);

                    $product['price'] = preg_replace('/(-?[0-9]+(\s[0-9]+)*[0-9.]*)/', '<span class="num">$1</span>', $product['price']);

                    $total += $product['cprice'] * $product['quantity'];

                }
                $set['ceconomy'] = $discount;
                $discount        = $this->currency->format($discount, $this->session->data['currency'], '', false);

                $round = $this->config->get('module_sets_rounding');

                if ($round == 'up_to_big') {
                    $discount = ceil($discount);
                } else if ($round == 'up_to_small') {
                    $discount = floor($discount);
                }
                $total -= $discount;

                $set['new_total'] = $this->currency->format($total, $this->session->data['currency'], 1);

                $set['economy'] = $this->currency->format($discount, $this->session->data['currency'], 1);

                $set['economy']   = preg_replace('/(-?[0-9]+(\s[0-9]+)*[0-9.]*)/', '<span class="num">$1</span>', $set['economy']);
                $set['new_total'] = preg_replace('/(-?[0-9]+(\s[0-9]+)*[0-9.]*)/', '<span class="num">$1</span>', $set['new_total']);
            }
        }

        return $sets;

    }

    public function getSets()
    {

        if (!$this->config->get('module_sets_status')) {
            return;
        }

        $this->load->language('extension/module/set');

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        $data['text_sets']     = $this->language->get('text_sets');
        $data['text_buy_sets'] = $this->language->get('text_buy_sets');
        $data['text_economy']  = $this->language->get('text_economy');

        $data['sets'] = $this->getSet($product_id);

        $add_to_cart = '';
        if ($data['sets']) {
            $this->document->addScript('catalog/view/javascript/sets/script.js');

            $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
            $this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
            $this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');

            $this->document->addStyle('catalog/view/javascript/sets/style.css');
            $this->loadMedia();

            $js          = html_entity_decode($this->config->get('module_sets_js_cart_add'));
            $add_to_cart = "<script>function kjsetAddSetToCartSuccess(json) { $js }</script>";
        }

        $data['decimal_place']  = $this->currency->getDecimalPlace($this->session->data['currency']);
        $data['show_qty']       = $this->config->get('module_sets_show_qty');
        $data['show_disc_prec'] = $this->config->get('module_sets_show_disc_prec');

        $data['rounding']         = $this->config->get('module_sets_rounding');
        $data['display_num_sets'] = $this->config->get('module_sets_display_num_sets');

        $data['selector'] = $this->config->get('module_sets_selector');
        $data['position'] = $this->config->get('module_sets_position');

        $data['orientation'] = $this->config->get('module_sets_orientation');

        $data['module_sets_product_link_newtab'] = $this->config->get('module_sets_product_link_newtab') ? 'target="_blank"' : '';

        if (floatval(VERSION) >= 2.2) {
            return $this->load->view('extension/module/sets', $data) . $add_to_cart;
        } else {
            return $this->load->view('default/template/extension/module/sets.tpl', $data) . $add_to_cart;
        }

    }

    public function debug($d)
    {
        echo "<pre>";
        var_dump($d);
        echo "</pre>";
        exit();
    }

    public function getSelectedOptions($arg)
    {
        $this->load->model('tool/image');
        $options    = $arg['options'];
        $pr_options = $arg['pr_options'];

        $options_array = array();
        //$this->debug($options);
        foreach ($pr_options as $id_option => $option) {

            $value = array();
            $type  = $option['type'];
            $name  = $option['name'];

            if (isset($options[$id_option])) {
                if (isset($pr_options[$id_option]) && ($pr_options[$id_option]['type'] == 'select' ||
                    $pr_options[$id_option]['type'] == 'radio' ||
                    $pr_options[$id_option]['type'] == 'image' ||
                    $pr_options[$id_option]['type'] == 'checkbox')) {
                    if ($option['type'] == 'checkbox' && is_array($options[$id_option])) {
                        foreach ($options[$id_option] as $product_option_value_id) {
                            if (isset($option['product_option_value'][$product_option_value_id])) {
                                $value[$product_option_value_id] = $option['product_option_value'][$product_option_value_id]['name'];

                            } else {
                                continue;
                            }

                        }
                    } else {
                        if ($option['type'] == 'image') {
                            if (isset($option['product_option_value'][$options[$id_option]])) {
                                $image                       = $option['product_option_value'][$options[$id_option]]['image'];
                                $value[$options[$id_option]] = $option['product_option_value'][$options[$id_option]]['name'] . " <img src='$image'>";
                            } else {
                                continue;
                            }

                        } else {
                            if (isset($option['product_option_value'][$options[$id_option]])) {
                                $value[$options[$id_option]] = $option['product_option_value'][$options[$id_option]]['name'];
                            } else {
                                continue;
                            }

                        }
                    }
                } else {
                    $value = isset($options[$id_option]) ? $options[$id_option] : '';
                }

            }

            $options_array[$id_option]['type']  = $type;
            $options_array[$id_option]['value'] = $value;
            $options_array[$id_option]['name']  = $name;
        }
        //$this->debug($options_array);

        return $options_array;
    }

    public function getPriceOpts($arg)
    {
        $options       = $arg['options'];
        $my_pr_options = $arg['pr_options'];
        $total         = $arg['price'];
        //echo "<pre>";
        //  var_dump($arg['options']);exit();
        // 218 7
        if ($options) {
            foreach ($options as $key => $option) {
                if ($my_pr_options[$key]['type'] == 'select' ||
                    $my_pr_options[$key]['type'] == 'radio' ||
                    $my_pr_options[$key]['type'] == 'image' ||
                    $my_pr_options[$key]['type'] == 'checkbox') {
                    if ($my_pr_options[$key]['type'] == 'checkbox' && is_array($option)) {
                        foreach ($option as $product_option_value_id) {
                            if (isset($my_pr_options[$key]['product_option_value'][$product_option_value_id])) {
                                $price = $my_pr_options[$key]['product_option_value'][$product_option_value_id]['pprice'];
                                $pre   = $my_pr_options[$key]['product_option_value'][$product_option_value_id]['price_prefix'];
                                $total = $this->help_opt($pre, $total, $price);
                            }
                        }

                    } else {
                        if (isset($my_pr_options[$key]['product_option_value'][$option])) {

                            $price = (float) $my_pr_options[$key]['product_option_value'][$option]['pprice'];
                            $pre   = $my_pr_options[$key]['product_option_value'][$option]['price_prefix'];
                            $total = $this->help_opt($pre, $total, $price);

                        }
                    }
                }
            }
        }

        return $total;
    }

    public function help_opt($pre, $total, $price)
    {
        if ($pre == '-') {
            $total -= $price;
        } else if ($pre == '+') {
            $total += $price;
        } else if ($pre == '=') {
            $total = $price;
        } else if ($pre == '*') {
            $total *= $price;
        } else if ($pre == '/') {
            $total /= $price;
        } else if ($pre == 'u') {
            $total = $total + (($total * $price) / 100);
        } else if ($pre == 'd') {
            $total = $total - (($total * $price) / 100);
        }

        return $total;
    }

}
