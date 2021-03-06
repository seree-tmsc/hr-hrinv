<?php
    try
    {
        include('include/db_Conn.php');
        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_Request R ";
        $strSql .= "JOIN MAS_Item I ON I.item_code = R.item_code ";
        $strSql .= "JOIN MAS_Category C ON C.category_code = I.category_code ";
        $strSql .= "WHERE open_request_by ='" . $user_emp_code . "' ";
        $strSql .= "AND issue_status='1' ";
        //$strSql .= "ORDER BY R.issue_status, R.enter_date, R.request_no ";
        $strSql .= "ORDER BY R.enter_date, R.request_no ";
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
            echo "<th style='width:4%;' class='text-center'>Status</th>";
            echo "<th style='width:3%;' class='text-center'>No.</th>";            
            echo "<th style='width:10%;' class='text-center'>Enter Date</th>";
            echo "<th style='width:15%;' class='text-center'>Req.No.</th>";
            echo "<th style='width:3%;' class='text-center'>L.</th>";
            echo "<th style='width:15%;' class='text-center'>Item Code</th>";
            echo "<th style='width:25%;' class='text-center'>Item Name</th>";
            echo "<th style='width:5%;' class='text-center'>U.</th>";
            echo "<th style='width:3%;' class='text-center'>Q.</th>";
            echo "<th style='width:10%;' class='text-center'>Due Date</th>";
            echo "<th style='width:8%;' class='text-center'>R.By</th>";            
            echo "</tr>";

            echo "</thead>";
            echo "<tbody>";

            $nI =1;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                /*
                echo $ds['enter_date'][0] . "<br>";
                echo $ds['enter_date'][1] . "<br>";
                */

                echo "<tr>";
                echo "<td style='color:lightgray;'>Closed</td>";
                echo "<td class='text-center' style='color:lightgray;'>" . $nI . "</td>";
                echo "<td class='text-center' style='color:lightgray;'>" . date('d-M-Y', strtotime($ds['enter_date'][0])) . "</td>";  
                echo "<td style='color:lightgray;'>" . $ds['request_no'] . "</td>";
                echo "<td class='text-center' style='color:lightgray;'>" . $ds['request_line'] . "</td>";
                echo "<td style='color:lightgray;'>" . $ds['item_code'][0] . "</td>";
                echo "<td style='color:lightgray;'>" . $ds['item_name'] . "</td>";
                echo "<td class='text-center' style='color:lightgray;'>" . $ds['unit'] . "</td>";
                echo "<td class='text-right' style='color:lightgray;'>" . $ds['quantity'] . "</td>";
                echo "<td style='color:lightgray;'>" . date('d-M-Y', strtotime($ds['due_date'])) . "</td>";
                echo "<td class='text-center' style='color:lightgray;'>" . $ds['request_by']. "</td>";
                echo "</tr>";

                $nI++;
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