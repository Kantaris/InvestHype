<?php

class Utility_model extends CI_Model    {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function insert($table, $data){
        return $this->db->insert($table, $data);
    }
    public function update($table, $data, $cond){
        return $this->db->update($table, $data, $cond);
    }
    public function delete($table, $cond){
       return $this->db->delete($table , $cond);
    }
    public function execute($sql){
        return $this->db->query($sql);
    }

    public function get_count($table, $cond){
        $query = $this->db->get_where($table, $cond);
        return $query->num_rows();
    }
    public function get_count__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    
    public function get($table, $cond){
        $query = $this->db->get_where($table, $cond);
        return $query->row_array();
    }
    public function get__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function get_field__by_sql($sql, $field, $default=''){
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if ($row){
            return isset($row[$field]) ? $row[$field] : $default;
        }
        
        return $default;
    }
    
    public function get_list($table, $cond){
        $query = $this->db->get_where($table, $cond);
        return $query->result_array();
    }
    public function get_list__by_order($table, $cond, $order){
        foreach ($order as $row) {
            $this->db->order_by($row['name'], $row['order']);
        }
        
        $query = $this->db->get_where($table, $cond);
        return $query->result_array();
    }
    public function get_list__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_diff_time($time1, $time2){
        $result = "";
        $diff = abs(doubleval($time1)-doubleval($time2));

        if ($diff<60) {
            $result = "1m ago";
        } else {
            if ($diff<60*60) {
                $result = intval($diff/(60)) . "m";
            } else {
                if ($diff<60*60*24) {
                    $result = intval($diff/(60*60)) . "h";
                } else {
//                    if ($diff<60*60*24*8) {
//                        $result = intval($diff/(60*60*24)) . "d";
//                    } else {
                        $dd = $time1;
                        $result = intval(substr($dd, 4, 2)) . "/" . intval(substr($dd, 6, 2)) . "/" . substr($dd, 2, 2);
//                    }
                }
            }
        }
        
        return $result;        
    }
 
    
}
