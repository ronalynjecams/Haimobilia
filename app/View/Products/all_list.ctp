
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
                <h4 class="page-title">List of all Products</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
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
                                    <th>Image</th> 
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Sale Price</th> 
                                    <th>Update</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product) { ?>
                                    <tr>
                                        <td><?php echo '<img class="img-responsive" src="../product_uploads/' . $product['Product']['image'] . '" width="100" height="100">'; ?></td>
                                        <td><?php echo $product['Product']['name']; ?></td>
                                        <td><?php echo ucwords($product['Product']['description']); ?></td>
                                        <td><?php echo $product['Product']['price']; ?></td>
                                        <td><?php echo ucwords($product['Product']['sale_price']); ?></td> 
                                        <td><a href="/products/update?id=<?php echo $product['Product']['id']; ?>" class="btn btn-success"><i class="fa fa-update"></i>Update</a></td> 
                                        
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

