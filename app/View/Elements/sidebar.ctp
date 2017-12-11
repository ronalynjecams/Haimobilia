
<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div><img src="../plugins/images/users/varun.jpg" alt="user-img" class="img-circle"></div>
                <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Steave Gection <span class="caret"></span></a>
                <ul class="dropdown-menu animated flipInY">
                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="login.html"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                    </span> </div>
                <!-- /input-group -->
            </li>
            <!--<li class="nav-small-cap m-t-10">--- Main Menu</li>-->
            <li> <a href="/users/dashboard" class="waves-effect active"><i class="fa fa-home" data-icon="v"></i> <span class="hide-menu"> Dashboard  </a></li>
            <li> <a href="/companies/all_list?type=clients" class="waves-effect active"><i class="fa fa-users" data-icon="v"></i> <span class="hide-menu"> Clients  </a></li>
            <li> <a href="/companies/all_list?type=suppliers" class="waves-effect active"><i class="fa fa-users" data-icon="v"></i> <span class="hide-menu"> Suppliers  </a></li>
            <!--<li> <a href="/quotations/create" class="waves-effect active"><i class="fa fa-users" data-icon="v"></i> <span class="hide-menu"> Quotations  </a></li>-->

            <li> <a href="#" class="waves-effect active"><i class="fa fa-file-pdf-o" data-icon="v"></i> <span class="hide-menu"> Quotations <span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <?php // if($userRole == 'sales_executive'){?>
                    <li> <a href="/quotations/create">Create</a> </li>
                    <?php //} ?>
                    <li> <a href="index2.html">Demographical</a> </li>
                    <li> <a href="index3.html">Analitical</a> </li>
                    <li> <a href="index4.html">Simpler</a> </li>
                </ul>
            </li>
            <li> <a href="index.html" class="waves-effect active"><i class="fa fa-users" data-icon="v"></i> <span class="hide-menu"> Purchase Orders  </a></li>
 
            <li><a href="login.html" class="waves-effect"><i class="icon-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
            <!--                    <li class="nav-small-cap">--- Support</li>
                                <li><a href="documentation.html" class="waves-effect"><i class="fa fa-circle-o text-danger"></i> <span class="hide-menu">Documentation</span></a></li>
                                <li><a href="gallery.html" class="waves-effect"><i class="fa fa-circle-o text-info"></i> <span class="hide-menu">Gallery</span></a></li>
                                <li><a href="faq.html" class="waves-effect"><i class="fa fa-circle-o text-success"></i> <span class="hide-menu">Faqs</span></a></li>-->
        </ul>
    </div>
</div>
