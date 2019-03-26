<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Term_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('terms_model','term');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{ 
      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
     
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/terms/terms',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->term->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $term_list) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" class="data-check" value="'.$term_list->id.'">';
			$row[] = $term_list->name;
			$row[] = $term_list->year;
			$row[] = date("d/m/Y",strtotime($term_list->date_added));
		
		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_term('."'".$term_list->id."'".')"><i class="fa fa-edit"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_term('."'".$term_list->id."'".')"><i class="fa fa-trash-o"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->term->count_all(),
						"recordsFiltered" => $this->term->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_edit($id)
	{
		$data = $this->term->get_by_id($id);
		
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		
		$data = array(
			
				'name' => $this->input->post('name'),
				'year' => $this->input->post('year'),
				'school_id'  => $this->session->userdata['logged_in']['school_id'], 
			    'date_added' => date_create('now')->format('Y-m-d H:i:s')
			);

		$insert = $this->term->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		//$startDate = date("Y-m-d",strtotime($this->input->post('start_date')));
        //$endDate = date("Y-m-d",strtotime($this->input->post('end_date')));

		$data = array(
				'name' => $this->input->post('name'),
				'year' => $this->input->post('year'),
			
			);
		$this->term->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->term->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->term->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Term name is required';
			$data['status'] = FALSE;
		}


		if($this->input->post('year') == '')
		{
			$data['inputerror'][] = 'year';
			$data['error_string'][] = 'Year required';
			$data['status'] = FALSE;
		}


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	 public function clearTerms(){
        $this->db->where('school_id',$this->session->userdata['logged_in']['school_id']);
        $this->db->delete('term');
        redirect(base_url().'terms');

    }

   
   
}
