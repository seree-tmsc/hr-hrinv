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
                <?php require_once("pMA_Receive_InsertTrnType1_Modal.php"); ?>

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