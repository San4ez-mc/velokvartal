<?php

class ControllerExtensionModuleKjseriesAdapt extends Controller
{
    public $products   = array();
    public $options    = array();
    public $attributes = array();
    public function setProductsAndOptions($all_prds)
    {
        if (!is_array($all_prds)) {
            $arr      = array();
            $arr[]    = $all_prds;
            $all_prds = $arr;
        }

        $this->load->model('extension/module/kjseries_adapt');

        $old_products   = $this->products;
        $old_options    = $this->options;
        $old_attributes = $this->attributes;

        $this->products   = $this->model_extension_module_kjseries_adapt->getProducts($all_prds);
        $this->options    = $this->model_extension_module_kjseries_adapt->getProductOptions($all_prds);
        $this->attributes = $this->model_extension_module_kjseries_adapt->getProductAttributes($all_prds);

        $this->products   = $this->products + $old_products;
        $this->options    = $this->options + $old_options;
        $this->attributes = $this->attributes + $old_attributes;

    }

    public function checkProductOption($params)
    {
        extract($params);

        $this->load->language('checkout/cart');
        $json = array();

        $array   = array();
        $array[] = $product_id;
        $this->setProductsAndOptions($array);

        $this->load->model('catalog/product');

        $product_info = $this->products[$product_id];

        if ($product_info) {

            $product_options = isset($this->options[$product_id]) ? $this->options[$product_id] : array();

            if ($product_options) {

                foreach ($product_options as $product_option) {
                    if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                        $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
                    }
                }

                if (isset($this->request->post['recurring_id'])) {
                    $recurring_id = $this->request->post['recurring_id'];
                } else {
                    $recurring_id = 0;
                }

                $recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

                if ($recurrings) {
                    $recurring_ids = array();

                    foreach ($recurrings as $recurring) {
                        $recurring_ids[] = $recurring['recurring_id'];
                    }

                    if (!in_array($recurring_id, $recurring_ids)) {
                        $json['error']['recurring'] = $this->language->get('error_recurring_required');
                    }
                }
            }
            if (!$json) {
                $json['success'] = true;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}