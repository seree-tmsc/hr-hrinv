<?php
    /*
    echo  $_GET['categoryCode'];
    */
    
    require_once('include/db_Conn.php');
    
    $strSql = "SELECT * ";
    $strSql .= "FROM EMP_Main ";
    $strSql .= "ORDER BY emp_code ";
    //echo $strSql . "<br>";

    $statement = $conn3->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    if ($nRecCount >0)
    {
        $json = [];
        while($ds = $statement->fetch(PDO::FETCH_NAMED))
        {            
            $cValueTemp = $ds['emp_code'] . " " . $ds['emp_efname'] . " " . $ds['emp_elname'];
            $cKeyTemp = $ds['emp_code'];
            $json[$cKeyTemp] = $cValueTemp;
        }
        echo json_encode($json);
    }
?>