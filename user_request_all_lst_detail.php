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

            if ($nRecCount > 0)            
            {
                echo "<div class='table-responsive'>";
                
                echo "<table class='table table-bordered table-hover' id='inv_list_Table'>";
                
                echo "<thead style='background-color:CornflowerBlue;'>";
    
                echo "<tr style='font-size: 12px;'>";
                echo "<th class='text-center'>Req.Date</th>";
                echo "<th class='text-center'>Req.No.</th>";
                echo "<th class='text-center'>Req.L.</th>";
                echo "<th class='text-center'>Category Code</th>";
                echo "<th class='text-center'>Category Name</th>";
                echo "<th class='text-center'>Item Code</th>";
                echo "<th class='text-center'>Item Name</th>";
                echo "<th class='text-center'>UOM</th>";
                echo "<th class='text-center'>QTY</th>";
                echo "<th class='text-center'>Req.By</th>";
                echo "<th class='text-center'>Status</th>";
                echo "<th class='text-center'>Due Date</th>";
                echo "</tr>";
    
                echo "</thead>";
                
                echo "<tbody>";                

                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    echo "<tr style='font-size: 12px;'>";
                    echo "<td>" . date('Y-d-m', strtotime($ds['enter_date'][0])). "</td>";
                    echo "<td>" . $ds['request_no'] . "</td>";
                    echo "<td class='text-center'>" . $ds['request_line'] . "</td>";
                    echo "<td>" . $ds['category_code'][0] . "</td>";
                    echo "<td>" . $ds['category_name'] . "</td>";
                    echo "<td>" . $ds['item_code'][0] . "</td>";
                    echo "<td>" . $ds['item_name'] . "</td>";
                    echo "<td class='text-center'>" . $ds['unit'] . "</td>";
                    echo "<td>" . $ds['quantity'] . "</td>";
                    echo "<td>" . $ds['request_by'] . "</td>";
                    if($ds['issue_status'] == '1')
                    {
                        echo "<td>Closed</td>";
                    }
                    else
                    {
                        echo "<td>Open</td>";
                    }
                    
                    echo "<td>" . date('Y-d-m', strtotime($ds['due_date'])). "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
            else
            {
                echo "<script> alert('Error! ... Data not found ! ...'); window.close(); </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>