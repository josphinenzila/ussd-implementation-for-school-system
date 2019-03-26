<?php
  //if (isset($this->session->userdata['logged_in'])) {
  $school_name = ($this->session->userdata['logged_in']['school_name']);
  $school_id = ($this->session->userdata['logged_in']['school_id']);
  $logo = ($this->session->userdata['logged_in']['logo']);
/*} else {
 redirect(base_url().'login');
}*/
?>


<body>
  <!-- container section start -->
  <section id="container" class="">
     
      
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->
            <a href="dashboard" class="logo">Jossy<span class="lite">TECH</span></a>
            <!--logo end-->

           

            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    
                    
                    <!-- inbox notification start-->
                    <!--
                    <li id="mail_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-envelope-l"></i>
                            <span class="badge bg-important">4</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">You have 4 new messages</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary"><i class="icon_profile"></i></span> 
                                    Password Change
                                    <span class="small italic pull-right">5 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="icon_pin"></i></span>  
                                    Account Creation
                                    <span class="small italic pull-right">50 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-danger"><i class="icon_book_alt"></i></span> 
                                    Get Invoice
                                    <span class="small italic pull-right">1 hr</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success"><i class="icon_like"></i></span> 
                                    Thanks for registering
                                    <span class="small italic pull-right"> Today</span>
                                </a>
                            </li>                            
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!-- alert notification end-->
                    <!-- user login dropdown start-->

                    <li class="dropdown">
                    
                        <a data-toggle="dropdown" class="user-profile dropdown-toggle" href="#">
                            <span class="profile-ava">

                            <?php if($logo != ""): ?>
                                    <img src="<?php echo base_url(); ?>assets/uploads/secondary/logo/<?php echo $logo ?>" width="30" height="30">
                                    <?php else: ?>
                                    <img src="<?php echo base_url(); ?>assets/dashboard/images/user.png" width="30" height="30"><?php endif; ?>
                            </span>
                            <span class="username"><?php echo $school_name ?></span>
                            <b class="caret"></b>
                        </a>
                       

                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="profile"><i class="icon_profile"></i> Account</a>
                            </li>

                            <!--
                            <li>
                                <a href="#"><i class="icon_mail_alt"></i> My Inbox</a>
                            </li>
                            -->
                         
                            <li>
                                <a href="logout"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                            
                          
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
      </header>      
      <!--header end-->