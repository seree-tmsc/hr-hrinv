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
                <?php //require_once("list_HistInv_Script.php"); ?>
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
                            <?php include "list_HistInv_List.php"; ?>
                        </div>
                    </div>
                    <!-- ----------------------------------- -->
                    <!-- End content page -->
                </div>  
                <!-- End Body page -->          

                <!-- Left slide menu -->
                <?php
                    /*
                    if(strtoupper($_SESSION["ses_user_type"]) == 'A')
                    {                                                
                        require_once("include/menu_admin.php");
                    }
                    */
                ?>
                <!-- End Left slide menu -->
                
                
                
                <!-- Bootstrap Modals Section ------------>
                <!-- Begin -->
                <!-- Logout Modal-->
                <?php require_once("include/modal_logout.php"); ?>

                <!-- Change Password Modal-->
                <?php require_once("include/modal_chgpassword.php"); ?>
                        
                <!-- Modal - Insert Record -->
                <?php //require_once("pMA_Item_Insert_Modal.php"); ?>                

                <!-- Modal - View Record -->
                <?php //require_once("pMA_Item_View_Modal.php"); ?>

                <!-- Modal - Insert Record -->
                <?php //require_once("pMA_Item_Edit_Modal.php"); ?>

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

                                $cMAS_Balance_Before="MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'];
                                $cTRN_Transaction_Movement="TRN_Transaction_Movement_" . $_POST['cYear'] . $_POST['cMonth'];
                                
                                $strSql = "SELECT * ";
                                $strSql .= "FROM " . $cMAS_Balance_Before . " B ";
                                $strSql .= "JOIN MAS_Item I ON I.item_code = B.item_code ";
                                $strSql .= "ORDER BY I.item_code ";
                                //echo $strSql . "<br>";

                                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $statement->execute();  
                                $nRecCount = $statement->rowCount();
                                //echo $nRecCount . " records <br>";

                                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $statement->execute();  
                                $nRecCount = $statement->rowCount();

                                if ($nRecCount >0)
                                {
                                    $dataArray = array();
                                    $rowArray = array("Item Code", "Item Name", "Effective Date", "Reference No.", "IN", "OUT", "BALANCE", "Transaction Type", "Request By", "Sytem Documnet No.");
                                    array_push($dataArray, $rowArray);
                                    while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                                    {

                                        /*----------------------------*/
                                        /*--- Print Balance Before ---*/
                                        /*----------------------------*/
                                        $nBalanceEnd = $ds['item_bf_qty'];                                        

                                        //echo $ds["emp_code"] . "<br>";
                                        $rowArray = array($ds["item_code"][0], 
                                                        $ds["item_name"], 
                                                        date('d/M/Y' , strtotime($ds['item_bf_date'])),
                                                        '', 
                                                        '', 
                                                        '', 
                                                        $nBalanceEnd,
                                                        'B/B',
                                                        '');
                                        array_push($dataArray, $rowArray);

                                        /*------------------------------*/
                                        /*--- Print detail each line ---*/
                                        /*------------------------------*/                    
                                        $strSql1 = "SELECT * ";
                                        $strSql1 .= "FROM " . $cTRN_Transaction_Movement . " T ";
                                        $strSql1 .= "WHERE T.item_code = '" . TRIM($ds['item_code'][0]) . "' ";
                                        $strSql1 .= "ORDER BY T.iss_po_date, T.transaction_type DESC, T.doc_no ";
                                        //echo $strSql1 . "<br>";

                                        $statement1 = $conn1->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                        $statement1->execute();
                                        $nRecCount1 = $statement1->rowCount();
                                        //echo $nRecCount1 . " records <br>";

                                        if ($nRecCount > 0)
                                        {
                                            while ($ds1 = $statement1->fetch(PDO::FETCH_NAMED))
                                            {
                                                switch ($ds1['transaction_type'])
                                                {
                                                    case '-':
                                                        $nBalanceEnd = $nBalanceEnd - $ds1['item_qty'];

                                                        $rowArray = array(
                                                                        $ds["item_code"][0], 
                                                                        $ds["item_name"], 
                                                                        date('d/M/Y' , strtotime($ds1['iss_po_date'])),
                                                                        $ds1["req_no"],
                                                                        '-', 
                                                                        $ds1["item_qty"],
                                                                        $nBalanceEnd,
                                                                        $ds1['transaction_type'],
                                                                        $ds1['enter_by'],
                                                                        strval($ds1['doc_no']));
                                                        array_push($dataArray, $rowArray);
                                                        break;

                                                    case '+':
                                                        $nBalanceEnd = $nBalanceEnd + $ds1['item_qty'];

                                                        $rowArray = array(
                                                                        $ds["item_code"][0], 
                                                                        $ds["item_name"], 
                                                                        date('d/M/Y' , strtotime($ds1['iss_po_date'])),
                                                                        strval($ds1["po_no"]),                                                             
                                                                        $ds1["item_qty"],
                                                                        '-',
                                                                        $nBalanceEnd,
                                                                        $ds1['transaction_type'],
                                                                        $ds1['enter_by'],
                                                                        strval($ds1['doc_no']));
                                                        array_push($dataArray, $rowArray);
                                                        break;
                                                }
                                            }
                                        }
                                    }

                                    $fileName = "tmpInventoryData.csv";
                                    $fp = fopen('tmpInventoryData.csv', 'w');
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
                <!-- Begin -->
                
                
                <!-- Javascript  Section ------------>
                <!-- Begin -->
                <script>
                    //--------------------------
                    // javascript for side-menu
                    //--------------------------
                    $(document).ready(function () {
                        $('#myTable').DataTable({
                            paging: false,
                            bFilter: false,
                            ordering: false,
                            searching: true,
                            dom: 't'         // This shows just the table
                        });

                        /*
                        var table = $('#myTable').DataTable();
                        $('#column2_search').on( 'keyup', function () {
                            table
                                .columns(2)
                                .search(this.value)
                                .draw();
                        } );
                        */                        

                        // Setup - add a text input to each footer cell
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

                        /*
                        $('#myTable').DataTable( {
                            initComplete: function () {
                                this.api().columns().every( function () {
                                    var column = this;
                                    var select = $('<select><option value=""></option></select>')
                                        .appendTo( $(column.footer()).empty() )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );
                    
                                            column
                                                .search( val ? '^'+val+'$' : '', true, false )
                                                .draw();
                                        } );
                    
                                    column.data().unique().sort().each( function ( d, j ) {
                                        select.append( '<option value="'+d+'">'+d+'</option>' )
                                    } );
                                } );
                            }
                        } );
                        */
                    });
                </script>
                <!-- Begin -->
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