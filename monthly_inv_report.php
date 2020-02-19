<?php
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
            if($user_user_type == "A" or $user_user_type == "P")
            {                     
                require_once('include/db_Conn.php');
                $strSql = "SELECT * ";
                $strSql .= "FROM MAS_Balance_Before B ";
                $strSql .= "JOIN MAS_Item I ON I.item_code = B.item_code ";
                $strSql .= "ORDER BY I.category_code, I.item_code ";
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
                            $this->Image('images/tmsc-new-logo-long1.gif', 55, 10, 100);

                            $aMonth = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
                            //assign font                                        
                            $this->SetFont('Arial','B',12);
                            $this->SetTextColor(0, 0, 0);
                            $this -> SetY(22);
                            $this -> SetX(0);
                            //คำสั่งสำหรับขึ้นบรรทัดใหม่
                            //cell(width, height, text, border, in, align, fill, link)
                            $this->Cell( 0, 10, 'Monthly Inventory Report', 0, 0, 'C');

                            $this->Ln();                        
                            $this->SetFont('Arial','',10);
                            $this->SetFillColor(255,102,102);
                            $this->Cell( 10, 10, '', 0, 0, 'C');
                            $this->Cell( 20, 10, 'Doc.No.', 1, 0, 'C', true);
                            $this->Cell( 25, 10, 'Iss./Rec.Date', 1, 0, 'C', true);
                            $this->Cell( 40, 10, 'Ref.No.', 1, 0, 'C', true);
                            $this->Cell( 20, 10, 'IN', 1, 0, 'C', true);
                            $this->Cell( 20, 10, 'OUT', 1, 0, 'C', true);
                            $this->Cell( 20, 10, 'BALANCE', 1, 0, 'C', true);
                            $this->Cell( 15, 10, 'Trn.Type', 1, 0, 'C', true);
                            $this->Cell( 20, 10, 'By Who', 1, 0, 'C', true);
                            $this->Ln();
                        }                    
                        
                        // Page footer
                        function Footer()
                        {
                            $this->SetTextColor(0, 0, 0);
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
                    // Add Thai font
                    $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
                    $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
                    $pdf->AddFont('THSarabunNew','I','THSarabunNew_i.php');
                    $pdf->AddFont('THSarabunNew','BI','THSarabunNew_bi.php');

                    $pdf->AliasNbPages();

                    //add page
                    $pdf->AddPage();

                    /*-------------------*/
                    /*--- Print Body --- */
                    /*-------------------*/
                    while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                    {
                        $pdf->SetFont('THSarabunNew','',16);
                        /*----------------------------*/
                        /*--- Print Balance Before ---*/
                        /*----------------------------*/
                        $pdf->SetTextColor(0, 0, 255);
                        $pdf->Cell( 10, 10, '', 0, 0, 'C');
                        $pdf->Cell( 22, 10, 'Item Code :', 'L', 0, 'L');
                        $pdf->Cell( 30, 10, $ds['item_code'][0], 0, 0, 'L');
                        $pdf->Cell( 128, 10, iconv('UTF-8', 'cp874', $ds['item_name']), 'R', 0, 'L');
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
                        $strSql1 .= "FROM TRN_Transaction_Movement T ";
                        //$strSql1 .= "JOIN MAS_Item I ON I.item_code = T.item_code ";
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
                                $pdf->SetFont('THSarabunNew','',14);

                                /*------------------------------*/
                                /*--- Print Detail each line ---*/
                                /*------------------------------*/
                                

                                switch ($ds1['transaction_type'])
                                {
                                    case '-':
                                        $pdf->SetTextColor(255, 0, 0);
                                        $pdf->Cell( 10, 10, '', 0, 0, 'C');
                                        $pdf->Cell( 20, 10, $ds1['doc_no'], 1, 0, 'L');
                                        $pdf->Cell( 25, 10, date('d/M/Y', strtotime($ds1['iss_po_date'])), 1, 0, 'C');
                                        $pdf->Cell( 40, 10, $ds1['req_no'], 1, 0, 'L');
                                        $pdf->Cell( 20, 10, "-", 1, 0, 'R');
                                        $pdf->Cell( 20, 10, $ds1['item_qty'], 1, 0, 'R');
                                        $nBalanceEnd = $nBalanceEnd - $ds1['item_qty'];
                                        break;

                                    case '+':
                                        $pdf->SetTextColor(0, 128, 0);
                                        $pdf->Cell( 10, 10, '', 0, 0, 'C');
                                        $pdf->Cell( 20, 10, $ds1['doc_no'], 1, 0, 'L');
                                        $pdf->Cell( 25, 10, date('d/M/Y', strtotime($ds1['iss_po_date'])), 1, 0, 'C');
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
            else
            {
                echo "<script> alert('You are not authorization for this menu ... Please contact your administrator'); window.location.href='pMain.php'; </script>";
            }
    
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>