<?php
    /*
    echo "1." . $_POST['paramedit_ItemCode']; 
    echo "2." . $_POST['edit_ItemName']; 
    */
    
    try
    {
        include('include/db_Conn.php');

        $strSql = "UPDATE MAS_Item SET ";
        $strSql .= "item_name = '" . $_POST["edit_ItemName"] . "' ";
        $strSql .= "WHERE item_code = '" . $_POST["paramedit_ItemCode"] . "' ";
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