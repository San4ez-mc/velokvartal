<?php

class ModelExtensionModuleSets extends Model
{

    public function getSets($product_id)
    {
        $cid            = $this->customer->getGroupId();
        $did            = (int) $this->config->get('config_customer_group_id');
        $logged         = (int) $this->customer->isLogged();
        $query_customer = "(`customer_group_id`='0' OR ($logged<>0 AND `customer_group_id`='$cid')
            OR ($logged=0 AND `customer_group_id`='$did'))";

        $id_not_id = "(SELECT DISTINCT(k.id) FROM `" . DB_PREFIX . "kjset_product` kp LEFT JOIN `" . DB_PREFIX . "kjset` k ON kp.set_id = k.id LEFT JOIN `" . DB_PREFIX . "product` p ON p.product_id=kp.product_id WHERE p.quantity = 0 OR p.status = 0)";

        if ($this->config->get('module_sets_links')) {

            $query = "SELECT DISTINCT(k.id) as id,k.* FROM `" . DB_PREFIX . "kjset` k LEFT JOIN `" . DB_PREFIX . "kjset_product` kp ON k.id = kp.set_id WHERE kp.product_id='" . (int) $product_id . "' AND k.status='1' AND (k.enddate>UNIX_TIMESTAMP(NOW()) || k.enddate IS NULL || k.enddate = '') AND";
            $query .= $query_customer;

            if (!$this->config->get('module_sets_show_if_empty')) {
                $query .= " AND k.id NOT IN $id_not_id";
            }

        } else {
            $query = "SELECT * FROM `" . DB_PREFIX . "kjset`  WHERE `product_id`='" . (int) $product_id . "' AND `status`='1' AND (enddate>UNIX_TIMESTAMP(NOW()) || enddate IS NULL || enddate = '') AND ";
            $query .= $query_customer;

            if (!$this->config->get('module_sets_show_if_empty')) {
                $query .= " AND `id` NOT IN $id_not_id";
            }
        }

        $set_info = $this->db->query($query);

        if ($set_info->num_rows) {
            $sets = array();
            if ($this->config->get('module_sets_links')) {
                $set_ids = array();
                foreach ($set_info->rows as $row) {
                    $set_ids[] = $row['id'];
                }

                $products = $this->db->query("SELECT * FROM `" . DB_PREFIX . "kjset_product`  WHERE " . DB_PREFIX . "kjset_product.set_id IN(" . implode($set_ids, ',') . ");");
            } else {
                $products = $this->db->query("SELECT " . DB_PREFIX . "kjset_product.* FROM `" . DB_PREFIX . "kjset` LEFT JOIN `" . DB_PREFIX . "kjset_product` ON " . DB_PREFIX . "kjset.id = " . DB_PREFIX . "kjset_product.set_id WHERE " . DB_PREFIX . "kjset.product_id='" . (int) $product_id . "'");
            }

            foreach ($set_info->rows as $set) {
                $sets[$set['id']] = $set;
            }

            foreach ($products->rows as $product) {
                if (isset($sets[$product['set_id']])) {
                    $sets[$product['set_id']]['products'][(int) $product['sort']] = $product;
                }

            }

            foreach ($set_info->rows as $set) {
                ksort($sets[$set['id']]['products']);
            }

            return $sets;
        } else {
            return false;
        }

    }

    public function getSetsAll()
    {
        $c = count($this->cart->getProducts());
        if ($c == 0) {
            return false;
        }

        $psql = "
        SELECT a.set_id,count,need_count FROM
        (
            SELECT set_id,COUNT(*) as count
            FROM `" . DB_PREFIX . "kjset_product`
            WHERE (
            ";

        $i = 0;
        foreach ($this->cart->getProducts() as $key => $p) {

            $pid = $p['product_id'];
            $qty = $p['quantity'];
            $psql .= "(`product_id`='$pid' AND `quantity`<='$qty' AND `required`='1')";
            if ($i !== $c - 1) {
                $psql .= ' OR ';
            }

            $i++;
        }

        $psql .= ")
            GROUP by set_id
        ) a
        LEFT JOIN
        (
            SELECT set_id,COUNT(*) as need_count
            FROM `" . DB_PREFIX . "kjset_product`
            WHERE `required`='1'
            GROUP by set_id
        ) b
        ON a.set_id = b.set_id
        WHERE count=need_count";

        $set_ids = $this->db->query($psql);

        if (!$set_ids->num_rows) {
            return false;
        }

        $set_ids_row = '';
        foreach ($set_ids->rows as $row) {
            $set_ids_row .= $row['set_id'] . ',';
        }

        $set_ids_row = rtrim($set_ids_row, ',');

        $cid            = $this->customer->getGroupId();
        $did            = (int) $this->config->get('config_customer_group_id');
        $logged         = (int) $this->customer->isLogged();
        $query_customer = "(`customer_group_id`='0' OR ($logged<>0 AND `customer_group_id`='$cid')
            OR ($logged=0 AND `customer_group_id`='$did'))";

        $query = "SELECT * FROM `" . DB_PREFIX . "kjset`  WHERE `status`='1' AND `id` IN ($set_ids_row) AND (enddate>UNIX_TIMESTAMP(NOW()) || enddate IS NULL || enddate = '') AND ";

        $query .= $query_customer;

        $set_info = $this->db->query($query);

        if ($set_info->num_rows) {
            $sets = array();

            $products = $this->db->query("SELECT " . DB_PREFIX . "kjset_product.* FROM `" . DB_PREFIX . "kjset` LEFT JOIN `" . DB_PREFIX . "kjset_product` ON " . DB_PREFIX . "kjset.id = " . DB_PREFIX . "kjset_product.set_id ");

            foreach ($set_info->rows as $set) {
                $sets[$set['id']] = $set;
            }

            foreach ($products->rows as $product) {
                if (isset($sets[$product['set_id']])) {
                    $sets[$product['set_id']]['products'][(int) $product['sort']] = $product;
                }

            }

            foreach ($set_info->rows as $set) {
                ksort($sets[$set['id']]['products']);
            }

            return $sets;
        } else {
            return false;
        }

    }

}
