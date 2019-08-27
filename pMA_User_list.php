<?php
    try
    {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover' id='myTable'>";        
        echo "<thead>";
        echo "<tr class='info'>";
        echo "<th style='width:10%;'>Code</th>";
        echo "<th style='width:10%;'>First Name</th>";
        echo "<th style='width:15%;'>Last Name</th>";
        echo "<th style='width:15%;'>e-Mail</th>";
        echo "<th style='width:5%;' class='text-center'>Type</th>";
        echo "<th style='width:15%;' class='text-center'>Created Date</th>";        
        echo "<th style='width:20%;' class='text-center'>Mode</th>";        
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_Users_ID ";        
        $strSql .= "ORDER BY user_type, emp_code ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $strSql3 = "SELECT * ";
                $strSql3 .= "FROM Emp_Main ";                
                $strSql3 .= "WHERE emp_code ='" . $ds['emp_code'] . "' ";
                //echo $strSql . "<br>";
        
                $statement3 = $conn3->prepare( $strSql3, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                $statement3->execute();  
                $nRecCount3 = $statement3->rowCount();
                if ($nRecCount3 == 1)
                {
                    $ds3 = $statement3->fetch(PDO::FETCH_NAMED)
?>
                    <tr>
                        <td> <?php echo $ds['emp_code']; ?> </td>
                        <td> <?php echo $ds3['emp_tfname']; ?> </td>
                        <td> <?php echo $ds3['emp_tlname']; ?> </td>
                        <td> <?php echo $ds['user_email']; ?> </td>
                        <td class='text-center'> <?php echo $ds['user_type']; ?> </td>
                        <td class='text-center'> <?php echo $ds['user_create_date']; ?> </td>
                        <td class='text-center'>
                            <!--
                            <input type="button" name="view" value="view" 
                                class="btn btn-info btn-xs view_data" 
                                emp_code="<?php //echo $ds['emp_code'];?>">
                            -->

                            <a href="#" class="view_data" emp_code="<?php echo $ds['emp_code'];?>">
                                <span class='fa fa-sticky-note-o fa-lg'></span>
                            </a>

                            <a href="#" class="delete_data" emp_code="<?php echo $ds['emp_code'];?>">
                                <span class='fa fa-trash-o fa-lg'></span>
                            </a>

                            <a href="#" class="edit_data" emp_code="<?php echo $ds['emp_code'];?>">
                                <span class='fa fa-pencil-square-o fa-lg'></span>
                            </a>
                        </td>
                    </tr> 
<?php
                }
                else
                {
                    break;
                }
?>                               
<?php
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        else
        {            
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "No data";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>    