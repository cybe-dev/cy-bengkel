<?php
class Supplier_model extends CI_Model {
    function post($data) {
        $this->db->insert("suppliers",$data);
    }

    function get($id = 0) {
        if(!$id) {
            $this->db->order_by("name","ASC");
            return $this->db->get("suppliers");
        } else {
            return $this->db->get_where("suppliers",['id' => $id]);
        }
    }

    function put($id,$data) {
        $this->db->where("id",$id);
        $this->db->update("suppliers",$data);
    }

    function delete($id) {
        $this->db->delete("suppliers",["id" => $id]);
    }
}