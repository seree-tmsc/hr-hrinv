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
                                    Criteria [ Summary Monthyly Inventory Report ]
                                </div>

                                <div class="panel-body">
                                    <form method="post" action="rpt_SummaryMonthlyInventory.php">
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                <label>Month :</label>
                                                <br>
                                                <select name="cMonth">
                                                    <?php
                                                        $aMonthValue = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                                                        $aMonth = array('01. January', '02. February', '03. March', '04. April', '05. May', '06. June', '07. July', '08. August', '09. September', '10. October', '11. November', '12. December');
                                                        for($nMonth=0; $nMonth<=11; $nMonth++)
                                                        {
                                                            /*
                                                            echo (int)date('m') . "<br>";
                                                            echo $nMonth . "<br>";
                                                            */
                                                            
                                                            if((int)date('m') == $nMonth+1)
                                                            {
                                                                echo "<option value='" . $aMonthValue[$nMonth] . "' selected>" . $aMonth[$nMonth]. "</option>";
                                                            }
                                                            else
                                                            {
                                                                echo "<option value='" . $aMonthValue[$nMonth] . "'>" . $aMonth[$nMonth]. "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Year :</label>
                                                <br>
                                                <select name="cYear">
                                                    <option value="<?php echo date('Y')-1;?>">
                                                        <?php echo date('Y')-1;?>
                                                    </option>
                                                    <option value="<?php echo date('Y');?>" selected>
                                                        <?php echo date('Y');?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <br>
                                                <button type="submit" class="btn btn-success" style="float:right">
                                                    <span>View</span>
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
?>