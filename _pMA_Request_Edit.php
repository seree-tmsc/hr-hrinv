<?php
    /*
    echo $_POST['edit_RequestNo'];
    echo $_POST['edit_RequestDate'];
    */
    try
    {
        include('include/db_Conn.php');

        $strSql = "UPDATE TRN_Request SET ";
        $strSql .= "quantity = " . $_POST["edit_Quantity"] . ", ";
        $strSql .= "due_date = '" . $_POST["edit_RequestDate"] . "' ";
        $strSql .= "WHERE request_no = " . $_POST["edit_RequestNo"] ;
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {
            echo "Edit data complete!";
        }
        else
        {
            echo "Error! Cannot edit data!";
        }
    }
    catch(PDOException $e)
    {     
        echo substr($e->getMessage(),0,105) ;
    }
?>