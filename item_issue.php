<?php
    /*
    echo $_POST['fromDate'];
    echo $_POST['toDate'];
    */

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
        if($user_user_type == "A" || $user_user_type == "P")
        {
?>        
        <!DOCTYPE html>
        <html>
            <head>                
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>TMSC TPDT System V.1.0</title>
                <link rel="icon" type="image/png"  href="images/tmsc-logo-64x32.png">

                <?php require_once("include/library.php"); ?>
            </head>
            
            <!--<body style='background-color:black;'>-->
            <body style='background-color:LightSteelBlue;'>
                <div class="container">
                    <br>
                    <?php require_once("include/submenu_navbar.php"); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                            <!--<h5>User Data:</h5>-->
                            <?php
                                $dFromDate = $_POST['fromDate'];
                                $dToDate = $_POST['toDate'];

                                include "item_issue_list.php"; 
                            ?>
                        </div>
                    </div>
                </div>              

                <script>
                    //--------------------------
                    // javascript for side-menu
                    //--------------------------
                    $(document).ready(function () {
                        $('.issue_data').click(function(){
                            var request_no = $(this).attr("request_no");
                            var request_line = $(this).attr("request_line");

                            var lConfirm = confirm("Do you want to issue this item?");

                            if (lConfirm)
                            {                
                                $.ajax({
                                    url: "item_issue_change_status.php",
                                    method: "post",
                                    data: {request_no: request_no, request_line: request_line},
                                    success: function(data){
                                        alert(data);
                                        location.reload();
                                    },
                                    error: function(){
                                        alert("Error ... ! " + data);
                                    }
                                });
                            }
                        })
                    });
                </script>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
        }
    }
?>