<?php
class ModelExtensionModuleCyberAutosearch extends Model {
    public function ajaxLiveSearch($data=array()) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $sql = "SELECT p.product_id,p.status,p.date_available FROM " . DB_PREFIX . "product p";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }

            if (!empty($data['filter_model'])) {
                $sql .= " OR LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
            }

            if (!empty($data['filter_sku'])) {
                $sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
            }

            if (!empty($data['filter_upc'])) {
                $sql .= " OR LCASE(p.upc) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
            }

            if (!empty($data['filter_manufacturer'])) {
                $sql .= " OR p.manufacturer_id IN (SELECT manufacturer_id from ".DB_PREFIX."manufacturer WHERE `name` LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%')";
            }

            $sql .= ")";
        }

        $sql .= " GROUP BY p.product_id";
        $sql .= " ORDER BY p.sort_order";
        $sql .= " ASC, LCASE(pd.name) ASC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 10;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        $product_data = array();

        $query = $this->db->query($sql);
        $this->load->model('catalog/product');
        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
        }

        return $product_data;
    }
}