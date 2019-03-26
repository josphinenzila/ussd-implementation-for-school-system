<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model','profile');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{

    
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
    
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/settings/profile/profile',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->profile->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $profile) {
			$no++;
			$row = array();
			
			$row[] = $profile->email;
			$row[] = $profile->school_name;
			$row[] = $profile->school_id;
			$row[] = $profile->phone;
			$row[] = $profile->population;

			if($profile->logo)
                $row[] = '<a href="'.base_url('assets/uploads/secondary/logo/'.$profile->logo).'" target="_blank"><img src="'.base_url('assets/uploads/secondary/logo/'.$profile->logo).'" class="img-responsive" /></a>';
            else
                $row[] = '(No Logo)';
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_profile('."'".$profile->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
         
            $data[] = $row;
        }

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->profile->count_all(),
						"recordsFiltered" => $this->profile->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_edit($id)
	{
		$data = $this->profile->get_by_id($id);
		//$data->start_date = ($data->start_date == '0000-00-00') ? '' : $data->start_date; // if 0000-00-00 set to empty for datepicker compatibility
		//$data->end_date = ($data->end_date == '0000-00-00') ? '' : $data->end_date; // if 0000-00-00 set to empty for datepicker compatibility
		echo json_encode($data);

	}

	public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
                'email' => $this->input->post('email'),
                'school_name' => $this->input->post('school_name'),
                'school_id' => $this->input->post('school_id'),
                'phone' => $this->input->post('phone'),
                'population' => $this->input->post('population'),
                'date_modified' => date_create('now')->format('Y-m-d H:i:s'),
            );
 
        if(!empty($_FILES['logo']['name']))
        {
            $upload = $this->_do_upload();
            $data['logo'] = $upload;
        }
 
        $insert = $this->profile->save($data);
 
        echo json_encode(array("status" => TRUE));
    }

	 public function ajax_update() {
        $this->_validate();
        $data = array(
                'email' => $this->input->post('email'),
                'school_name' => $this->input->post('school_name'),
                'school_id' => $this->input->post('school_id'),
                'phone' => $this->input->post('phone'),
                'population' => $this->input->post('population'),
                
            );
 
        if($this->input->post('remove_photo')) // if remove photo checked
        {
            if(file_exists('assets/uploads/secondary/logo/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('assets/uploads/secondary/logo/'.$this->input->post('remove_photo'));
            $data['logo'] = '';
        }

 
        if(!empty($_FILES['logo']['name']))
        {
            $upload = $this->_do_upload();
             
            //delete file
            $profile = $this->profile->get_by_id($this->input->post('id'));
            if(file_exists('assets/uploads/secondary/logo/'.$profile->logo) && $profile->logo)
                unlink('assets/uploads/secondary/logo/'.$profile->logo);
 
            $data['logo'] = $upload;
        }
 
        $this->profile->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
	public function ajax_delete($id)
    {
        //delete file
        $profile = $this->profile->get_by_id($id);
        if(file_exists('assets/uploads/secondary/logo/'.$profile->logo) && $profile->logo)
            unlink('assets/uploads/secondary/logo/'.$profile->logo);
         
        $this->profile->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


	 private function _do_upload() 
	 {
        $config['upload_path']          = 'assets/uploads/secondary/logo/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
 
        $this->load->library('upload', $config);
 
        if(!$this->upload->do_upload('logo')) //upload and validate
        {
            $data['inputerror'][] = 'logo';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('email') == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('school_id') == '')
        {
            $data['inputerror'][] = 'school_id';
            $data['error_string'][] = 'School ID is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('phone') == '')
        {
            $data['inputerror'][] = 'phone';
            $data['error_string'][] = 'Phone Number is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('population') == '')
        {
            $data['inputerror'][] = 'population';
            $data['error_string'][] = 'Population is required';
            $data['status'] = FALSE;
        }
 
       
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}