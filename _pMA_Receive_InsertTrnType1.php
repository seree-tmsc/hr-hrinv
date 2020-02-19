<?php
    /*
    echo $_POST['paramPo_Date'] ;
    echo $_POST['paramPo_No'] ;
    echo $_POST['paramItem_Code'] ;
    echo $_POST['paramEmp_Code'] ;
    echo $_POST['paramQty'] ;
    */

    try
    {
        include('include/db_Conn.php');
        $strSql = "INSERT INTO TRN_Transaction_Movement ";
        $strSql .= "VALUES(";
        $strSql .= "NULL, ";
        $strSql .= "'" . $_POST['paramPo_No'] . "', ";
        $strSql .= "'" . $_POST['paramPo_Date'] . "', ";
        $strSql .= "'" . trim($_POST["paramItem_Code"]) . "', ";
        $strSql .= "" . $_POST["paramQty"] . ", ";
        $strSql .= "'+', " ;
        $strSql .= "'" . $_POST['paramEmp_Code'] . "')";
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