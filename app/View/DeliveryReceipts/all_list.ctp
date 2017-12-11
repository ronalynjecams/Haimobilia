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
				<h4 class="page-title">Delivery Receipt List</h4>
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
                                    <th>Company Name</th>
                                    <th>DR Number</th>
                                    <th>DR Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($drs as $dr_obj) {
                                    $dr = $dr_obj['DeliveryReceipt'];
                                    $dr_created = date("F d, Y", strtotime($dr['created']));
                                    $dr_quotation_id = $dr['quotation_id'];
                                    $dr_number = $dr['dr_number'];
                                    $dr_type = ucwords($dr['dr_type']);
                                    
                                    $company = $companies[$dr_quotation_id]['Company'];
                                    $company_name_tmp = ucwords($company['name']);
                                    if($company_name_tmp!="") {
                                        $company_name = $company_name_tmp;
                                    }
                                    else {
                                        $company_name = "No company.";
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $dr_created; ?></td>
                                        <td><?php echo $company_name; ?></td>
                                        <td><?php echo $dr_number; ?></td>
                                        <td><?php echo $dr_type; ?></td>
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
<script>
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