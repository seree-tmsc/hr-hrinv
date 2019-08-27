<?php
    try
    {        
        /*
        echo $_POST["code"] . "<br>";
        */

        include('include/db_Conn.php');
        $strSql = "DELETE FROM MAS_Category ";
        $strSql .= "WHERE category_code='" . $_POST["code"] . "' ";
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