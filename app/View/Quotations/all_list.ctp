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
				<h4 class="page-title">Create Delivery Receipts</h4>
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
				                	<th>Company name</th>
				                	<?php if($role != "sales_executive") { ?>
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
				                	$quote_created = $quote['created'];
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
				                	$contract_amnt = "₱ ".number_format((float)$quote['grand_total'],2,'.',',');
				                	?>
				                	<tr>
				                		<td><?php echo $quote_created; ?></td>
				                		<td><?php echo $company_name; ?></td>
				                		<?php if($role != "sales_executive") {
				                			echo '<td>'.$sales_exe_name.'</td>';
				                		} ?>
				                		<td><?php echo $contract_amnt; ?></td>
				                		<td>--- UNDER CONSTRUCTION ---</td>
				                		<td>
				                			<button class="btn btn-info"
				                					id="btn_view"
				                					data-toggle="tooltip"
				                					data-placement="top"
				                					title="View Quotation">
				                				<span class="fa fa-eye"></span>
				                			</button>
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
    });
    TableManageButtons.init();

</script>
<!--END OF JAVASCRIPT FUNCTIONS-->