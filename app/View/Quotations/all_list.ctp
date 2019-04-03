<link href="../hai/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="../hai/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../hai/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="../hai/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="../hai/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
<script src="../hai/assets/plugins/datatables/jszip.min.js"></script>
<script src="../hai/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="../hai/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="../hai/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="../hai/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="../hai/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
<script src="../hai/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
<script src="../hai/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../hai/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="../hai/assets/plugins/datatables/dataTables.scroller.min.js"></script>

<div class="content">
	<div class="container">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title">Quotation List</h4>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box"> 
                    <div class="table-responsive"> 
                        <table id="datatable" class="table table-striped dt-responsive nowrap">
				            <thead>
				                <tr>
				                	<th>Date Created</th>
				                	<th>Company name [Quotation #]</th>
				                	<?php if($userRole != "sales_executive") { ?>
				                	<th>Sales Executive</th>
				                	<?php } ?>
				                	<th>Contract Amount</th>
				                	<th>Collected Amount</th>
				                	<th>Action</th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php
				                foreach($quotations as $quotation) {
				                	$quote = $quotation['Quotation'];
				                	$quote_id = $quote['id'];
				                	$quote_created = date("F d, Y", strtotime($quote['created']));
				                	$company = $quotation['Company'];
				                	$company_name_tmp = $company['name'];
				                	if($company_name_tmp != "") {
				                		$company_name = $company_name_tmp;
				                	}
				                	else {
				                		$company_name = "No Company.";
				                	}
				                	$sales_exe = $quotation['User'];
				                	$sales_exe_name_tmp = ucwords($sales_exe['fullname']);
				                	$sales_exe_username = ucwords($sales_exe['username']);
				                	if($sales_exe_name_tmp != "") {
				                		$sales_exe_name = $sales_exe_name_tmp;
				                	}
				                	else {
				                		if($sales_exe_username!="") {
				                			$sales_exe_name = $sales_exe_username;
				                		}
				                		else {
					                		$sales_exe_name = "No Sales Executive.";
				                		}
				                	}
				                	$contract_amnt = number_format((float)$quote['grand_total'],2,'.',',');
				                	
				                	$paid_amount = 0.000000;
				                	$ewt_amount = 0.000000;
				                	$other_amount = 0.000000;
				                	$col_obj = $cols_obj[$quote_id];
				                	foreach($col_obj as $cols) {
				                		$col = $cols['Collection'];
					                	$paid_amount += $col['paid_amount'];
					                	$ewt_amount += $col['ewt_amount'];
					                	$other_amount += $col['other_amount'];
				                	}
				                	$total_tmp = $paid_amount + $ewt_amount + $other_amount;
				                	$total = number_format((float)$total_tmp,2,'.',',');
				                	?>
				                	<tr>
				                		<td><?php echo $quote_created; ?></td>
				                		<td><?php echo $company_name.'  <small>['.$quote['quote_number'].']</small>'; ?></td>
				                		<?php if($userRole != "sales_executive") {
				                			echo '<td>'.$sales_exe_name.'</td>';
				                		} ?>
				                		<td align="right">	&#8369; <?php echo $contract_amnt; ?></td>
				                		<td align="right">	&#8369; <?php echo $total; ?></td>
				                		<td>
				                			<a href="/collections/view?id=<?php echo $quote_id; ?>">
				                			<button class="btn btn-info"
				                					id="btn_view"
				                					data-toggle="tooltip"
				                					data-placement="top"
				                					title="View Quotation">
				                				<span class="fa fa-eye"></span>
				                			</button>
				                			</a>
				                			
				                			<?php
				                			
				                // 			if($userRole == 'sales_executive' || $userRole == 'sales_manager') {
				                				echo '
				                					<a href="/pdfs/print_quote?id='.$quote_id.'">
				                					<button class="btn btn-default"
				                							data-toggle="tooltip"
				                							data-placement="top"
				                							title="Print Quotation">
				                						<span class="fa fa-file-pdf-o text-danger">
				                						</span>
				                					</button>
				                					</a>
				                				';
				                // 			}
				                			
				                			if($userRole == "sales_executive") {
				                				if($status == "pending") {
				                					echo '
				                					<a href="/quotations/update?id='.$quote_id.'" class="btn btn-warning"
				                							 data-toggle="tooltip"
				                							 data-placement="top"
				                							 title="Update"   >
				                						<span class="fa fa-edit">
				                						</span>
				                					</a>
				                					<button class="btn btn-primary"
				                							 data-toggle="tooltip"
				                							 data-placement="top"
				                							 title="Move"
				                							 id="btn_move"
				                							 data-action="moved"
				                							 value="'.$quote_id.'">
				                						<span class="fa fa-truck">
				                						</span>
				                					</button>
				                					';
				                				}
				                			}
				                			
				                			if($userRole == 'sales_manager'
				                			|| $userRole == 'admin') {
				                				if($status=="moved") {
					                				echo '
					                					<button class="btn btn-success"
					                							 data-toggle="tooltip"
					                							 data-placement="top"
					                							 title="Approve"
					                							 id="btn_approve"
					                							 data-action="approved"
					                							 value="'.$quote_id.'">
					                						<span class="fa fa-check">
					                						</span>
					                					</button>
					                				';
				                				}
				                			}
				                			
				                // 			if($userRole == 'sales_manager') {
				                				if($status == 'approved') {
				                					echo '
					                					<button class="btn btn-danger"
					                							 data-toggle="tooltip"
					                							 data-placement="top"
					                							 title="Process"
					                							 id="btn_process"
					                							 data-action="processed"
					                							 value="'.$quote_id.'">
					                						<span class="fa fa-refresh">
					                						</span>
					                					</button>
					                				';
				                				}
				                // 			}
				                			
				                			if($userRole != 'sales_executive'){
				                					echo '
				                					<a href="/pdfs/print_jo?id='.$quote_id.'" target="_blank">
				                					<button class="btn btn-default"
				                							data-toggle="tooltip"
				                							data-placement="top"
				                							title="Print Job Order">
				                						<span class="fa fa-file-zip-o text-danger">
				                						</span>
				                					</button>
				                					</a>
				                				';
				                			}
				                			?>
				                		</td>
				                	</tr>
				                	<?php
				                }
				                ?>
				            </tbody>
				        </table>
				    </div>
				</div>
			</div>
	    </div>
    </div>
</div>

<!--JAVASCRIPT FUNCTIONS-->
<script type="text/javascript">
    $(document).ready(function () {
    	$("[data-toggle='tooltip']").tooltip();
    	
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true});
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
        
        // "button#btn_approve, button#btn_move, button#btn_process"
        $(document).on('click', function(e) {
        	var target = $(e.target);
        	var button_span = $(e.target).prop('id');
        	var action = "";
        	var isOkay = false;
        	if(button_span!="") {
        		var quote_id = target.val();
	        	action = target.data('action');
	        	var data = {"id":quote_id, "action":action};
	        	isOkay = true;
        	}
        	else {
        		var span = target.prop('nodeName');
        		if(span == "SPAN") {
        			var button = target.closest('button');
        			var quote_id = button.val();
		        	action = button.data('action');
		        	var data = {"id":quote_id, "action":action};
		        	isOkay = true;
        		}
        		else {
        			isOkay = false;
        		}
        	}
			
			if(isOkay) {
	          	swal({
		            title: "Are you sure?",
		            text: "This quotation will be "+action+".",
		            type: "warning",
		            showCancelButton: true,
		            confirmButtonClass: "btn-danger",
		            confirmButtonText: "Yes",
		            cancelButtonText: "No",
		            closeOnConfirm: false,
		            closeOnCancel: true
		        },
		        function (isConfirm) {
		            if (isConfirm) {
				        $.ajax({
		        			url: '/quotations/action',
			        		type: 'POST',
			        		data: {"data": data},
			        		dataType: 'text',
			        		success: function(msg) {
			        			console.log(msg);
			        			swal({
						            title: "Success!",
						            text: "Quotation was "+action+".",
						            type: "success"
						        },
						        function (isConfirm) {
						            if (isConfirm) { location.reload(); }
						        });
			        		},
			        		error: function(error) {
			        			console.log("Error: "+error);
			        			swal({
						            title: "Oops!",
						            text: "Something went wrong while quotation was being "+action+". Please try again.",
						            type: "warning"
						        });
			        		}
			        	});	
		            }
		        });
			}
        });
    });
    TableManageButtons.init();
</script>
<!--END OF JAVASCRIPT FUNCTIONS-->