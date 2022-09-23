<?php

	require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    //$today=date('Y-m-d');

    
    
    if(isset($_POST['start_date']) && isset($_POST['end_date'])){
        
        $start_date=htmlspecialchars($_POST['start_date']);
        $end_date=htmlspecialchars($_POST['end_date']);
        $tableTotal = 0.0;
        $takeawayTotal = 0.0;
        $uberTotal = 0.0;
        $grandTotal = 0.0;
        ////////////////
        $tableCount = 0;
        $takeawayCount = 0;
        $uberCount = 0;
        $allBillCount = 0;

        $output['result'] = true;

        //invoice_save is -->ti ////////


        //get table Total/////////
        $getTableTotal = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE id.invoice_type = '1' AND DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($gt = $getTableTotal->fetch_array()){
            // $productIncome = number_format($pi[0],2);
            $tableTotal = $gt[0];
        }
        ////////////////////////
        //get table invoice count/////////
        $getTableCount = $conn->query("SELECT COUNT(*) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE id.invoice_type = '1' AND DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($gtc = $getTableCount->fetch_array()){
            
            $tableCount = $gtc[0];
        }
        ////////////////////////


        //get Takeaway Total/////////
        $getTakeawayTotal = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE id.invoice_type = '2' AND DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($tt = $getTakeawayTotal->fetch_array()){
            // $serviceIncome = number_format($si[0],2);
            $takeawayTotal = $tt[0];
        }
        ////////////////////////
        //get Takeaway invoice count/////////
        $getTakeawayCount = $conn->query("SELECT COUNT(*) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE id.invoice_type = '2' AND DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($gtac = $getTakeawayCount->fetch_array()){
            
            $takeawayCount = $gtac[0];
        }
        ////////////////////////


        //get Uber Total/////////
        $getUberTotal = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE id.invoice_type = '3' AND DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($gu = $getUberTotal->fetch_array()){
            // $grandTotalIncome = number_format($gti[0],2);
            $uberTotal = $gu[0];
        }
        ////////////////////////
        //get Uber PickMe invoice count/////////
        $getUberCount = $conn->query("SELECT COUNT(*) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE id.invoice_type = '3' AND DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($guc = $getUberCount->fetch_array()){
            
            $uberCount = $guc[0];
        }
        ////////////////////////


        //get Grand Total/////////
        $getGrandTotal = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($gt = $getGrandTotal->fetch_array()){
            
            $grandTotal = $gt[0];
        }
        ////////////////////////
        //get all bill count/////////
        $getAllBillCount = $conn->query("SELECT COUNT(*) FROM invoice_save ti INNER JOIN invoice_details id ON ti.invoice_id=id.invoice_details_id WHERE DATE(ti.invoice_save_datetime) BETWEEN '$start_date' AND '$end_date'");
        if($gabc = $getAllBillCount->fetch_array()){
            
            $allBillCount = $gabc[0];
        }
        ////////////////////////

        
        $output['table_total'] = $tableTotal;
        $output['takeaway_total'] = $takeawayTotal;
        $output['uber_total'] = $uberTotal;

        //////////////////////////////////////////////////

        $output['table_count'] = $tableCount;
        $output['takeaway_count'] = $takeawayCount;
        $output['uber_count'] = $uberCount;

        $output['grand_total'] = $grandTotal;
        $output['all_bill_count'] = $allBillCount;
       
        
        
    }else{
        $output['result']=false;
        $output['msg']="Invalid request, Please try again.";
    }
    
    echo json_encode($output);
    
    
    