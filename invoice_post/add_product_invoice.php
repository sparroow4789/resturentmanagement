<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();

    $ProductCount=0;
    $SubTotal=0;

    //Start Service Charge
    $getServiceChargeQuery=$conn->query("SELECT * FROM service_charge ORDER BY service_charge_id DESC LIMIT 1");
    if ($GSCrs=$getServiceChargeQuery->fetch_array()) {
        $ServiceCharge=$GSCrs[1];
    }
    //End Service Charge

    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $invoice_id = htmlspecialchars($_POST['invoice_id']);
        $product_badge_id = htmlspecialchars($_POST['product_badge_id']);
        
        $product_quantity = '1';

        //Start Get Invoice Details
        $getInvoiceQuery=$conn->query("SELECT * FROM invoice_details WHERE invoice_details_id='$invoice_id'");
        if ($GIrs=$getInvoiceQuery->fetch_array()) {
            $ResturentTableId=$GIrs[1];
            $PaymentStatus=$GIrs[2];
            $InvoiceType=$GIrs[3];
            $InvoiceWaiterId=$GIrs[4];
            $InvoiceDiscount=$GIrs[5];
            $InvoiceDate=$GIrs[6];
        }
        //End Get Invoice Details



        $checkProductSameCount = $conn->query("SELECT count(*) FROM invoice_product WHERE product_badge_id='$product_badge_id' AND invoice_id='$invoice_id' ");
            if($qRS = $checkProductSameCount->fetch_array()){
            $ProductSameCount = (int)$qRS[0];

            if($ProductSameCount == 0){


                $sql = "INSERT INTO `invoice_product`(`invoice_id`, `product_badge_id`, `product_quantity`) VALUES (?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "sss", $invoice_id, $product_badge_id, $product_quantity);
                $result = mysqli_stmt_execute($stmt);
                if($result)
                {
                    // echo 'Completed';
                    $ProductQuantitysql = "UPDATE product_badge_details SET quantity=quantity-'$product_quantity' WHERE product_badge_id='$product_badge_id' ";

                    if ($conn->query($ProductQuantitysql) === TRUE) {
                    //   echo "Record updated successfully";
                
                        $getProductRecord=$conn->query("SELECT * FROM invoice_product ipr INNER JOIN product_badge_details pbd ON ipr.product_badge_id=pbd.product_badge_id INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE ipr.invoice_id='$invoice_id' ORDER BY ipr.invoice_product_id ASC");
                        while($gprRs=$getProductRecord->fetch_array()){

                            $InvoiceProductId=$gprRs[0];
                            $InvoiceId=$gprRs[1];
                            $ProductBadgeId=$gprRs[2];
                            $ProductQuantity=$gprRs[3];
                                                      
                            $ProductNameId=$gprRs[6];
                            $ProductBadgeLabel=$gprRs[7];
                            $ProductUnitPrice=number_format($gprRs[9],2);
                            $ProductPrice=$gprRs[9];
                            $ProductBadgeQuantity=$gprRs[11];
                                                          
                            $ProductName=$gprRs[14];
                            $ProductCode=$gprRs[15];


                            $ProductCountList=$ProductCount+=1;

                          // $DiscountAmount = ((double)$ProductPrice * (double)$ProductDiscount) / 100;
                          // $TotalPriceWithDisc = (double)$ProductPrice - $DiscountAmount;
                          // $ItemPriceWithQty = number_format($TotalPriceWithDisc * $ProductQuantity,2);
                            
                            $ItemPriceWithQty = number_format((double)$ProductPrice * (double)$ProductQuantity,2);


                            /////////////Calculation///////////////////
                            $ItemPriceWithQtyForCount = (double)$ProductPrice * (double)$ProductQuantity;
                            $SubTotal += (double)$ItemPriceWithQtyForCount;

                            //Service Charge
                            $TotalServiceCharge = ((double)$SubTotal * (double)$ServiceCharge)/100;
                            $SubTotalWithServiceCharge = (double)$SubTotal + (double)$TotalServiceCharge;
                            //Discount
                            $TotalDiscount = ((double)$SubTotal * (double)$InvoiceDiscount)/100;
                            $FullTotal = (double)$SubTotalWithServiceCharge - (double)$TotalDiscount;

                            /////////////Calculation///////////////////

                          $row='
                                <tr>
                                    <td>'.$ProductCountList.'</td>
                                    <td>'.$ProductName.' - '.$ProductBadgeLabel.'</td>
                                    <td style="text-align: right;">'.$ProductUnitPrice.'</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <form id="Product-Minus" method="POST">
                                                    <input type="hidden" value="'.$InvoiceProductId.'" name="invoice_product_id">
                                                    <input type="hidden" value="'.$InvoiceId.'" name="invoice_id">
                                                    <input type="hidden" value="'.$ProductBadgeId.'" name="product_badge_id">
                                                    <button type="submit" id="btn-minus" class="btn btn-danger btn-burger add_order">-</button> 
                                                </form>
                                            </div>
                                            <div class="col-xl-4">
                                                <font style="margin-right: 8px; margin-left: 8px;">'.$ProductQuantity.'</font>
                                            </div>
                                            <div class="col-xl-4">
                                                <form id="Product-Plus" method="POST">
                                                    <input type="hidden" value="'.$InvoiceProductId.'" name="invoice_product_id">
                                                    <input type="hidden" value="'.$InvoiceId.'" name="invoice_id">
                                                    <input type="hidden" value="'.$ProductBadgeId.'" name="product_badge_id">
                                                    <button type="submit" id="btn-plus" class="btn btn-success btn-burger add_order">+</button> 
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">'.$ItemPriceWithQty.'</td>
                                </tr>
                                ';
                                
                                array_push($dataArray,$row);
                            
                            
                        }
                        
                        /////////////////
                        
                        
                        $output['result'] = true;
                        $output['msg'] = 'Successfully product added.';
                        $output['data'] = $dataArray;
                        $output['SubTotal'] = number_format($SubTotal,2);
                        $output['TotalServiceCharge'] = number_format($TotalServiceCharge,2);
                        $output['TotalDiscount'] = number_format($TotalDiscount,2);
                        $output['FullTotal'] = number_format($FullTotal,2);
                    }

                    $output['result'] = true;
                    $output['msg'] = 'Successfully product added.';
                    $output['data'] = $dataArray;


                }else{  
                    // echo 'Error';   
                    $output['result']=false;
                    $output['msg']="Error adding product.";
                }



            }else{

                //////////////////////////////////////////////////////////////////////////////
                $ProductInvoiceUpdatesql = "UPDATE invoice_product SET product_quantity=product_quantity+'$product_quantity' WHERE product_badge_id='$product_badge_id' AND  invoice_id='$invoice_id' ";

                if ($conn->query($ProductInvoiceUpdatesql) === TRUE) {
                    // echo 'Completed';

                    $ProductQuantitysql = "UPDATE product_badge_details SET quantity=quantity-'$product_quantity' WHERE product_badge_id='$product_badge_id' ";

                    if ($conn->query($ProductQuantitysql) === TRUE) {
                    //   echo "Record updated successfully";
                
                        $getProductRecord=$conn->query("SELECT * FROM invoice_product ipr INNER JOIN product_badge_details pbd ON ipr.product_badge_id=pbd.product_badge_id INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE ipr.invoice_id='$invoice_id' ORDER BY ipr.invoice_product_id ASC");
                        while($gprRs=$getProductRecord->fetch_array()){

                            $InvoiceProductId=$gprRs[0];
                            $InvoiceId=$gprRs[1];
                            $ProductBadgeId=$gprRs[2];
                            $ProductQuantity=$gprRs[3];
                                                      
                            $ProductNameId=$gprRs[6];
                            $ProductBadgeLabel=$gprRs[7];
                            $ProductUnitPrice=number_format($gprRs[9],2);
                            $ProductPrice=$gprRs[9];
                            $ProductBadgeQuantity=$gprRs[11];
                                                          
                            $ProductName=$gprRs[14];
                            $ProductCode=$gprRs[15];


                            $ProductCountList=$ProductCount+=1;

                          // $DiscountAmount = ((double)$ProductPrice * (double)$ProductDiscount) / 100;
                          // $TotalPriceWithDisc = (double)$ProductPrice - $DiscountAmount;
                          // $ItemPriceWithQty = number_format($TotalPriceWithDisc * $ProductQuantity,2);

                            $ItemPriceWithQty = number_format((double)$ProductPrice * (double)$ProductQuantity,2);

                            /////////////Calculation///////////////////
                            $ItemPriceWithQtyForCount = (double)$ProductPrice * (double)$ProductQuantity;
                            $SubTotal += (double)$ItemPriceWithQtyForCount;

                            //Service Charge
                            $TotalServiceCharge = ((double)$SubTotal * (double)$ServiceCharge)/100;
                            $SubTotalWithServiceCharge = (double)$SubTotal + (double)$TotalServiceCharge;
                            //Discount
                            $TotalDiscount = ((double)$SubTotal * (double)$InvoiceDiscount)/100;
                            $FullTotal = (double)$SubTotalWithServiceCharge - (double)$TotalDiscount;

                            /////////////Calculation///////////////////


                          $row='
                                <tr>
                                    <td>'.$ProductCountList.'</td>
                                    <td>'.$ProductName.' - '.$ProductBadgeLabel.'</td>
                                    <td style="text-align: right;">'.$ProductUnitPrice.'</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <form id="Product-Minus" method="POST">
                                                    <input type="hidden" value="'.$InvoiceProductId.'" name="invoice_product_id">
                                                    <input type="hidden" value="'.$InvoiceId.'" name="invoice_id">
                                                    <input type="hidden" value="'.$ProductBadgeId.'" name="product_badge_id">
                                                    <button type="submit" id="btn-minus" class="btn btn-danger btn-burger add_order">-</button> 
                                                </form>
                                            </div>
                                            <div class="col-xl-4">
                                                <font style="margin-right: 8px; margin-left: 8px;">'.$ProductQuantity.'</font>
                                            </div>
                                            <div class="col-xl-4">
                                                <form id="Product-Plus" method="POST">
                                                    <input type="hidden" value="'.$InvoiceProductId.'" name="invoice_product_id">
                                                    <input type="hidden" value="'.$InvoiceId.'" name="invoice_id">
                                                    <input type="hidden" value="'.$ProductBadgeId.'" name="product_badge_id">
                                                    <button type="submit" id="btn-plus" class="btn btn-success btn-burger add_order">+</button> 
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">'.$ItemPriceWithQty.'</td>
                                </tr>
                                ';
                                
                                array_push($dataArray,$row);
                            
                            
                        }
                        
                        /////////////////
                        
                        
                        $output['result'] = true;
                        $output['msg'] = 'Successfully product update.';
                        $output['data'] = $dataArray;
                        $output['SubTotal'] = number_format($SubTotal,2);
                        $output['TotalServiceCharge'] = number_format($TotalServiceCharge,2);
                        $output['TotalDiscount'] = number_format($TotalDiscount,2);
                        $output['FullTotal'] = number_format($FullTotal,2);
                    }

                    $output['result'] = true;
                    $output['msg'] = 'Successfully product update.';
                    $output['data'] = $dataArray;


                }else{  
                    // echo 'Error';   
                    $output['result']=false;
                    $output['msg']="Error updating product.";
                }

            }

        }

    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>