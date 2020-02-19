<?php
    try
    {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover' id='myTable'>";        
        echo "<thead>";
        echo "<tr class='info'>";
        echo "<th style='width:10%;' class='text-center'>Doc.No.</th>";
        echo "<th style='width:10%;' class='text-center'>PO.No.</th>";
        echo "<th style='width:5%;' class='text-center'>PO.L.</th>";
        echo "<th style='width:10%;' class='text-center'>PO.Date</th>";
        echo "<th style='width:15%;' class='text-center'>Item Code</th>";
        echo "<th style='width:30%;' class='text-center'>Item Name</th>";
        echo "<th style='width:5%;' class='text-center'>QTY</th>";
        echo "<th style='width:5%;' class='text-center'>TR.Type</th>";
        echo "<th style='width:10%;' class='text-center'>Mode</th>";        
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_Transaction_Movement T ";
        $strSql .= "JOIN MAS_Item I ON I.item_code = T.item_code ";
        $strSql .= "WHERE T.iss_po_date='" . date('Y-m-d', strtotime($_POST['po_date'])) . "' ";
        $strSql .= "AND T.transaction_type='+' ";
        $strSql .= "ORDER BY T.po_no, T.item_code ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {                
?>
                <tr>
                    <td> <?php echo $ds['doc_no']; ?> </td>
                    <td> <?php echo $ds['po_no']; ?> </td>
                    <td class='text-center'> <?php echo $ds['po_line']; ?> </td>
                    <td class='text-center'> <?php echo date('Y/m/d' , strtotime($ds['iss_po_date'])); ?> </td>
                    <td> <?php echo $ds['item_code'][0]; ?> </td>
                    <td> <?php echo $ds['item_name']; ?> </td>
                    <td class='text-right'> <?php echo number_format($ds['item_qty'], 0, '.', ','); ?> </td>
                    <td class='text-center'> <?php echo $ds['transaction_type']; ?> </td>
                    
                    <td class='text-center'>
                        <a href="#" class="delete_data" po_no="<?php echo $ds['po_no'];?>" po_line="<?php echo $ds['po_line']?>">
                            <span class='fa fa-trash-o fa-lg'></span>
                        </a>
                        <a href="#" class="edit_data" po_no="<?php echo $ds['po_no'];?>" po_line="<?php echo $ds['po_line']?>">
                            <span class='fa fa-pencil-square-o fa-lg'></span>
                        </a>
                    </td>
                    
                </tr> 
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