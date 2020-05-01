<?php
class Purchase_model extends CI_Model {
    function post($data) {
        $this->db->insert("purchase",$data);
        return $this->db->insert_id();
    }

    function post_details($data) {
        $this->db->insert_batch("purchase_details",$data);
    }

    function update_stock($data) {
        $this->db->update_batch("products",$data,"id");
    }

    function get($id = 0) {
        $this->db->select("purchase.*,suppliers.name,suppliers.address,suppliers.telephone");
        $this->db->join("suppliers","suppliers.id = purchase.supplier_id","left");
        if($id) {
            return $this->db->get_where("purchase",["purchase.id" => $id]);
        } else {
            return $this->db->get("purchase");
        }
    }

    function get_details($id) {
        $this->db->select("purchase_details.*,products.name");
        $this->db->join("products","products.id = purchase_details.product_id","left");
        return $this->db->get_where("purchase_details",["purchase_id" => $id]);
    }
}