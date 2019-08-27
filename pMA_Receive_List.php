<?php
    try
    {        
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_Balance_Before M ";
        $strSql .= "LEFT JOIN TRN_Transaction_Movement T  ON T.item_code = M.item_code ";
        //$strSql .= "JOIN TRN_Request R ON R.request_no = T.req_no ";
        $strSql .= "LEFT JOIN MAS_Item I ON I.item_code = T.item_code ";
        $strSql .= "WHERE M.item_Code = '" . $_POST['items'] . "' ";
        $strSql .= "ORDER BY T.iss_po_date, T.transaction_type DESC, T.doc_no ";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-hover' id='myTable'>";
            echo "<thead style='background-color:CornflowerBlue;'>";

            echo "<tr>";
            //echo "<th class='text-center'>No.</th>";
            echo "<th style='width:7%;' class='text-center'>doc_no</th>";
            echo "<th style='width:10%;' class='text-center'>iss-rec date</th>";            
            echo "<th style='width:7%;' class='text-center'>item_code</th>";
            echo "<th style='width:32%;' class='text-center'>item_name</th>";
            echo "<th style='width:15%;' class='text-center'>req_po_no</th>";
            echo "<th style='width:5%;' class='text-center'>IN</th>";
            echo "<th style='width:5%;' class='text-center'>OUT</th>";
            echo "<th style='width:7%;' class='text-center'>BALANCE</th>";
            echo "<th style='width:5%;' class='text-center'>trn.type</th>";            
            echo "<th style='width:7%;' class='text-center'>By</th>";
            //echo "<th class='text-center'>Detail</th>";
            echo "</tr>";

            echo "</thead>";
            echo "<tbody>";

            $nI =1;
            $nBalance = 0;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {                
                if($nI == 1)
                {
                    $cItem_Code = $ds['item_code'][0];
                    $cItem_Name = $ds['item_name'];
                    $nBalance = $ds['item_bf_qty'];

                    echo "<tr>";
                    //echo "<td class='text-center'>" . $nI . "</td>";
                    echo "<td class='text-center'></td>";
                    echo "<td class='text-center'>" . date('d-M-Y', strtotime($ds['item_bf_date'])) . "</td>";
                    echo "<td>" . $ds['item_code'][0] . "</td>";
                    echo "<td>" . $ds['item_name'] . "</td>";
                    echo "<td>" . "" . "</td>";
                    echo "<td class='text-right'>" . "-". "</td>";
                    echo "<td class='text-right'>" . "-". "</td>";
                    echo "<td class='text-right'>" . $ds['item_bf_qty'] . "</td>";
                    echo "<td>" . "" . "</td>";
                    echo "<td>" . "" . "</td>";
                    /*
                    echo "<td class='text-center'>";
                    echo "<a href='#' class='issue_data' request_no='" . $ds['doc_no']. "'>";
                    echo "<span class='fa fa-send-o fa-lg'></span>";
                    echo "</a>";
                    echo "</td>";
                    */
                    echo "</tr>";                    
                    
                    $nI++;
                }
                
                if(!is_null($ds['doc_no']))
                {
                    echo "<tr>";
                    //echo "<td class='text-center'>" . $nI . "</td>";
                    echo "<td>" . $ds['doc_no'] . "</td>";
                    echo "<td class='text-center'>" . date('d-M-Y', strtotime($ds['iss_po_date'])) . "</td>";                
                    echo "<td>" . $ds['item_code'][1] . "</td>";
                    echo "<td>" . $ds['item_name'] . "</td>";
    
                    switch ($ds['transaction_type'])
                    {
                        case '+':
                            echo "<td>" . $ds['po_no'] . "</td>";
                            
                            $nBalance = $nBalance + $ds['item_qty'];
                            echo "<td class='text-right'>" . $ds['item_qty'] . "</td>";
                            echo "<td class='text-right'>" . "-" . "</td>";
                            break;
                        case '-':
                            echo "<td>" . $ds['req_no'] . "</td>";
    
                            $nBalance = $nBalance - $ds['item_qty'];
                            echo "<td class='text-right'>" . "-" . "</td>";
                            echo "<td class='text-right'>" . $ds['item_qty'] . "</td>";
                            break;
                    }
    
                    echo "<td class='text-right'>" . $nBalance . "</td>";
                    echo "<td class='text-center'>" . $ds['transaction_type'] . "</td>";
                    //echo "<td class='text-center'>" . $ds['request_by'] . "</td>";
                    echo "<td class='text-center'>" . $ds['enter_by'][1] . "</td>";
                    /*
                    echo "<td class='text-center'>";
                    echo "<a href='#' class='issue_data' request_no='" . $ds['doc_no']. "'>";
                    echo "<span class='fa fa-send-o fa-lg'></span>";
                    echo "</a>";
                    echo "</td>";
                    */
                    echo "</tr>";
                                
                    $nI++;
                }                
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        else
        {
            echo "Data not found ...!";
            //echo "<script> alert('Warning! No Data ! ... ); window.location.href='pMain.php'; </script>";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>    