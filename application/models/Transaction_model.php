<?php
class Transaction_model extends CI_Model {
    function create($data) {
        $this->db->insert("transactions",$data);
        return $this->db->insert_id();
    }

    function get_items($array) {
        $this->db->where_in("id",$array);
        return $this->db->get("products");
    }

    function post_details($data) {
        $this->db->insert_batch("details",$data);
    }

    function sparepart_update($data) {
        $this->db->update_batch("products",$data,"id");
    }

    function get($id) {
        if($id) {
            return $this->db->get_where("transactions",["id" => $id]);
        } else {
            return $this->db->get("transactions");
        }
    }

    function get_details($id) {
        return $this->db->get_where("details",["transaction_id" => $id]);
    }
}