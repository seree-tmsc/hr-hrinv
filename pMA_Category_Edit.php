<?php
    /*
    echo "1." . $_POST['parameditPdCode']; 
    echo "2." . $_POST['editPdLt']; 
    */
    
    try
    {
        include('include/db_Conn.php');

        $strSql = "UPDATE MAS_Category SET ";
        $strSql .= "category_name = '" . $_POST["edit_CategoryName"] . "' ";
        $strSql .= "WHERE category_code = '" . $_POST["paramedit_CategoryCode"] . "' ";
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