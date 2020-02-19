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
        if($user_user_type == "A" || $user_user_type == "P" || $user_user_type == "U")
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
            
            <!--<body style='background-color:black;'>-->
            <body style='background-color:LightSteelBlue;'>
                <div class="container">
                    <br>
                    
                    <?php require_once("include/submenu_navbar.php"); ?>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-inline">                    
                                <div class="pull-right">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#user_request_insert_modal">
                                        <span class="glyphicon glyphicon-plus"></span> Insert
                                    </button>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                            <!--<h5>User Data:</h5>-->
                            <?php include "user_request_list.php"; ?>
                        </div>
                    </div>
                </div>
                        
                <!-- Modal - Insert Record -->
                <!--<div class="modal fade" id="user_request_insert_modal" tabindex="-1" role="dialog">-->
                <div class="modal fade" id="user_request_insert_modal" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <!-- header -->
                            <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <h4 class="modal-title">Insert Mode :</h4>
                                <!--<h4 class="modal-title">[Requested by : <?php //echo $user_emp_code;?>]</h4>-->
                            </div>
                            
                            <!-- detail -->
                            <form class="form-horizontal" role="form" id='user_request_insert_form' method='post'>
                                <!-- body -->
                                <div class="modal-body" >
                                    <!-- First Row -->
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <input type="hidden" value='<?php echo $user_emp_code;?>' name='param_open_request_by'>
                                        </div>

                                        <div class="col-lg-6">
                                            <label style="display: block; text-align: center;">Requested By:</label>
                                            <select name='emp_code' class="form-control mySelectEmpCode" required>
                                                <option value="">--- Select Employee Code ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Second Row -->
                                    <div class="form-group">                                        
                                        <div class="col-lg-3">
                                            <label style="display: block; text-align: center;">Enter Date:</label>
                                            <input type="date" name="enter_date"  value="<?php echo date('Y-m-d'); ?>" class='form-control' disabled>
                                            <input type="hidden" name="paramenter_date"  value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label style="display: block; text-align: center;">Due Date:</label>
                                            <?php
                                                $timezone = "Asia/bangkok";
                                                date_default_timezone_set($timezone);
                                                $today = date("Y-m-d");

                                                switch(date('w'))
                                                {
                                                    case 0:
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 2 days'));
                                                        break;
                                                    case 1:
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 1 days'));
                                                        break;
                                                    case 2:
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 2 days'));
                                                        break;
                                                    case 3:
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 1 days'));
                                                        break;
                                                    case 4:                                        
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 5 days'));
                                                        break;
                                                    case 5:
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 4 days'));
                                                        break;
                                                    case 6:
                                                        $dueDate = date('Y-m-d', strtotime($today. ' + 3 days'));
                                                        break;                                        
                                                }                                
                                            ?>
                                            <input type='date' name='due_date' value = '<?php echo $dueDate ;?>' class='form-control'>
                                        </div>
                                        <div class="col-lg-3">
                                            <label style="display: block; text-align: center;">Request No.:</label>
                                            <input type="text" name="request_no" class='form-control' value='<?php echo $user_emp_code . '-' . date('Y-m-d')?>' disabled>
                                            <input type="hidden" name="paramrequest_no" value='<?php echo $user_emp_code . '-' . date('Y-m-d')?>'>
                                        </div>
                                        <div class="col-lg-1">
                                            <label style="display: block; text-align: center;">Unit:</label>
                                            <input type="text" id="unit" class='form-control' disabled>
                                        </div>
                                        <div class="col-lg-2">
                                            <label style="display: block; text-align: center;">Current-STK:</label>
                                            <input type="text" id="cur_stk" class='form-control' disabled>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Third Row -->
                                    <div class="form-group">
                                        <div class="col-lg-1">
                                            <label>Line</label>
                                            <input type="text" id="request_line" name ="request_line" class='form-control' required>
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
                                            <select name='item_code' class="form-control mySelect2" required>
                                                <option value="">--- Select Item Code ---</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <label>Quantity:</label>
                                            <input type="number" min="1" max="9" id="quantity" name ='quantity' class='form-control' required>
                                        </div>
                                    </div>
                                </div>

                                <!-- footer -->
                                <div class="modal-footer">
                                    <button type="submit" id='btn_insert' class="btn btn-success">Insert</button>
                                    <!--<button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Close</button>-->
                                </div>
                            </form>            
                        </div>
                    </div>
                </div>

                <!-- Modal - Edit Record -->
                <!--<div class="modal fade" id="user_request_edit_modal" tabindex="-1" role="dialog">-->
                <div class="modal fade" id="user_request_edit_modal" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <!-- header -->
                            <div class="modal-header" style='background-color: SkyBlue; color: Blue;'>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <h4 class="modal-title">Edit Mode :</h4>
                                <!--<h4 class="modal-title">[Edit by : <?php //echo $user_emp_code;?>]</h4>-->
                            </div>
                            
                            <!-- detail -->
                            <form class="form-horizontal" role="form" id='user_request_edit_form' method='post'>
                                <!-- body -->
                                <div class="modal-body" >
                                    <!-- First Row -->
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        </div>

                                        <div class="col-lg-6">
                                            <label style="display: block; text-align: center;">Requested By:</label>
                                            <input type="text" id="view_request_by" class='form-control' disabled>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Second Row -->
                                    <div class="form-group">
                                        <input type="hidden" value='<?php echo $user_emp_code;?>' name='paramrequest_by'>
                                        <div class="col-lg-3">
                                            <label style="display: block; text-align: center;">Enter Date:</label>
                                            <input type="date" id="view_enter_date"  class='form-control' disabled>
                                        </div>
                                        <div class="col-lg-3">
                                            <label style="display: block; text-align: center;">Due Date:</label>
                                            <input type='date' id='edit_due_date' name='edit_due_date' class='form-control'>
                                        </div>
                                        <div class="col-lg-3">
                                            <label style="display: block; text-align: center;">Request No.:</label>
                                            <input type="text" id="view_request_no" class='form-control' disabled>
                                            <input type="hidden" id="edit_request_no" name="edit_request_no">
                                        </div>
                                        <div class="col-lg-1">
                                            <label style="display: block; text-align: center;">Unit:</label>
                                            <input type="text" id="view_unit" class='form-control' disabled>
                                        </div>
                                        <div class="col-lg-2">
                                            <label style="display: block; text-align: center;">Current-STK:</label>
                                            <input type="text" class='form-control' disabled>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Third Row -->
                                    <div class="form-group">
                                        <div class="col-lg-1">
                                            <label>Line</label>
                                            <input type="text" id="view_request_line" class='form-control' disabled>
                                            <input type="hidden" id="edit_request_line" name="edit_request_line">
                                        </div>

                                        <div class="col-lg-2">
                                            <label>Category Code:</label>
                                            <input type="text" id="view_category_code" class='form-control' disabled>
                                        </div>

                                        <div class="col-lg-2">
                                            <label>Item Code:</label>
                                            <input type="text" id="view_item_code" class='form-control' disabled>
                                        </div>

                                        <div class="col-lg-5">
                                            <label>Item Name:</label>
                                            <input type="text" id="view_item_name" class='form-control' disabled>
                                        </div>                                            

                                        <div class="col-lg-2">
                                            <label>Quantity:</label>
                                            <input type="number" min="1" max="9" id="edit_quantity" name ='edit_quantity' class='form-control' required>
                                        </div>
                                    </div>
                                </div>
                                <!-- footer -->
                                <div class="modal-footer">
                                    <button type="submit" id='btn_edit' class="btn btn-success">Edit</button>
                                    <!--<button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Close</button>-->
                                </div>
                            </form>            
                        </div>
                    </div>
                </div>

                <script>
                    //--------------------------
                    // javascript for side-menu
                    //--------------------------
                    $(document).ready(function () {
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

                        /*
                        $( "select[name='item_code']" ).click(function () {
                            var item_code = $(this).val();

                            $.ajax({
                                url: "ajaxInqCurStk.php",
                                method: 'post',
                                dataType: 'json',
                                data: {'item_code' : item_code},
                                success: function(data){
                                    $('#cur_stk').val(data[0]['item_bf_qty']);
                                },
                                error: function(data){
                                    $('#cur_stk').val('0');
                                }
                            });

                        });
                        */

                        $('.mySelect2').change(function(){
                            var item_code = $(this).val();

                            $.ajax({
                                url: "ajaxInqCurStk.php",
                                method: 'post',
                                dataType: 'json',
                                data: {'item_code' : item_code},
                                success: function(data){
                                    $('#cur_stk').val(data[0]['item_bf_qty']);
                                },
                                error: function(data){
                                    $('#cur_stk').val('0');
                                }
                            });
                        });

                        $("#user_request_insert_form").submit(function(event) {
                            /* stop form from submitting normally */
                            event.preventDefault();
                            
                            console.log( $( this ).serialize() );

                            $.ajax({
                                url: "user_request_insert.php",
                                method: "post",
                                data: $('#user_request_insert_form').serialize(),
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
                            var request_no = $(this).attr("request_no");
                            var request_line = $(this).attr("request_line");

                            $.ajax({
                                url: "user_request_fetch.php",
                                method: "post",
                                data: {request_no: request_no, request_line: request_line},
                                dataType: "json",
                                success: function(data)
                                {
                                    $('#view_request_by').val(data['request_by'] + data['emp_name']);

                                    $('#view_enter_date').val(data['enter_date'][0]);
                                    $('#edit_due_date').val(data['due_date']);
                                    $('#view_request_no').val(data['request_no']);
                                    $('#edit_request_no').val(data['request_no']);
                                    $('#view_unit').val(data['unit']);

                                    $('#view_request_line').val(data['request_line']);
                                    $('#edit_request_line').val(data['request_line']);
                                    $('#view_category_code').val(data['category_code']);
                                    $('#view_item_code').val(data['item_code'][0]);
                                    $('#view_item_name').val(data['item_name']);
                                    $('#edit_quantity').val(data['quantity']);

                                    $('#user_request_edit_modal').modal('show');
                                },
                                error: function()
                                {                    
                                    alert(data);
                                }
                            });
                        });

                        $('#user_request_edit_form').submit(function(){
                            /* stop form from submitting normally */
                            event.preventDefault();
                            
                            console.log( $( this ).serialize() );
                            $.ajax({
                                url: "user_request_edit.php",
                                method: "post",
                                data: $('#user_request_edit_form').serialize(),
                                beforeSend:function(){
                                    $('#btn_edit').val('Edit...')
                                },
                                success: function(data){
                                    if (data == '') {
                                        $('#user_request_edit_form')[0].reset();
                                        $('#user_request_edit_modal').modal('hide');
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
                            var request_no = $(this).attr("request_no");
                            var request_line = $(this).attr("request_line");

                            var lConfirm = confirm("Do you want to delete this record?");
                            if (lConfirm)
                            {                
                                $.ajax({
                                    url: "user_request_delete.php",
                                    method: "post",
                                    data: {request_no: request_no, request_line: request_line},
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

                        $('#user_request_insert_modal').on('shown.bs.modal', function(e){
                            $.ajax({
                                url: "ajaxBrowseEmpCode.php",
                                dataType: 'Json',
                                data: {},
                                success: function(data) 
                                {
                                    $('select[name="emp_code"]').empty();

                                    $.each(data, function(key, value) 
                                    {
                                        var emp_code = <?php echo "'" . $user_emp_code . "'";?>;
                                        console.log(key);
                                        console.log(emp_code);

                                        if(key == emp_code)
                                        {
                                            $('select[name="emp_code"]').append('<option selected="selected" value="'+ key +'">'+ value +'</option>');
                                        }
                                        else
                                        {
                                            $('select[name="emp_code"]').append('<option value="'+ key +'">'+ value +'</option>');
                                        }
                                    });

                                    $('.mySelectEmpCode').select2({
                                        width: '100%'
                                    });
                                },
                                error: function(data)
                                {
                                    alert(JSON.stringify(data));
                                }
                                
                            });
                        });
                    });
                </script>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); ";
            echo "window.location.href='pMain.php'; ";
            echo "</script>";
        }
    }
?>