
<div class="text-center logo-alt-box">
    <a href="" class="logo">Haimobilia</a>
    <!--<h5 class="text-muted m-t-0">Responsive Admin Dashboard</h5>-->
</div>

<div class="wrapper-page">

    <div class="m-t-30 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">Sign In</h4>
        </div>
        <div class="panel-body"> 
            <?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form-horizontal m-t-10')); ?>

                <div class="form-group ">
                    <div class="col-xs-12"> 
                    <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'Username', 'label' => false)); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                    <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'label' => false)); ?>
                    </div>
                </div>

<!--                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-custom">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>

                    </div>
                </div>-->

                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <!--<button class="btn btn-custom btn-bordred btn-block waves-effect waves-light text-uppercase" type="submit">Log In</button>-->
                    <?php echo $this->Form->submit(__('Login'), array('class' => 'btn btn-custom btn-bordred btn-block waves-effect waves-light text-uppercase')); ?>
                    </div>
                </div>

<!--                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="page-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>-->


<!--                <div class="form-group m-t-20 m-b-0">
                    <div class="col-sm-12 text-center"><h4>Sign In with</h4></div>
                </div>-->

<!--                <div class="form-group m-b-0 text-center">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-facebook waves-effect waves-light m-t-20"><i
                                class="fa fa-facebook m-r-5"></i> Facebook
                        </button>
                        <button type="button" class="btn btn-twitter waves-effect waves-light m-t-20"><i
                                class="fa fa-twitter m-r-5"></i> Twitter
                        </button>
                        <button type="button" class="btn btn-googleplus waves-effect waves-light m-t-20"><i
                                class="fa fa-google-plus m-r-5"></i> Google+
                        </button>
                    </div>
                </div>-->

            
            <?php echo $this->Form->end() ?>

        </div>
    </div>
    <!-- end card-box -->

<!--    <div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-muted">Don't have an account? <a href="page-register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
        </div>
    </div>-->

</div>
<!-- end wrapper page -->
<script>
    $( document ).ready(function() {
    $("body").removeClass("fixed-left");
//    $("div").removeClass("wrapper");
$('div#wrapper').removeAttr('id');
    $("div").removeClass("content-page");
//    $("document").removeClass("fixed-left");
//   document.querySelector('body').classList.remove('fixed-left');
//   document.querySelector('div').classList.remove('wrapper');
//   document.querySelector('div').classList.remove('content-page');
   
//   $( "#wrapper" ).hide();
//   $( ".content-page" ).hide();
    });
</script>