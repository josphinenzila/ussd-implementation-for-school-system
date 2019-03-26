<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model','invoice');
		$this->load->library(array('session', 'form_validation', 'email')); 
		$this->load->helper(array('form', 'url','string'));
	}

	public function index()
	{

      $data['school_name']=$this->session->userdata('school_name');
      $data['school_id']=$this->session->userdata('school_id');
      $data['logo']=$this->session->userdata('logo');
    
	  $this->load->helper('url');
	  $this->load->view('backend/secondary/reports/invoice/invoice',$data);
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->invoice->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $invoice) {
			$no++;
			$row = array();
			
			$row[] = $invoice->school_name;
			$row[] = $invoice->invoice_number;
			$row[] = $invoice->transaction_code;
			$row[] = $invoice->status;
			$row[] = $invoice->setup_cost;
			$row[] = $invoice->website;
			$row[] = $invoice->shortcodes;
			$row[] = $invoice->quantity;
			$row[] = $invoice->unit_cost;

		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->invoice->count_all(),
						"recordsFiltered" => $this->invoice->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    
	public function ajax_view($id)
	{
		$this->invoice->view_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	
    public function invoice()
 	{
 
  		require('fpdf/fpdf.php');
		
		$this->load->model('invoice_model','invoice');

        $report = $this->invoice->getInvoice();

		foreach ($report as $invoice) {
		
			$row[] = $invoice->school_name;
			$row[] = $invoice->invoice_number;
			$row[] = $invoice->transaction_code;
			$row[] = $invoice->payment_date;
			$row[] = $invoice->due_date;
			$row[] = $invoice->status;
			$row[] = $invoice->setup_cost;
			$row[] = $invoice->website;
			$row[] = $invoice->shortcodes;
			$row[] = $invoice->quantity;
			$row[] = $invoice->unit_cost;
			$row[] = $invoice->date_posted;

			$service_cost=sprintf("%.2f",$invoice->quantity*$invoice->unit_cost);
			$subtotal=sprintf("%.2f",$service_cost+$invoice->setup_cost);
			$vat=sprintf("%.2f",$subtotal*0.16);
			$total=sprintf("%.2f",$subtotal+$vat);

			$pdf = new FPDF();
			$pdf->AddPage();


			// Insert a logo in the top-left corner at 300 dpi
	      	$pdf->Image('assets/uploads/secondary/wiretech/logo.png',10,15,35);

	      	$pdf->SetFont('times','B',20);
	      	$pdf->Multicell(0,2,"\n\n\n\n");
	      	$pdf->Cell(0,2, "WIRETECH\n\n", 0, 0, 'R');
	      	$pdf->Multicell(0,2,"\n\n\n\n\n");
	      	$pdf->SetFont('times','',12);
	      	$pdf->Cell(0,2, "Phone:+254 728 086 084\n\n", 0, 0, 'R');
	      	$pdf->Multicell(0,2,"\n\n\n");
	      	$pdf->Cell(0,2, "Email:info@wiretechsystems.co.ke\n\n", 0, 0, 'R');
	      	$pdf->Multicell(0,2,"\n\n\n");
	      	$pdf->Cell(0,2, "Website:www.wiretechsystems.co.ke\n\n", 0, 0, 'R');

	      	$pdf->Multicell(0,2,"\n\n\n\n\n\n\n\n\n");
	      	$pdf->SetFont('times','B',20);
	      	$pdf->Cell(0,2, "INVOICE\n\n", 0, 0, 'L');
	      	
	      	$pdf->Multicell(0,2,"\n\n\n\n\n");
	     	$pdf->SetFont('times','',12);
	      	$schoolname = 'Invoiced To: '.$invoice->school_name;
	      	$pdf->Cell(0,2,$schoolname, 0, 0, 'L');

	      	$pdf->Multicell(0,2,"\n\n\n");
	     	$pdf->SetFont('times','',12);
	      	$invoiceNumber = 'Reference: '.$invoice->invoice_number;
	      	$pdf->Cell(0,2,$invoiceNumber,0, 0, 'L');

	  
	      	$pdf->Multicell(0,2,"\n\n\n");
	     	$pdf->SetFont('times','',12);

	      	$invoiceDate = 'Invoice Date: '.date("d/m/Y",strtotime($invoice->date_posted));
	      	$pdf->Cell(0,2,$invoiceDate,0, 0, 'L');


	      	$pdf->Multicell(0,2,"\n\n\n");
	     	$pdf->SetFont('times','',12);
	      	$date = 'Due Date: '.date("d/m/Y",strtotime($invoice->due_date));
	      	$pdf->Cell(0,2,$date,0, 0, 'L');

	      	$pdf->Multicell(0,2,"\n\n\n");
	     	$pdf->SetFont('times','',12);
	      	$status = 'Status: '.$invoice->status;
	      	$pdf->Cell(0,2,$status,0, 0, 'L');

	   
	        $pdf->Multicell(0,2,"\n\n\n\n\n");
	        $pdf->SetFont('times','B',10);
	        $pdf->Cell(90, 5,"___________________________________________________________________________________________________________",0, 'L', 1, 0, '', '', true);

	        $pdf->Multicell(0,2,"\n\n");
	      	$pdf->SetFont('times','B',12);
	      	$pdf->Cell(60, 5,'   Description',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(30, 5,'Quantity',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(40, 5,'Unit Cost',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(30, 5,'Amount(KES)',0, 'L', 0, 0, '', '', true);
	        $pdf->Multicell(0,2,"\n");
	        $pdf->SetFont('times','B',10);
	        $pdf->Cell(90, 5,"___________________________________________________________________________________________________________",0, 'L', 1, 0, '', '', true);



	      	$pdf->Multicell(0,2,"\n\n\n\n");
	      	$pdf->SetFont('times','',11);
	      	$pdf->Cell(60, 5,'1. One time setup fee',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(30, 5,'--',0, 'C', 1, 0, '', '', true);
	      	$pdf->Cell(45, 5,'--',0, 'C', 1, 0, '', '', true);
	      	$pdf->MultiCell(60, 5,$invoice->setup_cost,0, 'L', 0, 0, '', '', true);

	      	$pdf->Multicell(0,2,"\n");
	      	$pdf->SetFont('times','',11);
	      	$pdf->Cell(60, 5,'2. Yearly Service Charges',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(30, 5,$invoice->quantity,0, 'C', 1, 0, '', '', true);
	      	$pdf->Cell(45, 5, $invoice->unit_cost,0, 'C', 1, 0, '', '', true);
	      	$pdf->MultiCell(60, 5,$service_cost,0, 'L', 0, 0, '', '', true);

	      	$pdf->Multicell(0,2,"\n");
	        $pdf->SetFont('times','B',10);
	        $pdf->Cell(90, 5,"___________________________________________________________________________________________________________",0, 'L', 1, 0, '', '', true);


	        $pdf->Multicell(0,2,"\n\n\n\n");
	      	$pdf->SetFont('times','B',11);
	      	$pdf->Cell(90, 5,'',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(45, 5,'Sub-Total',0, 'R', 1, 0, '', '', true);
	      	$pdf->SetFont('times','',11);
	      	$pdf->MultiCell(50, 5,$subtotal,0, 'L', 0, 0, '', '', true);
	      	
	      	$pdf->Multicell(0,2,"\n");
	      	$pdf->SetFont('times','B',11);
	      	$pdf->Cell(90, 5,'',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(47, 5,'16% VAT',0, 'R', 1, 0, '', '', true);
	      	$pdf->SetFont('times','',11);
	      	$pdf->MultiCell(50, 5,$vat,0, 'L', 0, 0, '', '', true);

	      	$pdf->Multicell(0,2,"\n");
	      	$pdf->SetFont('times','B',11);
	      	$pdf->Cell(90, 5,'',0, 'L', 1, 0, '', '', true);
	      	$pdf->Cell(45, 5,'Total',0, 'R', 1, 0, '', '', true);
	      	$pdf->SetFont('times','',11);
	      	$pdf->MultiCell(50, 5,$total,0, 'L', 0, 0, '', '', true);

	      	$pdf->Multicell(0,2,"\n");
	        $pdf->SetFont('times','B',10);
	        $pdf->Cell(90, 5,'',0, 'L', 1, 0, '', '', true);
	        $pdf->Cell(50, 5,"________________________________________________________",0, 'L', 1, 0, '', '', true);

	        $pdf->Multicell(0,2,"\n\n\n\n\n\n\n\n\n\n");
	        $pdf->SetFont('times','B',10);
	        $pdf->Cell(0,2, "PDF generated on ".date("l, d-M-Y"), 0, 0, 'C');
	      
	      	$pdf->Output();


            /**
		    // sending the pdf to email
		
		    $email=$this->session->userdata('email');

		    $config['protocol'] = 'smtp';
		    $config['smtp_host'] = 'ssl://smtp.gmail.com'; //smtp host name
		    $config['smtp_port'] = '465'; //smtp port number
		    $config['smtp_user'] = 'simplebasil@gmail.com';
		    $config['smtp_pass'] = 'KAJWANGS'; //$from_email password
		    $config['mailtype'] = 'html';
		    $config['charset'] = 'iso-8859-1';
		    $config['wordwrap'] = TRUE;
		    $config['newline'] = "\r\n"; //use double quotes

		    $this->email->initialize($config);

		    $this->email->from('simplebasil@gmail.com', 'WIRETECH INVOICE');
		    $this->email->to('basilndonga@gmail.com');
		    $this->email->subject('INVOICE');
		    $this->email->attach($pdf,'application/pdf', "Pdf File " .date("m-d H-i-s") . ".pdf", false);
		    $this->email->message('Hi,Please find the attached invoice');  

		    $this->email->send();
           
           **/


		 }

     }


}
