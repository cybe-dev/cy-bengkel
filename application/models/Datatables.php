<?php
class Datatables extends CI_Model {

    private $table = "products";
    private $select = "";
    private $where = array();
    private $join = array();
    private $column = array();
    private $result = array();
    private $searchField = NULL;
    private $ordering = array();
    private $group = array();

    function setTable($name) {
        $this->table = $name;
    }

    function setSelect($select) {
        $this->select = $select;
    }

    function setJoin($table,$on,$type) {
        $this->join[] = [
            "table" => $table,
            "on" => $on,
            "type" => $type,
        ];
    }

    function setGroup($group) {
        $this->group[] = $group;
    }

    function setWhere($key,$value) {
        $this->where[$key] = $value;
    }
    
    function setColumn($column = array()) {
        $this->column = $column;
    }

    function setSearchField($field) {
        $this->searchField = $field;
    }

    function setOrdering($ordering) {
        $this->ordering = $ordering;
    }

    private function process() {
        if($this->select) {
            $this->db->select($this->select);
        }

        if($this->join) {
            foreach($this->join as $join) {
                $this->db->join($join["table"],$join["on"],$join["type"]);
            }
        }


        if($_GET['search']['value']) {
            $this->db->like($this->searchField,$_GET['search']['value']);
        }

        if(isset($_GET['order'][0]['column'])) {
            $order_by = $_GET['order'][0]['column'];
            $this->db->order_by($this->ordering[$order_by],$_GET['order'][0]['dir']);
        }

        if($this->group) {
            foreach($this->group as $group) {
                $this->db->group_by($group);    
            }
        }
        
    }

    private function columnReplace($index,$string) {

        preg_match_all("/<get-([A-Za-z0-9]+)>/",$string,$get);

        $index2 = $index + $_GET['start'];

        $i = 0;

        $array = ["id" => 1];

        $string = str_replace("<index>",$index2+1,$string);

        foreach($get[1] as $row) {
            $string = str_replace($get[0][$i],$this->result[$index][$row],$string);
            $i++;
        }

        preg_match_all("/\[(.*)\=(.*)\]/",$string,$function);

        $i = 0;

        foreach($function[0] as $row) {
            $callFunc = $function[1][$i];
            $getStr = $function[2][$i];
            $tmp = $callFunc($getStr);

            $string = str_replace($row,$tmp,$string);
            $i++;
        }

        return $string;
    }

    function get_num_rows() {
        $this->process();
        if($this->where) {
            $data = $this->db->get_where($this->table,$this->where);
        } else {
            $data = $this->db->get($this->table);
        }
        return $data->num_rows();
    }

    function generate() {
        $this->process();
        if($_GET['length'] > 0) {
            $this->db->limit($_GET['length'], $_GET['start']);
        }

        if($this->where) {
            $data = $this->db->get_where($this->table,$this->where);
        } else {
            $data = $this->db->get($this->table);
        }

        
        $this->result = $data->result_array();
        
        $response['draw'] = $_GET['draw'];
        $response['recordsTotal'] = $this->get_num_rows();
        $response['recordsFiltered'] = $this->get_num_rows();
        $response['data'] = array();

        $i = 0;
        foreach($this->result as $row) {
            $tmp = array();
            foreach($this->column as $col) {
                $tmp[] = $this->columnReplace($i,$col);
            }

            $response['data'][] = $tmp;
            $i++;
        }

        echo json_encode($response);
    }
}
