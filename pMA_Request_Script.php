
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.btnClose').click(function(){
            $('#insert-form')[0].reset();            
        })

        /*-------------------------------------------------------------------------------------------*/
        /* when submit id=insert-form from modal form then call ajax to run Insert.php  */
        /*-------------------------------------------------------------------------------------------*/
        $("#insert-form").submit(function(event) {
            alert('You click insert button!');

            /* stop form from submitting normally */
            event.preventDefault();
            
            console.log( $( this ).serialize() );

            $.ajax({
                url: "pMA_Request_Insert.php",
                method: "post",
                data: $('#insert-form').serialize(),
                beforeSend:function(){
                    $('#insert').val('Insert...')
                },
                
                success: function(data){
                    if (data == '')
                    {
                        $('#insert-form')[0].reset();
                        $('#insert_modal').modal('hide');
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

        /*-----------------------------------------------------------------------------------*/
        /* when click class view_data from list then call ajax to run View.php  */
        /*-----------------------------------------------------------------------------------*/
        $('.view_data').click(function(){
            //alert('You click class view_data');

            var request_no = $(this).attr("request_no");
            //alert(code);

            $.ajax({
                url: "pMA_Request_View.php",
                method: "post",
                data: {request_no: request_no},
                success: function(data){
                    $('#view_detail').html(data);
                    $('#view_modal').modal('show');
                }
            });
        });

        /*------------------------------------------------------------------------------------*/
        /* when click class edit_data from list then call ajax to run Fetch.php  */
        /*------------------------------------------------------------------------------------*/
        $('.edit_data').click(function(){
            //alert('You click class edit_data ...!');

            var request_no = $(this).attr("request_no");
            //alert(request_code);

            $.ajax({
                url: "pMA_Request_Fetch.php",
                method: "post",
                data: {request_no: request_no},
                dataType: "json",
                
                success: function(data)
                {
                    var month = new Array();
                    month[0] = "Jan";
                    month[1] = "Feb";
                    month[2] = "Mar";
                    month[3] = "Apr";
                    month[4] = "May";
                    month[5] = "Jun";
                    month[6] = "Jul";
                    month[7] = "Aug";
                    month[8] = "Sep";
                    month[9] = "Oct";
                    month[10] = "Nov";
                    month[11] = "Dec";

                    var cDay = new Date(data['enter_date'][0]).getDate();
                    var cMonth = new Date(data['enter_date'][0]).getMonth();
                    var cYear = new Date(data['enter_date'][0]).getFullYear();
                    var cEnterDate = cDay.toString() + "-" + month[cMonth] + "-" + cYear.toString();
                    //alert(typeof cDay);
                    
                    $('#edit_RequestNo').val(data['request_no']);
                    $('#paramedit_RequestNo').val(data['request_no']);
                    $('#edit_EnterDate').val(cEnterDate);
                    $('#edit_RequestDate').val(data['due_date']);
                    $('#edit_ItemCode').val(data['item_code'][0]);
                    $('#edit_ItemName').val(data['item_name']);
                    $('#edit_Quantity').val(data['quantity']);
                    $('#edit_Uom').val(data['unit']);

                    $('#edit_modal').modal('show');                    
                },
                error: function()
                {                    
                    alert('Error ...!');
                }
            });
        });

        $("#edit-form").submit(function(event) {
            //alert('You click edit button!');

            /* stop form from submitting normally */
            event.preventDefault();            
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "pMA_Request_Edit.php",
                method: "post",
                data: $('#edit-form').serialize(),
                beforeSend:function(){
                    $('#edit').val('Edit...')
                },
                success: function(data){
                    if (data == '') {
                        $('#edit-form')[0].reset();
                        $('#edit_modal').modal('hide');
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
        
        /*---------------------------------------------------------------------------------------*/
        /* when click class delete_data from list then call ajax to run Delete.php  */
        /*---------------------------------------------------------------------------------------*/
        $('.delete_data').click(function(){
            //alert('You click class delete_data');
            
            var request_no = $(this).attr("request_no");
            //alert(request_no);

            var lConfirm = confirm("Do you want to delete this record?");
            if (lConfirm)
            {                
                $.ajax({
                    url: "pMA_Request_Delete.php",
                    method: "post",
                    data: {request_no: request_no},

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
        
        
        /*---------------------------------------------------------------------------------------*/
        /* when click class delete_data from list then call ajax to run pMA_Category_Delete.php  */
        /*---------------------------------------------------------------------------------------*/
        $( "select[name='item-ddl']" ).click(function ()
        {
            //alert('You click drop-down-list');

            var tmpString = $(this).val();
            console.log(tmpString);
            itemCode = tmpString.substring(0,4);
            console.log(itemCode);

            if(itemCode)
            {
                $.ajax({
                    url: "ajaxBrowseUom.php",
                    dataType: 'Json',
                    data: {'id' : itemCode},
                    success: function(data)
                    {
                        $('select[name="uom-ddl"]').empty();
                        $.each(data, function(key, value)
                        {
                            $('select[name="uom-ddl"]').append('<option value="'+ key +'">'+ value +'</option>');
                            $('#uom').val(value);
                        });
                    }
                });
            }
            else
            {
                $('select[name="uom-ddl"]').empty();
                //$('input[name="item_Uom"]').empty();
            }
        });

    });

    function formatMoney(inum) // ฟังก์ชันสำหรับแปลงค่าตัวเลขให้อยู่ในรูปแบบ เงิน
    {
        var s_inum=new String(inum);
        var num2=s_inum.split(".");
        var n_inum="";  
        if(num2[0] != undefined)
        {
            var l_inum=num2[0].length;  
            for(i=0;i<l_inum;i++)
            {  
                if(parseInt(l_inum-i)%3 == 0)
                {  
                    if(i==0)
                    {  
                        n_inum+=s_inum.charAt(i);         
                    }
                    else
                    {  
                        n_inum+=","+s_inum.charAt(i);         
                    }     
                }
                else
                {  
                    n_inum+=s_inum.charAt(i);  
                }  
            }  
        }
        else
        {            
            n_inum=inum;
        }
        
        if(num2[1] != undefined)
        {
            n_inum+="."+num2[1];
        }

        return n_inum;
    }

    function func_show_Uom() 
    {
        var selectItem = document.getElementById("item-ddl");
        var selectedUom = selectItem.options[selectItem.selectedIndex].value;
        alert(selectedUom);
   }
</script>