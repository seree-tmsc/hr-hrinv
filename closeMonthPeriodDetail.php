<?php
    /*
    echo $_POST['cMonth'];
    echo $_POST['cYear'];
    */
    function Copy_MAS_Balance_Before_To_History()
    {
        /* ------------------------------------------ */
        /* --- Copy MAS_Balance_Before to History --- */
        /* ------------------------------------------ */
        include('include/db_Conn.php');
        $strSql = "SELECT * ";
        $strSql .= "INTO MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'] . " ";
        $strSql .= "FROM MAS_Balance_Before ";
        $strSql .= "WHERE item_bf_date='" . $_POST['cYear'] . "/" . $_POST['cMonth'] . "/01' ";
        $strSql .= "ORDER BY item_code ";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "Copy MAS_Balance_Before to History -> Complete ...!" . "<br>";
            return true;
        }
        else
        {
            echo "Copy MAS_Balance_Before to History -> Error ...!" . "<br>";
            $strSql = "DROP TABLE [MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'] . "] ";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();

            //echo "Please Contact Admin to DELETE TABLE MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'] . "<br>";
            return false;
        }
    }
    function Copy_TRN_Transaction_Movement_To_History()
    {
        /* ------------------------------------------------ */
        /* --- Copy TRN_Transaction_Movement to History --- */
        /* ------------------------------------------------ */
        include('include/db_Conn.php');
        $strSql = "SELECT * ";
        $strSql .= "INTO TRN_Transaction_Movement_" . $_POST['cYear'] . $_POST['cMonth'] . " ";
        $strSql .= "FROM TRN_Transaction_Movement ";
        $strSql .= "ORDER BY item_code, transaction_type, iss_po_date, doc_no";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "Copy TRN_Transaction_Movement to History -> Complete ...!" . "<br>";
            return true;
        }
        else
        {
            echo "Copy TRN_Transaction_Movement to History -> Error ...!" . "<br>";

            $strSql = "DROP TABLE [MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'] . "] ";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();

            $strSql = "DROP TABLE [TRN_Transaction_Movement_" . $_POST['cYear'] . $_POST['cMonth'] . "] ";
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();

            //echo "Please Contact Admin to DELETE TABLE MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'] . "<br>";
            //echo "Please Contact Admin to DELETE TABLE TRN_Transaction_Movement_" . $_POST['cYear'] . $_POST['cMonth'] . "<br>";
            return false;
        }
    }
    function Find_Balance_End()
    {
        /* ------------------------ */
        /* --- Find Balance-End --- */
        /* ------------------------ */
        include('include/db_Conn.php');
        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_Balance_Before ";
        $strSql .= "ORDER BY item_code ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount > 0)
        {
            for($nLoop=1; $nLoop<=$nRecCount ; $nLoop++)
            {
                $ds = $statement->fetch(PDO::FETCH_NAMED);
                
                //echo $nLoop . " " . $ds['item_code'] . "<br>";

                $strSql1 = "SELECT * ";
                $strSql1 .= "FROM MAS_Balance_Before M ";
                $strSql1 .= "LEFT JOIN TRN_Transaction_Movement T  ON T.item_code = M.item_code ";
                $strSql1 .= "LEFT JOIN MAS_Item I ON I.item_code = T.item_code ";
                $strSql1 .= "WHERE M.item_Code = '" . $ds['item_code'] . "' ";
                $strSql1 .= "ORDER BY T.iss_po_date, T.transaction_type DESC, T.doc_no ";
                //echo $strSql1 . "<br>";
                
                
                $statement1 = $conn1->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement1->execute();
                $nRecCount1 = $statement1->rowCount();

                $nBalance = 0;
                $nI = 1;
                if ($nRecCount1 >0)
                {
                    while ($ds1 = $statement1->fetch(PDO::FETCH_NAMED))
                    {
                        if($nI == 1)
                        {
                            $nBalance = $ds1['item_bf_qty'];
                            $nI++;
                        }
                        switch ($ds1['transaction_type'])
                        {
                            case '+':
                                $nBalance = $nBalance + $ds1['item_qty'];                            
                                break;
                            case '-':
                                $nBalance = $nBalance - $ds1['item_qty'];
                                break;
                        }
                        $nI++;
                    }
                    //echo $ds['item_code'] . " BE=" .$nBalance . "<br>";
                    
                    $strSql2 = "INSERT INTO MAS_Balance_End VALUES(";
                    $strSql2 .= "'" . $ds['item_code'] . "', ";
                    $strSql2 .= "" . $nBalance . ", ";
                    $strSql2 .= "DATEADD(month, 1, '" . $_POST['cYear'] . "/" . $_POST['cMonth'] . "/01')) ";
                    //echo $strSql2 . "<br>";

                    $statement2 = $conn2->prepare( $strSql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                    $statement2->execute();
                    $nRecCount2 = $statement2->rowCount();
                    if ($nRecCount2 >0)
                    {
                        echo "Find Balance-End ->[ " .  $nLoop . ". / " . $ds['item_code'] . " ] Complete ...!" . "<br>";                        
                    }
                    else
                    {
                        echo "Find Balance-End -> Error ...!" . "<br>";
                        return false;
                    }

                }
                else
                {
                    echo "TRN_Transaction_Movement / Data nto found !..." . "<br>";
                    return false;
                }
            }
            return true;
        }
        else
        {
            echo  "MAS_Balance_Before / Data not found !..." . "<br>";
            return false;
            //echo "<script> alert('Warning! No Data ! ... ); window.location.href='pMain.php'; </script>";
        }
    }
    function Delete_MAS_Balance_Before()
    {
        /*------------------------------------*/
        /* --- Delete MAS_Balance_Before  --- */
        /*------------------------------------*/
        include('include/db_Conn.php');
        $strSql = "DELETE FROM MAS_Balance_Before ";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "Delete MAS_Balance_Before -> Complete ...!" . "<br>";
            return true;
        }
        else
        {
            echo "Delete MAS_Balance_Before -> Error ...!" . "<br>";
            return false;
        }
    }
    function Delete_TRN_Transaction_Movement()
    {
        /*-----------------------------------------*/
        /* --- Delete TRN_Transaction_Movement --- */
        /*-----------------------------------------*/
        include('include/db_Conn.php');
        $strSql = "DELETE FROM TRN_Transaction_Movement ";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "Delete TRN_Transaction_Movement -> Complete ...!" . "<br>";
            return true;
        }
        else
        {
            echo "Delete TRN_Transaction_Movement -> Error ...!" . "<br>";
            return false;
        }
    }
    function Insert_MAS_Balance_End_To_MAS_Balnce_Before()
    {
        /*-----------------------------------------------------*/
        /* --- Insert MAS_Balance_End To MAS_Balnce_Before --- */
        /*-----------------------------------------------------*/
        include('include/db_Conn.php');
        $strSql = "INSERT INTO MAS_Balance_Before ";
        $strSql .= "SELECT * " ;
        $strSql .= "FROM MAS_Balance_End ";        
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "Insert MAS_Balance_End To MAS_Balnce_Before -> Complete ...!" . "<br>";
            return true;
        }
        else
        {
            echo "Insert MAS_Balance_End To MAS_Balnce_Before -> Error ...!" . "<br>";
            return false;
        }
    }
    function Delete_MAS_Balance_End()
    {
        /*---------------------------------*/
        /* --- Delete MAS_Balance_End  --- */
        /*---------------------------------*/
        include('include/db_Conn.php');
        $strSql = "DELETE FROM MAS_Balance_End ";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            echo "Delete MAS_Balance_End -> Complete ...!" . "<br>";
            return true;
        }
        else
        {
            echo "Delete MAS_Balance_End -> Error ...!" . "<br>";
            return false;
        }
    }

    try
    {
        if(Copy_MAS_Balance_Before_To_History())
        {
            if(Copy_TRN_Transaction_Movement_To_History())
            {
                if(Find_Balance_End())
                {
                    if(Delete_MAS_Balance_Before())
                    {
                        if(Delete_TRN_Transaction_Movement())
                        {
                            if(Insert_MAS_Balance_End_To_MAS_Balnce_Before())
                            {
                                if(Delete_MAS_Balance_End())
                                {
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    catch(PDOException $e)
    {
        echo "Error ...! " .$e->getMessage() . "<br>";
    }
?>    