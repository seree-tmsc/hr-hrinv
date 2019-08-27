<?php
    try
    {        
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_Category ";        
        $strSql .= "ORDER BY category_code ";
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
            //echo "<th style='width:5%;' class='text-center'>No.</th>";
            echo "<th style='width:15%;' class='text-center'>Category Code</th>";
            echo "<th style='width:40%;' class='text-center'>Category Name</th>";
            echo "<th style='width:10%;' class='text-center'>Enter Date</th>";
            echo "<th style='width:15%;' class='text-center'>Enter By</th>";
            echo "<th style='width:20%;' class='text-center'>Mode</th>";
            echo "</tr>";

            echo "</thead>";
            echo "<tbody>";

            $nI =1;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                echo "<tr>";
                //echo "<td class='text-right'>" . $nI . "</td>";
                echo "<td class='text-center'>" . $ds['category_code'] . "</td>";
                echo "<td>" . $ds['category_name'] . "</td>";
                echo "<td class='text-center'>" . date('d-M-Y', strtotime($ds['enter_date'])) . "</td>";
                echo "<td class='text-center'>" . $ds['enter_by'] . "</td>";

                echo "<td class='text-center'>";
                echo "<a href='#' class='view_data' category_code='" . $ds['category_code'] . "' >";
                echo "<span class='fa fa-sticky-note-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                echo "</a>";
                echo "<a href='#' class='edit_data' category_code='" . $ds['category_code'] . "'>";
                echo "<span class='fa fa-pencil-square-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                echo "</a>";
                echo "<a href='#' class='delete_data' category_code='" . $ds['category_code'] . "'>";
                echo "<span class='fa fa-trash-o fa-lg'></span>";
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