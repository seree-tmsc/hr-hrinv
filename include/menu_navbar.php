<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" 
                class="navbar-toggle collapsed" 
                data-toggle="collapse" 
                data-target="#navbar" 
                aria-expanded="false" 
                aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<img src="images/tmsc-logo-128.png" width="96" class="img-responsive center-block">-->
            <img src="images/tmsc-logo-128.png" width="96">
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="pMain.php">
                        <span class="fa fa-home fa-lg" style="color:blue"></span>
                        Home
                    </a>                            
                </li>                
            </ul>            

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-database fa-lg" style="color:blue"></span> 
                        Maintain
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="pMA_Category.php">
                                <span class='fa fa-square-o fa-lg' style="color:navy"></span>
                                Category
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="pMA_Item.php">
                                <span class='fa fa-square-o fa-lg' style="color:navy"></span>
                                Item
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-file-o fa-lg" style="color:blue"></span> 
                        User request
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>                             
                            <a href="pMA_Request.php">
                                <span class="fa fa-square-o fa-lg" style="color:navy"></span> 
                                User request for Item
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-list fa-lg" style="color:blue"></span> 
                        Issue - Receive
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>                             
                            <a href="pMA_Issue_Main.php" >
                                <span class="fa fa-minus-square fa-lg" style="color:navy"></span> 
                                Items Issue
                            </a>
                        </li>
                        <li class="divider">
                        <li>                             
                            <a href="pMA_Receive_Main.php" >
                                <span class="fa fa-plus-square fa-lg" style="color:navy"></span> 
                                Items Receive
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Menu Report -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-print fa-lg" style="color:blue"></span> 
                        Report
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="rpt_PickingList_Main.php">
                                <span class='fa fa-square-o fa-lg' style="color:navy"></span>
                                Monthly Request Report
                                <!-- add dropdownlist ALL/Closed/Open เพื่อเลือก ประเภท -->
                                <!-- Req.Date / Req.No. / Cat.Code / Cat.Name / Item Code / itrm Name / Unit / QTY / Req.By / Status / Iss-Date -->
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="rpt_SumMonthlyInv.php" target='_blank'>
                                <span class='fa fa-square-o fa-lg' style="color:navy"></span>
                                Monthly Inventory Report
                                <!-- Cat.Code / Cat.Name / Item Code. / Item Name / BF / In / OUT / BE -->
                            </a>
                        </li>
                        <li>
                            <a href="rpt_SumMonthlyInvHist_Main.php">
                                <span class='fa fa-square-o fa-lg' style="color:navy"></span>
                                History Inventory Report
                                <!-- Cat.Code / Cat.Name / Item Code. / Item Name / BF / In / OUT / BE -->
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="list_HistInv_Criteria.php">
                                <span class='fa fa-square-o fa-lg' style="color:navy"></span>
                                History Inventory List
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-wrench fa-lg" style="color:blue"></span> 
                        Tools
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="closeMonthPeriodMain.php">
                                <span class='fa fa-square-o fa-lg' style="color:blue"></span>
                                Close Month Period
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="pMA_User.php">
                                <span class='fa fa-address-card-o' style="color:blue"></span>
                                User Management
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class='fa fa-user-circle-o fa-lg' style="color:blue"></span> 
                        Login as ... 
                        <?php echo $_SESSION["ses_email"];?> 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>                                
                            <a href="#" data-toggle="modal" data-target="#chgpasswordModal">
                                <span class='fa fa-pencil-square-o fa-lg'></span> 
                                Change Password
                            </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>                                
                            <a href="#" data-toggle="modal" data-target="#logoutModal">
                                <span class="fa fa-sign-out fa-lg"></span> 
                                logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>