<?php
if (isset($this->session->userdata['logged_in'])) {
    redirect(base_url().'dashboard');
    }
?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="form-box">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3>School Login</h3>
                    </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php echo $this->session->flashdata('msg'); ?>

                                    <?php
                                        echo "<div class='error_msg'>";
                                            if (isset($error_message)) {
                                                echo $error_message;
                                            }

                                        echo "</div>";
                                    ?>
                            </div>
                        </div>


                        <form action="<?php echo base_url(); ?>dashboard" method="post">
                
                          <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                         <label class="control-label" for="email">Email</label>
                                         <div>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required="">
                                            <span class="text-danger"><?php echo form_error('email'); ?></span>
                                        </div>
                                    </div>
                             </div>

                            </div>


                            <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="pswd">Password</label>
                                        <div>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                                            <span class="text-danger"><?php echo form_error('password'); ?></span>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group"> 
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-3  btn-submit">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
                                    </div>
                                </div>
                        </div>
                     </form>

                     <div class="text-center">
                     <p>Don't have an account? Click to <a href="<?php echo base_url();?>register">Register</a></p>
                    
                      </div>
    

            </div>


    