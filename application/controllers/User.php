<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
  function __Construct(){
    parent::__Construct();

    $this->load->helper(array('form', 'url','string'));
    $this->load->library(array('session', 'form_validation', 'email')); 
    $this->load->database();
    $this->load->model('user_model');
    $this->load->model('login_model');
    $this->session->set_userdata('data');
    }  

  public function index(){
    $this->load->view('backend/user/layouts/header');
    $this->load->view('backend/user/register');
    $this->load->view('backend/user/layouts/footer');

  }

  public function contacts(){
   
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
      $data['posts'] = $this->user_model->getPosts(); 
  
        
      $this->load->view('backend/secondary/Admissions',$data);   
  }

  public function register()
  {
    //validate input value with form validation class of codeigniter
    $this->form_validation->set_rules('schoolname', 'School Name', 'required');
    $this->form_validation->set_rules('schoolcode', 'School Code', 'required');
    $this->form_validation->set_rules('phone', 'Phone Number', 'required');
    $this->form_validation->set_rules('population', 'Population', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[15]');
    $this->form_validation->set_rules('confirmpswd', 'Password Confirmation', 'required|matches[password]');

    //$this->form_validation->set_message('is_unique', 'This %s is already exits');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('backend/user/layouts/header');
            $this->load->view('backend/user/register');
            $this->load->view('backend/user/layouts/footer');
        }
        else
        {

          if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/secondary/logo/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                // $config['max_size'] = '1000000';
                $config['file_name'] = $_FILES['picture']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('picture')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }else{
                $picture = '';
            }

            $schoolname = $_POST['schoolname'];
            $schoolcode = $_POST['schoolcode'];
            $phone = $_POST['phone'];
            $population = $_POST['population'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passhash = hash('md5', $password);
            
            //md5 hashing algorithm to decode and encode input password
            //$salt       = uniqid(rand(10,10000000),true);
            $saltid     = md5($email);
            $status     = 0;
            
            $data = array(
              'school_name' => $schoolname,
              'school_id' => $schoolcode,
              'phone' => $phone,
              'population' => $population,
              'email' => $email,
              'password' => $passhash,
              'status' => $status,
              'logo' => $picture,
              );


           if($this->user_model->insertuser($data)){

                    $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Thanks for completing the  registration.You may now login</div>');
                    redirect(base_url().'login');

                
            } else{

                  $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Something Wrong. Please try again ...</div>');
                    redirect(base_url().'register');
                  }
               
            }

          }


          function sendemail($email,$saltid){
              // configure the email setting
              $schoolname = $_POST['schoolname'];
              
              $this->load->library('email');
              $url = base_url()."user/confirmation/".$saltid;
              $this->email->from('info@wiretechsystems.co.ke', 'WIRETECH');
              $this->email->to($email); 
              $this->email->subject('Please Verify Your Email Address');
            
              $message = "<html><head><head></head><body><p>Hi, ".$schoolname." </p><p>Thanks for registration with WIRETECH.</p><p>Please click below link to activate your account.</p>".$url."<br/><p>Sincerely,</p><p>WIRETECH Team</p></body></html>";
              $this->email->message($message);

              if($this->email->send()) 
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Email sent successfully.Please verify your email to activate your account</div>'); 
                 else 
                 $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Error in sending Email.</div>');      
            //return $this->email->send();
  }

  public function confirmation($key){

        if($this->user_model->verifyemail($key)){
            $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your Email Address is successfully verified!</div>');
             redirect(base_url().'login');
        }else{
            $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Your Email Address Verification Failed. Please try again later...</div>');
            redirect(base_url());
        }
    }

  public function login(){
            $this->load->view('backend/user/layouts/header');
            $this->load->view('backend/user/login');
            $this->load->view('backend/user/layouts/footer');
      }
      
 
  // Check for user login process
  public function authenticate() {

   // require_once APPPATH."third_party/vendor/autoload.php";

    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[15]');

    if ($this->form_validation->run() == FALSE) {
        if(isset($this->session->userdata['logged_in'])){

            $this->load->model('events_model','events');
            $this->load->model('user_model','balance');
            $data['fee_balances'] = $this->balance->getBalances();
            $data['event'] = $this->events->getAllEvents();
            $this->load->view('backend/secondary/main/home',$data);

          } else{
            $this->load->view('backend/user/layouts/header');
            $this->load->view('backend/user/login');
            $this->load->view('backend/user/layouts/footer');
          }

        } else {

            $data = array(
                  'email' => $this->input->post('email'),
                  'password' =>md5($this->input->post('password')),
                );

            $result = $this->login_model->login($data);

            if ($result == TRUE) {
                $email = $this->input->post('email');
                $result = $this->login_model->display_info($email);

            if ($result != false) {

                $session_data = array(
                  'email' => $result[0]->email,
                  'school_id' => $result[0]->school_id,
                  'school_name' => $result[0]->school_name,
                  'logo' => $result[0]->logo,
                  //'role' => $result[0]->role
                );

                // Add user data in session
                $this->session->set_userdata('logged_in', $session_data);

                   $session_data = array(
                  'email' => $result[0]->email,
                  'school_id' => $result[0]->school_id,
                  'school_name' => $result[0]->school_name,
                  'logo' => $result[0]->logo,
                  //'role' => $result[0]->role
                );
              
                 $this->load->model('events_model','events');
                 $this->load->model('user_model','balance');
                 $data['fee_balances'] = $this->balance->getBalances();
                 $data['event'] = $this->events->getAllEvents();
                 $this->load->view('backend/secondary/main/home',$data);
              }

            } else {
                $data = array(
                'error_message' => '<div class="alert alert-danger text-center">Invalid Email or Password</div>'
                );

                $this->load->view('backend/user/layouts/header');
                $this->load->view('backend/user/login',$data);
                $this->load->view('backend/user/layouts/footer');
            }

       }

  }

  function logout(){
    $this->session->sess_destroy();
    redirect(base_url(), 'refresh');
  }

  public function forgot(){
    $data="";
    $this->load->view('backend/user/layouts/header');
    $this->load->view('backend/user/forgot',$data);
    //$this->load->view('backend/user/layouts/footer');

  }

  public function resetPassword(){
    
    $this->form_validation->set_rules('email','Email','required|valid_email');

    if ($this->form_validation->run() == FALSE){
        $this->load->view('backend/user/layouts/header');
        $this->load->view('backend/user/forgot');
        $this->load->view('backend/user/layouts/footer');
      
      }else{
      
            $email= $this->input->post('email');
            $userInfo = $this->user_model->getUserInfoByEmail($email);

            if(!$userInfo){
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">We cant find your email address</div>');
                    redirect(base_url().'forgot');
                }   

            

            $this->load->helper('string', 6);
            $password= random_string('alnum', 8);
           
            $data = array(
                           'password' => MD5($password)
                        );
           
            $this->db->where('email', $email);
            $this->db->update('user', $data);

            $this->load->library('email');
            $this->email->from('info@wiretechsystems.co.ke', 'WIRETECH');
            $this->email->to($email); 
            $this->email->subject('Password reset request');
            $link = base_url()."newpassword";
            $message = "<html><head><head></head><body><p>You have requested a new password your new password is <strong>".$password."</strong><br/><p>Sincerely,</p><p>WIRETECH Team</p></body></html>";

            $this->email->message($message);


           if($this->email->send())
                {

                $data=$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Password has been reset and has been sent to email</div>'); 
                redirect(base_url().'forgot');

                  }else{
                    $data=$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Error in sending email</div>'); 
                    $this->load->view('backend/user/layouts/header');
                    $this->load->view('backend/user/forgot',$data);
                    $this->load->view('backend/user/layouts/footer');
                    }               

              }

    }


    


}