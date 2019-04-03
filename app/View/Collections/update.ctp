<div class="content">
    <div class="container">

        <input type="hidden" id="quotation_id" value="<?php echo $quote_data['Quotation']['id']; ?>"> 
        <input type="hidden" id="userrole" value="<?php echo $userRole; ?>"> 

        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-5 m-b-20"> 
                
                </div>
                <h4 class="page-title">Collection Details for <small>[<b> <?php if (!is_null($quote_data['Quotation']['quote_number'])) echo $quote_data['Quotation']['quote_number']; ?> </b>]</h4>
            </div>
        </div> 
        
        <div class="row">
            <div class="col-sm-4">
                <div class="card-box"> 
                
                <div class="form-group">
                    <label>Payment Mode</label>
                    <select id="type" class="form-control">
                        <option ></option>
                        <option value="cash">cash</option>
                        <option value="cheque">cheque</option>
                        <option value="online">online</option>
                    </select>
                </div>
                
                <div class="form-group" id="paid_amount_div">
                    <label>Amount</label>
                    <input type="number" class="form-control" id="paid_amount"> 
                </div>
                
                <div class="form-group" id="amounts_div">
                    <label>EWT Amount</label>
                    <input type="number" class="form-control" id="ewt_amount"> 
                    <label>Other Amount</label>
                    <input type="number" class="form-control" id="other_amount"> 
                </div>
                
                <div class="form-group" id="cheque_div">
                    <label>Cheque Number</label>
                    <input type="number" class="form-control" id="cheque_number"> 
                    <label>Cheque Date</label>
                    <input type="date" class="form-control" id="cheque_date"> 
                </div>
                <div class="form-group" id="bank_div">
                    <label>Bank</label>
                    <select id="bank_id" class="form-control">
                        <option value=""></option> 
                        <?php foreach ($banks as $bank) {
                            echo '<option value="'.$bank['Bank']['id'].'">'.$bank['Bank']['name'].'</option> ';
                        } ?>
                    </select>
                </div>
                
                    <button data-processtype="save" class="btn btn-info waves-effect waves-light saveCollection">Save</button> 
                </div>
                
                
                
            </div>
            <div class="col-sm-8">
                <div class="card-box"> 
                
							<div class="table-responsive">
		                        <table  class="table table-striped dt-responsive nowrap">
						            <thead>
						                <tr>
						                	<th>Date Created</th>
						                	<th>Type</th>
						                	<th>Amount Paid</th>
						                	<th>EWT Amount</th>
						                	<th>Other</th>
						                	<th>Cheque/Bank Details</th>
						                	<th>Action</th>
						                </tr>
						            </thead>
						            <tbody>
						                <?php foreach ($collection_data as $collection) {
						                    echo '
						                    <tr>
						                	<td>'.date("F d, Y", strtotime($collection['Collection']['created'])).'</td>
						                	<td>'.$collection['Collection']['type'].'</td>
						                	<td>&#8369; '.number_format($collection['Collection']['paid_amount'],2).'</td>
						                	<td>&#8369; '.number_format($collection['Collection']['ewt_amount'],2).'</td>
						                	<td>&#8369; '.number_format($collection['Collection']['other_amount'],2).'</td> 
						                	<td>';
						                	if($collection['Collection']['type'] == 'cheque'){
						                	    echo '<p>Cheque #: '.$collection['Collection']['cheque_number'].'</p>';
						                	    echo '<p>Cheque Date: '.date("F d, Y", strtotime($collection['Collection']['cheque_date'])).'</p>';
						                	    echo '<p>Bank: '.$collection['Bank']['name'].'</p>';
						                	}
						                	if($collection['Collection']['type'] == 'online'){
						                	    echo '<p>Bank: '.$collection['Bank']['name'].'</p>';
						                	}
						                	echo'</td>
						                	<td>';
						                	    if($collection['Collection']['status']=="void") {
				            						echo 'Void';
				            					}
				            					elseif ($collection['Collection']['status']=="verified") {
				            						echo 'Verified';
				            					}
				            					else {
				            					    if($userRole == "sales_manager" || $userRole == "admin") {
				            					        echo '
        						                	    <button class="btn btn-success"
        						                	            id="btn_verify"
        						                	            data-toggle="tooltip"
        						                	            data-placement="top"
        						                	            title="Verify"
        						                	            data-action="verified"
        						                	            value="'.$collection['Collection']['id'].'">
        						                	        <span class="fa fa-check">
        						                	    </button>
        						                	    <button class="btn btn-danger"
        						                	            id="btn_void"
        						                	            data-toggle="tooltip"
        						                	            data-placement="top"
        						                	            title="Void"
        						                	            data-action="void"
        						                	            value="'.$collection['Collection']['id'].'">
        						                	        <span class="fa fa-close">
        						                	    </button>';
				            					    }
				            					    else {
				            					        echo ucwords($collection['Collection']['status']);
				            					    }
				            					}
						                	echo '</td>
						                	</tr>';
        						              //  	void
        						              //verified
						                	//if status == newest || unverified; sales_manager could void or verified
						                	
						                } ?>
						            </tbody> 
						            </table>
                            </div>
                </div>
            </div>
        </div>
        
<script> 
$(document).ready(function () { 
    $(".saveCollection").prop("disabled",true);
    $("#paid_amount_div").hide();
    $("#amounts_div").hide();
    $("#bank_div").hide();
    $("#cheque_div").hide(); 
    
    $("#type").change(function () {
        var type = $(this).val();
        
        if(type == 'cash'){ 
            $("#paid_amount_div").show();
            $("#amounts_div").show();
            $("#bank_div").hide();
            $("#cheque_div").hide(); 
            $(".saveCollection").prop("disabled",false);
        }else if(type == 'cheque'){ 
            $("#paid_amount_div").show();
            $("#amounts_div").hide();
            $("#bank_div").show();
            $("#cheque_div").show(); 
            $(".saveCollection").prop("disabled",false);
        }else if(type == 'online'){ 
            $("#paid_amount_div").show();
            $("#amounts_div").show();
            $("#bank_div").show();
            $("#cheque_div").hide(); 
            $(".saveCollection").prop("disabled",false);
        } 
    });
    
    $("button#btn_verify, #btn_void").on('click', function() {
        var col_id = $(this).val();
        var action = $(this).data('action');
        var data = {"id": col_id, "action":action};
        
        swal({
	            title: "Are you sure?",
	            text: "This Collection will be "+action+".",
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
	        			url: '/collections/action',
		        		type: 'POST',
		        		data: {"data": data},
		        		dataType: 'text',
		        		success: function(msg) {
		        			console.log(msg);
		        			swal({
					            title: "Success!",
					            text: "Collection was "+action+".",
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
					            text: "Something went wrong while Collection was being "+action+". Please try again.",
					            type: "warning"
					        });
		        		}
		        	});	
	            }
	        });
    });
});

$('.saveCollection').on("click", function () { 
    var paid_amount = $("#paid_amount").val();
    var ewt_amount = $("#ewt_amount").val();
    var other_amount = $("#other_amount").val();
    var cheque_date = $("#cheque_date").val();
    var cheque_number = $("#cheque_number").val();
    var bank_id = $("#bank_id").val();
    var type = $("#type").val();
    var quotation_id = $("#quotation_id").val();
    
    var data = {
        "paid_amount":paid_amount,
        "ewt_amount":ewt_amount,
        "other_amount":other_amount,
        "cheque_date":cheque_date,   
        "cheque_number":cheque_number,   
        "bank_id":bank_id,    
        "type":type,
        "quotation_id":quotation_id,
    }
    
     
    if(type == 'cash'){ 
        if(paid_amount==""){
            document.getElementById('paid_amount').style.borderColor = "red"; 
        }else{
            if(ewt_amount==""){
            document.getElementById('ewt_amount').style.borderColor = "red"; 
            }else{
                if(other_amount==""){
                document.getElementById('other_amount').style.borderColor = "red"; 
                }else{
                    //process
                    process_payment(data);
                }
                
            }
        }
    }else if(type == 'cheque'){ 
        if(paid_amount==""){
                document.getElementById('paid_amount').style.borderColor = "red"; 
        }else{
            if(cheque_date==""){
                document.getElementById('cheque_date').style.borderColor = "red"; 
            }else{
                if(cheque_number==""){
                    document.getElementById('cheque_number').style.borderColor = "red"; 
                }else{
                    if(bank_id==""){
                        document.getElementById('bank_id').style.borderColor = "red"; 
                    }else{
                        //process
                    process_payment(data);
                    }       
                }     
            }
        }
        
    }else if(type == 'online'){ 
        if(paid_amount==""){
            document.getElementById('paid_amount').style.borderColor = "red"; 
        }else{ 
            if(ewt_amount==""){
                document.getElementById('ewt_amount').style.borderColor = "red"; 
            }else{ 
                if(other_amount==""){
                    document.getElementById('other_amount').style.borderColor = "red"; 
                }else{ 
                    if(bank_id==""){
                        document.getElementById('bank_id').style.borderColor = "red"; 
                    }else{ 
                        //process
                    process_payment(data);
                    } 
                }  
            }  
        }  
    } 
     
});

function process_payment(data){ 
    
    $(".saveCollection").prop("disabled",true);
    $.ajax({
        url: "/collections/processpayment",
        type: 'POST',
        data: {'data': data},
        dataType: 'text',
        success: function (dd) {
            if(dd == 'success'){
                var userrole = $("#userrole").val();
                if(userrole == 'sales_executive'){
                    window.location.href = '/quotations/all_list?status=moved';
                }else{
                    location.reload();
                } 
            } else{
                // alert('An error occured');
                console.log(dd);
            }
        },
        error: function (dd) {
            console.log(dd);
        }
    });
}
</script>