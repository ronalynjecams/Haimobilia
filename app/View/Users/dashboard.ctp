<?php if($userRole=='admin') { ?>
<!-- Start content -->
<!--Morris Chart CSS -->
<link rel="stylesheet" href="../hai/assets/plugins/morris/morris.css">
<div class="content">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <ul class="nav nav-pills nav-pills-custom display-xs-none pull-right">
                    <li role="presentation"><a href="#">Today</a></li>
                    <li role="presentation" class="active"><a href="#">Yesterday</a></li>
                    <li role="presentation"><a href="#">Last Week</a></li>
                </ul>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <h4 class="header-title m-t-0">Daily Sales</h4>
                    <div class="row text-center m-t-30">
                        <div class="col-xs-6">
                            <h3 data-plugin="counterup">8,459</h3>
                            <p class="text-muted text-overflow">Total Sales</p>
                        </div>
                        <div class="col-xs-6">
                            <h3 data-plugin="counterup">584</h3>
                            <p class="text-muted text-overflow">Open Compaign</p>
                        </div>
                    </div>
                    <div class="text-center m-t-10">
                        <div id="morris-donut-example" style="height: 245px;"></div>
                        <ul class="list-inline chart-detail-list m-b-0">
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #da5461;"></i>Series A</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #fe8995;"></i>Series B</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <h4 class="header-title m-t-0">Statistics</h4>
                    <div class="row text-center m-t-30">
                        <div class="col-xs-4">
                            <h3 data-plugin="counterup">1,507</h3>
                            <p class="text-muted text-overflow">Total Sales</p>
                        </div>
                        <div class="col-xs-4">
                            <h3 data-plugin="counterup">916</h3>
                            <p class="text-muted text-overflow" title="Open Compaign">Open Compaign</p>
                        </div>
                        <div class="col-xs-4">
                            <h3 data-plugin="counterup">22</h3>
                            <p class="text-muted text-overflow">Daily Sales</p>
                        </div>
                    </div>
                    <div id="morris-bar-example" style="height: 280px;" class="m-t-10"></div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <h4 class="header-title m-t-0">Total Revenue</h4>
                    <div class="row text-center m-t-30">
                        <div class="col-xs-6">
                            <h3 data-plugin="counterup">7,653</h3>
                            <p class="text-muted text-overflow">Total Sales</p>
                        </div>
                        <div class="col-xs-6">
                            <h3 data-plugin="counterup">852</h3>
                            <p class="text-muted text-overflow">Open Compaign</p>
                        </div>
                    </div>
                    <div id="morris-line-example" style="height: 280px;" class="m-t-10"></div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        
        <div class="row" onload="sales_per_agent()">
            <?php foreach($users as $user){
                echo '
                <div class="col-lg-3 col-md-6">
                    <div class="card-box widget-user">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <div class="row">
                                    <img src="../hai/assets/images/users/7.png"
                                         class="img-responsive img-circle"
                                         alt="user">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <p>Sales for '.date('F').' '.date('Y').'
                                <br/>&#8369; <font id="sales_month'.$user['User']['id'].'">0.00</font></p>
                                <p>Sales for '.date('Y').'
                                <br/>&#8369; <font id="sales_year'.$user['User']['id'].'">0.00</font></p>
                            </div>
                        </div>
                        <div>
                            <div>
                                <h4 class="m-t-0 m-b-5">'.$user['User']['fullname'].'</h4>
                                <a style="padding-left:15px;" href="/pdfs/earnings?id='.$user['User']['id'].'" target="_blank">View Status</a>
                            </div>
                        </div>
                    </div>
                </div>';
            } ?>
            
            <!-- TOTAL-->
            <?php
            $timeline_arr = ['month', 'year'];
            foreach($timeline_arr as $timeline) {
                if($timeline == "month"): $timeline_txt = "Sales for ".date('F')." ".date('Y');
                elseif($timeline == "year"): $timeline_txt = "Sales for ".date('Y'); endif;
                echo "
                    <div class='col-lg-3 col-md-6'>
                        <div class='card-box widget-user'>
                                <h5>$timeline_txt</h5>
                                <p>&#8369; ".number_format((float)$$timeline, 2, '.', ',')."</p>";
                                
                                if($userRole=="admin"):
                                    echo '<div align="right">
                                            <button class="btn btn-info" id="view_total" data-timeline="'.$timeline.'">View</button>
                                          </div>';
                                endif;
                            echo "</div>
                        </div>
                    </div>";
            } ?>
            <!--END OF TOTAL-->
        </div>
        <!-- end row -->
    </div>
    <!-- end row -->
</div>
<!-- container -->
</div>
<!-- content -->
<!-- ============================================================== -->
<!-- End  content here -->
<!-- ============================================================== -->

<!--JAVASCRIPT FUNCTIONS-->
<script type="text/javascript">
function sales_per_agent() {
    $.ajax({
        url: '/users/get_sales_per_agent/',
        type: 'GET',
        success: function (success) {
            console.log(success);
            var data_arr = JSON.parse(success);
            var month = data_arr['month'];
            var year = data_arr['year'];

            var users = JSON.parse('<?php echo json_encode($users); ?>');
            for(var i=0;i<users.length;i++) {
                var user_id = users[i]['User']['id'];
                if(month[user_id][0][0]['monthly_total']!=null) {
                    var monthly_total = month[user_id][0][0]['monthly_total'];
                    $("#sales_month"+user_id).text(parseFloat(monthly_total).toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                }
                if(year[user_id][0][0]['yearly_total']!=null) {
                    var yearly_total = year[user_id][0][0]['yearly_total'];
                    $("#sales_year"+user_id).text(parseFloat(yearly_total).toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                }
            }
        },
        error: function (error) {
            console.log(error);
            alert("Oops! An error occured. Please try again later.");
        }
    });
}

$(function(){
	$('div[onload]').trigger('onload');
});
$(document).ready(function() {
    $("button#view_total").on('click', function() {
        var timeline = $(this).data('timeline');
        window.open('/pdfs/sales/'+timeline, '_blank');
    });
});
</script>
<!--END OF JAVASCRIPT FUNCTIONS-->
<?php
} else { echo '<div class="content"><div class="container">This is a restricted area. Please contact System Administrator.</div></div>'; }
?>