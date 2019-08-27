<?php
    //echo $_POST['code'];

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_Item I ";
    $strSql .= "JOIN MAS_Category C ON C.category_code = I.category_code ";
    $strSql .= "WHERE item_code ='" . $_POST['code'] . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    
    $cOutput = "<div class='table-responsive'>";
    $cOutput .= "<table class='table table-bordered'>";

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $cOutput .= "<tr><td style='width:40%;'><label>Category Code</label></td> <td>" . $ds['category_code'][0] . "</td></tr>";
        $cOutput .= "<tr><td><label>Category Name</label></td> <td>" . $ds['category_name'] . "</td></tr>";
        $cOutput .= "<tr><td><label>Item Code</label></td> <td>" . $ds['item_code'] . "</td></tr>";
        $cOutput .= "<tr><td><label>item Name</label></td> <td>" . $ds['item_name'] . "</td></tr>";
        $cOutput .= "<tr><td><label>Enter Date</label></td> <td>" . $ds['enter_date'][0] . "</td></tr>";
        $cOutput .= "<tr><td><label>Enter By</label></td> <td>" . $ds['enter_by'][0] . "</td></tr>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    echo $cOutput;
?>