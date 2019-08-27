<?php
    //echo $_GET['id'];

    require_once('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_Item ";
    $strSql .= "WHERE item_code='" . $_GET['id'] . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    if ($nRecCount >0)
    {
        $json = [];
        $nI = 0;
        while($ds = $statement->fetch(PDO::FETCH_NAMED))
        {            
            $cValueTemp = $ds['unit'];
            $cKeyTemp = $nI;
            $json[$cKeyTemp] = $cValueTemp;
            $nI++;            
        }
        echo json_encode($json);
    }   
?>