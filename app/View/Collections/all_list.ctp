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
				                    <th>Client</th>
				                    <th>Contract Amount</th>
				                    <th>Balance</th>
				                    <th>Action</th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php
				                // foreach($collections as $collection_obj) {
				                //     $collection = $collection_obj['Quotation'];
				                //     $id = $collection['id'];
				                //     $date = date("F d, Y", strtotime($collection['created']));
				                //     $client = $collection_obj['Company'];
				                //     $client_name_tmp = ucwords($client['name']);
				                //     if($client_name_tmp!="") {
				                //         $client_name = $client_name_tmp;
				                //     }
				                //     else {
				                //         $client_name = "No Client.";
				                //     }
				                //     $contract_amount = "₱ ".number_format((float)$collection['grand_total'],2,'.',',');
				                //     $balance = "₱ ".number_format((float)$collection['balance'],2,'.',',');
				                    
				                //     echo '
				                //         <tr>
				                //             <td>'.$date.'</td>
				                //             <td>'.$client_name.'</td>
				                //             <td>'.$contract_amount.'</td>
				                //             <td>'.$balance.'</td>
				                //             <td>
				                //                 <button class="btn btn_info"
				                //                         id="btn_view"
				                //                         value="'.$id.'"
				                //                         data-toggle="tooltip"
				                //                         data-placement="top"
				                //                         title="View Collection">
				                //                     <span class="fa fa-eye"></span>
				                //                 </button>
				                //                 <button class="btn btn_mint"
				                //                         id="btn_update_collection"
				                //                         value="'.$id.'"
				                //                         data-toggle="tooltip"
				                //                         data-placement="top"
				                //                         title="Update Collection">
				                //                     <span class="fa fa-money"></span>
				                //                 </button>
				                //             </td>
				                //         </tr>
				                //     ';
				                // }
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