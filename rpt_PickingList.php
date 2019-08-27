<?php
    /*
    echo $_POST['cMonth'] . "<br>";
    echo $_POST['cYear'] . "<br>";
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

            $strSql = "SELECT * ";
            $strSql .= "FROM TRN_Request R ";
            $strSql .= "JOIN MAS_Item I ON I.item_code = R.item_code ";
            $strSql .= "JOIN MAS_Category C ON C.category_code = I.category_code ";
            $strSql .= "WHERE MONTH(R.due_date) = " . $_POST['cMonth'] . " AND YEAR(R.due_date)=" . $_POST['cYear'] . " " ;
            $strSql .= "ORDER BY R.enter_date, R.request_no ";
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
                        $this->Image('images/tmsc-new-logo-long1.gif', 95, 10, 100);

                        $aMonth = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
                        //assign font                                        
                        $this->SetFont('Arial','B',12);
                        $this -> SetY(25);
                        $this -> SetX(0);
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        //cell(width, height, text, border, in, align, fill, link)
                        $this->Cell( 0, 10, 'Monthly Request Report [' . $aMonth[(int)$_POST['cMonth']-1] . " - " . $_POST['cYear'] . "]", 0, 0, 'C');
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
                        $this->Cell( 5, 10, '', 0, 0, 'C');

                        $this->Cell( 25, 10, 'Req.Date', 1, 0, 'C', true);
                        $this->Cell( 30, 10, 'Req.No.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Cat.Code.', 1, 0, 'C', true);
                        $this->Cell( 30, 10, 'Cat.Name', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Item Code', 1, 0, 'C', true);
                        $this->Cell( 70, 10, 'Item Name', 1, 0, 'C', true);
                        $this->Cell( 12, 10, 'Unit', 1, 0, 'C', true);
                        $this->Cell( 12, 10, 'Qty.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Req.By', 1, 0, 'C', true);
                        $this->Cell( 15, 10, 'Status', 1, 0, 'C', true);
                        $this->Cell( 25, 10, 'Iss.Date', 1, 0, 'C', true);
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
                $pdf=new PDF('L', 'mm', 'A4');
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
                    //$pdf->SetTextColor(255, 0, 0);
                    $pdf->Cell( 5, 10, '', 0, 0, 'C');

                    $pdf->Cell( 25, 10, date('d/M/Y', strtotime($ds['enter_date'][0])), 'LR', 0, 'L');
                    $pdf->Cell( 30, 10, $ds['request_no'], 'R', 0, 'L');
                    $pdf->Cell( 20, 10, $ds['category_code'][0], 'R', 0, 'L');
                    $pdf->Cell( 30, 10, $ds['category_name'], 'R', 0, 'L');
                    $pdf->Cell( 20, 10, $ds['item_code'][0], 'R', 0, 'L');
                    $pdf->Cell( 70, 10, $ds['item_name'], 'R', 0, 'L');
                    $pdf->Cell( 12, 10, trim($ds['unit']), 'R', 0, 'C');
                    $pdf->Cell( 12, 10, $ds['quantity'], 'R', 0, 'R');
                    $pdf->Cell( 20, 10, $ds['request_by'], 'R', 0, 'L');
                    if($ds['issue_status'] == 0)
                    {
                        $pdf->SetTextColor(0, 0, 255);
                        $pdf->Cell( 15, 10, 'Open', 'R', 0, 'C');
                        $pdf->SetTextColor(0, 0, 0);
                    }
                    else
                    {
                        $pdf->SetTextColor(255, 0, 0);
                        $pdf->Cell( 15, 10, 'Closed', 'R', 0, 'C');
                        $pdf->SetTextColor(0, 0, 0);
                    }
                    $pdf->Cell( 25, 10, date('d/M/Y', strtotime($ds['due_date'])), 'R', 0, 'C');
                    $pdf->Ln();

                    /*------------------------------*/
                    /*--- Print detail each line ---*/
                    /*------------------------------*/                    
                }

                /*---------------------*/
                /*--- Print Footer --- */
                /*---------------------*/
                //print to output
                $pdf->Cell( 5, 10, '', 0, 0, 'C');

                $pdf->Cell( 25, 10, '', 'LRB', 0, 'L');
                $pdf->Cell( 30, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 30, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 70, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 12, 10, '', 'RB', 0, 'C');
                $pdf->Cell( 12, 10, '', 'RB', 0, 'R');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 15, 10, '', 'RB', 0, 'C');
                $pdf->Cell( 25, 10, '', 'RB', 0, 'C');
                $pdf->Ln();
                $pdf->Output();
            }
            else
            {
                echo "<script> alert('Error! ... Not Found Request Data ! ...'); window.close(); </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>