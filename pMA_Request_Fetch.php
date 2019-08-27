<?php
    /*
    echo $_POST['request_no'];
    */

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_Request R ";
    $strSql .= "JOIN MAS_Item I ON R.item_code = I.item_code ";
    $strSql .= "JOIN MAS_Category C ON I.category_code = C.category_code ";
    $strSql .= "WHERE R.request_no =" . $_POST['request_no'] ;
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