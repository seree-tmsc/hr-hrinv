<?php
    try
    {
        include('include/db_Conn.php');
        $strSql = "INSERT INTO TRN_Request ";
        $strSql .= "VALUES(";
        $strSql .= "'" . $_POST['paramrequest_no'] . "', ";
        $strSql .= "" . $_POST['request_line'] . ", ";
        $strSql .= "'" . $_POST['paramenter_date'] . "', ";
        //$strSql .= "'" . $_POST['paramrequest_by'] . "', ";
        $strSql .= "'" . $_POST['emp_code'] . "', ";
        $strSql .= "'" . $_POST['item_code'] . "', ";
        $strSql .= "" . $_POST['quantity'] . ", ";
        $strSql .= "'" . date('Y-m-d', strtotime($_POST['due_date'])) . "', ";
        $strSql .= "'0', " ;
        $strSql .= "'" . $_POST['param_open_request_by'] . "') ";
        //echo $strSql ;
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {
            echo "Insert data complete!";
        }
        else
        {
            echo "Error! Cannot insert data!";
        }
    }
    catch(PDOException $e)
    {
        echo substr($e->getMessage(),0,105) ;
    }
?>