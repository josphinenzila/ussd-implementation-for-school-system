<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Password_model extends CI_Model
{

  public function save() 
  { 
    $pass = md5($this->input->post('newPassword')); 
  
    $data = array( 
          'password' => $pass 
          ); 

    $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']); 
    $this->db->update ('user', $data); 
  }

  public function check_old() 
  { 
    $old = md5($this->input->post('oldPassword')); 
    $this->db->where('password',$old); 
    $this->db->where('school_id', $this->session->userdata['logged_in']['school_id']); 
    $query = $this->db->get('user'); 

    return $query->result();

  }    
   
}