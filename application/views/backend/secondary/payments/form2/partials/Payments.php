
 <section id="main-content" style="background-color: #fff">
          <section class="wrapper">            
           
              <!--overview start-->
            <div class="row">
             <div class="col-lg-12">
                    
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="dashboard">Home</a></li>
                        <li><i class="fa fa-book"></i>Fee Balances</li>                          
                    </ol>
                </div>
            </div>
      
            <div class="col-md-12 col-sm-12 col-xs-12">

                    <ul class="nav nav-tabs">
                      <li role="presentation"><a href="payments1">Form1</a></li>
                      <li role="presentation" class="active"><a href="payments2">Form 2</a></li>
                      <li role="presentation"><a href="payments3">Form 3</a></li>
                      <li role="presentation"><a href="payments4">Form 4</a></li>
                      <li role="presentation"><a href="PaymentMethod">Details</a></li>
                      <li role="presentation"><a href="FeeStructure">Fee Structure</a></li>
                    </ul>


              <div>
                <div class="x_panel">
               
                 
                      <div class="navbar-right panel_toolbox">
                        
                           <li style="list-style: none;">
                            <a for="DeleteAll" href="#clear-contacts" data-toggle="modal" data-target="#clear-contacts">
                                <button class="btn btn-danger btn-outline" style="vertical-align: middle;"><i class="fa fa-info"></i> Clear Balances</button>
                            </a>
                            <!-- delete modal user -->
                                <div class="modal fade" id="clear-contacts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> User</h4>
                                        </div>

                                        <div class="modal-body">
                                            <div class="alert alert-danger">
                                                This will erase all fee balances from database. Are you sure you want to clear all fee balances?
                                            </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> No
                                            </button>

                                            <a href="clearPayments2" style="margin-bottom:5px;" class="btn btn-primary"><i class="fa fa-check"></i> Yes</a>
                                        </div>
                                    </div>

                                </div>
                             </li>

                            <button class="btn btn-danger btn-outline" onclick="bulk_delete()"><i class="fa fa-trash-o"></i> Bulk Delete</button>
                         
                      

                           
                            <button class="btn btn-success btn-outline" onclick="add_payment()" style="vertical-align: middle;"><i class="fa fa-plus"></i> Add Student</button>
                          
                          
                         
                           
                       
                        
                        
    
                        </div></div></div>
       
    
         <table id="table" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"></th>
                     <th>Adm</th>
                     <th>Student Name</th>
                     <th>Fee Balance</th>
                     <th>Stream</th>
                     <th>Class</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            
        </table>
    </div>



<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Add Student</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Adm No</label>
                            <div class="col-md-9">
                                <input name="adm" placeholder="Admission Number" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Student Name</label>
                            <div class="col-md-9">
                                <input name="student_name" placeholder="Student Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Fee Balance</label>
                            <div class="col-md-9">
                                <input name="fee_balance" placeholder="Fee Balance" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Stream</label>
                            <div class="col-md-9">
                            <select name="stream" class="form-control">

                                    <option value="STREAM A">A</option>
                                    <option value="STREAM B">B</option>

                            </select>
                            
                            <span class="help-block"></span>
                            </div>
                        </div>

                            
                        <div class="form-group">
                            <label class="control-label col-md-3">Class</label>
                            <div class="col-md-9">
                                <select name="class" class="form-control">
                                   <!-- 
                                   <option value="">--Select Class--</option> 
                                   -->
                                    <option value="FORM1">FORM1</option>
                                    <option value="FORM2">FORM2</option>
                                    <option value="FORM3">FORM3</option>
                                    <option value="FORM4">FORM4</option>

                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>



                    
                        <!--
                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="address" placeholder="Address" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</section>
