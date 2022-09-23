<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    //$today=date('Y-m-d');

    $output=[]; 
    $datalist=array();
    // $JanInvoice = array();
    // $FebInvoice = array();
    // $MarInvoice = array();
    // $AprInvoice = array();
    // $MayInvoice = array();
    // $JunInvoice = array();
    // $JulInvoice = array();
    // $AugInvoice = array();
    // $SepInvoice = array();
    // $OctInvoice = array();
    // $NovInvoice = array();
    // $DecInvoice = array();

    $summary = [];


    //////////////////Jan Month//////////////////////////
    $jan = date("Y-01");
    $getJanMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$jan%'");
    if($gjm = $getJanMonthQuary->fetch_array()){
            $jan_invoice = $gjm[0];
            $summary['jan'] = $jan_invoice;

            // array_push($JanInvoice,$jan_invoice);
    }

    //////////////////Feb Month//////////////////////////
    $feb = date("Y-02");
    $getFebMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$feb%'");
    if($gfm = $getFebMonthQuary->fetch_array()){
            $feb_invoice = $gfm[0];
            $summary['feb'] = $feb_invoice;

                // array_push($FebInvoice,$feb_invoice);
    }

    //////////////////Mar Month//////////////////////////
    $mar = date("Y-03");
    $getMarMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$mar%'");
    if($gmm = $getMarMonthQuary->fetch_array()){
            $mar_invoice = $gmm[0];
            $summary['mar'] = $mar_invoice;

                // array_push($MarInvoice,$mar_invoice);
    }

    //////////////////Apr Month//////////////////////////
    $apr = date("Y-04");
    $getAprMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$apr%'");
    if($gam = $getAprMonthQuary->fetch_array()){
            $apr_invoice = $gam[0];
            $summary['apr'] = $apr_invoice;

                // array_push($AprInvoice,$apr_invoice);
    }

    //////////////////May Month//////////////////////////
    $may = date("Y-05");
    $getMayMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$may%'");
    if($gmam = $getMayMonthQuary->fetch_array()){
            $may_invoice = $gmam[0];
            $summary['may'] = $may_invoice;

                // array_push($MayInvoice,$may_invoice);
    }

    //////////////////Jun Month//////////////////////////
    $jun = date("Y-06");
    $getJunMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$jun%'");
    if($gjum = $getJunMonthQuary->fetch_array()){
            $jun_invoice = $gjum[0];
            $summary['jun'] = $jun_invoice;

                // array_push($JunInvoice,$jun_invoice);
    }

    //////////////////Jul Month//////////////////////////
    $jul = date("Y-07");
    $getJulMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$jul%'");
    if($gjulm = $getJulMonthQuary->fetch_array()){
            $jul_invoice = $gjulm[0];
            $summary['jul'] = $jul_invoice;

                // array_push($JulInvoice,$jul_invoice);
    }

    //////////////////Aug Month//////////////////////////
    $aug = date("Y-08");
    $getAugMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$aug%'");
    if($gaum = $getAugMonthQuary->fetch_array()){
            $aug_invoice = $gaum[0];
            $summary['aug'] = $aug_invoice;

                // array_push($AugInvoice,$aug_invoice);
    }

    //////////////////Sep Month//////////////////////////
    $sep = date("Y-09");
    $getSepMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$sep%'");
    if($gsm = $getSepMonthQuary->fetch_array()){
            $sep_invoice = $gsm[0];
            $summary['sep'] = $sep_invoice;

                // array_push($SepInvoice,$sep_invoice);
    }

    //////////////////Oct Month//////////////////////////
    $oct = date("Y-10");
    $getOctMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$oct%'");
    if($gom = $getOctMonthQuary->fetch_array()){
            $oct_invoice = $gom[0];
            $summary['oct'] = $oct_invoice;

                // array_push($OctInvoice,$oct_invoice);
    }

    //////////////////Nov Month//////////////////////////
    $nov = date("Y-11");
    $getNovMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$nov%'");
    if($gnm = $getNovMonthQuary->fetch_array()){
            $nov_invoice = $gnm[0];
            $summary['nov'] = $nov_invoice;
                // array_push($NovInvoice,$nov_invoice);
    }

    //////////////////Dec Month//////////////////////////
    $dec = date("Y-12");
    $getDecMonthQuary = $conn->query("SELECT SUM(ti.grand_total) FROM invoice_save ti WHERE ti.invoice_save_datetime LIKE '%$dec%'");
    if($gdm = $getDecMonthQuary->fetch_array()){
            $dec_invoice = $gdm[0];
            $summary['dec'] = $dec_invoice;

                // array_push($DecInvoice,$dec_invoice);
    }

    /////////////////////////////////////////////////////

    $output['result']=true;
    $output['summary_data'] = $summary;

    // $output['janInvoice'] = $JanInvoice;
    // $output['febInvoice'] = $FebInvoice;
    // $output['marInvoice'] = $MarInvoice;
    // $output['aprInvoice'] = $AprInvoice;
    // $output['mayInvoice'] = $MayInvoice;
    // $output['junInvoice'] = $JunInvoice;
    // $output['julInvoice'] = $JulInvoice;
    // $output['augInvoice'] = $AugInvoice;
    // $output['sepInvoice'] = $SepInvoice;
    // $output['octInvoice'] = $OctInvoice;
    // $output['novInvoice'] = $NovInvoice;
    // $output['decInvoice'] = $DecInvoice;


    echo json_encode($output);