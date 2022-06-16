<?php

class ModelExtensionModuleKjseriesAdapt extends Model
{
    public function getProducts($product_ids)
    {
        if (!$product_ids) {
            return array();
        }

        $arr = array();
        foreach ($product_ids as $id) {
            $arr[] = (int) $id;
        }

        $product_ids = implode(',',$arr);

        $sql = "SELECT *,m.mname as manufacturer, ";
        $sql .= "(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int) $this->config->get('config_language_id') . "') AS stock_status, ";
        $sql .= "(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, ";
        $sql .= "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special ";
        $sql .= "FROM " . DB_PREFIX . "product p LEFT JOIN (SELECT * FROM " . DB_PREFIX . "product_description WHERE language_id = '" . (int) $this->config->get('config_language_id') . "') pd ON p.product_id = pd.product_id ";
        $sql .= "LEFT JOIN (SELECT manufacturer_id,name as mname FROM " . DB_PREFIX . "manufacturer) m ON p.manufacturer_id = m.manufacturer_id ";

        $sql .= "WHERE p.product_id IN (" . $this->db->escape($product_ids) . ")";
        $query = $this->db->query($sql);

        $product_data = array();
        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $result;
        }

        return $product_data;
    }

    public function getProductOptions($product_ids)
    {
        if (!$product_ids) {
            return array();
        }

        $arr = array();
        foreach ($product_ids as $id) {
            $arr[] = (int) $id;
        }

        $product_ids = implode($arr, ',');

        $sql     = "SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id IN (" . $this->db->escape($product_ids) . ") AND od.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY po.product_id, o.sort_order";
        $query   = $this->db->query($sql);
        $options = $query->rows;

        $sql            = "SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id IN (" . $this->db->escape($product_ids) . ") AND ovd.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY pov.product_id, pov.product_option_id, ov.sort_order";
        $query          = $this->db->query($sql);
        $options_values = $query->rows;

        $options_data = array();

        foreach ($options as $result) {
            $options_data[$result['product_id']][$result['product_option_id']] = array(
                'product_option_id'    => $result['product_option_id'],
                'product_option_value' => array(),
                'option_id'            => $result['option_id'],
                'name'                 => $result['name'],
                'type'                 => $result['type'],
                'value'                => $result['value'],
                'required'             => $result['required'],
            );
        }

        foreach ($options_values as $result) {
            if(isset($options_data[$result['product_id']][$result['product_option_id']]))
            $options_data[$result['product_id']][$result['product_option_id']]['product_option_value'][$result['product_option_value_id']] = array(
                'product_option_value_id' => $result['product_option_value_id'],
                'option_value_id'         => $result['option_value_id'],
                'name'                    => $result['name'],
                'image'                   => $result['image'],
                'quantity'                => $result['quantity'],
                'subtract'                => $result['subtract'],
                'price'                   => $result['price'],
                'price_prefix'            => $result['price_prefix'],
                'weight'                  => $result['weight'],
                'weight_prefix'           => $result['weight_prefix'],
            );
        }
        return $options_data;
    }

    public function getProductAttributes($product_ids)
    {
        if (!$product_ids) {
            return array();
        }

        $arr = array();
        foreach ($product_ids as $id) {
            $arr[] = (int) $id;
        }

        $product_ids = implode($arr, ',');

        $sql   = "SELECT pa.product_id, ag.attribute_group_id, a.attribute_id, agd.name AS group_name , ad.name AS attribute_name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id IN (" . $this->db->escape($product_ids) . ") AND agd.language_id = '" . (int) $this->config->get('config_language_id') . "'AND ad.language_id = '" . (int) $this->config->get('config_language_id') . "'AND pa.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY ag.sort_order, agd.name, ad.name";
        $query = $this->db->query($sql);

        $attribute_data = array();
        foreach ($query->rows as $result) {
            $attribute_data[$result['product_id']][$result['attribute_group_id']]['attribute_group_id']                 = $result['attribute_group_id'];
            $attribute_data[$result['product_id']][$result['attribute_group_id']]['name']                               = $result['group_name'];
            $attribute_data[$result['product_id']][$result['attribute_group_id']]['attribute'][$result['attribute_id']] = array(
                'attribute_id' => $result['attribute_id'],
                'name'         => $result['attribute_name'],
                'text'         => $result['text'],
            );
        }

        return $attribute_data;
    }

}
