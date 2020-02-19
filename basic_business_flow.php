<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>

        <link rel="stylesheet" href="basic_business_flow.css">
        <link rel="stylesheet" href="../vendors/font-awesome-4.7.0/css/font-awesome.css">

        <script src="../vendors/jquery-3.2.1/jquery-3.2.1.js"></script>

        <style>
            h2
            {
                cursor: pointer;
            }
            p
            {
                color: navy;
            }
        </style>        
    </head>

    <body>
        <div class="timeline">
            <div class="container right">
                <div class="content">
                    <h2 id='menu6' style='color: skyblue;'><i class="fa fa-home" style="font-size:48px;color:skyblue"></i> HOME</h2>
                    <p>- กลับสู่เมนูหลัก</p>
                    <br>
                    <h2>Basic Business Flow Of HR-INV</h2>
                    <p>เนื้อหาในส่วนนี้ จะเป็นทางลัด ที่จะช่วยให้คุณใช้ระบบ HR-INV ได้สะดวกยิ่งขึ้น</p>
                </div>
            </div>

            <hr style="height:2px; border:none; background-color:silver; background: linear-gradient(to right, red, yellow)">
            
            <div class="container left">
                <div class="content">
                    <h2 id='menu1'>Open request by end-user</h2>
                    <p>- ผู้ใช้งานทำการเปิดใบร้องขอ (Request) เพื่อขอเบิกรายการอุปกรณ์ต่าง ๆ ที่ต้องการ</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2 id='menu2'>Preparation Stationary, Uniform  or Other Items By HR</h2>
                    <p>- เจ้าหน้าที่ฝ่ายบุคคล ทำการจัดเตรียมรายการอุปกรณ์ต่าง ๆ ที่ขอเบิก และทำการส่งมอบ รายการอุปกรณ์ต่าง ๆ ให้ผู้ใช้งาน</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2 id='menu3' style='color: red;'>Issue Item by HR</h2>
                    <p>- เจ้าหน้าที่ฝ่ายบุคคล ทำการ ตัดรายการอุปกรณ์ต่าง ๆ ที่ถูกเบิก ออกจากสต๊อก</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2 id='menu4' style='color :green;'>Receive Item By HR</h2>
                    <p>- เจ้าหน้าที่ฝ่ายบุคคล ทำการ รับรายการอุปกรณ์ต่าง ๆ ที่จัดซื้อ เพิ่มเข้าสู่สต๊อก</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2 id='menu5'>Checking Inventory By HR</h2>
                    <p>- เจ้าหน้าที่ฝ่ายบุคคล ทำการ ตรวจสอบปริมาณ การเบิก - การรับ รายการอุปกรณ์ต่าง ๆ</p>
                </div>
            </div>

            <hr style="height:2px; border:none; background-color:silver; background: linear-gradient(to right, red, yellow)">
        </div>

        <script>
            $(document).ready(function(){
                $('#menu1').click(function(){
                    window.open("user_request.php", "_blank");
                });

                $('#menu2').click(function(){
                    window.open("user_request_all_lst_criteria.php", "_blank");
                });

                $('#menu3').click(function(){
                    window.open("item_issue_criteria.php", "_blank");
                });

                $('#menu4').click(function(){
                    window.open("item_receive_criteria.php", "_blank");
                });

                $('#menu5').click(function(){
                    window.open("monthly_inv_list.php", "_blank");
                });

                $('#menu6').click(function(){
                    window.location.href = "pMain.php";
                });
            })
        </script>
    </body>
</html>