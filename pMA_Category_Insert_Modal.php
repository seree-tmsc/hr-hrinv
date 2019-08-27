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
                            <input type="date" class='form-control' value="<?php echo date('Y-m-d'); ?>" disabled>                            
                        </div>                        
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Category Code:</label>
                            <input type="text" name ='Cat_Code' class='form-control' required>
                        </div>
                        <div class="col-lg-9">
                            <label style="display: block; text-align: center;">Category Name:</label>
                            <input type="text" name='Cat_Name' class='form-control' required>
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