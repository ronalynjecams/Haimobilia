
<!-- DataTables -->
<link href="../hai/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../hai/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Page Content --><div class="content">
    <div class="container">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">List of all <?php echo ucwords($this->params['url']['type']); ?></h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="#" data-usertype="<?php echo $this->params['url']['type']; ?>" data-toggle="modal" data-target="#exampleModal"  class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-plus"></i> Add new <?php echo ucwords($this->params['url']['type']); ?></a>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <!--<h3 class="box-title m-b-0">Data Table</h3>-->
                    <!--<p class="text-muted m-b-30">Data table example</p>-->
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Contact Person</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($companies as $company) { ?>
                                    <tr>
                                        <td><?php echo ucwords($company['Company']['name']); ?></td>
                                        <td><?php echo $company['Company']['contact_number']; ?></td>
                                        <td><?php echo ucwords($company['Company']['contact_person']); ?></td>
                                        <td><?php echo $company['Company']['email']; ?></td>
                                        <td><?php echo ucwords($company['Company']['address']); ?></td>
                                        <td><?php echo ucwords($company['User']['fullname']); ?></td>
                                        <td>
                                            <?php
                                            if ($company['Company']['user_id'] == $me) {
                                                echo '<button class="btn btn-default update_company_btn" data-id="' . $company['Company']['id'] . '"><i class="fa fa-edit"></i></button>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--MODAL FOR ADD-->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">New <?php echo ucwords($this->params['url']['type']); ?></h4>
            </div> 
            <?php echo $this->Form->create('Company', array('role' => 'form', 'url' => '/companies/add')); ?> 
            <div class="modal-body"> 

                <input type="hidden" id="type" class="form-control" value="<?php echo $this->params['url']['type']; ?>">
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


<!--update modal-->

<div class="modal" id="update_modal" role="dialog" tabindex="-2"  aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">New <?php echo ucwords($this->params['url']['type']); ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="update_company_id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="uname" class="form-control">
                </div>
                <div class="form-group"> 
                    <label>Contact Number</label>
                    <input type="text" id="ucontact_number" class="form-control">
                </div>
                <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text" id="ucontact_person" class="form-control"> 
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" id="uaddress" class="form-control">  
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="uemail" class="form-control">  
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                <button type="button" class="btn btn-primary updateCompanyBtn"  >Update</button>  
            </div>  
        </div>
    </div> 
</div>
<!-- Datatables-->
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true});
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
    });
    TableManageButtons.init();

</script>
<script type="text/javascript">

//    $(document).ready(function () {
//        $('#myTable').DataTable();
//
//
//    });



    $(".update_company_btn").each(function () {
        $(this).on("click", function () {
//                alert('asdadsad');exit();
            var id = $(this).data('id'); //this line gets value of data-id from delete button
            $('#update_company_id').val(id); // this line passes the value from data id to modal, to be able to manipulate id of the selected row
            $('#update_modal').modal('show'); // this line shows modal, make sure to assign values first before showing modal


            $.get('/companies/get_company_info', {
                id: id,
            }, function (data) {
                console.log(data['name']);
                $('#uname').val(data['name']);
                $('#ucontact_person').val(data['contact_person']);
                $('#uaddress').val(data['address']);
                $('#uemail').val(data['email']);
                $('#ucontact_number').val(data['contact_number']);
            });


        });
    });




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


    $('.updateCompanyBtn').on("click", function () {
        var name = $('#uname').val();
        var contact_person = $('#ucontact_person').val();
        var address = $('#uaddress').val();
        var email = $('#uemail').val();
        var contact_number = $('#ucontact_number').val();
        var update_company_id = $('#update_company_id').val();

        if ((name != "")) {
            if (contact_person != "") {
                if (address != "") {
                    if (email != "") {

                        if (!validateEmail(email)) {
//                            console.log('invalid');
                            document.getElementById('uemail').style.borderColor = "red";
                        } else {
                            if (contact_number != "") {
                                var data = {"name": name,
                                    "contact_person": contact_person,
                                    "address": address,
                                    "email": email,
                                    "contact_number": contact_number,
                                    "id": update_company_id,
                                }
                                $.ajax({
                                    url: "/companies/update_company_process",
                                    type: 'POST',
                                    data: {'data': data},
                                    dataType: 'json',
                                    success: function (id) {
                                        location.reload();
                                    }
                                });
                            } else {
                                document.getElementById('ucontact_number').style.borderColor = "red";
                            }
                        }
                    } else {
                        document.getElementById('uemail').style.borderColor = "red";
                    }
                } else {
                    document.getElementById('uaddress').style.borderColor = "red";
                }
            } else {
                document.getElementById('ucontact_person').style.borderColor = "red";
            }
        } else {
            document.getElementById('uname').style.borderColor = "red";
        }
    });
</script>

