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
        if($user_user_type == "A" or $user_user_type == "P")
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
                                    Criteria [ Issue Date ]
                                </div>

                                <div class="panel-body">
                                    <!--<form method="post" action="pMA_Issue.php" target="_blank">-->
                                    <form method="post" action="item_issue.php">
                                        <div class="form-group">
                                            <div class="col-lg-6">
                                                <label>Due Date From :</label>
                                                <input type="date" name = 'fromDate' class='form-control' value='<?php echo date('Y-m-d')?>'>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Due Date To :</label>
                                                <input type="date" name = 'toDate' class='form-control' value='<?php echo date('Y-m-d')?>'>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button type="submit" style="float: right; margin:2px;" class="btn btn-success">
                                                    <span class="fa fa-check fa-lg">&nbsp&nbsp&nbspOK</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator'); window.location.href='pMain.php'; </script>";
        }
    }
?>