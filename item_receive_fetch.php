<?php
    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_Transaction_Movement ";
    $strSql .= "WHERE po_no ='" . $_POST['po_no'] . "' ";
    $strSql .= "AND po_line = " . $_POST['po_line'] . " ";
    $strSql .= "AND transaction_type = '+' ";
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