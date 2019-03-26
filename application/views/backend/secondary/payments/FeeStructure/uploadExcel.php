<?php

defined('BASEPATH') OR exit('No direct script access allowed');

  $this->load->view('backend/secondary/layouts/master/header');

  $this->load->view('backend/secondary/layouts/master/topnav');

  $this->load->view('backend/secondary/layouts/master/sidebar');

?>

<?php echo $this->session->flashdata('msg'); ?>
<?php echo $this->session->flashdata('error_msg'); ?>
<section id="main-content" style="background-color: #fff">
          <section class="wrapper">            
           
              <!--overview start-->
            <div class="row">
             <div class="col-lg-12">
                    
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="dashboard">Home</a></li>
                      <li><i class="fa fa-upload"></i>Fee Uploads</li>                          
                    </ol>
                </div>
            </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

        
<form action="fee_controller/add" role="form" method="post" enctype="multipart/form-data">
    <div>
        <div class="panel-body">
            <div class="form-group">
                <label>Upload File</label>
                <input class="form-control" type="file" name="fees" />
            </div>
            
             <div class="form-group">
                <input type="submit" class="btn btn-primary" name="userSubmit" value="Import Fee Structure">
            </div>
        </div>
    </div>
</form>

</div></div>
</section>
</section>
<?php  $this->load->view('backend/secondary/payments/FeeStructure/layouts/footer'); ?>





  
 
  