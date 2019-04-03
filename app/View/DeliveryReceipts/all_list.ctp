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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($drs as $dr_obj) {
                                    $dr = $dr_obj['DeliveryReceipt'];
                                    $dr_id = $dr['id'];
                                    $dr_created = date("F d, Y", strtotime($dr['created']));
                                    $dr_quotation_id = $dr['quotation_id'];
                                    $dr_number = $dr['dr_number'];
                                    $dr_type = ucwords($dr['dr_type']);
                                    
                                    $company_name = "No company.";
                                    if(!empty($companies[$dr_quotation_id]['Company'])) { 
                                        $company = $companies[$dr_quotation_id]['Company'];
                                        $company_name_tmp = ucwords($company['name']);
                                        if($company_name_tmp!="") {
                                            $company_name = $company_name_tmp;
                                        }
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $dr_created; ?></td>
                                        <td><?php echo $company_name; ?></td>
                                        <td><?php echo $dr_number; ?></td>
                                        <td><?php echo $dr_type; ?></td>
                                        <td>
                                            <a href="/pdfs/print_dr?id=<?php echo $dr_id; ?>">
                                                <button class="btn btn-default"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Print DR">
                                                    <span class="fa fa-file-powerpoint-o text-danger">
                                                    </span>
                                                </button>
                                            </a>
                                            <?php
                                            if($userRole == "sales_manager" ||
                                                $userRole == "admin") {
                                                    
                                                if($status == "pending") {
                                                    echo '
                                                    <button class="btn btn-warning"
                                                            data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="Deliver"
                                                            id="btn_deliver"
                                                            data-action="delivered"
                                                            value="'.$dr_id.'">
                                                        <span class="fa fa-truck">
                                                        </span>
                                                    </button>
                                                    
                                                    <button class="btn btn-danger"
                                                            data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="Cancel"
                                                            id="btn_cancel"
                                                            data-action="cancelled"
                                                            value="'.$dr_id.'">
                                                        <span class="fa fa-close">
                                                        </span>
                                                    </button>
                                                    ';
                                                    
                                                    echo '<button class="btn btn-default update_booking_btn" data-id="' . $dr_id . '"><i class="fa fa-edit"></i></button>';
                                                }
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

<!--update modal-->

<div class="modal" id="update_modal" role="dialog" tabindex="-2"  aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Update Booking Code</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="update_dr_id">
                
						<div class="col-lg-6">
							<div class="form-group">
							    <label>Type</label>
								<select class="form-control" id="utype">
									<option>--- Select Type ---</option>
									<option value="transportify">Transportify</option>
									<option value="jecams">Jecams</option>
									<option value="pickup">Pickup</option>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
							    <label>Amount</label>
								<input type="number" step="any" id="uamount"
									   placeholder="Amount" class="form-control"
									   onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
							    <label>Booking Code</label>
								<input type="number" step="any" id="ubooking_code"
									   class="form-control" placeholder="Booking Code"
									   onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" />
							</div>
						</div>
                <!--<div class="form-group">-->
                <!--    <label>Booking Code</label>-->
                <!--    <input type="text" id="ubooking_code" class="form-control">-->
                <!--</div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                <button type="button" class="btn btn-primary updateBookingBtn"  >Update</button>  
            </div>  
        </div>
    </div> 
</div>
<!--JAVASCRIPT FUNCTIONS-->
<script>
    $(document).ready(function () {
        
    $(".update_booking_btn").each(function () {
        $(this).on("click", function () {
//                alert('asdadsad');exit();
            var id = $(this).data('id'); //this line gets value of data-id from delete button
            $('#update_dr_id').val(id); // this line passes the value from data id to modal, to be able to manipulate id of the selected row
            $('#update_modal').modal('show'); // this line shows modal, make sure to assign values first before showing modal


            $.get('/delivery_receipts/get_info', {
                id: id,
            }, function (data) { 
                $('#ubooking_code').val(data['booking_code']);
                $('#utype').val(data['dr_type']);
                $('#uamount').val(data['amount']);
            });


        });
    });
    
    $('.updateBookingBtn').on("click", function () {
        var ubooking_code = $('#ubooking_code').val(); 
        var utype = $('#utype').val(); 
        var uamount = $('#uamount').val(); 
        var dr_id = $("#update_dr_id").val();

        if ((utype != "")) { 
            var data = {
                "ubooking_code": ubooking_code,
                "utype": utype,
                "uamount": uamount,
                "dr_id": dr_id
            }
                                $.ajax({
                                    url: "/delivery_receipts/update_booking_process",
                                    type: 'POST',
                                    data: {'data': data},
                                    dataType: 'json',
                                    success: function (id) {
                                        location.reload();
                                    }
                                });
                            } else {
                                document.getElementById('utype').style.borderColor = "red";
                            }
                    
    });
    
    
        
    	$("[data-toggle='tooltip']").tooltip();
    	
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true});
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
    
        $("button#btn_cancel, button#btn_deliver").on('click', function() {
            var id = $(this).val();
            var action = $(this).data('action');
            var data = {"id":id, "action":action};
            
            swal({
	            title: "Are you sure?",
	            text: "This Delivery Receipt will be "+action+".",
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
	        			url: '/delivery_receipts/action',
		        		type: 'POST',
		        		data: {"data": data},
		        		dataType: 'text',
		        		success: function(msg) {
		        			console.log(msg);
		        			swal({
					            title: "Success!",
					            text: "Delivery Receipt was "+action+".",
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
					            text: "Something went wrong while Delivery Receipt was being "+action+". Please try again.",
					            type: "warning"
					        });
		        		}
		        	});	
	            }
	        });
        });
    });
    TableManageButtons.init();
    
    

</script>
<!--END OF JAVASCRIPT FUNCTIONS-->