<?php
    require_once('include/db_Conn.php');
    
    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_Balance_Before ";
    $strSql .= "WHERE item_code='" . $_POST['item_code'] . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    if ($nRecCount > 0)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $cKey = $ds['item_code'];
        $nCurStk = $ds['item_bf_qty'];

        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_Transaction_Movement ";
        $strSql .= "WHERE item_code='" . $_POST['item_code'] . "' ";
        $strSql .= "ORDER BY iss_po_date, transaction_type ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . " records <br>";

        if ($nRecCount > 0)
        {
            while($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                if($ds['transaction_type'] == '+')
                {
                    $nCurStk += $ds['item_qty'];
                }
                else
                {
                    $nCurStk -= $ds['item_qty'];
                }
            }
            $nValue = $nCurStk;
            $json_data[] = array("item_code" => $cKey, "item_bf_qty" => $nValue);
            echo json_encode($json_data);
        }
        else
        {
            $nValue = $nCurStk;
            $json_data[] = array("item_code" => $cKey, "item_bf_qty" => $nValue);
            echo json_encode($json_data);
        }
    }
?>