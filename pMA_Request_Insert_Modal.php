<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Insert Mode: [Insert by <?php echo $user_emp_code;?>]</h4>
            </div>
            
            <form class="form-horizontal" role="form" id='insert-form' method='post'>
                <div class="modal-body" id="insert_detail">                    
                    <div class="form-group">
                        <input type="hidden" value='<?php echo $user_emp_code;?>' name='Enter_By'>
                        <div class="col-lg-9">
                        </div>
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Enter Date:</label>
                            <!--<input style="text-align: right;" type="text" name="ent_date"  value="<?php //echo date('d-M-Y'); ?>" class='form-control' disabled>-->
                            <input type="date" name="ent_date"  value="<?php echo date('Y-m-d'); ?>" class='form-control' disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-5">
                            <label style="display: block; text-align: center;">Item Code:</label>
                            <!--<input type="text" name ='Cat_Code' class='form-control' required>-->

                            <!--<select name="item-ddl" id="item-ddl" class="form-control" onchange="func_show_Uom();">-->
                            <select name="item-ddl" id="item-ddl" class="form-control">
                                <option value="">-- Item --</option>

                                <?php                        
                                    require_once('include/db_Conn.php');

                                    $strSql = "SELECT * ";
                                    $strSql .= "FROM MAS_Item ";                                    
                                    $strSql .= "ORDER BY Item_name ";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                                    $statement->execute();  
                                    $nRecCount = $statement->rowCount();
                                    //echo $nRecCount . " records <br>";
                                        
                                    if ($nRecCount >0)
                                    {
                                        while($ds = $statement->fetch(PDO::FETCH_NAMED))
                                        {
                                            echo "<option value='" . $ds['item_code'] . "'>". $ds['item_code'] . ' - ' . $ds['item_name'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>

                        </div>

                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Quantity:</label>
                            <input type="text" name ='qty' class='form-control' required>
                        </div>

                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">UOM:</label>
                            <select name="uom-ddl" class="form-control" disabled>
                            </select>
                            <input type="hidden" id="uom" name ='uom' class='form-control' >
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
                    </div>
                </div>                        
                
                <div class="modal-footer">
                    <button type="submit" id='insert' class="btn btn-success">Insert</button>
                    <button type="button" class="btn btn-close btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>            
        </div>
    </div>
</div>