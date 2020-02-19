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
        if($user_user_type == "A" || $user_user_type == "P")
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
            <body style='background-color:LightSteelBlue;'>
                <!-- Begin Body page -->
                <div class="container">
                    <br>
                    <!-- Begin Static navbar -->
                    <?php require_once("include/submenu_navbar.php"); ?>
                    <!-- End Static navbar -->

                    <!-- Begin content page-->
                    <!-- ----------------------------------- -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-inline">
                                <div class="pull-right">
                                    <button class="btn btn-info" data-toggle="modal" data-target="#export_modal">
                                        <span class="fa fa-cloud-download"></span> 
                                        Export To CSV File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                            <!--<h5>User Data:</h5>-->
                            <?php include "user_request_all_lst_detail.php"; ?>
                        </div>
                    </div>
                    <!-- ----------------------------------- -->
                    <!-- End content page -->
                </div>  
                <!-- End Body page -->

                <!-- Modal - Export To CSV File -->
                <div class="modal fade" id="export_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Generate CSV File</h4>
                            </div>
                            <div class="modal-body">

                            <?php
                                include_once('include/db_Conn.php');

                                $strSql = "SELECT * ";
                                $strSql .= "FROM TRN_Request R ";
                                $strSql .= "JOIN MAS_Item I ON I.item_code = R.item_code ";
                                $strSql .= "JOIN MAS_Category C ON C.category_code = I.category_code ";
                                $strSql .= "WHERE MONTH(R.due_date) = " . $_POST['cMonth'] . " AND YEAR(R.due_date)=" . $_POST['cYear'] . " " ;
                                $strSql .= "ORDER BY R.enter_date, R.request_no, R.request_line ";
                                //echo $strSql . "<br>";

                                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $statement->execute();  
                                $nRecCount = $statement->rowCount();
                                //echo $nRecCount . " records <br>";

                                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $statement->execute();  
                                $nRecCount = $statement->rowCount();

                                if ($nRecCount > 0)
                                {
                                    $dataArray = array();
                                    
                                    $rowArray = array("Req_Date", "Req_No", "Req_Line", "Category_Code", "Category_Name", "Item_Code", "Item_Name", "UOM", "Quantity", "Req_By", "Status", "Due_Date");

                                    array_push($dataArray, $rowArray);
                                    while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                                    {
                                        $rowArray = array(date('Y-m-d', strtotime($ds["enter_date"][0])),
                                                        $ds["request_no"],
                                                        $ds["request_line"],
                                                        $ds["category_code"][0],
                                                        $ds["category_name"],
                                                        $ds["item_code"][0],
                                                        $ds["item_name"],
                                                        $ds["unit"],
                                                        $ds["quantity"],
                                                        $ds["request_by"],
                                                        $ds["issue_status"],
                                                        date('Y-m-d', strtotime($ds["due_date"][0])));                                                        
                                        array_push($dataArray, $rowArray);
                                    };

                                    $fileName = "tmpUserRequestData.csv";
                                    $fp = fopen('tmpuserRequestData.csv', 'w');
                                    //for support Thai 
                                    fputs($fp,(chr(0xEF).chr(0xBB).chr(0xBF)));

                                    foreach ($dataArray as $fields) {
                                        fputcsv($fp, $fields);        
                                    }

                                    fclose($fp);
                                    echo "<br>Generate CSV File Done.<br><a href=$fileName>Download</a>";
                                }
                                else
                                {

                                }
                            ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                                
                <script>
                    //------------
                    // javascript 
                    //------------
                    $(document).ready(function () {
                        /*
                        $('#inv_list_Table').DataTable({
                            paging: false,
                            bFilter: false,
                            ordering: true,
                            searching: true,
                            dom: 't' // This shows just the table
                        });

                        // Setup - add a text input to each footer cell
                        var nColNo = 1;
                        $('#inv_list_Table thead th').each( function ()
                        {
                            switch(nColNo)
                            {
                                case 1:
                                case 2:
                                case 3:
                                    var title = $(this).text();
                                    $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;" />' );
                                    break;
                            }
                            nColNo = nColNo + 1;
                        });
                        
                        // DataTable
                        var table = $('#inv_list_Table').DataTable();
                        
                        // Apply the search
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