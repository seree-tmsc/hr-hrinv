<?php
    /*
    echo date('Y/m/d') . "<br>";
    echo $_POST['Enter_By'] . "<br>";
    echo $_POST['item-ddl'] . "<br>";
    echo $_POST['qty'] . "<br>";
    echo trim($_POST['uom']) . "<br>";
    echo date('Y/m/d', strtotime($_POST['due_date'])) . "<br>";
    */

    try
    {
        include('include/db_Conn.php');
        $strSql = "INSERT INTO TRN_Request ";
        $strSql .= "VALUES(";
        $strSql .= "'" . date('Y/m/d') . "', ";
        $strSql .= "'" . $_POST["Enter_By"] . "', ";
        $strSql .= "'" . $_POST["item-ddl"] . "', ";
        $strSql .= "" . $_POST["qty"] . ", ";
        $strSql .= "'" . date('Y/m/d', strtotime($_POST['due_date'])) . "', ";
        $strSql .= "0)";
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