<?php
    include_once('include/chk_Session.php');
    if($user_email == "")
    {
        echo "<script> 
                alert('Warning! Please Login!'); 
                window.location.href='login.php'; 
            </script>";
    }
    else
    {
?>        
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>HR Inventory System [v.1.0]</title>
                <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />

                <?php require_once("include/library.php"); ?>    
            </head>
            
            <!--<body style='background-color:black;'>-->
            <body>
                <div class="container">
                    <br>

                    <?php require_once("include/submenu_navbar.php"); ?>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    Result of Month Period Closing
                                </div>

                                <div class="panel-body">
                                    <?php include_once('closeMonthPeriodDetail.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout Modal-->
                <?php require_once("include/modal_logout.php"); ?>

                <!-- Change Password Modal-->
                <?php require_once("include/modal_chgpassword.php"); ?>

                <!-- Upload Modal-->
                <?php //require_once("include/modal_upload_customer.php"); ?>

                <script>
                    $(document).ready(function(){
                        /*
                        $('#myTable').dataTable({
                            "order": [[ 0, 'desc' ]],
                            "pageLength": 10
                            });
                        $('#myTable_COA_VF05').dataTable({
                            "order": [[ 0, 'desc' ]],
                            "pageLength": 10
                            });
                        
                        $('#myTable_COA_QcDataHeader').dataTable({
                            "order": [[ 0, 'desc' ]],
                            "pageLength": 5
                            });
                            
                        $('#myTable_COA_QcDataDetail').dataTable({
                            "order": [[ 0, 'desc' ]],
                            "pageLength": 10
                            });
                        */
                    });
                </script>
            </body>
        </html>
<?php
    }
?>