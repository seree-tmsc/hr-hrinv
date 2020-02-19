<?php
    try
    {
        include('include/db_Conn.php');
        
        $strSql = "UPDATE TRN_Transaction_Movement SET ";
        $strSql .= "item_qty = '" . $_POST["edit_item_qty"] . "' ";
        $strSql .= "WHERE po_no = '" . $_POST["edit_po_no"] . "' ";
        $strSql .= "AND po_line = " . $_POST["edit_po_line"] . " ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {
            echo "Edit data complete!";
        }
        else
        {
            echo "Error! Cannot edit data!";
        }
    }
    catch(PDOException $e)
    {     
        echo substr($e->getMessage(),0,105) ;
    }
?>