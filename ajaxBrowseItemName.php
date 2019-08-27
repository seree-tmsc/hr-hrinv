<?php
    /*
    echo  $_GET['categoryCode'];
    */
    
    require_once('include/db_Conn.php');
    
    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_item ";
    $strSql .= "WHERE category_code='" . $_GET['categoryCode'] . "' ";
    $strSql .= "ORDER BY item_name ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    if ($nRecCount >0)
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