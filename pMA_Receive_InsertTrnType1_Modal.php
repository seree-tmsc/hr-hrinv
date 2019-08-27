<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog">
    
    <div class="modal-dialog role="document">
    <!--<div class="modal-dialog modal-lg" role="document">-->
        <div class="modal-content">
            <div class="modal-header" style='background-color: SeaGreen; color: Lime;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Insert Mode: [Insert by <?php echo $user_emp_code;?>]</h4>
            </div>
            
            <form class="form-horizontal" role="form" id='insert-form' method='post'>
                <div class="modal-body" id="insert_detail">
                    <?php
                        /*
                        echo $cItem_Code;
                        echo $cItem_Name;
                        */
                    ?>
                    
                    <div class="form-group">
                        <div class="col-lg-4">
                            <label style="display: block; text-align: center;">PO Date:</label>
                            <input type="date" name='paramPo_Date' class='form-control' value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-lg-6">
                            <label style="display: block; text-align: center;">PO No.:</label>
                            <input style="text-align: right;" type="text" name='paramPo_No' class='form-control' required>
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Trn.Type:</label>
                            <input style="text-align: center;" type="text" class='form-control' value="+" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Item Code:</label>
                            <input type="text" class='form-control' value="<?php echo $cItem_Code; ?>" disabled>
                            <input type="hidden" name='paramItem_Code' value="<?php echo $cItem_Code; ?>">
                            <input type="hidden" name='paramEmp_Code' value="<?php echo $user_emp_code; ?>">
                        </div>
                        <div class="col-lg-7">
                            <label style="display: block; text-align: center;">Item Name:</label>
                            <input type="text" class='form-control' value="<?php echo $cItem_Name; ?>" disabled>
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Qty:</label>
                            <input type="number" name='paramQty' class='form-control' value=1 required>
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