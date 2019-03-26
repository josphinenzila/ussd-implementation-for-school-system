<?php

Class Login_model extends CI_Model {

// Read data using username and password
public function login($data) {

	$stmt = "email =" . "'" . $data['email'] . "' AND " . "password =" . "'" . $data['password'] . "'";
	$this->db->select('*');
	$this->db->from('user');
	$this->db->where($stmt);
	//$this->db->where('status', 1);
	$this->db->limit(1);
	$query = $this->db->get();

	if ($query->num_rows() == 1) {
		return true;
		} else {
			return false;
	   }
}

// Read data from database to show data in dashboard
public function display_info($email) {

	$stmt = "email =" . "'" . $email. "'";
	$this->db->select('*');
	$this->db->from('user');
	$this->db->where($stmt);
	$this->db->limit(1);
	$query = $this->db->get();

	if ($query->num_rows() == 1) {
		return $query->result();
		} else {
			return false;
		}
	}

}

?>