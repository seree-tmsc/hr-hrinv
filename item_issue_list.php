<?php
    try
    {        
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_Request R ";
        $strSql .= "JOIN MAS_Item I ON I.item_code = R.item_code ";
        $strSql .= "JOIN MAS_Category C ON C.category_code = I.category_code ";
        $strSql .= "WHERE R.due_date >= '" . $dFromDate . "' AND R.due_date <='" . $dToDate . "' " ;
        $strSql .= "AND R.issue_status = '0' ";
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
            
            echo "<th class='text-center'>Enter Date</th>";
            echo "<th class='text-center'>Due Date</th>";
            echo "<th class='text-center'>Req.No.</th>";
            echo "<th class='text-center'>Li</th>";
            echo "<th class='text-center'>Item Code</th>";
            echo "<th class='text-center'>Item Name</th>";
            echo "<th class='text-center'>U.</th>";
            echo "<th class='text-center'>Q.</th>";
            echo "<th class='text-center'>Req.By</th>";
            echo "<th class='text-center'>Issue</th>";
            echo "</tr>";

            echo "</thead>";
            echo "<tbody>";

            $nI =1;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                echo "<tr>";
                
                
                echo "<td>" . date('d-M-Y', strtotime($ds['enter_date'][0])) . "</td>";
                echo "<td>" . date('d-M-Y', strtotime($ds['due_date'])) . "</td>";
                echo "<td>" . $ds['request_no'] . "</td>";
                echo "<td class='text-center'>" . $ds['request_line'] . "</td>";
                echo "<td>" . $ds['item_code'][0] . "</td>";
                echo "<td>" . $ds['item_name'] . "</td>";
                echo "<td class='text-center'>" . $ds['unit'] . "</td>";
                echo "<td class='text-right'>" . $ds['quantity'] . "</td>";
                echo "<td class='text-center'>" . $ds['request_by']. "</td>";

                echo "<td class='text-center'>";                
                echo "<a href='#' class='issue_data' request_no='" . $ds['request_no'] . "' request_line='" . $ds['request_line'] . "' quantity='" . $ds['quantity'] . "'>";
                echo "<span class='fa fa-send-o fa-lg'></span>";
                echo "</a>";
                echo "</td>";

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