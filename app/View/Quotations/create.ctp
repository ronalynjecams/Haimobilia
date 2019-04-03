<!--IMPORT SELECT 2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script> 
<div class="content">
    <div class="container">

        <input type="hidden" id="quotation_id" value="<?php echo $quote_data['Quotation']['id']; ?>"> 

        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-5 m-b-20"> 
                    <a href="#" data-quotationid="<?php echo $quote_data['Quotation']['id']; ?>"  data-processtype="save" class="btn btn-info waves-effect waves-light savePendingQuote">Save</a>
                    <a href="#" data-quotationid="<?php echo $quote_data['Quotation']['id']; ?>"  data-processtype="cancelled"  class="btn btn-custom waves-effect waves-light">Cancel</a>
                </div>
                <h4 class="page-title">Create Quotation <small>[<b> <?php if (!is_null($quote_data['Quotation']['quote_number'])) echo $quote_data['Quotation']['quote_number']; ?> </b>]</h4>
            </div>
        </div> 

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box"> 
                    <div class="row"> 
                        <div class="col-lg-6">
                            <h4 class="header-title m-t-0 m-b-30">Quotation Details</h4>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Subject</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control help-block" id="subject" value="<?php if (!is_null($quote_data['Quotation']['subject'])) echo $quote_data['Quotation']['subject']; ?>" >
                                 <!--<span class="help-block"><small>&nbsp;</small></span>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" >Validity Date</label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control help-block" name="date"   id="validity_date" value="<?php if (!is_null($quote_data['Quotation']['validity_date'])) echo $quote_data['Quotation']['validity_date']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" >Shipping Address</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control help-block" name="text"   id="shipping_address" value="<?php if (!is_null($quote_data['Quotation']['shipping_address'])) echo $quote_data['Quotation']['shipping_address']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" >Billing Address</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control help-block" name="text"   id="billing_address" value="<?php if (!is_null($quote_data['Quotation']['billing_address'])) echo $quote_data['Quotation']['billing_address']; ?>" />
                                </div>
                            </div>

                        </div> 

                        <div class="col-lg-6"> 
                            <h4 class="header-title m-t-0 m-b-30">Client Details
                                <a href="#" data-usertype="clients" data-toggle="modal" data-target="#exampleModal"  class="btn btn-default"><i class="fa fa-plus"></i> </a></h4>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Select Client</label>
                                <div class="col-md-10">
                                    <select id="company_id" class="form-control help-block">
                                        <?php if ($quote_data['Quotation']['company_id'] != 0) { ?>
                                            <option value="<?php echo $quote_data['Quotation']['company_id']; ?>"><?php echo $quote_data['Company']['name']; ?></option>
                                            <?php
                                        } else {
                                            echo '<option></option>';
                                        }
                                        foreach ($companies as $client) {
                                            ?>
                                            <option value="<?php echo $client['Company']['id']; ?>"> <?php echo $client['Company']['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <?php if ($quote_data['Quotation']['company_id'] != 0) { ?>
                                <div class="form-group oldInfo">
                                    <div class="col-sm-12">
                                        <label class="col-md-2 control-label">Contact Person</label> 
                                        <div class="col-md-10">
                                            <input type="text" class="form-control help-block" readonly id="contact_person" value="<?php echo $quote_data['Company']['contact_person']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-md-2 control-label">Contact Person</label> 
                                        <div class="col-md-10">
                                            <input type="text" class="form-control help-block" readonly id="contact_number" value="<?php echo $quote_data['Company']['contact_number']; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?> 
                        </div><!-- end col --> 
                    </div><!-- end row -->
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->





        <div class="row">
            <div class="col-sm-12">
                <div class="card-box"> 
                    <div class="row"> 
                        <div class="col-lg-12">
                            <h4 class="header-title m-t-0 m-b-30">
                                Product Details
                                <a href="#" data-toggle="modal" data-target="#addQuotationproductModal"  class="btn btn-default"><i class="fa fa-plus"></i> </a>
                            </h4> 
                            <?php if (count($quote_prods) != 0) { ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>#</th>
                                            <!--<th>Image</th>-->
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Quantity</th>
                                            <th>List Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php 
                                        $ctr = 1;
                                        // pr($quote_prods);
                                        foreach ($quote_prods as $quote_prod) { ?>
                                            <tr>
                                                <td><?php echo $ctr; ?></td> 
                                                <td><?php echo  $quote_prod['Product']['name']; ?></td>
                                                <td>  <?php echo  $quote_prod['QuotationProduct']['description']; ?><?php if($quote_data['Quotation']['status'] == 'pending' || $quote_data['Quotation']['status'] == 'ongoing'){?> <button class="btn btn-default btn-xs update_desc" data-descid="<?php echo $quote_prod['QuotationProduct']['id']; ?>" data-descdata="<?php echo $quote_prod['QuotationProduct']['description']; ?>"><i class="fa fa-edit"></i></button> <?php } ?></td>
                                                <td>
                                                    <input type="number" class="form-control quoted_qty" <?php if($quote_data['Quotation']['status'] != 'pending' && $quote_data['Quotation']['status'] != 'ongoing'){echo 'disabled';} ?> data-qtyid="<?php echo $quote_prod['QuotationProduct']['id']; ?>" value="<?php echo $quote_prod['QuotationProduct']['qty']; ?>">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control quoted_list_price" <?php if($quote_data['Quotation']['status'] != 'pending' && $quote_data['Quotation']['status'] != 'ongoing'){echo 'disabled';} ?> data-listpriceid="<?php echo $quote_prod['QuotationProduct']['id']; ?>" value="<?php echo $quote_prod['QuotationProduct']['list_price']; ?>"  min="1" step="1">
                                                </td> 
                                                <td>
                                                    <input type="number" class="form-control"  id="quoted_total_price" disabled  data-totalpriceid="<?php echo $quote_prod['QuotationProduct']['id']; ?>" value="<?php echo $quote_prod['QuotationProduct']['total_price'] ?>">
                                                </td>  
                                                <td><button class="btn btn-danger btn-xs deleteProduct" data-id="<?php echo $quote_prod['QuotationProduct']['id'] ?>">x</button></td>
                                            </tr>
                                        <?php 
                                        $ctr++;
                                            
                                        }
                                        ?>
                                        
                                        <tr>
                                            <th colspan="4" align="right"> </th> 
                                            <th align="right">Sub Total</th> 
                                            <th> 
                                                <input type="number" class="form-control"  id="subtotal" disabled  value="<?php echo $quote_data['Quotation']['sub_total'] ?>">
                                            </th>
                                            <th></th>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="4" align="right"> </th> 
                                            <th align="right">Discount</th> 
                                            <th> <input type="number" class="form-control"  id="discount"  value="<?php echo $quote_data['Quotation']['discount'] ?>"> </th>
                                            <th></th>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="4" align="right"> </th> 
                                            <th align="right">Delivery</th> 
                                            <th> <input type="number" class="form-control"  id="delivery_amount"  value="<?php echo $quote_data['Quotation']['delivery_amount'] ?>"> </th>
                                            <th></th>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="4" align="right"> </th> 
                                            <th align="right">Installation</th> 
                                            <th> <input type="number" class="form-control"  id="installation_amount"  value="<?php echo $quote_data['Quotation']['installation_amount'] ?>"> </th>
                                            <th></th>
                                        </tr>
                                          
                                        <tr>
                                            <th colspan="4" align="right"> </th> 
                                            <th>Grand Total</th> 
                                            <th> <input type="number" class="form-control" disabled id="grand_total"  value="<?php echo $quote_data['Quotation']['grand_total'] ?>"> </th>
                                            <th></th>
                                        </tr> 
                                    </table>
                                </div>
                                <?php
                            } else {
                                echo 'No Added Product for this Quotation';
                            }
                            ?>

                        </div>  
                    </div>
                </div> 
            </div>
        </div>
        <!-- end row -->
        
        

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box"> 
                    <div class="row"> 
                        <div class="col-lg-12">
                            <h4 class="header-title m-t-0 m-b-30">
                                Terms and Conditions 
                            </h4> 
                            
                            
                                <textarea id="terms" class="form-control"><?php echo $quote_data['Quotation']['terms'];?></textarea>
                            </div> 
                            </div>
                            </div>
                            </div>
                            </div>





        <!-- START MODAL FOR ADD CLIENT--> 
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">New Client</h4>
                    </div> 
                    <?php echo $this->Form->create('Company', array('role' => 'form', 'url' => '/companies/add')); ?> 
                    <div class="modal-body"> 

                        <input type="hidden" id="type" class="form-control" value="clients">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" class="form-control">
                        </div>
                        <div class="form-group"> 
                            <label>Contact Number</label>
                            <input type="text" id="contact_number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input type="text" id="contact_person" class="form-control"> 
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" id="address" class="form-control">  
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" class="form-control">  
                        </div>  
                        <input type="hidden" id="user_id" class="form-control" value="<?php echo $me; ?>">   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                        <button type="button" class="btn btn-primary addCompanyBtn"  >Add</button>    
                    </div> 
                    <?php echo $this->Form->end() ?>
                </div> 
            </div>
        </div>

        <!-- END MODAL FOR ADD CLIENT-->




        <!-- START MODAL FOR ADD PRODUCT--> 
        <div class="modal fade" id="addQuotationproductModal"  role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">Add New Product</h4>
                    </div>  
                    <div class="modal-body">  
                        <div class="col-lg-12">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Product</label>
                                <select class="form-control" id="product_id">
                                    <?php
                                    foreach ($product_lists as $product_list) {
                                        echo '<option value="' . $product_list['Product']['id'] . '">' . $product_list['Product']['name'] . '</option>';
                                    }
                                    ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" id="qty" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>List Price</label>
                                <input type="number" id="list_price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Sale Price</label>
                                <input type="number" id="sale_price" class="form-control">
                            </div>
                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Product Image </label>
                                <div id="productImageDiv"></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-12">
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="description" class="form-control"></textarea>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                            <button type="button" class="btn btn-primary" id="addQuotationProductBtn"  >Add</button>    
                        </div>  
                    </div>  

                </div> 
            </div>
        </div>

        <!-- END MODAL FOR ADD PRODUCT-->

        <!-- START MODAL FOR update PRODUCT--> 
        <div class="modal fade" id="update_desc_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel1">Update Product Description</h4>
                    </div>  
                    <div class="modal-body">   
                        <div class="col-lg-12">
                            
                            <div class="form-group">
                                <label>Description</label>
                                <input type="hidden" id="desc_qp_id"/>
                                <textarea id="udescription" class="form-control"></textarea>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                            <button type="button" class="btn btn-primary" id="update_descBtn"  >Update</button>    
                        </div>  
                    </div>  

                </div> 
            </div>
        </div>

        <!-- END MODAL FOR ADD PRODUCT-->


    </div>
</div>

<script>

// tinymce.init({
//     selector: ".quoted_description",
//     setup: function (ed) {
//         ed.on("change", function () {
//             TinyMceGetStatsLost(ed);
//         })
//     }
// });
// function TinyMceGetStatsLost(inst) {
//     alert("The HTML is now:" + inst.getBody().innerHTML);           
// }
     
    tinymce.init({
        selector: 'textarea',
        height: 100, 
        menubar: false,
        // plugins: [
        //     // 'autolink',
        //     // 'link',
        //     // 'codesample',
        //     // 'lists',
        //     // 'searchreplace visualblocks',
        //     // 'table contextmenu paste code'
        // ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample | link',
    });
</script>

<script>



    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }
    $('.addCompanyBtn').on("click", function () {
        var name = $('#name').val();
        var contact_person = $('#contact_person').val();
        var address = $('#address').val();
        var email = $('#email').val();
        var contact_number = $('#contact_number').val();
        var type = $('#type').val();
        var user_id = $('#user_id').val();


        if ((name != "")) {
            if (contact_person != "") {
                if (address != "") {
                    if (email != "") {
                        if (!validateEmail(email)) {
//                            console.log('invalid');
                            document.getElementById('email').style.borderColor = "red";
                        } else {
//                            console.log('valid'); 
                            if (contact_number != "") {
                                var data = {
                                    "name": name,
                                    "contact_person": contact_person,
                                    "address": address,
                                    "email": email,
                                    "contact_number": contact_number,
                                    "type": type,
                                    "user_id": user_id,
                                }
//                            console.log(data);
                                $.ajax({
                                    url: "/companies/add",
                                    type: 'POST',
                                    data: {'data': data},
                                    dataType: 'json',
                                    success: function (dd) {
                                        location.reload();
                                    },
                                    error: function (dd) {
//                                        location.reload();
                                        console.log(dd);
                                    }
                                });
                            } else {
                                document.getElementById('contact_number').style.borderColor = "red";
                            }
                        }
                    } else {
                        document.getElementById('email').style.borderColor = "red";
                    }
                } else {
                    document.getElementById('address').style.borderColor = "red";
                }
            } else {
                document.getElementById('contact_person').style.borderColor = "red";
            }
        } else {
            document.getElementById('name').style.borderColor = "red";
        }
    });






    $(document).ready(function () { 
        $("#company_id").select2({
            placeholder: "Select Client Name",
            allowClear: true
        }); 
        
        $("#product_id").select2({
            allowClear: true,
            width: "100%",
        });
        
        $("#company_id").select2({
           allowClear: true,
           width: "100%"
        });
    });//end document data







    function saveProcess(data) {
        $.ajax({
            url: "/quotations/saveCreateQuotation",
            type: 'POST',
            data: {'data': data},
            dataType: 'json',
            success: function (dd) {
                // console.log(dd);
                location.reload();
            },
            error: function (dd) {
                console.log(dd);
            }
        });
    }
    ///// CLIENT ///// 
    $("#company_id").change(function () {
        $(".oldInfo").remove();
        $(".cInfo").remove();
        var id = $("#company_id").val();
        $.get('/company/get_company_info', {
            id: id,
        }, function (data) {
            $(".client_info").append('<div class="form-group cInfo">' +
                    '<div class="col-sm-6">' +
                    '<label class="control-label">Contact Person</label>' +
                    '<input type="text" class="form-control" readonly id="ucontact_person" value="' + data['contact_person'] + '">' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                    '<label class="control-label">Contact Number</label>' +
                    '<input type="text" class="form-control" readonly id="ucontact_number" value="' + data['contact_number'] + '">' +
                    '</div>' +
                    '</div>');
        });
        var value = $("#company_id").val();
        var id = $("#quotation_id").val();
        var Qfield = 'company_id';

        var data = {"id": id,
            "value": value,
            "Qfield": Qfield
        }
        saveProcess(data);
    });


    ///// validity_date /////
    $('#validity_date').on('change', function (e) {
        var value = $("#validity_date").val();
        var id = $("#quotation_id").val();
        var Qfield = 'validity_date';

        var data = {"id": id,
            "value": value,
            "Qfield": Qfield
        }
        saveProcess(data);
    });
    
    
    $('#subject').on('change', function (e) {
        var value = $("#subject").val();
        var id = $("#quotation_id").val();
        var Qfield = 'subject';

        var data = {"id": id,
            "value": value,
            "Qfield": Qfield
        }
        saveProcess(data);
    });
    
    $('#shipping_address').on('change', function (e) {
        var value = $("#shipping_address").val();
        var id = $("#quotation_id").val();
        var Qfield = 'shipping_address';

        var data = {"id": id,
            "value": value,
            "Qfield": Qfield
        }
        saveProcess(data);
    });
    
    $('#billing_address').on('change', function (e) {
        var value = $("#billing_address").val();
        var id = $("#quotation_id").val();
        var Qfield = 'billing_address';

        var data = {"id": id,
            "value": value,
            "Qfield": Qfield
        }
        saveProcess(data);
    });



    // function saveSubject() {
    //     var subject = $("#subject").val();
    //     var id = $("#quotation_id").val();
    //     var Qfield = 'subject';

    //     var data = {"id": id,
    //         "value": subject,
    //         "Qfield": Qfield
    //     }

    //     saveProcess(data);
    // }
//    );


//// On change product ///

    $("#product_id").change(function () {
        
            $('#list_price').val();
            $('#sale_price').val();
            $('#description').val();
            $('.addedProductImageDiv').remove();
        var product_id = $('#product_id').val();
        //get details of selected product  
         
        $.get('/products/get_product_info', {
            id: product_id,
        }, function (data) {
            console.log(data);
            $('#list_price').val(data['price']);
            $('#sale_price').val(data['sale_price']);
            // var description = $('#').val(data['description']); 
            // tinyMCE.activeEditor.setContent();
            
            tinymce.get('description').setContent(data['description']);
            
            $("#productImageDiv").append('<div class="form-group addedProductImageDiv">' +
                    '<img class="img-responsive" src="../product_uploads/' + data['image'] + '" width="70%"> </div>' + 
                    '</div>');
        });  
    });
    
    
//    addQuotationProductBtn

    $('#addQuotationProductBtn').on("click", function () {
//    alert('adasd');
    var product_id = $('#product_id').val();
    var qty = $('#qty').val();
    var list_price = $('#list_price').val();
    var sale_price = $('#sale_price').val();
    // var description = $('#description').val();
    var quotation_id = $('#quotation_id').val();
    
    
    var description = tinyMCE.get('description').getContent();
    console.log('=>'+description)
    var data = {
        "product_id": product_id,
        "qty": qty,
        "list_price": list_price,
        "sale_price": sale_price,
        "description": description,
        "quotation_id": quotation_id
    } 
    
    if(list_price!=""){
        if(qty!=""){
            if(sale_price!=""){
                $.ajax({
                    url: "/quotations/saveProductQuotation",
                    type: 'POST',
                    data: {'data': data},
                    dataType: 'json',
                    success: function (dd) {
                        location.reload();
                    },
                    error: function (dd) {
                        console.log(dd);
                    }
                });
            }else{
                document.getElementById('sale_price').style.borderColor = "red";
            }
        }else{
            document.getElementById('qty').style.borderColor = "red";
        }
    }else{
        document.getElementById('list_price').style.borderColor = "red";
    }
    });
    
    
    
    
    
    $(".deleteProduct").each(function(index) {
        $(this).on("click", function(){ 
            var id = $(this).data('id');  
            var quotation_id = $('#quotation_id').val();
            //   console.log('sdfsdf'+id);
    var data = {
        "quotation_product_id": id, 
        "quotation_id": quotation_id
    } 
         swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this product.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {  
                    $.ajax({
                    url: "/quotations/delete_product",
                    type: 'POST',
                    data: {'data': data},
                    dataType: 'text',
                    success: function (dd) {
                        location.reload();
                    },
                    error: function (dd) { 
                        console.log("AJAX error: " + JSON.stringify(dd, null, 2));
                    }
                });
                
                
                } else {
                    swal("Cancelled", "", "error");
                }
            });
            
            
        });
   });
    
    
     

    function saveQuotaionProductProcess(data) {
        $.ajax({
            url: "/quotation_products/saveQuotationProduct",
            type: 'POST',
            data: {'data': data},
            dataType: 'json',
            success: function (dd) {
                location.reload();
            },
            error: function (dd) {
                console.log(dd);
            }
        });
    }
    
    
    
    $(".update_desc").each(function(index) {
        $(this).on("click", function(){    
            // alert('asdasd');
            var descid = $(this).data('descid');  
            var descdata = $(this).data('descdata');  
            $('#desc_qp_id').val(descid);
            tinymce.get('udescription').setContent(descdata); 
            $('#update_desc_modal').modal('show');   
        });
    });
    
    
        $("#update_descBtn").on("click", function(){  
        var quotation_product_id = $('#desc_qp_id').val();
        
        var value = tinyMCE.get('udescription').getContent(); 
        var Qfield = 'description';
        

        var data = {
            "quotation_product_id": quotation_product_id,
            "value": value,
            "Qfield": Qfield
        }
        
        saveQuotaionProductProcess(data);
    });
    
    
    
    
    $(".quoted_qty").each(function(index) {
        $(this).on("change", function(){  
            
                var quotation_product_id = $(this).data('qtyid');  
                var value = parseFloat($(this).val());
                var Qfield = 'qty';
                
            if (value % 1 == 0) {
                // alert('int');
                
        
                var data = {
                    "quotation_product_id": quotation_product_id,
                    "value": value,
                    "Qfield": Qfield
                }
                
                saveQuotaionProductProcess(data);
                
            }else{
                alert('Invalid Quantity!');
            }
    }); 
    });
    $(".quoted_list_price").each(function(index) {
        $(this).on("change", function(){   
         
        var quotation_product_id = $(this).data('listpriceid');  
        var value = parseFloat($(this).val());
        var Qfield = 'list_price';
        

        var data = {
            "quotation_product_id": quotation_product_id,
            "value": value,
            "Qfield": Qfield
        }
        
        saveQuotaionProductProcess(data);
    });
    });
    
    
    function saveComputeQuotationProcess(data) {
        $.ajax({
            url: "/quotations/saveComputeQuotationProcess",
            type: 'POST',
            data: {'data': data},
            dataType: 'json',
            success: function (dd) {
                location.reload();
            },
            error: function (dd) {
                console.log(dd);
            }
        });
    }
    
        $("#discount").on("change", function(){   
         
        var quotation_id = $("#quotation_id").val();  
        var value = $("#discount").val();
        var Qfield = 'discount';
        

        var data = {
            "quotation_id": quotation_id,
            "value": value,
            "Qfield": Qfield
        }
        
        saveComputeQuotationProcess(data);
    });
    
        $("#delivery_amount").on("change", function(){   
         
        var quotation_id = $("#quotation_id").val();  
        var value = $("#delivery_amount").val();
        var Qfield = 'delivery_amount';
        

        var data = {
            "quotation_id": quotation_id,
            "value": value,
            "Qfield": Qfield
        }
        
        saveComputeQuotationProcess(data);
    });
    
        $("#installation_amount").on("change", function(){   
         
        var quotation_id = $("#quotation_id").val();  
        var value = $("#installation_amount").val();
        var Qfield = 'installation_amount';
        

        var data = {
            "quotation_id": quotation_id,
            "value": value,
            "Qfield": Qfield
        }
        
        saveComputeQuotationProcess(data);
    });
    
    
    
    
    
    
    
        $('.savePendingQuote').each(function (index) {
            $(this).click(function () {
                var button_type = $(this).data("buttontype");
                var terms = tinyMCE.get('terms').getContent();
 
                var id = $("#quotation_id").val();  
                    var Qfield = 'terms';
                    var shipping_address = $('#shipping_address').val();
                    var billing_address = $('#billing_address').val();
            
                    var data = {"id": id,
                        "value": terms,
                        "Qfield": Qfield,
                        "shipping_address": shipping_address,
                        "billing_address": billing_address,
                    }
            
                    saveProcess(data);
            });
        });

</script>
