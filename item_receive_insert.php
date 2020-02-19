<?php
    try
    {
        include('include/db_Conn.php');
        $strSql = "INSERT INTO TRN_Transaction_Movement ";
        $strSql .= "VALUES(";
        $strSql .= "'" . date('Y-m-d', strtotime($_POST['po_date'])) . "', ";
        $strSql .= "NULL, ";
        $strSql .= "NULL, ";
        $strSql .= "'" . $_POST['po_no'] . "', ";
        $strSql .= "" . $_POST['po_line'] . ", ";
        $strSql .= "'" . $_POST['category_code'] . "', ";
        $strSql .= "'" . $_POST['item_code'] . "', ";
        $strSql .= "" . $_POST['item_qty'] . ", ";
        $strSql .= "'+', " ;
        $strSql .= "'" . $_POST['emp_code'] . "')";
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
            echo "Error! Cannot insert data into '-- TRN_Transaction_Movement --'";
        }
    }
    catch(PDOException $e)
    {
        echo substr($e->getMessage(),0,105) ;
    }
?>