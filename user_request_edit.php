<?php
    try
    {
        include('include/db_Conn.php');
        
        $strSql = "UPDATE TRN_Request SET ";
        $strSql .= "quantity = '" . $_POST["edit_quantity"] . "', ";
        $strSql .= "due_date = '" . $_POST["edit_due_date"] . "' ";
        $strSql .= "WHERE request_no = '" . $_POST["edit_request_no"] . "' ";
        $strSql .= "AND request_line = " . $_POST["edit_request_line"] . " ";
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