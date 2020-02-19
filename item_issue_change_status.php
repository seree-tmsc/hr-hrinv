<?php
    //echo $_POST["request_no"] . "<br>";
        
    try
    {
        function check_Inventory_Level()
        {
            include('include/db_Conn.php');
            $strSql = "SELECT * FROM TRN_Request ";
            $strSql .= "WHERE request_no='" . $_POST['request_no'] . "' ";
            $strSql .= "AND request_line=" . $_POST['request_line'] . " ";
            $strSql .= "AND issue_status = '0' ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
    
            if($nRecCount = 1)
            {
                $ds = $statement->fetch(PDO::FETCH_NAMED);

                $strSql1 = "SELECT * ";
                $strSql1 .= "FROM MAS_Balance_Before M ";
                $strSql1 .= "LEFT JOIN TRN_Transaction_Movement T ON T.item_code = M.item_code ";
                $strSql1 .= "WHERE M.item_code='" . $ds['item_code'] . "' ";    
                $strSql1 .= "ORDER By T.iss_po_date, T.transaction_type ";
                //echo $strSql1 . "<br>";

                $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                $statement1->execute();
                $nRecCount1 = $statement1->rowCount();
                //echo $nRecCount . "<br>";
                
                if( $nRecCount1 > 0)
                {
                    $nRecord = 1;
                    $nInventoryLevel = 0;
                    while($ds1 = $statement1->fetch(PDO::FETCH_NAMED))
                    {
                        if($nRecord == 1)
                        {
                            $nInventoryLevel = $ds1['item_bf_qty'];
                        }

                        switch($ds1['transaction_type'])
                        {
                            case '+':
                                $nInventoryLevel += $ds1['item_qty'];
                                break;
                            case '-':
                                $nInventoryLevel -= $ds1['item_qty'];
                                break;
                        }

                        $nRecord++;
                    }
                }
                return array('BF'=>$nInventoryLevel, 'QTY'=>$ds['quantity']);
            }
        }

        $aData = check_Inventory_Level();
        if( ($aData['BF'] - $aData['QTY']) >= 0 )
        {
            include('include/db_Conn.php');

            $strSql = "UPDATE TRN_Request ";
            $strSql .= "SET issue_status = '1' ";
            $strSql .= "WHERE request_no='" . $_POST['request_no'] . "' ";
            $strSql .= "AND request_line=" . $_POST['request_line'];
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
    
            if($nRecCount = 1)
            {
                $strSql = "SELECT * FROM TRN_Request ";        
                $strSql .= "WHERE request_no='" . $_POST['request_no'] . "' ";
                $strSql .= "AND request_line=" . $_POST['request_line'] . " ";
                $strSql .= "AND issue_status = '1' ";
                //echo $strSql . "<br>";
    
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                $statement->execute();
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";
                    
                if($nRecCount = 1)            
                {
                    $ds = $statement->fetch(PDO::FETCH_NAMED);
    
                    $strSql = "INSERT INTO TRN_Transaction_Movement ";
                    $strSql .= "VALUES(";
                    $strSql .= "'" . date('Y-m-d', strtotime($ds['due_date'])) . "', ";
                    $strSql .= "'" . $ds['request_no'] . "', ";
                    $strSql .= "" . $ds['request_line'] . ", ";
                    $strSql .= "NULL, ";
                    $strSql .= "NULL, ";
                    $strSql .= "NULL, ";
                    $strSql .= "'" . $ds['item_code'] . "', ";
                    $strSql .= "" . $ds['quantity'] . ", ";
                    $strSql .= "'-', " ;
                    $strSql .= "'" . $ds['request_by'] . "')";
                    //echo $strSql . "<br>";
    
                    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                    $statement->execute();
                    $nRecCount = $statement->rowCount();
                    //echo $nRecCount . "<br>";
    
                    if($nRecCount = 1)
                    {
                        //echo " -- Issue Item Complete ! -- ";
                        echo 'Curent inventory is ' . $aData['BF'];
                    }
                    else
                    {
                        echo " -- Error ... ! Cannot issue item -- ";
                    }
                }
            }
        }
        else
        {
            echo(' Error ... ! -- Inventory remaining not enough -- [ ' . $aData['BF'] . ' ]');
        }        
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>