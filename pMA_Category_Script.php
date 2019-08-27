
<script type="text/javascript">
    $(document).ready(function(){
        $('.btnClose').click(function(){
            $('#insert-form')[0].reset();            
        })

        /*-------------------------------------------------------------------------------------------*/
        /* when submit id=insert-form from modal form then call ajax to run pMA_Category_Insert.php  */
        /*-------------------------------------------------------------------------------------------*/
        $("#insert-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();            
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "pMA_Category_Insert.php",
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
        /* when click class view_data from list then call ajax to run pMA_Category_View.php  */
        /*-----------------------------------------------------------------------------------*/
        $('.view_data').click(function(){
            //alert('You click class view_data');

            var code = $(this).attr("category_code");
            //alert(code);

            $.ajax({
                url: "pMA_Category_View.php",
                method: "post",
                data: {code: code},
                success: function(data){
                    $('#view_detail').html(data);
                    $('#view_modal').modal('show');
                }
            });
        });
                
        $("#edit-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();            
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "pMA_Category_Edit.php",
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
        
        /*------------------------------------------------------------------------------------*/
        /* when click class edit_data from list then call ajax to run pMA_Category_Fetch.php  */
        /*------------------------------------------------------------------------------------*/
        $('.edit_data').click(function(){
            //alert('You click class edit_data ...!');

            var code = $(this).attr("category_code");
            //alert(code);        

            $.ajax({
                url: "pMA_Category_Fetch.php",
                method: "post",
                data: {code: code},
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

                    var cDay = new Date(data['enter_date']).getDate();
                    var cMonth = new Date(data['enter_date']).getMonth();
                    var cYear = new Date(data['enter_date']).getFullYear();
                    var cDate = cDay.toString() + "/" + month[cMonth] + "/" + cYear.toString();
                    //alert(typeof cDay);
                    
                    $('#edit_EnterDate').val(cDate);
                    $('#edit_CategoryCode').val(data['category_code']);
                    $('#paramedit_CategoryCode').val(data['category_code']);
                    $('#edit_CategoryName').val(data['category_name']);

                    $('#edit_modal').modal('show');                    
                },
                error: function()
                {                    
                    alert('Error ...!');
                }
            });
        });
        
        /*---------------------------------------------------------------------------------------*/
        /* when click class delete_data from list then call ajax to run pMA_Category_Delete.php  */
        /*---------------------------------------------------------------------------------------*/
        $('.delete_data').click(function(){
            //alert('You click class view_data');

            var code = $(this).attr("category_code");
            //alert(code);            

            var lConfirm = confirm("Do you want to delete this record?");
            if (lConfirm)
            {                
                $.ajax({
                    url: "pMA_Category_Delete.php",
                    method: "post",
                    data: {code: code},
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
</script>