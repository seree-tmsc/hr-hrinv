<?php
    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_Request T ";
    $strSql .= "JOIN MAS_Item M ";
    $strSql .= "ON M.item_code = T.item_code ";
    $strSql .= "WHERE T.request_no ='" . $_POST['request_no'] . "' ";
    $strSql .= "AND T.request_line = " . $_POST['request_line'] . " ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        
        $strSql = "SELECT * ";
        $strSql .= "FROM emp_main ";
        $strSql .= "WHERE emp_code ='" . $ds['request_by'] . "' ";
        //echo $strSql . "<br>";

        $statement = $conn3->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();

        if($nRecCount == 1)
        {
            $ds1 = $statement->fetch(PDO::FETCH_NAMED);

            $ds['emp_name'] = $ds1['emp_efname'] . ' ' . $ds1['emp_elname'];
        }
        else
        {
            $ds['emp_name'] = 'NULL';
        }

        echo json_encode($ds);
    }
?>