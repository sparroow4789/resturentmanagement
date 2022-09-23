<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    $currentDate=date('Y-m-d H:i:s');

    $ProductCount=0;
    $SubTotal=0;
    $ServiceCharge=0;

    $output=[];
    // $printPreview = "------------------------------------\n";
    // $printPreview.="------------------------------------";

    if($_POST)
    {
        $invoice_id = htmlspecialchars($_POST['invoice_id']);

        $getInvoiceQuery=$conn->query("SELECT * FROM invoice_details WHERE invoice_details_id='$invoice_id'");
        while ($GIrs=$getInvoiceQuery->fetch_array()) {
            $ResturentTableId=$GIrs[1];
            $PaymentStatus=$GIrs[2];
            $InvoiceType=$GIrs[3];
            $InvoiceDiscount=$GIrs[5];
            $InvoiceDate=$GIrs[6];

        }

        $ProductQuantityPlusSql = "UPDATE invoice_details SET payment_status='2' WHERE invoice_details_id='$invoice_id' ";

        if ($conn->query($ProductQuantityPlusSql) === TRUE) 
        {


            $getInvoiceQuery=$conn->query("SELECT * FROM invoice_product ip INNER JOIN product_badge_details pbd ON ip.product_badge_id=pbd.product_badge_id INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE ip.invoice_id='$invoice_id' ORDER BY ip.invoice_product_id ASC");
            while ($GIrs=$getInvoiceQuery->fetch_array()) {
                $InvoiceProductId=$GIrs[0];
                $InvoiceId=$GIrs[1];
                $InvoiceBadgeId=$GIrs[2];
                $InvoiceQty=$GIrs[3];
                $InvoiceProductDateTime=$GIrs[4];

                $ProductNameId=$GIrs[6];
                $ProductBadgeLabel=$GIrs[7];
                $ProductUnitPrice=$GIrs[9];
                $ProductPrice=$GIrs[9];
                $ProductBadgeQuantity=$GIrs[11];
                                                                                      
                $ProductName=$GIrs[14];
                $ProductCode=$GIrs[15];

                $ItemPriceWithQty = (double)$ProductPrice * (double)$InvoiceQty;

                $SubTotal += (double)$ItemPriceWithQty;

                $ProductCountList=$ProductCount+=1;

                //Invoice Product Save
                $pInvoiceId = $invoice_id;
                $pBadgeId = $InvoiceBadgeId;
                $pDetails = $ProductCountList.','.$ProductName.' - '.$ProductBadgeLabel.','.$ProductUnitPrice.','.$InvoiceQty.','.$ItemPriceWithQty;

                $conn->query("INSERT INTO invoice_save_product VALUES(null, '$pInvoiceId','$pBadgeId','$pDetails')");
                //Invoice Product Save


                // $printPreview.=$ProductBadgeLabel." \n";

            }

                    //Calculation Start
                    $TotalServiceCharge = ((double)$SubTotal * (double)$ServiceCharge)/100;
                    $SubTotalWithServiceCharge = (double)$SubTotal + (double)$TotalServiceCharge;
                    //Discount
                    $TotalDiscount = ((double)$SubTotal * (double)$InvoiceDiscount)/100;
                    $FullTotal = (double)$SubTotalWithServiceCharge - (double)$TotalDiscount;
                    //Calculation End



                //Invoice Save Details
                $conn->query("INSERT INTO invoice_save VALUES(null, '$invoice_id',null,'$SubTotal','$TotalServiceCharge','$TotalDiscount','$FullTotal','$currentDate')");
                //Invoice Save Details



            // echo 'Completed';
            $output['result'] = true;
            $output['msg'] = 'Successfully saved.';

        }else{

            $output['result']=false;
            $output['msg']="Error saving record.";

        }


    }else{
            $output['result']=false;
            $output['msg']="Invalid request, Please try again.";
    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>