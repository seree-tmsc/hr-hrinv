<?php
    /*
    echo $_POST['pd_code'] . "<br>";    
    */

    try
    {
        include('include/db_Conn.php');
        
        $strSql = "INSERT INTO MAS_Item ";
        $strSql .= "VALUES(";
        $strSql .= "'" . $_POST["Item_Code"] . "',";
        $strSql .= "'" . $_POST["Item_Name"] . "',";
        $strSql .= "'" . $_POST["category-ddl"] . "',";
        $strSql .= "'" . $_POST["uom-ddl"] . "',";
        $strSql .= "'" . date('Y/m/d') . "',";
        $strSql .= "'" . $_POST["Enter_By"] . "') ";
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