<?php
    /*
    echo $_POST['pd_dode'];    
    */

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_Category ";
    $strSql .= "WHERE category_code ='" . $_POST['code'] . "' ";    
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        echo json_encode($ds);
    }
?>