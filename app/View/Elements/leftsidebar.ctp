 <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                        	<li class="text-muted menu-title">Navigation</li>

                            <li class="has_sub">
                                <a href="/users/dashboard" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i> <span> Dashboard </span> </a>
                            </li>
                            <li class="has_sub">
                                <a href="/companies/all_list?type=clients" class="waves-effect"><i class="fa fa-user-md"></i> <span> Clients </span> </a>
                            </li>
                            <li class="has_sub">
                                <a href="/companies/all_list?type=suppliers" class="waves-effect"><i class="fa fa-leanpub"></i> <span> Suppliers </span> </a>
                            </li>  
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-file-pdf-o"></i> <span> Quotations </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <?php // if($userRole == 'sales_executive'){?>
                                        <li> <a href="/quotations/create">Create</a> </li>
                                    <?php //} ?>
                                    <li><a href="/quotations/all_list?status=pending">Pending</a></li>
                                    <li><a href="/quotations/all_list?status=ongoing">Ongoing</a></li>
                                    <li><a href="/quotations/all_list?status=moved">Moved </a></li>
                                    <li><a href="/quotations/all_list?status=approved">Approved</a></li>
                                    <li><a href="/quotations/all_list?status=processed">Processed</a></li> 
                                </ul>
                            </li>
                            
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-object-group"></i> <span> Collection </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="/collection/all_list?status=pending">Pending</a></li>
                                    <li><a href="/collection/all_list?status=accomplished">Accomplished</a></li> 
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa-file-powerpoint-o"></i> <span> Products </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="/products/create">Create</a></li>
                                    <li><a href="/products/list">List</a></li> 
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="widgets.html" class="waves-effect"><i class="zmdi zmdi-layers"></i> <span> Employees </span> </a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-text"></i><span class="label label-default pull-right">6</span><span> Purchase Orders </span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="form-elements.html">Pending </a></li>
                                    <li><a href="form-advanced.html">Processed</a></li> 
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-view-list"></i> <span> Delivery Schedules  </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                	<li><a href="tables-basic.html">Pending</a></li>
                                    <li><a href="tables-datatable.html">Approved</a></li>
                                    <li><a href="tables-editable.html">Scheduled</a></li>
                                    <li><a href="tables-editable.html">Delivered</a></li>
                                </ul>
                            </li>
                            <!--DELIVERY RECIEPTS-->
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-text"></i><span class="label label-default pull-right">6</span><span> Delivery Receipts </span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="/delivery_receipts/add">Create </a></li>
                                    <li><a href="/delivery_receipts/all_list?status=pending">Pending</a></li> 
                                    <li><a href="/delivery_receipts/all_list?status=delivered">Delivered</a></li> 
                                    <li><a href="/delivery_receipts/all_list?status=cancelled">Cancelled</a></li> 
                                    <li><a href="/delivery_receipts/all_list?status=rescheduled">Rescheduled</a></li> 
                                </ul>
                            </li>
                            <!--END OF DELIVERY RECIEPTS-->
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-chart"></i><span> Payment Requests </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="chart-flot.html">Flot Chart</a></li>
                                    <li><a href="chart-morris.html">Morris Chart</a></li>
                                    <li><a href="chart-chartist.html">Chartist Charts</a></li>
                                    <li><a href="chart-other.html">Other Chart</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-map"></i><span> Maps </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="map-google.html">Google Maps</a></li>
                                    <li><a href="map-vector.html">Vector Maps</a></li>
                                </ul>
                            </li>

                            <li class="text-muted menu-title">More</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-item"></i><span class="label label-default pull-right">8</span><span> Pages </span></a>
                                <ul class="list-unstyled">
                                	<li><a href="page-starter.html">Starter Page</a></li>
                                    <li><a href="page-timeline.html">Timeline</a></li>
                                    <li><a href="page-login.html">Login</a></li>
                                    <li><a href="page-register.html">Register</a></li>
                                    <li><a href="page-recoverpw.html">Recover Password</a></li>
                                    <li><a href="page-lock-screen.html">Lock Screen</a></li>
                                    <li><a href="page-confirm-mail.html">Confirm Mail</a></li>
                                    <li><a href="page-404.html">Error 404</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-share"></i><span> Multi Level </span> <span class="menu-arrow"></span></a>
                                <ul>
                                    <li class="has_sub">
                                        <a href="javascript:void(0);" class="waves-effect"><span>Menu Level 1.1</span> <span class="menu-arrow"></span></a>
                                        <ul style="">
                                            <li><a href="javascript:void(0);"><span>Menu Level 2.1</span></a></li>
                                            <li><a href="javascript:void(0);"><span>Menu Level 2.2</span></a></li>
                                            <li><a href="javascript:void(0);"><span>Menu Level 2.3</span></a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><span>Menu Level 1.2</span></a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
			<!-- Left Sidebar End -->
