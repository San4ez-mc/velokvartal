<?php

class ModelExtensionModuleSets extends Model
{
    public function getIdsHaveSets()
    {
       $sql = "SELECT set_id,product_id FROM `" . DB_PREFIX . "kjset_product` WHERE 1";

       $query = $this->db->query($sql);

       $array=array();

       if($query->num_rows)
       {
           foreach ($query->rows as $key => $value) {
            if(!isset($array[$value['set_id']]))
                $array[$value['set_id']]=array();

            $array[$value['set_id']][]=$value['product_id'];
            
           }
       }

       return $array;
   }


   public function boolOneManuf(array $ids)
   {
        $pids=$this->db->escape(implode(",",$ids));

         $query = $this->db->query("SELECT DISTINCT manufacturer_id FROM `" . DB_PREFIX . "product` WHERE product_id in ($pids)");

         return $query->num_rows==1;
        
   }

      public function boolOneAttr(array $ids,$attr_id)
   {
        $c=count($ids);
        $pids=$this->db->escape(implode(",",$ids));
        $attr_id = (int)$attr_id;

        

        $query = $this->db->query("SELECT count(*) as c FROM `" . DB_PREFIX . "product_attribute` WHERE 
            product_id in ($pids) AND 
            attribute_id='$attr_id' AND 
            language_id = '" . (int) $this->config->get('config_language_id') . "' group by text
            ");


        return $query->num_rows == 1 && $query->row['c'] == $c;
        
   }

   
    public function getProducts($data = array())
    {
        $sql = "SELECT p.*,pd.name as name,(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int) $data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int) $data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int) $filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
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
                $sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int) $data['filter_manufacturer_id'] . "'";
        }
        if (!empty($data['filter_model'])) {
            $sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $result;
        }

        return $product_data;
    }

    public function myGetProducts($product_ids)
    {
        if (!$product_ids) {
            return false;
        }

        $product_ids = implode($product_ids, ',');
        $product_ids = rtrim($product_ids, ',');

        $sql = "SELECT * , ";
        $sql .= "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special ";
        $sql .= "FROM " . DB_PREFIX . "product p LEFT JOIN
        (SELECT * FROM " . DB_PREFIX . "product_description 
        WHERE language_id = '" . (int) $this->config->get('config_language_id') . "'
    ) pd ON p.product_id = pd.product_id ";
    $sql .= "WHERE p.product_id IN (" . $this->db->escape($product_ids) . ")";
    $query = $this->db->query($sql);

    $product_data = array();

    if ($query->num_rows) {
        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $result;
        }
    }

    return $product_data;
}

public function saveSets($product_id, $set)
{
    $name = json_encode($set['name']);
    $name = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
        return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
    }, $name);

    $name              = $this->db->escape($name);
    $status            = isset($set['status']) ? 1 : 0;
    $customer_group_id = (int) $set['customer_group_id'];
    $product_id        = (int) $product_id;
    $sort              = (int) $set['sort'];

    if(isset($set['enddate']))
        $enddate=strtotime($set['enddate']);
    else
        $enddate='';

    $this->db->query("INSERT INTO `" . DB_PREFIX . "kjset`(`name`, `status`, `sort`, `product_id`, `customer_group_id`,`enddate`) VALUES ('$name','$status','$sort','$product_id','$customer_group_id','$enddate')");
    $lastId = (int) $this->db->getLastId();

    $vals = '';
    $sort = 1;

    foreach ($set['products'] as $p) {
        $option = '';
        if (isset($p['option'])) {
            $option = json_encode($p['option']);
        }

        $required    = isset($p['required']) ? 1 : 0;
        $qty         = (int) $p['quantity'];
        $option      = $this->db->escape($option);
        $option_type = $this->db->escape($p['option_type']);
        $pid         = (int) $p['product_id'];
        $discount    = $this->db->escape($p['discount']);

        $vals .= "('$lastId','$pid','$discount','$qty','$option_type','$option','$required','$sort'),";

        $sort++;
    }

    $vals = rtrim($vals, ",");

    $this->db->query("INSERT INTO `" . DB_PREFIX . "kjset_product`(`set_id`, `product_id`, `discount`, `quantity`, `option_type`, `option_data`, `required`,`sort`) VALUES $vals");
}
public function clearSets($product_id=false)
{
    if($product_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "kjset_product` WHERE `set_id` IN (SELECT `id` FROM `" . DB_PREFIX . "kjset` WHERE `product_id`='" . (int) $product_id . "')");
        $this->db->query("DELETE FROM  `" . DB_PREFIX . "kjset` WHERE `product_id`='" . (int) $product_id . "' ");
    }
    else
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "kjset_product`");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "kjset`");
    }
}
public function removeSets($set_ids)
{
    $this->db->query("DELETE FROM `" . DB_PREFIX . "kjset_product` WHERE `set_id` IN ($set_ids)");
    $this->db->query("DELETE FROM `" . DB_PREFIX . "kjset` WHERE `id` IN ($set_ids) ");
}

public function getSets($product_id)
{
    $set_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "kjset` WHERE `product_id`='" . (int) $product_id . "'");
    if ($set_info->num_rows) {
        $sets     = array();
        $products = $this->db->query("SELECT " . DB_PREFIX . "kjset_product.* FROM `" . DB_PREFIX . "kjset` LEFT JOIN `" . DB_PREFIX . "kjset_product` ON " . DB_PREFIX . "kjset.id = " . DB_PREFIX . "kjset_product.set_id WHERE " . DB_PREFIX . "kjset.product_id='" . (int) $product_id . "'");

        foreach ($set_info->rows as $set) {
            $sets[$set['id']] = $set;
        }

        foreach ($products->rows as $product) {
            $sets[$product['set_id']]['products'][(int) $product['sort']] = $product;
        }

        foreach ($set_info->rows as $set) {
            ksort($sets[$set['id']]['products']);
        }

        return $sets;
    } else {
        return false;
    }

}

public function getTotalSets()
{
    $set_info = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "kjset`;");
    return $set_info->row['total'];
}

public function getAllSets($start, $limit)
{
    $set_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "kjset` LIMIT $start,$limit;");

    if ($set_info->num_rows) {
        $arr = array();
        foreach ($set_info->rows as $i) {
            $arr[] = $i['id'];
        }

        $ids = implode($arr, ',');

        $sets = array();

        $products = $this->db->query("SELECT kp.* FROM (SELECT * FROM `" . DB_PREFIX . "kjset` WHERE id IN ($ids))  k LEFT JOIN `" . DB_PREFIX . "kjset_product` kp ON k.id = kp.set_id WHERE k.id");

        foreach ($set_info->rows as $set) {
            $sets[$set['id']] = $set;
        }

        foreach ($products->rows as $product) {
            $sets[$product['set_id']]['products'][(int) $product['sort']] = $product;
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
