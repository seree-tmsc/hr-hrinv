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
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-2">
                            <label>Request No.:</label>
                            <input style="text-align:center;" type="text" id="edit_RequestNo" class='form-control' disabled>
                            <input type="hidden" id="paramedit_RequestNo" name="edit_RequestNo">
                        </div>
                        <div class="col-lg-2">
                            <label>Enter Date:</label>
                            <input style="text-align:center;" type="text" id="edit_EnterDate" class='form-control' disabled>
                        </div>
                        <div class="col-lg-3">
                            <label>Request Date:</label>
                            <input type="date" id="edit_RequestDate" name="edit_RequestDate" class='form-control'>
                        </div>
                        <div class="col-lg-2">
                            <label>Revise Date:</label>
                            <input style="text-align:center;" type="text" value=<?php echo date('d-M-y');?> class='form-control' disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Item Code:</label>
                            <input style="text-align:center;" type="text" id='edit_ItemCode' class='form-control' disabled>                            
                        </div>
                        <div class="col-lg-5">
                            <label style="display: block; text-align: center;">Item Name:</label>
                            <input type="text" id='edit_ItemName' name='edit_ItemName' class='form-control' disabled>
                        </div>
                        <div class="col-lg-2">
                            <label style="display: block; text-align: center;">Quantity:</label>
                            <input style="text-align:right;" type="text" id='edit_Quantity' name='edit_Quantity' class='form-control'>
                        </div>
                        <div class="col-lg-3">
                            <label style="display: block; text-align: center;">UOM:</label>
                            <input style="text-align:center;" type="text" id='edit_Uom' name='edit_Uom' class='form-control' disabled>
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