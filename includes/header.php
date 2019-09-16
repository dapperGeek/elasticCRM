
   <!-- <div id="loading-wrapper">
        <div id="loader"></div>
    </div> -->
    <header class="clearfix">
        <div class="logo">
            <img src="<?php echo $host;?>img/logo.png" alt="Logo">
        </div>

        <div class="pull-right">
            <ul id="header-actions" class="clearfix">
              <!--  <li class="list-box dropdown">
                    <a id="drop10" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><span class="info-label">4</span> <i class="icon-circle-check info-icon text-warning"></i></a>

                    <div class="dropdown-menu">
                        <section class="todo">
                            <fieldset class="todo-list">
                                <label class="todo-list-item">
                                    <input type="checkbox" class="todo-list-cb"><span class="todo-list-mark"></span>
                                    <span class="todo-list-desc">Fix UI Bug</span> <small class="scheduled">Scheduled for 24th Dec, Assigned to Shawn.</small>
                                </label>

                                <label class="todo-list-item">
                                    <input type="checkbox" class="todo-list-cb"><span class="todo-list-mark"></span>
                                    <span class="todo-list-desc">Send all Documents</span> <small class="scheduled">Scheduled for 24th Dec, Assigned to Leena.</small>
                                </label>

                                <label class="todo-list-item">
                                    <input type="checkbox" class="todo-list-cb"> <span class="todo-list-mark"></span>
                                    <span class="todo-list-desc">Attend Wedding Party</span> <small class="scheduled">Scheduled on 10th Dec, Assigned to Mark.</small>
                                </label>

                                <label class="todo-list-item">
                                    <input type="checkbox" class="todo-list-cb" checked="checked"> <span class="todo-list-mark"></span>
                                    <span class="todo-list-desc">Meet Mr.James</span> <small class="scheduled">Completed on 5th Dec, Assigned to Robin.</small>
                                </label>

                                <label class="todo-list-item">
                                    <input type="checkbox" class="todo-list-cb overdue" checked="checked"> <span class="todo-list-mark"></span>
                                    <span class="todo-list-desc">Read Turning Points</span> <small class="scheduled">Overdue 12 days, Assigned to Wincy.</small>
                                </label>
                            </fieldset>
                        </section>
                    </div>
                </li>
                <li class="list-box dropdown">
                    <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><span class="info-label">7</span> <i class="icon-notifications_active info-icon text-success"></i></a>
                    <ul class="dropdown-menu imp-notify">
                        <li>
                            <div class="thumb"><img src="img/user4.png" alt="Admin Dashboard"></div>
                            <div class="details"><strong>Wilson Kewis</strong>
                                <p>The best dashboard design I have ever seen. Good luck with sales.</p><small class="date">Today at 10:10 pm - 21.12.2016</small></div>
                        </li>
                        <li>
                            <div class="thumb"><img src="img/user7.png" alt="Admin Dashboard"></div>
                            <div class="details"><strong>Justin Mezzell</strong>
                                <p>To keep your account secure, we need to revalidate your account.</p><small class="date">3 days ago at 2:30 pm</small></div>
                        </li>
                        <li>
                            <div class="thumb"><img src="img/user1.png" alt="Admin Dashboard"></div>
                            <div class="details"><strong>Shawn Ankith</strong>
                                <p>Contact you via phone with support for recent purchases and product information.</p><small class="date">7 days ago at 5:15 pm</small></div>
                        </li>
                    </ul>
                </li>   -->

                <li class="list-box user-admin dropdown">
                    <div class="admin-details">
                        <div class="name"><?php echo $myData['fullname'];?></div>
                        <div class="designation"><?php echo $myData['designation'];?></div>
                    </div>

                  <a id="drop4" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-account_circle"></i></a>

                    <ul class="dropdown-menu sm">
                        <li class="dropdown-content">
                            <!--<a href="#"><i class="icon-warning2"></i>Update Password<br><span>Your password will expire in 7 days.</span></a>-->
                            <a href="profile.html">Edit Profile</a>
                            <a href="forgot-pwd.html">Change Password</a>
                            <!--<a href="validations.html">Settings</a>-->
                            <a href="<?php echo $host;?>Logout">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

       <!-- <a href="<?php echo $host;?>" class="support">Support</a>
        <div class="custom-search">
            <input type="text" class="search-query" placeholder="Search here ..."> <i class="icon-search4"></i></div>          -->

    </header>

    <div class="container-fluid">
    <?php if(isset($headcheck) && $headcheck == 1){?>
             <div class="dashboard-wrapper-full">
    <?php }else{ ?>
        <div class="dashboard-wrapper">
        <?php }?>
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li><a href="<?php echo $host;?>"><i class="icon-home2"></i>Dashboard</a></li>

                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-notification2"></i>Administrative <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $host;?>view-machine">View Machines</a></li>
                                <li><a href="<?php echo $host;?>view-account">View Accounts</a></li>
                                <li> -----------------------------</li>
                                 <li><a href="<?php echo $host;?>add-account">Add New Account</a></li>
                                <li><a href="<?php echo $host;?>add-machine">Add New Machine</a></li>

                                <!--<li><a href="calendar.html">Calendar</a></li>
                                <li><a href="profile.html">Profile</a></li>
                                <li><a href="invoice.html">Invoice</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="pricing.html">Pricing Plans</a></li>
                                <li><a href="gallery.html">Gallery</a></li>
                                <li><a href="timeline.html">Timeline</a></li>-->
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-location3"></i>Contracts <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                             <!-- <li><a href="c3-graphs.html">C3 Graphs</a></li>
                                  <li><a href="maps.html">Maps</a></li>
                                <li><a href="flot.html">Flot Graphs</a></li>
                                <li><a href="morris-graphs.html">Morris Graphs</a></li>
                                <li><a href="vector-maps.html">Vector Maps</a></li>-->
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-browser"></i>PM Call <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <!--   <li><a href="form-inputs.html">Form Inputs</a></li>
                               <li><a href="validations.html">Validations</a></li>
                                <li><a href="editor.html">Editors</a></li>-->
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-image2"></i>Service Call <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $host;?>service-call">Make a Call</a></li>
                                <li><a href="<?php echo $host;?>follow-up">Follow-Up Call</a></li>
                                <li><a href="<?php echo $host;?>view-service-call">View Service Call</a></li>
                               <!-- <li><a href="components.html">Components</a></li>
                                <li><a href="modals.html">Modals</a></li>
                                <li><a href="labels-badges.html">Labels &amp; Badges</a></li>
                                <li><a href="spinners.html">Spinners</a></li>
                                <li><a href="notifications.html">Notifications</a></li>
                                <li><a href="progressbars.html">Progress Bars</a></li>
                                <li><a href="icons.html">Icons</a></li>
                                <li><a href="typography.html">Typography</a></li>
                                <li><a href="custom-panels.html">Panels</a></li>
                                <li><a href="custom-drag.html">Drag &amp; Drop</a></li>
                                <li><a href="custom-grid.html">Grid</a></li>
                                <li><a href="default.html">Default Layout</a></li>
                                <li><a href="layout-full.html">Layout Without Sidebar</a></li>-->
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-new-message"></i>Billing <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-error_outline"></i>Statistics <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="login.html">Login</a></li>
                                <li><a href="signup.html">Sign Up</a></li>
                                <li><a href="lock-screen.html">Lock Screen</a></li>
                                <li><a href="forgot-pwd.html">Forgot Password</a></li>
                                <li><a href="error.html">Page Not Found</a></li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
