<?php
defined('BASEPATH') OR exit('No direct script access allowed');
     

class Sms_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSender() {

        $this->db->select('*')
      	->from('sender_ids')
       	->where('school_code', $this->session->userdata['logged_in']['school_id']);
        
        $query = $this->db->get();         
 		return $query->result(); 

        //echo 'Total Results: ' . $query->num_rows();
    }

}