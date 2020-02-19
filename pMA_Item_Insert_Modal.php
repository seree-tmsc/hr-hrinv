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
                            <input style="text-align: right;" type="date" class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>
                        </div>                        
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Category Code:</label>
                            <!--<input type="text" name ='Cat_Code' class='form-control' required>-->

                            <select name="category-ddl" class="form-control">
                                <option value="">-- Category --</option>

                                <?php                        
                                    require_once('include/db_Conn.php');

                                    $strSql = "SELECT * ";
                                    $strSql .= "FROM MAS_Category ";                                    
                                    $strSql .= "ORDER BY category_code ";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                                    $statement->execute();  
                                    $nRecCount = $statement->rowCount();
                                    //echo $nRecCount . " records <br>";
                                        
                                    if ($nRecCount >0)
                                    {
                                        while($ds = $statement->fetch(PDO::FETCH_NAMED))
                                        {
                                            //echo "<option value='" . $ds['category_code'] . "'>". $ds['category_code'] . ' - ' . $ds['category_name'] . "</option>";
                                            echo "<option value='" . $ds['category_code'] . "'>". $ds['category_code'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>

                        </div>

                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Item Code:</label>
                            <input type="text" name ='Item_Code' class='form-control' required>
                        </div>

                        <div class="col-lg-5">
                            <label style="display: block; text-align: center;">Item Name:</label>
                            <input type="text" name='Item_Name' class='form-control' required>
                        </div>

                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Unit:</label>

                            <select name="uom-ddl" class="form-control">
                                <option value="">-- UOM --</option>

                                <?php                        
                                    require_once('include/db_Conn.php');

                                    $strSql = "SELECT * ";
                                    $strSql .= "FROM MAS_Unit_Of_Measurement ";                                    
                                    $strSql .= "ORDER BY uom_code ";
                                    //echo $strSql . "<br>";

                                    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                                    $statement->execute();  
                                    $nRecCount = $statement->rowCount();
                                    //echo $nRecCount . " records <br>";
                                        
                                    if ($nRecCount >0)
                                    {
                                        while($ds = $statement->fetch(PDO::FETCH_NAMED))
                                        {
                                            //echo "<option value='" . $ds['uom_code'] . "'>". $ds['uom_code'] . ' - ' . $ds['uom_name'] . "</option>";
                                            echo "<option value='" . $ds['uom_code'] . "'>". $ds['uom_code'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>

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