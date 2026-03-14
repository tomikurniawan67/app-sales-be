<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
        $query = $this->db->get('tbl_users');
        return $query->result();
    }

    public function get_user_by_id($id) {
        $query = $this->db->get_where('tbl_users', array('id' => $id));
        return $query->row();
    }

    public function get_user_by_username($username) {
        $this->db->select('u.*, e.employee_name');
        $this->db->join('tbl_employees e', 'e.employee_id = u.employee_id');
        $query = $this->db->get_where('tbl_users u', array('u.username' => $username));
        return $query->row();
    }

    public function get_sales($employee_id) {
        $query = $this->db->get_where('v_sales_report', ['employee_id' => $employee_id]);
        return $query->result();
    }
}