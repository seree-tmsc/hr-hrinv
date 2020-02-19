<?php
    echo $_POST['items'];

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
                <?php //require_once("pMA_Receive_Script.php"); ?>
            </head>
            
            <!--<body style='background-color:black;'>-->
            <body style='background-color:LightSteelBlue;'>
                <div class="container">
                    <br>
                    <?php require_once("include/submenu_navbar.php"); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-inline">                    
                                <div class="pull-right">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#insert_modal">
                                        <span class="glyphicon glyphicon-plus"></span> 
                                        Insert
                                    </button>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                            <!--<h5>User Data:</h5>-->
                            <?php
                                /*
                                $dFromDate = $_POST['fromDate'];
                                $dToDate = $_POST['toDate'];
                                */
                                //echo $_POST['items'];
                                include "pMA_Receive_List.php";
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Modal - Insert Record -->
                <div class="modal fade" id="insert_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog role="document">
                    <!--<div class="modal-dialog modal-lg" role="document">-->
                        <div class="modal-content">
                            <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Insert Mode: [Insert by <?php echo $user_emp_code;?>]</h4>
                            </div>
                            
                            <form class="form-horizontal" role="form" id='insert-form' method='post'>
                                <div class="modal-body" id="insert_detail">
                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <label style="display: block; text-align: center;">PO Date:</label>
                                            <input type="date" name='paramPo_Date' class='form-control' value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label style="display: block; text-align: center;">PO No.:</label>
                                            <input style="text-align: right;" type="text" name='paramPo_No' class='form-control' required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label style="display: block; text-align: center;">Trn.Type:</label>
                                            <input style="text-align: center;" type="text" class='form-control' value="+" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-10">
                                            <label style="display: block; text-align: center;">Item Code:</label>
                                            <input type="text" class='form-control' value="<?php echo $_POST['items']; ?>" disabled>
                                            <input type="hidden" name='paramItem_Code' value="<?php echo $_POST['items']; ?>">
                                            <input type="hidden" name='paramEmp_Code' value="<?php echo $user_emp_code; ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label style="display: block; text-align: center;">Qty:</label>
                                            <input type="number" name='paramQty' class='form-control' value=1 required>
                                        </div>
                                    </div>                    
                                </div>                        
                                
                                <div class="modal-footer">
                                    <button type="submit" id='insert' class="btn btn-success">Insert</button>
                                    <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>            
                        </div>
                    </div>
                </div>

                <script>
                    //--------------------------
                    // javascript for side-menu
                    //--------------------------
                    $(document).ready(function () {
                        /*-------------------------------------------------------------------------------------------*/
                        /* when submit id=insert-form from modal form then call ajax to run Insert.php  */
                        /*-------------------------------------------------------------------------------------------*/
                        $("#insert-form").submit(function(event) {
                            alert('You click insert button');

                            /* stop form from submitting normally */
                            event.preventDefault();
                            
                            console.log( $( this ).serialize() );
                            $.ajax({
                                url: "pMA_Receive_InsertTrnType1.php",
                                method: "post",
                                data: $('#insert-form').serialize(),
                                beforeSend:function(){
                                    $('#insert').val('Insert...')
                                },
                                success: function(data){
                                    if (data == '')
                                    {
                                        $('#insert-form')[0].reset();
                                        $('#insert_modal').modal('hide');
                                        location.reload();
                                    }
                                    else
                                    {
                                        alert(data);
                                        location.reload();
                                    }
                                }
                            });
                        });


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