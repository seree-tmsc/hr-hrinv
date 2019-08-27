<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <!--<div class="modal-content" style='background-color: rgb(178, 231, 247);'>-->
        <div class="modal-content">
            <div class="modal-header" style='background-color: rgb(8, 188, 243);color: navy;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Mode : [Update by <?php echo $user_emp_code;?>]</h4>
            </div>
            
            <form class="form-horizontal" role="form" id='edit-form' method='post'>
                <!--<div class="modal-body" id="edit_detail">-->
                <input type="hidden" name='paramEnt_By' value=<?php echo $user_emp_code;?>>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-6">
                        </div>                        
                        <div class="col-lg-3">
                            <label>Last Enter Date:</label>
                            <input type="text" id="edit_EnterDate" class='form-control' disabled>
                        </div>
                        <div class="col-lg-3">
                            <label>Revise Date:</label>
                            <input type="text" value=<?php echo date('d/M/y');?> class='form-control' disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">Category Code:</label>
                            <input type="text" id='edit_CategoryCode' class='form-control' disabled>
                            <input type="hidden" id="paramedit_CategoryCode" name="paramedit_CategoryCode">
                        </div>
                        <div class="col-lg-9">
                            <label style="display: block; text-align: center;">Category Name:</label>
                            <input type="text" id='edit_CategoryName' name='edit_CategoryName' class='form-control'>
                        </div>
                    </div>                                    
                </div>
                
                <div class="modal-footer">
                    <button type="submit" id='insert' class="btn btn-success">Edit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>                    
                </div>
            </form>            
        </div>
    </div>
</div>