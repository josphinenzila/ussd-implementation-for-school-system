<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{

  public function insertuser($data)
  {
    return $this->db->insert('user', $data);
  }


  public function verifyemail($key)
  {
       $data = array(
            'status' => 1,
            'date_registered'=>date_create('now')->format('Y-m-d H:i:s'),
            );

        $this->db->where('md5(email)', $key);
        return $this->db->update('user', $data);
  }

  public function check_user($email,$pass)
  {
    $sql = "SELECT * FROM user where email = ? and password = ?";
    $data = $this->db->query($sql, array($email,$pass));
        return ($data->result_array()) ;
  }

  public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('user', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }

  public function getUserInfo($id)
    {
        $q = $this->db->get_where('user', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }

function getPosts(){
  $this->db->select("adm,student_name,parent_phone1,parent_phone2,stream,class"); 
  $this->db->from('student_contacts');
  $query = $this->db->get();
  return $query->result();


                       
 }
 
  public function getBalances(){
                            
        $this->db->select("SUM(fee_balance) AS balances,school_id");
        $this->db->from("fee_payments");
        $this->db->where("school_id",$this->session->userdata['logged_in']['school_id']);
        //$this->db->group_by('school_id'); 
        $balance=$this->db->get();
        if($balance->num_rows() > 0)
        { 
        $res = $balance->row_array();
        return $res['balances'];
        }
        return 0.00;
    }
                      





}