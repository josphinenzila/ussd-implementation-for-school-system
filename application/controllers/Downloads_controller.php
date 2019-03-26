<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('downloads_model','file');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{

      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
      $data['files'] = $this->file->getRows();
       
	  $this->load->view('backend/secondary/reports/downloads/downloads',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->file->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $file) {
			$no++;
			$row = array();
			$row[] = '<th></th>';
			$row[] = $file->title;
			$row[] = $file->file_name;
			$row[] = date("d/m/Y",strtotime($file->created));
		
		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger" href="downloads_controller/download/'.$file->id.'" title="Download"><i class="fa fa-download"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->file->count_all(),
						"recordsFiltered" => $this->file->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


    public function download($id){
        if(!empty($id)){
            //load download helper
            $this->load->helper('download');
            
            //get file info from database
            $fileInfo = $this->file->getRows(array('id' => $id));

             //$data['files'] = $this->file->getRows();
            
            //file path
            $file = 'assets/uploads/secondary/files/'.$fileInfo['file_name'];
            
            //download file from directory
            force_download($file, NULL);
        }
    }
    
	
	 
}
