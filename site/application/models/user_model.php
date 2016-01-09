<?php

/**
 * User model.
 * 
 * @author CJH
 */

class User_model extends CI_Model    {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get user data by email or password.
     * 
     * @param string $email
     * @param string $password
     * @return array 
     */
    public function get($email, $password=''){
        $cond = null;
        if ($password==''){
            $cond = array('email'=>$email);
        }else{
            $cond = array('email'=>$email, 'password'=>$password);
        }
        
        $query = $this->db->get_where("ih_user", $cond);
        return $query->row_array();
    }
    
    /**
     * Insert user data.
     * 
     * @param array $data
     * @return boolean
     */
    public function insert_user($data){
        return $this->db->insert('ih_user', $data);
    }

    /**
     * Update user.
     * 
     * @param long $id
     * @param array $data
     * @return boolean
     */
    public function update_user($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('ih_user', $data);
    }
    
    /**
     * Update user by email.
     * 
     * @param string $email
     * @param array $data
     * @return boolean
     */
    public function update_user__by_email($email, $data){
        $this->db->where('email', $email);
        return $this->db->update('ih_user', $data);
    }
    
    /**
     * Delete user by email.
     * 
     * @param string $email
     * @return boolean
     */
    public function delete_user__by_email($email){
        return $this->db->delete('ih_user', array('email'=>$email) );
    }
    
    /**
     * Insert activation data.
     * 
     * @param array $data
     * @return boolean
     */
    public function insert_verify($data){
        return $this->db->insert('ih_activate', $data);
    }
    
    /**
     * Get activation data.
     * 
     * @param char $kind
     * @param string $uuid
     * @param array $data
     * @return array
     */
    public function get_verify($kind, $uuid, $data){
        $cond = null;
        if ($kind=='1'){
            $cond = array('kind'=>$kind, 'uu_id'=>$uuid, 'email'=>$data);
        }
        
        $query = $this->db->get_where("ih_activate", $cond);
        return $query->row_array();
    }
    
    /**
     * Get user by id.
     * 
     * @param long $id
     * @return array
     */
    public function get_user__by_id($id){
        $query = $this->db->get_where("ih_user", array('id'=>$id));
        return $query->row_array();
    }
}
