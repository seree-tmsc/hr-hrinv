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
                <?php require_once("pMA_Issue_Script.php"); ?>
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

                                include "pMA_Issue_List.php"; 
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Logout Modal-->
                <?php require_once("include/modal_logout.php"); ?>

                <!-- Change Password Modal-->
                <?php require_once("include/modal_chgpassword.php"); ?>                

                <script>
                    //--------------------------
                    // javascript for side-menu
                    //--------------------------
                    $(document).ready(function () {
                        /*
                        $('#myTable').DataTable({
                            paging: false,
                            bFilter: false,
                            ordering: false,
                            searching: true,
                            dom: 't' // This shows just the table
                        });
                        */

                        // Setup - add a text input to each footer cell
                        /*
                        var nColNo = 1;
                        $('#myTable thead th').each( function () 
                            {
                                if(nColNo <= 5)
                                {
                                    var title = $(this).text();
                                    $(this).html( '<input type="text" placeholder="Search '+title+'" style="width:100%;" />' );
                                }
                                nColNo = nColNo + 1;
                            });
                        
                        // DataTable
                        var table = $('#myTable').DataTable();
                        */
                        
                        // Apply the search
                        /*
                        table.columns().every( function () 
                        {
                            var that = this;
                    
                            $( 'input', this.header() ).on( 'keyup change', function () 
                            {
                                if ( that.search() !== this.value ) 
                                {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            });
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
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
        }
    }
?>