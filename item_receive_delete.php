<?php
    try
    {
        include('include/db_Conn.php');

        $strSql = "DELETE FROM TRN_Transaction_Movement ";
        $strSql .= "WHERE po_no ='" . $_POST["po_no"] . "' ";
        $strSql .= "AND po_line ='" . $_POST["po_line"] . "' ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();

        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>