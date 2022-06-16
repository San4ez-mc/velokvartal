<?php

class ModelExtensionTotalSet extends Model
{

    public function getTotal($total)
    {

        $this->load->language('extension/total/set');

        $discount = $this->calc();

        if (!$discount) {
            return false;
        }

        $total['totals'][] = array(
            'code'       => 'set',
            'title'      => sprintf($this->language->get('text_set')),
            'value'      => -$discount,
            'sort_order' => $this->config->get('total_set_sort_order'),
        );

        $total['total'] -= $discount;

    }

    public function calc()
    {
        $sets=array();
        $cps = array();
        $this->load->model('catalog/product');
        $this->load->model('extension/module/sets');
        $this->load->model('extension/module/kjseries_adapt');

        $product_ids = array();
        foreach ($this->cart->getProducts() as $key => $p) {
            $product_ids[] = $p['product_id'];
        }
        array_unique($product_ids);

        $products = $this->model_extension_module_kjseries_adapt->getProducts($product_ids);

        foreach ($this->cart->getProducts() as $key => $p) {
            if (!isset($products[$p['product_id']])) {
                continue;
            }

            $product_info       = $products[$p['product_id']];
            $cps[$key]['id']    = $p['product_id'];
            $cps[$key]['q']     = (int) $p['quantity'];
            $cps[$key]['price'] = ($this->config->get('module_sets_discount_from') == 'old' && $p['oldprice']) ? $p['oldprice'] : $p['price'];

            if ($p['option']) {
                foreach ($p['option'] as $opt) {
                    $cps[$key]['option'][$opt['product_option_id']][] = (!empty($opt['product_option_value_id']) ? $opt['product_option_value_id'] : $opt['value']);
                }

            }
        }

        $cps  = array_reverse($cps);
        
        foreach ($this->cart->getProducts() as $key => $p) 
        {
            $x=$this->model_extension_module_sets->getSets($p['product_id']);
            if($x)
                $sets = array_merge($sets,$x);
        }

        $current_disc   = 0;
        $max_total_disc = array();

        if ($sets) {

            foreach ($sets as $sk => $set) {

                $current_disc = 0;
                $ccps         = $cps;

                while ($this->check_quantity_prods($cps)) {
                    $cs       = array();
                    $required = array();

                    if (isset($set['products']) && $set['products']) {
                        foreach ($set['products'] as $k => $p) {

                            if ($p['required']) {
                                $required[] = $k;
                            }

                            $cs[$k] = array();

                            foreach ($ccps as $key => $cp) {

                                if ($p['product_id'] == $cp['id'] && $cp['q'] >= $p['quantity']) {
                                    if (isset($p['option_type']) && $p['option_type'] == 'fixed') {

                                        $p['option'] = json_decode($p['option_data']);

                                        if (isset($cp['option']) && $this->check_opt($p['option'], $cp['option'])) {

                                            $n            = 1;
                                            $cs[$k][$key] = $n;

                                            $ccps[$key]['q'] -= $n * $p['quantity'];
                                            continue 2;
                                        } else {

                                        }
                                    } else {

                                        $n            = 1;
                                        $cs[$k][$key] = $n;

                                        $ccps[$key]['q'] -= $n * $p['quantity'];
                                        continue 2;
                                    }
                                }
                            }
                        }

                    }

                    if ($this->empty_recursive($cs)) {
                        break;
                    }

                    if ($required) {
                        foreach ($required as $rid) {
                            if (!isset($cs[$rid]) || count($cs[$rid]) == 0) {
                                break 2;
                            }
                        }
                    }

                    $total = 0;

                    $arrmin = array();
                    
                    foreach ($cs as $c) {
                        if ($c) {
                            $arrmin[] = array_sum($c);
                        }

                    }

                    $minc = min($arrmin);

                    foreach ($cs as $key1 => $val1) {
                        foreach ($val1 as $key2 => $val2) {

                            // $cps[$key2]['q'] -= $val2 * $set['products'][$key1]['quantity'];
                            $ctotal = $cps[$key2]['price'] * ($val2 * $set['products'][$key1]['quantity']);
                            $total += $ctotal;

                            if(!empty($set['products'][$key1]['discount'])) 
                            {
                                if (substr($set['products'][$key1]['discount'], -1) == "%") {
                                    $pd = floatval(substr($set['products'][$key1]['discount'], 0, -1));
                                    $current_disc += ($ctotal / 100) * $pd;
                                } else {
                                    $current_disc += $set['products'][$key1]['discount'];

                                }
                            }

                        }
                    }

                }
                $max_total_disc["$sk "] = $current_disc;
            }

            $price = array();
            foreach ($max_total_disc as $key => $row) {
                $price[$key] = $row;
            }

            array_multisort($price, SORT_DESC, $max_total_disc);

            $ccps         = $cps;
            $current_disc = 0;

            foreach ($max_total_disc as $key => $val) {

                $ccps = $cps;
                $set  = $sets[(int) $key];

                while (true) {
                    $cs       = array();
                    $required = array();

                    if (isset($set['products']) && $set['products']) {
                        foreach ($set['products'] as $k => $p) {

                            if ($p['required']) {
                                $required[] = $k;
                            }

                            $cs[$k] = array();

                            foreach ($ccps as $key => $cp) {

                                if ($p['product_id'] == $cp['id'] && $cp['q'] >= $p['quantity']) {
                                    if (isset($p['option_type']) && $p['option_type'] == 'fixed') {

                                        $p['option'] = json_decode($p['option_data']);
                                        
                                        if (isset($cp['option']) && $this->check_opt($p['option'], $cp['option'])) {

                                            $n            = 1;
                                            $cs[$k][$key] = $n;

                                            $ccps[$key]['q'] -= $n * $p['quantity'];
                                            continue 2;
                                        } else {

                                        }
                                    } else {

                                        $n            = 1;
                                        $cs[$k][$key] = $n;

                                        $ccps[$key]['q'] -= $n * $p['quantity'];
                                        continue 2;
                                    }
                                }
                            }
                        }

                    }

                    if ($this->empty_recursive($cs)) {
                        break;
                    }

                    if ($required) {
                        foreach ($required as $rid) {
                            if (!isset($cs[$rid]) || count($cs[$rid]) == 0) {
                                break 2;
                            }
                        }
                    }

                    $total = 0;

                    foreach ($cs as $c) {
                        if ($c) {
                            $arrmin[] = array_sum($c);
                        }

                    }

                    $minc = min($arrmin);

                    foreach ($cs as $key1 => $val1) {
                        foreach ($val1 as $key2 => $val2) {

                            $cps[$key2]['q'] -= $val2 * $set['products'][$key1]['quantity'];
                            $ctotal = $cps[$key2]['price'] * ($val2 * $set['products'][$key1]['quantity']);
                            $total += $ctotal;
                            
                            if(!empty($set['products'][$key1]['discount'])) 
                            {
                                if (substr($set['products'][$key1]['discount'], -1) == "%") {
                                    $pd = floatval(substr($set['products'][$key1]['discount'], 0, -1));
                                    $current_disc += ($ctotal / 100) * $pd;
                                } else {
                                    $current_disc += $set['products'][$key1]['discount'];

                                }
                            }

                        }
                    }

                }

            }

        }

        if ($current_disc) {
            $round                 = $this->config->get('sets_rounding');
            $current_disc_currency = $old_total_disc_currency = $this->currency->format($current_disc, $this->session->data['currency'], '', false);

            if ($round == 'up_to_big') {
                $current_disc_currency = ceil($old_total_disc_currency);
            } else if ($round == 'up_to_small') {
                $current_disc_currency = floor($old_total_disc_currency);
            }

            $current_disc *= $current_disc_currency / $old_total_disc_currency;

            return $current_disc;
        } else {
            return 0;
        }

    }

    public function empty_recursive($value)
    {
        if (is_array($value)) {
            $empty = true;
            array_walk_recursive($value, function ($item) use (&$empty) {
                $empty = $empty && empty($item);
            });
        } else {
            $empty = empty($value);
        }
        return $empty;
    }

    public function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    public function check_opt($need_opt, $c_opt)
    {

        foreach ($need_opt as $id => $val) {
            if (isset($c_opt[$id]) && (array_search($val, $c_opt[$id]) !== false || (is_array($val) && $val == $c_opt[$id]))) {
                continue;
            }

            return false;
        }

        return true;
    }
    public function check_quantity_prods($cps)
    {
        foreach ($cps as $p) {
            if ($p['q'] > 0) {
                return true;
            }

        }
        return false;
    }

}
