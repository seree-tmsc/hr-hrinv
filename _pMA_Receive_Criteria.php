<?php
    include_once('include/chk_Session.php');
    if($user_email == "")
    {
        echo "<script> 
                alert('Warning! Please Login!'); 
                window.location.href='login.php'; 
            </script>";
    }
    else
    {
        if($user_user_type == "A" or $user_user_type == "P")
        {
?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>HR Inventory System [v.1.0]</title>
                <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />

                <?php require_once("include/library.php"); ?>    
            </head>

            <body>                
                <div class="container">
                    <br>                    
                    <?php require_once("include/submenu_navbar.php"); ?>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">                                                        
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    Criteria [Items Receive]                                 
                                </div>

                                <div class="panel-body">
                                    <form method="post" action="pMA_Receive.php">
                                        <!-------------------------->
                                        <!-- Dropdownlist Invoice -->
                                        <!-------------------------->
                                        <div class="form-group">
                                            <label for="title">Select Category :</label>
                                            <select name="categories" class="form-control" style="width:500px" required>
                                                <option value="">--- Select Category Name ---</option>
                                                <?php                        
                                                    require_once('include/db_Conn.php');

                                                    $strSql = "select * ";
                                                    $strSql .= "from MAS_Category ";
                                                    $strSql .= "order by category_name ";
                                                    echo $strSql . "<br>";

                                                    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                                                    $statement->execute();  
                                                    $nRecCount = $statement->rowCount();
                                                    //echo $nRecCount . " records <br>";
                                                        
                                                    if ($nRecCount >0)
                                                    {
                                                        while($ds = $statement->fetch(PDO::FETCH_NAMED))
                                                        {
                                                            echo "<option value='" . $ds['category_code']. "'>" . $ds['category_name'] . "</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <input type="hidden" name="catCode">
                                        </div>

                                        <!-------------------------->
                                        <!-- Dropdownlist Lot No. -->
                                        <!-------------------------->
                                        <div class="form-group">
                                            <label for="title">Select Item :</label>
                                            <select name="items" class="form-control" style="width:500px">
                                            <option value="">--- Select Item Name ---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button type="submit" style="float: right; margin:2px;" class="btn btn-success">
                                                    <span class="fa fa-check fa-lg">&nbsp&nbsp&nbspOK</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>                                
                            </div>
                        </div>
                    </div> 
                </div>

                <script>
                    $( "select[name='categories']" ).click(function () 
                    {
                        var categoryCode = $(this).val();                        
                        //console.log(categoryCode);

                        if(categoryCode)
                        {
                            $.ajax({
                                url: "ajaxBrowseItemName.php",
                                dataType: 'Json',
                                data: {'categoryCode':categoryCode},
                                success: function(data) 
                                {
                                    $('select[name="items"]').empty();

                                    $.each(data, function(key, value) 
                                    {
                                        $('select[name="items"]').append('<option value="'+ key +'">'+ value +'</option>');
                                    });
                                }
                            });
                        }
                        else
                        {
                            $('select[name="items"]').empty();
                        }
                    });
                </script>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator'); window.location.href='pMain.php'; </script>";
        }
    }
?>