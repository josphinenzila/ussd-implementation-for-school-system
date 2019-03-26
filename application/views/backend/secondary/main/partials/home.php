<?php
  if (isset($this->session->userdata['logged_in'])) {
  $school_name = ($this->session->userdata['logged_in']['school_name']);
  $school_id = ($this->session->userdata['logged_in']['school_id']);
  $logo = ($this->session->userdata['logged_in']['logo']);
} else {
    redirect(base_url().'login');
}
?>



<!--main content start-->
 <section id="main-content">
    <section class="wrapper">            
      <div class="row">
        <div class="col-lg-12">
          <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="dashboard">Home</a></li>
            <li><i class="fa fa-laptop"></i>Dashboard</li>                
          </ol>
        </div>
      </div>
             

       <div id="sum_box" class="row">
          <div class="col-sm-6 col-md-3">
              <div class="panel">
                  <div class="panel-body green-bg">
                      <p class="icon"><i class="icon fa fa-user"></i></p>

                      <?php
                        $query = $this->db->query("SELECT * FROM user WHERE school_id='".$school_id."'");
                        $users= $query->num_rows();
                      ?>
                      <h4 class="value"><span><?=$users?></span></h4>
                      <p class="description">USER</p>
                                  
                  </div>
              </div>
          </div>

          <div class="col-sm-6 col-md-3"> 
              <div class="panel">
                  <div class="panel-body dark-bg">
                      <p class="icon"><i class="icon fa fa-users"></i></p>

                      <?php
                        $query = $this->db->query("SELECT * FROM student_contacts WHERE school_id='".$school_id."'");
                        $students= $query->num_rows();
                      ?>
                      <h4 class="value"><span><?=$students?></span></h4>
                      <p class="description">STUDENTS</p>
                                  
                  </div>
              </div>
          </div>

          <div class="col-sm-6 col-md-3"> 
              <div class="panel">
                  <div class="panel-body red-bg">
                      <p class="icon"><i class="icon fa fa-calendar"></i></p>

                      <?php
                        $query = $this->db->query("SELECT * FROM upcoming_events WHERE start_date >='".date("Y/m/d")."' AND school_id='".$school_id."'");
                        $events= $query->num_rows();
                      ?>
                      <h4 class="value"><span><?=$events?></span></h4>
                      <p class="description">COMING EVENTS</p>
                                  
                  </div>
              </div>
          </div>

          <div class="col-sm-6 col-md-3">
              <div class="panel">
                  <div class="panel-body green-bg">
                      <p class="icon"><i class="icon fa fa-money"></i></p>

                      <h4 class="value"><span>KES <?php echo $fee_balances;?></span></h4>
                      <p class="description">FEE BALANCES</p>
                                  
                  </div>
              </div>
          </div>
      </div><!--/.row-->
     
              
      
      <div class="row">      
        <div class="col-md-12"> 
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2><i class="fa fa-calendar"></i><strong>Term Calendar</strong></h2>
            
            </div>

          <div class="panel-body">
              <table id="table" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Event Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                  </tr>
                </thead> 

                <tbody>
             
                
               
                </tbody>
              </table>
          </div>
      </div>  
    </div><!--/col--> 

  
  </section>
</section>


  
 
  