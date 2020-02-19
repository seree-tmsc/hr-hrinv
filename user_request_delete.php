<?php
    try
    {
        include('include/db_Conn.php');

        $strSql = "DELETE FROM TRN_Request ";
        $strSql .= "WHERE request_no='" . $_POST['request_no'] . "' ";
        $strSql .= "AND request_line=" . $_POST['request_line'];
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