<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password_controller extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation', 'email')); 
    $this->load->helper(array('form', 'url','string'));
    $this->load->model('password_model','changes');

  }

  public function index(){
      
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
    
      $this->load->helper('url');
      $this->load->view('backend/secondary/settings/password/password',$data);


  }

  public function changePassword() 
  { 
    $this->form_validation->set_rules('oldPassword','Old Password','trim|required|min_length[6]|max_length[30]');

    $this->form_validation->set_rules('newPassword','New Password','trim|required|min_length[6]|max_length[30]');
    $this->form_validation->set_rules('renewPassword','Retype Password','trim|required|matches[newPassword]');

    if ($this->form_validation->run() == FALSE) 
      {
        $this->load->view('backend/secondary/settings/password/password');

      } else { 
        $check_old = $this-> changes-> check_old(); 

        if ($check_old == false) {
         $this-> session-> set_flashdata ('msg', '<div class="alert alert-danger text-center">Old password incorrect!</div>'); 
         $this->load->view('backend/secondary/settings/password/password');

        } else { 
          $this->changes->save(); 
          $this->session->sess_destroy(); 
          $this->session->set_flashdata ('msg', '<div class="alert alert-success text-center">Password successfully changed, please login again!</div>'); 
         redirect(base_url().'login');
          
        }  
      } 
    }

   /** Strong Password  

   $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[8]|alpha_numeric|callback_password_check');

    public function password_check($str){
      if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
      return TRUE;
      }
      return FALSE;
    }

    **/
  	
}
