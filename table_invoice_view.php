<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');
    $InvoiceDetailsId= base64_decode($_GET['i']);
    $ProductCount=0;
    $SubTotal=0;

    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] == true) 
    {

      $user_email = $_SESSION["email"];

      $getEmpQuery=$conn->query("SELECT user_id,name,email,role FROM users_login WHERE email='$user_email' ");
      while ($emp=$getEmpQuery->fetch_array()) {

        $user_id = $emp['0']; 
        $user_name = $emp['1']; 
        $user_email = $emp['2']; 
        $user_role = $emp['3']; 
        

      }
      
    }

    else
    {
        ?>

            <script type="text/javascript">
                window.location.href="login";
            </script>

        <?php
    }
?>
<?php
    $getInvoiceQuery=$conn->query("SELECT * FROM invoice_save ins INNER JOIN invoice_details ind ON ins.invoice_id=ind.invoice_details_id INNER JOIN users_login ul ON ins.invoice_waiter_id=ul.user_id INNER JOIN resturent_table rt ON ind.resturent_table_id=rt.resturent_table_id WHERE ins.invoice_id='$InvoiceDetailsId'");
    while ($GIrs=$getInvoiceQuery->fetch_array()) {
        $InvoiceSaveId=$GIrs[0];
        $InvoiceId=$GIrs[1];
        $WaiterId=$GIrs[2];
        $SubTotal=$GIrs[3];
        $TotalServiceCharge=$GIrs[4];
        $TotalDiscount=$GIrs[5];
        $FullTotal=$GIrs[6];

        $ResturentTableId=$GIrs[9];
        $PaymentStatus=$GIrs[10];
        $InvoiceType=$GIrs[11];
        $InvoiceDateTime=$GIrs[14];
        $WaiterName=$GIrs[16];

        $ResturentTableNumber=$GIrs[24];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('controls/meta.php'); ?>
</head>
<body>

    <style>
        .add_order{
            width: 35px !important;
            height: 35px !important;
            line-height: 0px !important;
            margin-top: -5px !important;
        }
        @media print {
            @page {
              size: auto;   
              /*size: A4 portrait;*/
              margin: 0;  
              /*border: 1px solid red;  */
            }
            #top-nav{
                display: none;
            }
            #side-nav{
                display: none;
            }
            #table-details{
                display: none;
            }
            #Print-Invoice{
                display: none;
            }
            #invoice-print {
                /*width: 155mm;*/
                /*max-width: 155mm;*/
            }
            #invoice-table{
                width: 1mm;
                max-width: 1mm;
            }
            #invoice-web-preview{
                display: none;
            }
            #print-preview{
                display: revert !important;
                transform: scale(.9);
                height:100%;
                position:absolute;
                margin-top: -50px;
            }
        }
        #print-preview{
            display: none;
        }
        
    </style>
    
                                    <!----------------START Print View------------------------>
    
                                        <div class="row" id="print-preview">
                      
                      
                                            <div style="text-align: center;">
                                                <!--<img src="assets/images/a_logo.png" style="width: 50%;">-->
                                                <img src="assets/images/seashell-logo-2.png" style="width: 100%;">
                                                <h5 style="color: #000;">
                                                    Inv No - <?php echo $InvoiceId+10000; ?><br>
                                                    <?php echo $InvoiceDateTime; ?>
                                                </h5>
                                            </div>

                                            <table class="table" id="invoice-table">
                                            <thead>
                                                <tr class="notranslate">
                                                    <th style="color: #000;"><b>Item</b></th>
                                                    <th style="text-align: right; color: #000;"><b>Unit Cost</b></th>
                                                    <th style="text-align: center; color: #000;"><b>Qty</b></th>
                                                    <th style="text-align: right; color: #000;"><b>Total</b></th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-area">
                                                <!--------------------------------Start Products--------------------------------------->
                                                <?php
                                                    $getInvoiceQuery=$conn->query("SELECT * FROM invoice_save_product WHERE invoice_id='$InvoiceDetailsId'");
                                                    while ($GIrs=$getInvoiceQuery->fetch_array()) {
                                                        $InvoiceSaveProductId=$GIrs[0];
                                                        // $InvoiceId=$GIrs[1];
                                                        $ProductBadgeId=$GIrs[2];
                                                        $ProductDetails=$GIrs[3];
                                                        

                                                        $ProductDetailsExplode = explode(",",$ProductDetails);



                                                        $ProductCount = $ProductDetailsExplode[0];
                                                        $ProductName = $ProductDetailsExplode[1];
                                                        $ProductUnitPrice = $ProductDetailsExplode[2];
                                                        $ProductQuantity = $ProductDetailsExplode[3];
                                                        $ItemPriceWithQty = $ProductDetailsExplode[4];

                                                        

                                                ?>
                                                <tr>
                                                    <td style="color: #000;"><?php echo $ProductName; ?></td>
                                                    <td style="text-align: right; color: #000;"><?php echo number_format($ProductUnitPrice,2); ?></td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <font style="margin-right: 8px; margin-left: 8px; color: #000;"><?php echo $ProductQuantity; ?></font>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: right; color: #000;"><?php echo number_format($ItemPriceWithQty,2); ?></td>
                                                </tr>

                                                <?php } ?>
                                                <!--------------------------------End Products--------------------------------------->
                                            </tbody>

                                                <!-----------------Start Calculations---------------------------->
                                                <?php 
                                                    
                                                    //Service Charge
                                                    $ServiceCharge=(double)$TotalServiceCharge * 100/(double)$SubTotal;

                                                    // Discount
                                                    $InvoiceDiscount =(double)$TotalDiscount * 100/(double)$SubTotal;

                                                ?>
                                                <!-----------------End Calculations---------------------------->


                                            <?php if ($ProductCount>0) { ?>


                                        </table>
                                        <table>

                                            <tfoot>
                                                <th style="text-align: left; font-size: 18px; color: #000; ">Total</th>
                                                <th style="text-align: right; font-size: 18px; color: #000; " id="full-total">Rs.<?php echo number_format($FullTotal,2) ?></th>
                                            </tfoot>
                                            
                                            <tfoot>
                                                
                                                <th style="text-align: left; font-size: 18px; color: #000; ">Sub Total</th>
                                                <th style="text-align: right; font-size: 18px; color: #000; " id="sub-total"><?php echo number_format($SubTotal,2); ?></th>
                                            </tfoot>

                                            <?php if ($TotalServiceCharge>0) { ?>
                                            <tfoot>
                                                
                                                <th style="text-align: left; font-size: 18px; color: #000; ">Service Charge (<?php echo $ServiceCharge; ?>%)</th>
                                                <th style="text-align: right; font-size: 18px; color: #000; " id="service-charge"><?php echo number_format($TotalServiceCharge,2); ?></th>
                                            </tfoot>
                                            <?php }else{} ?>
                                            <?php if ($TotalDiscount>0) { ?>
                                            <tfoot>
                                                
                                                <th style="text-align: left; font-size: 18px; color: #000; ">Discount (<?php echo $InvoiceDiscount; ?>%)</th>
                                                <th style="text-align: right; font-size: 18px; color: #000; " id="invoice-discount"><?php echo number_format($TotalDiscount,2); ?></th>
                                            </tfoot>
                                            <?php }else{} ?>
                                        <?php }else{} ?>



                                        </table>
                                        
                                        <br><br>
                                        <center><p>
                                            <font style="color: #000;">Thank You & Come Again !</font><br>
                                            ---------------------------------------<br>
                                            <font style="color: #000;">Powered By AMAZOFT</font>
                                        </p></center>

                                     

                                    </div>
    
                                <!----------------END Print View------------------------>
    

    <div class="app align-content-stretch d-flex flex-wrap">

        <div id="side-nav">
        <?php include_once('controls/side_nav.php'); ?>
        </div>


        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header" id="top-nav">


                <?php include_once('controls/top_nav.php'); ?>


            </div>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                        <div class="row" id="table-details">
                            <div class="page-description d-flex align-items-center">
                                <div class="page-description-content flex-grow-1 notranslate">
                                    <h1>Orders <font style="font-size: 15px;">Table Number <?php echo $ResturentTableNumber; ?></font></h1>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row" id="invoice-web-preview">
                            <div class="col-xl-8">
                                    <div class="card widget widget-stats">
                                        <div class="card-body">

                                            <div style="text-align: right;">
                                                <h5>Invoice Number - <?php echo $InvoiceId; ?><br>
                                                Invoice Date - <?php echo $InvoiceDateTime; ?><br></h5>
                                            </div>

                                            <table class="table table-striped">
                                            <thead>
                                                <tr class="notranslate">
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th style="text-align: right;">Unit Cost</th>
                                                    <th style="text-align: center;">Qty</th>
                                                    <th style="text-align: right;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-area">
                                                <!--------------------------------Start Products--------------------------------------->
                                                <?php
                                                    $getInvoiceQuery=$conn->query("SELECT * FROM invoice_save_product WHERE invoice_id='$InvoiceDetailsId'");
                                                    while ($GIrs=$getInvoiceQuery->fetch_array()) {
                                                        $InvoiceSaveProductId=$GIrs[0];
                                                        // $InvoiceId=$GIrs[1];
                                                        $ProductBadgeId=$GIrs[2];
                                                        $ProductDetails=$GIrs[3];
                                                        

                                                        $ProductDetailsExplode = explode(",",$ProductDetails);



                                                        $ProductCount = $ProductDetailsExplode[0];
                                                        $ProductName = $ProductDetailsExplode[1];
                                                        $ProductUnitPrice = $ProductDetailsExplode[2];
                                                        $ProductQuantity = $ProductDetailsExplode[3];
                                                        $ItemPriceWithQty = $ProductDetailsExplode[4];

                                                        

                                                ?>
                                                <tr>
                                                    <td><?php echo $ProductCount; ?></td>
                                                    <td><?php echo $ProductName; ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($ProductUnitPrice,2); ?></td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <font style="margin-right: 8px; margin-left: 8px;"><?php echo $ProductQuantity; ?></font>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: right;"><?php echo number_format($ItemPriceWithQty,2); ?></td>
                                                </tr>

                                                <?php } ?>
                                                <!--------------------------------End Products--------------------------------------->
                                            </tbody>

                                                <!-----------------Start Calculations---------------------------->
                                                <?php 
                                                    
                                                    //Service Charge
                                                    $ServiceCharge=(double)$TotalServiceCharge * 100/(double)$SubTotal;

                                                    // Discount
                                                    $InvoiceDiscount =(double)$TotalDiscount * 100/(double)$SubTotal;

                                                ?>
                                                <!-----------------End Calculations---------------------------->


                                            <?php if ($ProductCount>0) { ?>


                                                

                                            <tfoot>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="text-align: right; font-size: 25px; color: #000; font-weight: 700;">Total</th>
                                                <th style="text-align: right; font-size: 25px; color: #000; font-weight: 700;" id="full-total"><?php echo number_format($FullTotal,2) ?></th>
                                            </tfoot>
                                            
                                            <tfoot>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;">Sub Total</th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;" id="sub-total"><?php echo number_format($SubTotal,2); ?></th>
                                            </tfoot>

                                            <?php if ($TotalServiceCharge>0) { ?>
                                            <tfoot>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;">Service Charge (<?php echo $ServiceCharge; ?>%)</th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;" id="service-charge"><?php echo number_format($TotalServiceCharge,2); ?></th>
                                            </tfoot>
                                            <?php }else{} ?>
                                            <?php if ($TotalDiscount>0) { ?>
                                            <tfoot>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;">Discount (<?php echo $InvoiceDiscount; ?>%)</th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;" id="invoice-discount"><?php echo number_format($TotalDiscount,2); ?></th>
                                            </tfoot>
                                            <?php }else{} ?>
                                        <?php }else{} ?>



                                        </table>

                                        <div style="text-align: right;">
                                            <button onclick="window.print();" class="btn btn-primary"><i class="material-icons notranslate">print</i>Print</button>
                                        </div>
                                        

                                        </div>
                                    </div>
                               
                            </div>
                            
                            <div class="col-xl-4"></div>



                        </div>
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    


        <!-------Event Start------------>
        <div class="alert alert-success solid alert-dismissible fade" role="alert" id="success_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-check"></i> <strong>Success!</strong> <span id="success_msg"></span>
        </div>
        <!--------Event End----------->
                            
        <!-------Waiting  Upload Event Start------------>
        <div class="alert alert-warning solid alert-dismissible fade" role="alert" id="progress_upload_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <strong>Please Wait...</strong>
            <div class="progress" style="height:20px">
                <div class="progress-bar bg-success" style="width:0%;" id="upload-bar"><span id="upload-bar-label">0%</span></div>
            </div>
        </div>
        <!--------Waiting Upload  Event End----------->                   
                            
        <!-------Waiting Event Start------------>
        <div class="alert alert-warning solid alert-dismissible fade" role="alert" id="progress_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <strong>Please Wait...</strong>
        </div>
        <!--------Waiting Event End----------->
                            
        <!-------Error Event Start------------>
        <div class="alert alert-danger solid alert-dismissible fade" role="alert" id="danger_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-times"></i> <strong>Error!</strong> <span>Something went wrong...</span>
        </div>
        <!--------Error Event End----------->

        <!-------Error Event Start------------>
        <div class="alert alert-danger solid alert-dismissible fade" role="alert" id="danger_alert_msg" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-times"></i> <strong>Error!</strong> <span id="error_msg"></span>
        </div>
        <!--------Error Event End----------->

    
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

</body>
</html>
<?php } ?>