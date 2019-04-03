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
		<?php
			if(!empty($quotes_obj)) {
				$cli = $quotes_obj['Company'];
				$quote = $quotes_obj['Quotation'];
				$user = $quotes_obj['User'];
				$cols = $quotes_obj['Collection'];
				if(!empty($drs_obj)) {
					$drs = $drs_obj['DeliveryReceipt'];
					
					if($drs['dr_type']!="") {
						$dr_type = ucwords($drs['dr_type']);
					}
					else { $dr_type = "<font style='color:red'>Not Specified</font>"; }
					
					if($drs['delivery_date']!=null) {
						$delivery_date = date("F d, Y", strtotime($drs['delivery_date']));
					}
					else { $delivery_date = "<font style='color:red'>Not Specified</font>"; }
				}
				
				$shipping_address = "";
				if($quote['shipping_address']!="") {
					$shipping_address = ucwords($quote['shipping_address']);
				}
				
				$billing_address = "";
				if($quote['billing_address']!="") {
					$billing_address = ucwords($quote['billing_address']);
				}
				
				$address_tmp = $shipping_address." ".$billing_address;
				if($address_tmp!="") {
					$address = $address_tmp;
				}
				else { $address = "<font style='color:red'>Not Specified</font>"; }
				
				$grand_total = "₱ ".number_format((float)$quote['grand_total'],2,'.',',');
				
				$bal = 0.000000;
				foreach($cols as $col) {
					$bal += $col['balance'];
					$balance = "₱ ".number_format((float)$bal,2,'.',',');
				}
				
				$client_name_tmp = $cli['name'];
				
				if($client_name_tmp!=null) { $client_name = ucwords($client_name_tmp); }
				else { $client_name = "<font style='color:red'>Not Specified</p>"; }
				
				if($cli['contact_person']!="") {
					$contact_person = ucwords($cli['contact_person']);
				}
				else { $contact_person = "<font style='color:red'>Unknown</font>"; }
				
				if($cli['contact_number']!="") {
					$contact_number = $cli['contact_number'];
				}
				else { $contact_number = "<font style='color:red'>Not Specified</font>"; }
				
				if($cli['email']!="") {
					$email = $cli['email'];
				}
				else { $email = "<font style='color:red'>Not Specified</font>"; }
				
				$quote_number = "";
				if($quote['quote_number']!=null) {
					$quote_number = $quote['quote_number'];
				}
				
				if($quote['subject']!="") {
					$subject = ucfirst($quote['subject']);
				}
				else {
					$subject = "<font style='color:red'>No Subject</font>";
				}
				
				if($quote['status']!="") { $status = $quote['status']; }
				else { $status = "<font style='color:red'>Undefined</font>"; }
				
				$created_by_tmp = ucwords($user['fullname']);
				if($created_by_tmp != "") { $created_by = $created_by_tmp; }
				else {
					if($user['username']!="") {
						$created_by = $user['username'];
					}
					else {
						$created_by = "<font style='color:red'>Unknown</font>";
					}
				}
				
				if($quote['created']!=null) {
					$date_created = date("F d, Y", strtotime($quote['created']));
				}
				else { $date_created = "<font style='color:red'>Not Specified</font>"; }
				
				if($quote['validity_date']!=null) {
					$val_date = date("F d, Y", strtotime($quote['validity_date']));
				}
				else { $val_date = "<font style='color:red'>Not Specified</font>"; }
				?>
				
				<div class="row bg-title">
					<h4 class="page-title">
						<div class="col-lg-6">
							<?php echo $client_name; ?>
						</div>
						<div class="col-lg-6" align="right">
							<?php echo $quote_number; ?>
							<?php if($quote['status'] == 'processed'){ ?>
								&nbsp;&nbsp;<a href="/collections/update?id=<?php echo $quote['id']; ?>" class="btn btn-xs btn-info">Update Collection</a>
							<?php } ?>
							<?php if($quote['status'] == 'pending' && $userRole == "sales_executive"){ ?>
								&nbsp;&nbsp;<a href="/collections/update?id=<?php echo $quote['id']; ?>" class="btn btn-xs btn-info">Move to Purchasing</a>
								&nbsp;&nbsp;<a href="/quotations/update?id=<?php echo $quote['id']; ?>" class="btn btn-xs btn-primary">Update</a>
							<?php  
							}?>
								<?php if($quote['status'] != 'pending' && $userRole != "sales_executive"){ ?>
								<!--&nbsp;&nbsp;<a href="/collections/update?id=<?php echo $quote['id']; ?>" class="btn btn-xs btn-info">Move to Purchasing</a>-->
								&nbsp;&nbsp;<a href="/quotations/update?id=<?php echo $quote['id']; ?>" class="btn btn-xs btn-primary">Update</a>
							<?php  
							}
							elseif($userRole != "sales_executive"){?>
								&nbsp;&nbsp;<a href="/collections/update?id=<?php echo $quote['id']; ?>" class="btn btn-xs btn-info">Collect</a>
						<?php } ?>
						</div>
					</h4>
				</div>
				
				<div class="row">
					<div class="col-lg-6">
						<div class="card-box">
							
							<h5>Quotation Information</h5>
								<div class="row">
									<div class="col-lg-12">
										<div class="col-lg-6">
											<p>
												<font style="font-weight:bold">Subject:</font>
												<?php echo $subject; ?>
											</p>
											<p>
												<font style="font-weight:bold">Status:</font>
												<?php echo $status; ?>
											</p>
											<p>
												<font style="font-weight:bold">Created By:</font>
												<?php echo $created_by; ?>
											</p>
										</div>
										<div class="col-lg-6">
											<p>
												<font style="font-weight:bold">Date Created:</font>
												<?php echo $date_created; ?>
											</p>
											<p>
												<font style="font-weight:bold">Validity Date:</font>
												<?php echo $val_date; ?>
											</p>
										</div>
									</div>
								</div>
								
							<p style="font-weight:bold">Client</p>
								<div class="row">
									<div class="col-lg-12">
										<div class="col-lg-6">
											<p>
												<font style="font-weight:bold">Contact Person:</font>
												<?php echo $contact_person; ?>
											</p>
											<p>
												<font style="font-weight:bold">Contact Number:</font>
												<?php echo $contact_number; ?>
											</p>
										</div>
										<div class="col-lg-6">
											<p>
												<font style="font-weight:bold">Email Address:</font>
												<?php echo $email; ?>
											</p>
										</div>
									</div>
								</div>
						</div>
					</div>
					
					<?php if(!empty($col)) { ?>
					<div class="col-lg-6">
						<div class="card-box">
							<h5>Collection Details</h5>
							<div class="row">
								<div class="col-lg-12" > 
								<div class="col-lg-6" > 
									<p align="left" style="font-weight:bold">
										Total Contract Price:
									</p> 
								<div  align="left">
									<p style="padding-left:50px"><?php echo $grand_total; ?></p>
									<?php if($balance == 0){?>
									<p class="text-danger" style="font-weight:bold"> Balance </p>
									<p style="padding-left:50px" class="text-danger">
										<?php echo $balance; ?>
									</p>
									<?php } ?>
								</div> 
								</div> 
							</div>
						</div>
					</div>
					</div>
					<?php } ?>
					
					<?php if(!empty($drs_obj)) { ?>
					<div class="col-lg-6">
						<div class="card-box">
							<h5>Delivery / Billing Info</h5>
							<div class="row">
								<div class="col-lg-12">
									<div class="col-lg-6">
										<p>
											<font style="font-weight:bold">
												Delivery Mode:
											</font>
											<?php echo $dr_type; ?>
										</p>
										<p>
											<font style="font-weight:bold">
												Billing and Shipping Address:
											</font>
										</p>
										<?php echo $address; ?>
									</div>
									<div class="col-lg-6">
										<p>
											<font style="font-weight:bold">
												Tentative Delivery or Pickup Date:
											</font>
											<?php echo $delivery_date; ?>	
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					
					<div class="col-lg-12">
						<div class="card-box">
							<h5>Products Info</h5>
							<div class="table-responsive">
		                        <table  class="table table-striped dt-responsive nowrap">
						            <thead>
						                <tr>
						                	<th>#</th>
						                	<th>Product Name</th>
						                	<th>Description</th>
						                	<th>Quantity</th>
						                	<th>List Price</th>
						                	<th>Total Price</th>
						                </tr>
						            </thead>
						            
						            <tbody>
							            <?php
							            $count = 0;
							            foreach($quote_prods as $quote_prod_obj) {
							            	$count++;
								            $quote_prod = $quote_prod_obj['QuotationProduct'];
								            $product = $quote_prod_obj['Product'];
								            
								            if($product['name']!="") {
								            	$name = ucwords($product['name']);
								            }
								            else {
								            	$name = "<font style='color:red'>Not Specified</font>";
								            }
								            
								            if($product['description']!="") {
								            	$des = ucfirst($product['description']);
								            }
								            else {
								            	$des = "<font style='color:red'>No Description</font>";
								            }
								            
								            echo '
								            	<tr>
								            		<td>'.$count.'</td>
								            		<td>'.$name.'</td>
								            		<td>'.$des.'</td>
								            		<td>'.$quote_prod_obj['QuotationProduct']['qty'].'</td>
								            		<td>&#8369; '.$quote_prod_obj['QuotationProduct']['list_price'].'</td>
								            		<td>&#8369; '.$quote_prod_obj['QuotationProduct']['total_price'].'</td>
								            	</tr>
								            ';
							            }
						            	?>
						            	
						            	 <tr>
                                            <td colspan="4" align="right"> </td> 
                                            <td align="right">Sub Total</td> 
                                            <td align="right"> &#8369; <?php echo number_format($quotes_obj['Quotation']['sub_total'],2); ?>  </td>
                                           
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="4" align="right"> </td> 
                                            <td align="right">Discount</td>
                                            <td align="right">&#8369; <?php echo number_format($quotes_obj['Quotation']['discount'],2);?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="4" align="right"> </td> 
                                            <td align="right">Delivery</td> 
                                            <td align="right">&#8369; <?php echo number_format($quotes_obj['Quotation']['delivery_amount'],2); ?> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="4" align="right"> </td> 
                                            <td align="right">Installation</td> 
                                            <td align="right"> &#8369; <?php echo number_format($quotes_obj['Quotation']['installation_amount'],2); ?>  </td>
                                            
                                        </tr>
                                          
                                        <tr>
                                            <td colspan="4" align="right"> </td> 
                                            <td>Grand Total</td> 
                                            <td align="right">&#8369;  <?php echo number_format($quotes_obj['Quotation']['grand_total'],2);?>  </td> 
                                        </tr> 
						            </tbody>
						        </table>
						    </div>
						</div>
					</div>
				</div>
		<?php
			}
			else {
				echo "<h4>Quotation Not Found.</h4>";
			}
		?>
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