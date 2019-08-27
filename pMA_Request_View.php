<?php
    //echo $_POST['request_no'];

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_Request R ";
    $strSql .= "JOIN MAS_Item I ON R.item_code = I.item_code ";
    $strSql .= "JOIN MAS_Category C ON I.category_code = C.category_code ";
    $strSql .= "WHERE R.request_no =" . $_POST['request_no'] ;
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    
    $cOutput = "<div class='table-responsive'>";
    $cOutput .= "<table class='table table-bordered'>";

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $cOutput .= "<tr><td style='width:40%; color:red;'><label>Request No.</label></td> <td style='color:red;'>" . $ds['request_no'] . "</td></tr>";
        $cOutput .= "<tr><td><label>Category Code</label></td> <td>" . $ds['category_code'][0] . "</td></tr>";
        $cOutput .= "<tr><td><label>Category Name</label></td> <td>" . $ds['category_name'] . "</td></tr>";
        $cOutput .= "<tr><td><label>Item Code</label></td> <td>" . $ds['item_code'][0] . "</td></tr>";
        $cOutput .= "<tr><td><label>item Name</label></td> <td>" . $ds['item_name'] . "</td></tr>";
        $cOutput .= "<tr><td><label>UOM</label></td> <td>" . $ds['unit'] . "</td></tr>";
        $cOutput .= "<tr><td><label>QTY</label></td> <td>" . $ds['quantity'] . "</td></tr>";
        $cOutput .= "<tr><td><label>Request Date</label></td> <td>" . date('d/M/Y', strtotime($ds['enter_date'][0])) . "</td></tr>";
        $cOutput .= "<tr><td><label>Due Date</label></td> <td>" . date('d/M/Y', strtotime($ds['due_date'])) . "</td></tr>";
        $cOutput .= "<tr><td><label>Request By</label></td> <td>" . $ds['request_by'] . "</td></tr>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    echo $cOutput;
?>