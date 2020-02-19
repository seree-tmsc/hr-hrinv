<?php
    /*
    echo $_POST['cYear'] . "<br>";
    echo $_POST['cMonth'] . "<br>";
    */

    try
    {
        date_default_timezone_set("Asia/Bangkok");
        include_once('include/chk_Session.php');
        if($user_email == "")
        {
            echo "<script> 
                    alert('Warning! Please Login!'); 
                    window.location.href='login.php'; 
                </script>";
        }
        else
        {            
            require_once('include/db_Conn.php');            
            $cMAS_Balance_Before="MAS_Balance_Before_" . $_POST['cYear'] . $_POST['cMonth'];
            $cTRN_Transaction_Movement="TRN_Transaction_Movement_" . $_POST['cYear'] . $_POST['cMonth'];
            
            $strSql = "SELECT * ";
            $strSql .= "FROM " . $cMAS_Balance_Before . " B ";
            $strSql .= "JOIN MAS_Item I ON I.item_code = B.item_code ";
            $strSql .= "ORDER BY I.item_code ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . " records <br>";

            if ($nRecCount > 0)
            {   
                /*----------------------------------*/
                /*--- Initial Important Library --- */
                /*----------------------------------*/                
                // import library
                require("../vendors/fpdf16/fpdf.php");

                /*------------------------------*/
                /*-- creat class for all page --*/
                /*------------------------------*/
                class PDF extends FPDF
                {
                    // Page header
                    function Header()
                    {
                        // set margin
                        $this->SetMargins(5,0);
                        $this->SetAutoPageBreak(true, 15);

                        // Logo                                                
                        //$this->Image('images/tmsc-new-logo-long1.gif', 98, 6, 100);
                        $this->Image('images/tmsc-new-logo-long1.gif', 55, 10, 100);

                        $aMonth = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
                        //assign font                                        
                        $this->SetFont('Arial','B',12);
                        $this -> SetY(25);
                        $this -> SetX(0);
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        //cell(width, height, text, border, in, align, fill, link)
                        $this->Cell( 0, 10, 'Monthly Inventory Report [' . $aMonth[(int)$_POST['cMonth']-1]."/".$_POST['cYear'] . "]", 0, 0, 'C');
                        /*
                        $this -> SetY(25);
                        $this -> SetX(0);
                        $this->Cell( 0, 10, 'For : '. $aMonth[$_POST['nMonth']-1] . ' / '. $_POST['nYear'], 0, 0, 'C');
                        */
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        /*
                        $this->Ln();
                        $this->Cell( 0, 0, '', 1, 0, 'C');
                        */
                        $this->Ln();
                        $this->SetFont('Arial','',10);
                        $this->SetFillColor(255,102,102);
                        $this->Cell( 10, 10, '', 0, 0, 'C');
                        $this->Cell( 20, 10, 'Doc.No.', 1, 0, 'C', true);
                        $this->Cell( 25, 10, 'Date', 1, 0, 'C', true);
                        //$this->Cell( 20, 10, 'Item Code', 1, 0, 'C', true);
                        //$this->Cell( 80, 10, 'Item Name', 1, 0, 'C', true);
                        $this->Cell( 40, 10, 'Ref.No.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'IN', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'OUT', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'BALANCE', 1, 0, 'C', true);
                        $this->Cell( 15, 10, 'Trn.Type', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Req.By', 1, 0, 'C', true);
                        $this->Ln();

                        /*
                        // Arial bold 15
                        $this->SetFont('Arial','B',15);
                        // Move to the right
                        $this->Cell(80);
                        // Title
                        $this->Cell(30,10,'Title',1,0,'C');
                        // Line break
                        $this->Ln(20);
                        */
                    }                    
                    
                    // Page footer
                    function Footer()
                    {
                        // Position at 1.5 cm from bottom
                        $this->SetY(-15);
                        // Arial italic 8
                        $this->SetFont('Arial','I',8);                        
                        // Print current and total page numbers
                        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
                        $tDate = date('d/M/Y - H:i');                        
                        $this->Cell(0, 10, 'Print Date : '.$tDate, 0, 0, 'R');
                    }
                }
                
                // creat instant
                $pdf=new PDF('P', 'mm', 'A4');
                $pdf->AliasNbPages();

                //add page
                $pdf->AddPage();

                /*-------------------*/
                /*--- Print Body --- */
                /*-------------------*/                
                $pdf->SetFont('Arial','',10);
                

                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    /*----------------------------*/
                    /*--- Print Balance Before ---*/
                    /*----------------------------*/
                    $pdf->SetTextColor(255, 0, 0);
                    $pdf->Cell( 10, 10, '', 0, 0, 'C');
                    $pdf->Cell( 25, 10, 'Item Code :', 'L', 0, 'L');
                    $pdf->Cell( 20, 10, $ds['item_code'][0], 0, 0, 'L');
                    //$pdf->Cell( 25, 10, 'Item Name :', 0, 0, 'L');
                    $pdf->Cell( 135, 10, $ds['item_name'], 'R', 0, 'L');
                    $pdf->Ln();

                    $pdf->SetTextColor(0,0,0);
                    $nBalanceEnd = $ds['item_bf_qty'];
                    $pdf->Cell( 10, 10, '', 0, 0, 'C');
                    $pdf->Cell( 20, 10, '', 1, 0, 'C');
                    $pdf->Cell( 25, 10, date('d/M/Y' , strtotime($ds['item_bf_date'])), 1, 0, 'C');
                    $pdf->Cell( 80, 10, 'B/F', 1, 0, 'R');
                    $pdf->Cell( 20, 10, $nBalanceEnd, 1, 0, 'R');
                    $pdf->Cell( 15, 10, '', 1, 0, 'C');
                    $pdf->Cell( 20, 10, '', 1, 0, 'C');
                    $pdf->Ln();

                    /*------------------------------*/
                    /*--- Print detail each line ---*/
                    /*------------------------------*/
                    $strSql1 = "SELECT * ";
                    $strSql1 .= "FROM " . $cTRN_Transaction_Movement . " T ";
                    $strSql1 .= "WHERE T.item_code = '" . TRIM($ds['item_code'][0]) . "' ";
                    $strSql1 .= "ORDER BY T.iss_po_date, T.transaction_type DESC, T.doc_no ";
                    //echo $strSql1 . "<br>";

                    $statement1 = $conn1->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                    $statement1->execute();
                    $nRecCount1 = $statement1->rowCount();
                    //echo $nRecCount1 . " records <br>";

                    if ($nRecCount > 0)
                    {
                        while ($ds1 = $statement1->fetch(PDO::FETCH_NAMED))
                        {
                            /*------------------------------*/
                            /*--- Print Detail each line ---*/
                            /*------------------------------*/
                            $pdf->Cell( 10, 10, '', 0, 0, 'C');
                            $pdf->Cell( 20, 10, $ds1['doc_no'], 1, 0, 'L');
                            $pdf->Cell( 25, 10, date('d/M/Y', strtotime($ds1['iss_po_date'])), 1, 0, 'C');
                            //$pdf->Cell( 40, 10, $ds1['item_code'][0], 1, 0, 'L');
                            //$pdf->Cell( 40, 10, $ds1['item_name'], 1, 0, 'L');

                            switch ($ds1['transaction_type'])
                            {
                                case '-':
                                    $pdf->Cell( 40, 10, $ds1['req_no'], 1, 0, 'L');
                                    $pdf->Cell( 20, 10, "-", 1, 0, 'R');
                                    $pdf->Cell( 20, 10, $ds1['item_qty'], 1, 0, 'R');
                                    $nBalanceEnd = $nBalanceEnd - $ds1['item_qty'];
                                    break;

                                case '+':
                                    $pdf->Cell( 40, 10, $ds1['po_no'], 1, 0, 'L');
                                    $pdf->Cell( 20, 10, $ds1['item_qty'], 1, 0, 'R');
                                    $pdf->Cell( 20, 10, "-", 1, 0, 'R');
                                    $nBalanceEnd = $nBalanceEnd + $ds1['item_qty'];
                                    break;
                            }
                            $pdf->Cell( 20, 10, $nBalanceEnd, 1, 0, 'R');
                            $pdf->Cell( 15, 10, $ds1['transaction_type'], 1, 0, 'C');
                            $pdf->Cell( 20, 10, $ds1['enter_by'], 1, 0, 'L');
                            /*
                            $pdf->Ln();
                            $pdf->SetFillColor(128,128,128);
                            $pdf->Cell( 25, 10, '', 0, 0, 'C');
                            $pdf->Cell( 30, 10, '', 1, 0, 'L');
                            $pdf->Cell( 58, 10, 'Why process delay', 1, 0, 'L');
                            $pdf->Cell( 50, 10, $ds['Why_process_delay'], 1, 0, 'L');
                            $pdf->Cell( 40, 10, 'Why start delay', 1, 0, 'L');                    
                            $pdf->Cell( 54, 10, $ds['Why_start_delay'], 1, 0, 'L');
                            */
                            $pdf->Ln();
                        }
                    }

                    /*-------------------------*/
                    /*--- Print Balance End ---*/
                    /*-------------------------*/
                }

                /*---------------------*/
                /*--- Print Footer --- */
                /*---------------------*/
                //print to output
                $pdf->Output();
            }
            else
            {
                echo "<script> alert('Error! ... Not Found Production Schedule Data ! ...'); window.close(); </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>