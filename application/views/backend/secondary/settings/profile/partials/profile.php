
 <section id="main-content" style="background-color: #fff">
          <section class="wrapper">            
           
              <!--overview start-->
            <div class="row">
             <div class="col-lg-12">
                    
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="dashboard">Home</a></li>
                        <li><i class="fa fa-wrench"></i>Settings</li> 
                        <li><i class="fa fa-user"></i>Account</li>                          
                    </ol>
                </div>
            </div>
      
            <div class="col-md-12 col-sm-12 col-xs-12">

                   <ul class="nav nav-tabs">
                      <li role="presentation" class="active"><a href="profile">Account</a></li>
                      <li role="presentation"><a href="groups">Groups</a></li>
                      <li role="presentation"><a href="roles">Roles</a></li>

                    </ul>

                <div class="x_panel">
                    <div>

                    <div class="navbar-right panel_toolbox">
                        
                           <a href="password" target="_blank">
                            <button class="btn btn-primary btn-outline"><i class="fa fa-key"></i> Change Password</button>
                           </a>
                         
                       </div> 
    
    
       <table id="table" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                 
                     <th>Email</th>
                     <th>School Name</th>
                     <th>School ID</th>
                     <th>Phone</th>
                     <th>Population</th>
                     <th>Logo</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            
        </table>
    </div>

     </div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Profile</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="School Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">School Name</label>
                            <div class="col-md-9">
                                <input name="school_name" placeholder="School Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                         <div class="form-group">
                            <label class="control-label col-md-3">School ID</label>
                            <div class="col-md-9">
                                <input name="school_id" placeholder="School ID" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Phone</label>
                            <div class="col-md-9">
                                <input name="phone" placeholder="Phone Number" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Population</label>
                            <div class="col-md-9">
                                <input name="population" placeholder="Population" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    
                        
                        <div class="form-group" id="photo-preview">
                            <label class="control-label col-md-3">Logo</label>
                            <div class="col-md-9">
                                (No logo)
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo">Upload Logo </label>
                            <div class="col-md-9">
                                <input name="logo" type="file">
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
