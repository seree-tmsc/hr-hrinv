<?php
    //echo $_POST["request_no"] . "<br>";
        
    try
    {
        include('include/db_Conn.php');
        $strSql = "UPDATE TRN_Request ";
        $strSql .= "SET issue_status = '1' ";
        $strSql .= "WHERE request_no=" . $_POST['request_no'];
        //echo $strSql . "<br>";
    
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";

        if($nRecCount = 1)
        {
            $strSql = "SELECT * FROM TRN_Request ";        
            $strSql .= "WHERE request_no=" . $_POST['request_no'];
            echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
                
            if($nRecCount = 1)            
            {
                $ds = $statement->fetch(PDO::FETCH_NAMED);

                $strSql = "INSERT INTO TRN_Transaction_Movement VALUES(";
                $strSql .= "'" . $ds['request_no'] . "', ";
                $strSql .= "NULL, ";
                $strSql .= "'" . $ds['due_date'] . "', ";
                $strSql .= "'" . $ds['item_code'] . "', ";
                $strSql .= "" . $ds['quantity'] . ", ";
                $strSql .= "'-', ";
                $strSql .= "'" . $ds['request_by'] . "') ";
                echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";

                if($nRecCount = 1)
                {
                    //echo "Complete!";
                }
                else
                {
                    //echo "Error!";
                }
            }
        }        
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>