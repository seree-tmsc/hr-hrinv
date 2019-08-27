<?php
    /*
    echo $_POST['cYear'] . "<br>";
    echo $_POST['cMonth'] . "<br>";
    */

    try
    {
        date_default_timezone_set("Asia/Bangkok");
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
            require_once('include/db_Conn.php');

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

            if ($nRecCount > 0)            
            {
                echo "<div class='table-responsive'>";
                
                echo "<table class='table table-bordered table-hover' id='myTable'>";
                
                echo "<thead style='background-color:CornflowerBlue;'>";
    
                echo "<tr>";                
                echo "<th style='width:10%;' class='text-center'>Item Code</th>";
                echo "<th style='width:25%;' class='text-center'>Item Name</th>";
                echo "<th style='width:10%;' class='text-center'>Eff.Date</th>";
                echo "<th style='width:18%;' class='text-center'>Ref.No.</th>";
                echo "<th style='width:5%;' class='text-center'>IN</th>";
                echo "<th style='width:5%;' class='text-center'>OUT</th>";
                echo "<th style='width:5%;' class='text-center'>BAL</th>";
                echo "<th style='width:5%;' class='text-center'>Trn.Type</th>";
                echo "<th style='width:7%;' class='text-center'>Req.By</th>";
                echo "<th style='width:10%;' class='text-center'>Sys.Doc</th>";
                echo "</tr>";
    
                echo "</thead>";
                
                echo "<tbody>";                

                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    /*----------------------------*/
                    /*--- Print Balance Before ---*/
                    /*----------------------------*/
                    $nBalanceEnd = $ds['item_bf_qty'];

                    echo "<tr style='color:dodgerblue; font-weight:bold;'>";
                    echo "<td>" . $ds['item_code'][0] . "</td>";
                    echo "<td>" . $ds['item_name'] . "</td>";
                    echo "<td class='text-center'>" . date('d/M/Y' , strtotime($ds['item_bf_date']))  . "</td>";
                    echo "<td class='text-center'></td>";
                    echo "<td class='text-center'></td>";
                    echo "<td class='text-center'></td>";
                    echo "<td class='text-right'>" . $nBalanceEnd . "</td>";
                    echo "<td class='text-center'>B/B</td>";
                    echo "<td class='text-center'></td>";
                    echo "</tr>";

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
                                    echo "<tr style='color:coral; font-style:italic;'>";
                                    //echo "<td>" . $ds['item_code'][0] . "</td>";
                                    //echo "<td>" . $ds['item_name'] . "</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td class='text-center'>" . date('d/M/Y' , strtotime($ds1['iss_po_date']))  . "</td>";
                                    echo "<td>" . $ds1['req_no'] . "</td>";
                                    echo "<td class='text-center'>-</td>";
                                    echo "<td class='text-right'>" . $ds1['item_qty'] . "</td>";
                                    $nBalanceEnd = $nBalanceEnd - $ds1['item_qty'];
                                    break;

                                case '+':
                                    echo "<tr style='color:springgreen; font-style:italic;'>";
                                    //echo "<td>" . $ds['item_code'][0] . "</td>";
                                    //echo "<td>" . $ds['item_name'] . "</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td class='text-center'>" . date('d/M/Y' , strtotime($ds1['iss_po_date']))  . "</td>";
                                    echo "<td>" . $ds1['po_no'] . "</td>";
                                    echo "<td class='text-right'>" . $ds1['item_qty'] . "</td>";
                                    echo "<td class='text-center'>-</td>";
                                    $nBalanceEnd = $nBalanceEnd + $ds1['item_qty'];
                                    break;
                            }
                            echo "<td class='text-right'>" .  $nBalanceEnd . "</td>";
                            echo "<td class='text-center'>" . $ds1['transaction_type'] . "</td>";
                            echo "<td>" . $ds1['enter_by'] . "</td>";
                            echo "<td>" . $ds1['doc_no'] . "</td>";
                            echo "</tr>";
                        }
                    }
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
            else
            {
                echo "<script> alert('Error! ... Not Found Production Schedule Data ! ...'); window.close(); </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>