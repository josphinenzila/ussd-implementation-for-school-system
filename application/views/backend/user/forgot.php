

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="form-box">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3>Forgot Password</h3>
                    </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
 
                                    <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                        </div>


                        <form action="reset" method="post">
                
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


        

                        <div class="form-group"> 
                                <div class="row">
                                    <div class="col-sm-12">
                                     <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary">Reset Password</button>
                                      </div>
                                    </div>
                                </div>
                        </div>
                     </form>


            </div>

             <div class="panel-footer text-center">
              <h5><a href="login">Back to Login Page</a></h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>


    