<!DOCTYPE html>
<html lang="en">
    <head>


        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">


        <link rel="icon" type="image/png" sizes="16x16" href="../hai/haimobilia_logo.JPG">
        <!--<title>Haimobilia</title>--> 

        <link href="../hai/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../hai/assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="../hai/assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="../hai/assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="../hai/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="../hai/assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="../hai/assets/css/responsive.css" rel="stylesheet" type="text/css" />
        
        <!--CUSTOMIZED CSS-->
        <link href="../hai/haistyle.css" rel="stylesheet" type="text/css" />

        <script src="../hai/assets/js/modernizr.min.js"></script> 
        <script src="../hai/assets/js/jquery.min.js"></script>
    </head>

    <?php
    if ($authUser) {
        ?>
        <body class="fixed-left">
            <!-- Begin page -->
            <div id="wrapper">
                <?php
                echo $this->Element('topbar');
                echo $this->Element('leftsidebar');
                ?>
                <div class="content-page"> 
                    <?php
                    echo $this->fetch('content');
                    echo $this->Element('rightsidebar');
                    echo $this->Element('footbar');
                    ?>  
                </div> <!-- content -->
            </div> <!-- END wrapper -->
            <script>
                var resizefunc = [];
            </script>

            <!-- jQuery  -->
            <script src="../hai/assets/js/bootstrap.min.js"></script>
            <script src="../hai/assets/js/detect.js"></script>
            <script src="../hai/assets/js/fastclick.js"></script>
            <script src="../hai/assets/js/jquery.slimscroll.js"></script>
            <script src="../hai/assets/js/jquery.blockUI.js"></script>
            <script src="../hai/assets/js/waves.js"></script>
            <script src="../hai/assets/js/wow.min.js"></script>
            <script src="../hai/assets/js/jquery.nicescroll.js"></script>
            <script src="../hai/assets/js/jquery.scrollTo.min.js"></script>

            <!--Morris Chart-->
            <!--<script src="../hai/assets/plugins/morris/morris.min.js"></script>-->
            <!--<script src="../hai/assets/plugins/raphael/raphael-min.js"></script>-->

            <!-- Counter Up  -->
            <script src="../hai/assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
            <script src="../hai/assets/plugins/counterup/jquery.counterup.min.js"></script>

            <!-- Dashboard init -->
            <script src="../hai/assets/pages/jquery.dashboard.js"></script>


            <!-- App js -->
            <script src="../hai/assets/js/jquery.core.js"></script>
            <script src="../hai/assets/js/jquery.app.js"></script>

        </body>
<?php
    } else {
        echo $this->fetch('content');
?>
<?php
    }
?>
    <!-- Mirrored from coderthemes.com/flacto/light_red_2_dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Dec 2017 01:03:45 GMT -->
</html>

