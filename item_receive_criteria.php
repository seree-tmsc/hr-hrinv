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
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    Criteria [ Receive from PO. Date ]
                                </div>

                                <div class="panel-body">
                                    <form method="post" action="item_receive.php">
                                        <div class="form-group">
                                            <label for="title">Select PO.Date :</label>
                                            <input type="date" name="po_date" value='<?php echo date('Y-m-d')?>' class='form-control'>
                                        </div>

                                        <div class="form-group">                                            
                                            <button type="submit" style="float: right; margin:2px;" class="btn btn-success">
                                                <span class="fa fa-check fa-lg">&nbsp&nbsp&nbspOK</span>
                                            </button>
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