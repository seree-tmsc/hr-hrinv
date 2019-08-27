<?php
    /*
    echo  $_GET['itemCode'];
    */
    
    require_once('include/db_Conn.php');
    
    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_item ";
    $strSql .= "WHERE item_code='" . $_GET['itemCode'] . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    if ($nRecCount = 1)
    {
        $json = [];
        while($ds = $statement->fetch(PDO::FETCH_NAMED))
        {            
            $cValueTemp = $ds['item_name'];
            $cKeyTemp = $ds['item_code'];
            $json[$cKeyTemp] = $cValueTemp;
        }
        echo json_encode($json);
    }
?>