
 <section id="main-content" style="background-color: #fff">
          <section class="wrapper">            
           
              <!--overview start-->
            <div class="row">
             <div class="col-lg-12">
                    
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="dashboard">Home</a></li>
                        <li><i class="fa fa-user"></i>Staff</li>                          
                    </ol>
                </div>
            </div>
      
            <div class="col-md-12 col-sm-12 col-xs-12">
                   <ul class="nav nav-tabs">
                      <li role="presentation"><a href="admission1">Form1</a></li>
                      <li role="presentation"><a href="admission2">Form 2</a></li>
                      <li role="presentation"><a href="admission3">Form 3</a></li>
                      <li role="presentation"><a href="admission4">Form 4</a></li>
                      <li role="presentation" class="active"><a href="staff">Staff</a></li>
                    </ul>
                <div class="x_panel">
                 <div>
                 
                      <div class="navbar-right panel_toolbox">
                        
                           <li style="list-style: none;">
                            <a for="DeleteAll" href="#clear-admissions" data-toggle="modal" data-target="#clear-admissions">
                                <button class="btn btn-danger btn-outline" style="vertical-align: middle;"><i class="fa fa-info"></i> Clear Staff</button>
                            </a>
                            <!-- delete modal user -->
                                <div class="modal fade" id="clear-admissions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> User</h4>
                                        </div>

                                        <div class="modal-body">
                                            <div class="alert alert-danger">
                                                This will erase all admission details from database. Are you sure you want to clear all Stakeholder details?
                                            </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> No
                                            </button>

                                            <a href="clearStakeholders" style="margin-bottom:5px;" class="btn btn-primary"><i class="fa fa-check"></i> Yes</a>
                                        </div>
                                    </div>

                                </div>
                             </li>

                            <button class="btn btn-danger btn-outline" onclick="bulk_delete()"><i class="fa fa-trash-o"></i> Bulk Delete</button>
                         
                      

                           
                            <button class="btn btn-success btn-outline" onclick="add_person()" style="vertical-align: middle;"><i class="fa fa-plus"></i> Add Staff</button>
                          
                          
                         
                           <!--  <a href="uploadStaff">
                            <button class="btn btn-primary btn-outline"><i class="fa fa-upload"></i> Import Staff</button>
                            </a> -->
                       
                        
                        
    
                        </div></div></div>
       
    
      <table id="table" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"></th>
                     <th>Name</th>
                     <th>Category</th>
                     <th>Role</th>
                     <th>Phone 1</th>
                     <th>Phone 2</th>
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
                <h3 class="modal-title">Add Staff</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
             
                        <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name" class="form-control" type="text" id="input-field" onkeyup="validate();">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Category</label>
                            <div class="col-md-9">
                            <select name="category" class="form-control">


                                <option value="">--Select Category--</option> 
                                 
                                    <option value="Teachers">Teachers</option>
                                    <option value="2020">BOM</option>
                                    <option value="Support Staff">Support Staff</option>
                                    
                                 

                             <?php 
                                foreach($groups as $row){ 
                                echo '<option value="'.$row->name.'">'.$row->name.'</option>';
                                } 
                             ?>

                            </select>
                            <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Role</label>
                            <div class="col-md-9">
                            <select name="role" class="form-control">

                            <option value="">--Select Role--</option> 
                                 
                                 <option value="Principal">Principal</option>
                                 <option value="Admin">Admin</option>
                                 <option value="Human Resource">Human Resource</option>
                                 <option value="Matron">Matron</option>
                              



                             <?php 
                                foreach($roles as $row){ 
                                echo '<option value="'.$row->name.'">'.$row->name.'</option>';
                                } 
                             ?>

                            </select>
                            <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Phone 1</label>
                            <div class="col-md-9">
                                <input name="phone1" placeholder="Primary phone" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Phone 2</label>
                            <div class="col-md-9">
                                <input name="phone2" placeholder="Secondary phone" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>

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
