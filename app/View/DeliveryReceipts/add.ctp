<!--SWEET ALERT-->
<link href="../css/sweetalert.css" rel="stylesheet">
<script src="../js/sweetalert.min.js"></script>

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
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<select class="form-control" id="select_quotation">
									<option>--- Select Quotation ---</option>
									<?php
									foreach($quotations as $quotation) {
										$quote = $quotation['Quotation'];
										$quote_id = $quote['id'];
										$quote_number = $quote['quote_number'];
										
										echo '<option value="'.$quote_id.'">'.$quote_number.'</option>';
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<input type="date" class="form-control" id="input_date"
									   placeholder="Delivery Date" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<select class="form-control" id="select_type">
									<option>--- Select Type ---</option>
									<option value="transportify">Transportify</option>
									<option value="jecams">Jecams</option>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<input type="number" step="any" id="input_amount"
									   placeholder="Amount" class="form-control"
									   onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="number" step="any" id="input_booking_code"
									   class="form-control" placeholder="Booking Code"
									   onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" />
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<button class="btn btn-info" id="btn_add">
							<span class="fa fa-plus"></span>
							Add
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--JAVASCRIPT FUNCTIONS-->
<script>
$(document).ready(function() {
	$("#btn_add").on('click', function() {
		var quotation = $("#select_quotation");
		var dr_number = $("#input_dr_number");
		var date = $("#input_date");
		var type = $("#select_type");
		var amount = $("#input_amount");
		var booking_code = $("#input_booking_code");
		
		if(quotation.val()!="--- Select Quotation ---") {
			if(date.val()!="") {
				if(type.val()!="--- Select Type ---") {
					if(amount.val()!="") {
						if(booking_code.val()!="") {
							var data = {"quotation": quotation.val(),
										"date": date.val(),
										"type": type.val(),
										"amount": amount.val(),
										"booking_code": booking_code.val()};
										
							$.ajax({
								url: '/delivery_receipts/create',
								type: 'POST',
								data: {'data': data},
								dataType: 'text',
								success: function(id) {
									console.log(id);
									// location.reload();
								},
								error: function(error) {
									console.log("Error in delivery_receipts: "+error);
									swal({
		                                title: "Error!",
		                                text: "Something went wrong with creating Delivery Receipts. Please try again.",
		                                type: "warning",
		                                confirmButtonClass: "btn-danger",
		                                confirmButtonText: "Okay",
		                                closeOnConfirm: false,
		                            });
								}
							});
						}
						else {
							booking_code.css({'border-color':'red'});
						}
					}
					else {
						amount.css({'border-color':'red'});
					}
				}
				else {
					type.css({'border-color':'red'});
				}
			}
			else {
				date.css({'border-color':'red'});
			}
		}
		else {
			// change to sweet alert later on
			quotation.css({'border-color':'red'});
		}
	});
});
</script>
<!--END OF JAVASCRIPT FUNCTIONS-->