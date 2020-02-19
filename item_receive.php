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
        if($user_user_type == "A")
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
                        <div class="col-lg-12">
                            <div class="form-inline">
                                <div class="pull-left alert alert-info">
                                    <b>PO.Date.: <?php echo date('Y-m-d', strtotime($_POST['po_date']))?></b>
                                    <?php $GLOBALS['g_po_date']  = $_POST['po_date']?>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#item_receive_insert_modal">
                                        <span class="glyphicon glyphicon-plus"></span> Insert
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                                include "item_receive_list.php"; 
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Modal - Insert Record -->
                <div class="modal fade" id="item_receive_insert_modal" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style='background:lightgreen;'>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Insert Data [By : <?php echo $user_emp_code; ?>] </h4>
                            </div>

                            <div class="modal-body"> 
                                <form method='post' id='item_receive_insert_form'>
                                    <!-- data area -->
                                    <div class="panel panel-success">
                                        <div class="panel-body">
                                            <!-- first row -->
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label>Po.Date:</label>
                                                    <input type="date" class='form-control' value='<?php echo $g_po_date?>' disabled>
                                                    <input type="hidden" name='po_date' value='<?php echo $g_po_date?>'>
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Po.No.</label>
                                                    <input type="text" id="po_no" name ="po_no" class='form-control' required>
                                                    <input type="hidden" id="emp_code" name ="emp_code" value='<?php echo $user_emp_code; ?>'>
                                                </div>
                                            </div>

                                            <br>

                                            <!-- seconde row -->
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <label>Line</label>
                                                    <input type="text" id="po_line" name ="po_line" class='form-control' required>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label>Category Code:</label>
                                                    <select name="category_code" class="form-control" required>
                                                        <option value="">--- Select Category Code ---</option>
                                                        <?php
                                                            require_once('include/db_Conn.php');

                                                            $strSql = "select * ";
                                                            $strSql .= "from MAS_Category ";
                                                            $strSql .= "order by category_code ";
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
                                                </div>

                                                <div class="col-lg-5">
                                                    <label>Item Code:</label>
                                                    <select name="item_code" class="form-control mySelect2" required>
                                                        <option value=""></option>
                                                    </select>
                                                </div>                                            

                                                <div class="col-lg-2">
                                                    <label>Quantity:</label>
                                                    <input type="number" min="1" id="item_qty" name ='item_qty' class='form-control' required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- submit button -->
                                    <div class="form-inline">
                                        <div class="pull-right">
                                            <button type="submit" id='btn_insert' class="btn btn-success">Insert</button>
                                            <!--<input type="submit" class='btn btn-success' id='btn_insert' >-->
                                        </div>
                                    </div>
                                    <br>
                                </form>    
                            </div>

                            <br>
                        </div>                        
                    </div>
                </div>

                <!-- Modal - Edit Record -->
                <div class="modal fade" id="item_receive_edit_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style='background:lightgreen;'>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Edit Data [By : <?php echo $user_emp_code; ?>] </h4>
                            </div>

                            <div class="modal-body"> 
                                <form method='post' id='item_receive_edit_form'>
                                    <div class="panel panel-success">
                                        <div class="panel-body">
                                            <!-- first row -->
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label>Po.Date:</label>
                                                    <input type="date" id="view_po_date" name ='edit_po_date' class='form-control' disabled>
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Po.No.</label>
                                                    <input type="text" id="view_po_no" class='form-control' disabled>
                                                    <input type="hidden" id = "edit_po_no" name="edit_po_no">
                                                    <input type="hidden" id="edit_emp_code" name ="edit_emp_code" value='<?php echo $user_emp_code; ?>'>
                                                </div>
                                            </div>
                                            
                                            <br>
                                            
                                            <!-- second row -->
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <label>Line</label>
                                                    <input type="text" id="view_po_line" class='form-control' disabled>
                                                    <input type="hidden" id = "edit_po_line" name="edit_po_line">
                                                </div>

                                                <div class="col-lg-4">
                                                    <label>Category Code:</label>
                                                    <input type="text" id="view_category_code" class='form-control' disabled>
                                                </div>

                                                <div class="col-lg-5">
                                                    <label>Item Code:</label>
                                                    <input type="text" id="view_item_code" class='form-control' disabled>
                                                </div>                                            

                                                <div class="col-lg-2">
                                                    <label>Quantity:</label>
                                                    <input type="number" min="1" id="edit_item_qty" name="edit_item_qty" class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-inline">
                                        <div class="pull-right">
                                            <input type="submit" class='btn btn-success' id='btn_edit' >        
                                        </div>
                                    </div>
                                    <br>
                                </form>    
                            </div>

                            <br>
                        </div>                        
                    </div>
                </div>

                <script>
                    $( "select[name='category_code']" ).click(function () {
                        var category_code = $(this).val();

                        if(category_code)
                        {
                            $.ajax({
                                url: "ajaxBrowseItemCode.php",
                                dataType: 'Json',
                                data: {'category_code':category_code},
                                success: function(data) 
                                {
                                    $('select[name="item_code"]').empty();

                                    $.each(data, function(key, value) 
                                    {
                                        $('select[name="item_code"]').append('<option value="'+ key +'">'+ value +'</option>');
                                    });

                                    $('.mySelect2').select2();
                                }
                            });
                        }
                        else
                        {
                            $('select[name="item_code"]').empty();
                        }
                    });

                    $( "select[name='edit_category_code']" ).click(function () {
                        var category_code = $(this).val();

                        if(category_code)
                        {
                            $.ajax({
                                url: "ajaxBrowseItemCode.php",
                                dataType: 'Json',
                                data: {'category_code':category_code},
                                success: function(data) 
                                {
                                    $('select[name="edit_item_code"]').empty();

                                    $.each(data, function(key, value) 
                                    {
                                        $('select[name="edit_item_code"]').append('<option value="'+ key +'">'+ value +'</option>');
                                    });
                                }
                            });
                        }
                        else
                        {
                            $('select[name="edit_item_code"]').empty();
                        }
                    });

                    $("#item_receive_insert_form").submit(function(event) {
                        /* stop form from submitting normally */
                        event.preventDefault();
                        
                        console.log( $( this ).serialize() );

                        $.ajax({
                            url: "item_receive_insert.php",
                            method: "post",
                            data: $('#item_receive_insert_form').serialize(),
                            beforeSend:function(){
                                $('#btn_insert').val('Inserting...')
                            },
                            success: function(data){
                                alert(data);
                                location.reload();
                            },
                            error: function(data){
                                alert(data);
                                location.reload();
                            }
                        });
                    });

                    $('.edit_data').click(function(){
                        var po_no = $(this).attr("po_no");
                        var po_line = $(this).attr("po_line");

                        $.ajax({
                            url: "item_receive_fetch.php",
                            method: "post",
                            data: {po_no: po_no, po_line: po_line},
                            dataType: "json",
                            success: function(data)
                            {
                                $('#view_po_date').val(data['iss_po_date']);
                                
                                $('#view_po_no').val(data['po_no']);
                                $('#edit_po_no').val(data['po_no']);

                                $('#view_po_line').val(data['po_line']);
                                $('#edit_po_line').val(data['po_line']);

                                $('#view_category_code').val(data['category_code']);
                                
                                $('#view_item_code').val(data['item_code']);
                                
                                $('#edit_item_qty').val(data['item_qty']);

                                $('#item_receive_edit_modal').modal('show');                    
                            },
                            error: function()
                            {                    
                                alert(data);
                            }
                        });
                           
                    });

                    $('#item_receive_edit_form').submit(function(){
                        //alert('You click edit button!');

                        /* stop form from submitting normally */
                        event.preventDefault();            
                        
                        console.log( $( this ).serialize() );
                        $.ajax({
                            url: "item_receive_edit.php",
                            method: "post",
                            data: $('#item_receive_edit_form').serialize(),
                            beforeSend:function(){
                                $('#btn_edit').val('Edit...')
                            },
                            success: function(data){
                                if (data == '') {
                                    $('#item_receive_edit_form')[0].reset();
                                    $('#item_receive_edit_modal').modal('hide');
                                    location.reload();
                                }
                                else
                                {
                                    alert(data);
                                    location.reload();
                                }
                            }
                        });
                    });

                    $('.delete_data').click(function(){
                        var po_no = $(this).attr("po_no");
                        var po_line = $(this).attr("po_line");

                        var lConfirm = confirm("Do you want to delete this record?");
                        if (lConfirm)
                        {                
                            $.ajax({
                                url: "item_receive_delete.php",
                                method: "post",
                                data: {po_no: po_no, po_line: po_line},
                                success: function(data){
                                    alert("Data was deleted completely ...!");
                                    location.reload();
                                },
                                error: function(){
                                    alert("Error ...!");
                                }
                            });  
                        } 
                    });
                </script>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
        }
    }
?>