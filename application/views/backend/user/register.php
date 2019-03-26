
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="form-box">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3>Register School</h3>
                    </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                        </div>


                        <form action="<?php echo base_url(); ?>user/register" method="post" enctype="multipart/form-data">
                
                         <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                         <label class="control-label" for="schoolname">School Name</label>
                                         <div>
                                            <input type="text" class="form-control" id="schoolname" name="schoolname" placeholder="School Name" required="">
                                            <span class="text-danger"><?php echo form_error('schoolname'); ?></span>
                                        </div>
                                    </div>
                             </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="phone">Phone Number</label>
                                        <div>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required="">
                                            <span class="text-danger"><?php echo form_error('phone'); ?></span>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="population">Population</label>
                                        <div>
                                            <input type="number" class="form-control" id="population" name="population" placeholder="Population" required="">
                                            <span class="text-danger"><?php echo form_error('population'); ?></span>
                                        </div>
                                </div>
                            </div>

                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="schoolcode">School Code</label>
                                        <div>
                                            <input type="number" class="form-control" id="schoolcode" name="schoolcode" placeholder="KNEC Code" required="">
                                            <span class="text-danger"><?php echo form_error('schoolcode'); ?></span>
                                        </div>
                                </div>
                            </div>
                    
                        </div>
             

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="pswd">Email</label>
                                        <div>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
                                            <span class="text-danger"><?php echo form_error('email'); ?></span>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group ">
                                    <label class="control-label"for="picture">Logo (Optional)</label>
                                        <div>
                                            <input type="file" style="height:44px;" name="picture" id="picture" class="form-control">
                                            <span class="form-text" id="picture"></span>
                                        </div>
                               </div>
                             </div>
                        </div>


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
                                            <input type="password" class="form-control" id="cn-pswd" name="confirmpswd" placeholder="Confirm Password" required="">
                                            <span class="text-danger"><?php echo form_error('confirmpswd'); ?></span>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <!--
                        <div class="form-group"> <label> By signing up you agree to our Terms</label> 
                            </div>
                        -->

                            <div class="form-group"> 
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-3  btn-submit">
                                        <button type="submit" class="btn btn-success">Register</button>
                                    </div>
                                </div>
                            </div>
              
              </form>

              <div class="text-center">
                  <p>Already Registered? Click <a href="<?php echo base_url();?>login">here</a></p>
              </div>
            </div>

                          

                          
                          

                            
               
    

            