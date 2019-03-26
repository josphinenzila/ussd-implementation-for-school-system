<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentMethod extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('payment_method_model','method');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{

      $this->load->model('group_model');
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
      $data['groups'] = $this->group_model->getAllGroups();
  
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/payments/PaymentMethod/PaymentMethod',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->method->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $method) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" class="data-check" value="'.$method->id.'">';
			$row[] = $method->description;
		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_method('."'".$method->id."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_method('."'".$method->id."'".')"><i class="fa fa-trash-o"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->method->count_all(),
						"recordsFiltered" => $this->method->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_edit($id)
	{
		$data = $this->method->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		
		$data = array(
				'description' => $this->input->post('description'),
				'school_id'  => $this->session->userdata['logged_in']['school_id'], 
			    'date_posted' => date_create('now')->format('Y-m-d H:i:s'),
			);

		$insert = $this->method->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'description' => $this->input->post('description'),
			
			);
		$this->method->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->method->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->method->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('description') == '')
		{
			$data['inputerror'][] = 'description';
			$data['error_string'][] = 'Description is required';
			$data['status'] = FALSE;
		}

		
      
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	 public function clearPaymentMethod(){
        $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']);
        $this->db->delete('payment_instructions');
        redirect(base_url().'PaymentMethod');

    }

   
}
