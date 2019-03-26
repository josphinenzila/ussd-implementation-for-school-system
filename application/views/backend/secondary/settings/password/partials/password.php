
<section id="main-content">
    <section class="wrapper"> 

        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="dashboard">Home</a></li>
                    <li><i class="fa fa-wrench"></i>Settings</li>  
                    <li><i class="fa fa-key"></i>Change Password</li>                         
                </ol>
            </div>
        </div>
              
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  
                <div class="x_panel"> 

                          <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            </div>
              
                 
                    <?php echo form_open_multipart('changePassword');?>
                      <div class="panel panel-default">
                           
                     <div class="panel-body"> 

                        <div class="form-group">
                            <label for="in_to" class="col-sm-2 control-label">Old Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="in_to" placeholder="Old Password" name="oldPassword">
                                <span class="text-danger"><?php echo form_error('oldPassword'); ?></span>
                            </div>
                        </div>
                        <br><br>

                        <div class="form-group">
                            <label for="in_to" class="col-sm-2 control-label">New Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="in_to" placeholder="New Password" name="newPassword">
                                <span class="text-danger"><?php echo form_error('newPassword'); ?></span>
                            </div>
                        </div>
                        <br><br>

                        
                        <div class="form-group">
                            <label for="in_to" class="col-sm-2 control-label">Re-type Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="in_to" placeholder="Current Password" name="renewPassword">
                                <span class="text-danger"><?php echo form_error('renewPassword'); ?></span>
                            </div>
                        </div>
                        <br><br>

                        <div class="form-group">
                            <div class="col-sm-10">
                                <input class="btn btn-primary" type="submit" value="Change Password">

                            </div>
                        </div>

                    <?php echo form_close(); ?>


             </div>

        </div>


    </section>

</section>



  
 
  