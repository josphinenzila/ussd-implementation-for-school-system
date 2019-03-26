<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="form-box">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3>Enter New Password</h3>
                    </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                        </div>

                      <form action="<?php echo base_url(); ?>newpassword" method="post" >
                
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="pswd">Password</label>
                                        <div>
                                            <input type="password" class="form-control" id="pswd" name="password" placeholder="Password" required="">
                                            <span class="text-danger"><?php echo form_error('password'); ?></span>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="cn-pswd">Confirm Password</label>
                                        <div>
                                            <input type="password" class="form-control" id="cn-pswd" name="passconf" placeholder="Confirm Password" required="">
                                            <span class="text-danger"><?php echo form_error('passconf'); ?></span>
                                        </div>
                                </div>
                            </div>
                        </div>


                        
                            <div class="form-group"> 
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-3  btn-submit">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
              
              </form>

             
            </div>

