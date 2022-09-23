<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');
    $InvoiceDetailsId= base64_decode($_GET['o']);
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
    $getInvoiceQuery=$conn->query("SELECT * FROM invoice_details invd INNER JOIN resturent_table rest ON invd.resturent_table_id=rest.resturent_table_id WHERE invd.invoice_details_id='$InvoiceDetailsId'");
    while ($GIrs=$getInvoiceQuery->fetch_array()) {
        $ResturentTableId=$GIrs[1];
        $PaymentStatus=$GIrs[2];
        $InvoiceType=$GIrs[3];
        $InvoiceWaiterId=$GIrs[4];
        $InvoiceDiscount=$GIrs[5];
        $InvoiceDate=$GIrs[6];
        
        $ResturentTableNumber=$GIrs[9];
?>
<?php
    $getServiceChargeQuery=$conn->query("SELECT * FROM service_charge ORDER BY service_charge_id DESC LIMIT 1");
    if ($GSCrs=$getServiceChargeQuery->fetch_array()) {
        $ServiceCharge=$GSCrs[1];
    }
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
    
                                        <div class="row" id="print-preview">

                                            <div style="text-align: center;">
                                                <img src="assets/images/seashell-logo-2.png" style="width: 100%;">
                                                <h5 style="color: #000;">
                                                Inv No - <?php echo $InvoiceDetailsId+10000; ?><br>
                                                <?php echo $InvoiceDate; ?><br></h5>
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
                                            <tbody>
                                                <!--------------------------------Start Products--------------------------------------->
                                                <?php
                                                    $ProductCountPrint=0;
                                                    $getInvoiceQuery=$conn->query("SELECT * FROM invoice_product ip INNER JOIN product_badge_details pbd ON ip.product_badge_id=pbd.product_badge_id INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE ip.invoice_id='$InvoiceDetailsId' ORDER BY ip.invoice_product_id ASC");
                                                    while ($GIrs=$getInvoiceQuery->fetch_array()) {
                                                        $InvoiceProductId=$GIrs[0];
                                                        $InvoiceId=$GIrs[1];
                                                        $InvoiceBadgeId=$GIrs[2];
                                                        $InvoiceQty=$GIrs[3];
                                                        $InvoiceProductDateTime=$GIrs[4];

                                                        $ProductNameId=$GIrs[6];
                                                        $ProductBadgeLabel=$GIrs[7];
                                                        $ProductUnitPrice=number_format($GIrs[9],2);
                                                        $ProductPrice=$GIrs[9];
                                                        $ProductBadgeQuantity=$GIrs[11];
                                                                                      
                                                        $ProductName=$GIrs[14];
                                                        $ProductCode=$GIrs[15];

                                                        $ItemPriceWithQty = (double)$ProductPrice * (double)$InvoiceQty;

                                                        $SubTotal += (double)$ItemPriceWithQty;


                                                ?>
                                                <tr>
                                                    <td style="color: #000;"><?php echo $ProductName.' - '.$ProductBadgeLabel; ?></td>
                                                    <td style="text-align: right; color: #000;"><?php echo $ProductUnitPrice; ?></td>
                                                    <td>
                                                        <div class="row">
                                                            <font style="margin-right: 8px; margin-left: 8px; color: #000;"><?php echo $InvoiceQty; ?></font>
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
                                                    $TotalServiceCharge = ((double)$SubTotal * (double)$ServiceCharge)/100;
                                                    $SubTotalWithServiceCharge = (double)$SubTotal + (double)$TotalServiceCharge;
                                                    //Discount
                                                    $TotalDiscount = ((double)$SubTotal * (double)$InvoiceDiscount)/100;
                                                    $FullTotal = (double)$SubTotalWithServiceCharge - (double)$TotalDiscount;
                                                ?>
                                                <!-----------------End Calculations---------------------------->


                                            <?php if ($ProductCountPrint+=1 >0) { ?>

                                            </table>
                                            <table>
                                                

                                                <tfoot>
                                                    <th style="text-align: left; font-size: 18px; color: #000;">Total</th>
                                                    <th style="text-align: right; font-size: 18px; color: #000;"><?php echo number_format($FullTotal,2) ?></th>
                                                </tfoot>
                                                
                                                <tfoot>
                                                    <th style="text-align: left; font-size: 18px; color: #000;">Sub Total</th>
                                                    <th style="text-align: right; font-size: 18px; color: #000;"><?php echo number_format($SubTotal,2); ?></th>
                                                </tfoot>
    
                                                <?php if ($ServiceCharge>0) { ?>
                                                <tfoot>
                                                    <th style="text-align: left; font-size: 18px; color: #000;">Service Charge (<?php echo $ServiceCharge; ?>%)</th>
                                                    <th style="text-align: right; font-size: 18px; color: #000;"><?php echo number_format($TotalServiceCharge,2); ?></th>
                                                </tfoot>
                                                <?php }else{} ?>
                                                <?php if ($InvoiceDiscount>0) { ?>
                                                <tfoot>
                                                    <th style="text-align: left; font-size: 18px; color: #000;">Discount (<?php echo $InvoiceDiscount; ?>%)</th>
                                                    <th style="text-align: right; font-size: 18px; color: #000;"><?php echo number_format($TotalDiscount,2); ?></th>
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
                                <div class="page-description-content flex-grow-1">
                                    <h1 class="notranslate">Orders <font style="font-size: 15px;">Table Number <?php echo $ResturentTableNumber; ?></font></h1>
                                </div>
                                <div class="page-description-actions">
                                    <input type="hidden" id="delete_invoice_id" value="<?php echo $InvoiceDetailsId; ?>">
                                    <input type="hidden" id="table_id" value="<?php echo $ResturentTableId; ?>">
                                    
                                    <?php if ($PaymentStatus=='0') {?>
                                    <button type="button" class="btn btn-danger" id="cancel-table-btn"><i class="material-icons notranslate">close</i>Cancel</button>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#discountModal"><i class="material-icons notranslate">add</i>Add Discount</button>
                                    <?php }else{ } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="invoice-web-preview">
                            <div class="col-xl-8">
                                    <div class="card widget widget-stats">
                                        <div class="card-body">

                                            <div style="text-align: right;">
                                                <h5>Invoice Number - <?php echo $InvoiceDetailsId; ?><br>
                                                Invoice Date - <?php echo $InvoiceDate; ?><br></h5>
                                            </div>
                                            
                                            <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="notranslate">#</th>
                                                    <th class="notranslate">Item</th>
                                                    <th class="notranslate" style="text-align: right;">Unit Cost</th>
                                                    <th class="notranslate" style="text-align: center;">Qty</th>
                                                    <th class="notranslate" style="text-align: right;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-area">
                                                <!--------------------------------Start Products--------------------------------------->
                                                <?php
                                                    $ProductCountList=0;
                                                    $getInvoiceQuery=$conn->query("SELECT * FROM invoice_product ip INNER JOIN product_badge_details pbd ON ip.product_badge_id=pbd.product_badge_id INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE ip.invoice_id='$InvoiceDetailsId' ORDER BY ip.invoice_product_id ASC");
                                                    while ($GIrs=$getInvoiceQuery->fetch_array()) {
                                                        $InvoiceProductId=$GIrs[0];
                                                        $InvoiceId=$GIrs[1];
                                                        $InvoiceBadgeId=$GIrs[2];
                                                        $InvoiceQty=$GIrs[3];
                                                        $InvoiceProductDateTime=$GIrs[4];

                                                        $ProductNameId=$GIrs[6];
                                                        $ProductBadgeLabel=$GIrs[7];
                                                        $ProductUnitPrice=number_format($GIrs[9],2);
                                                        $ProductPrice=$GIrs[9];
                                                        $ProductBadgeQuantity=$GIrs[11];
                                                                                      
                                                        $ProductName=$GIrs[14];
                                                        $ProductCode=$GIrs[15];

                                                        $ItemPriceWithQty = (double)$ProductPrice * (double)$InvoiceQty;

                                                        $SubTotal += (double)$ItemPriceWithQty;

                                                ?>
                                                <tr>
                                                    <td><?php echo $ProductCountList+=1; ?></td>
                                                    <td><?php echo $ProductName.' - '.$ProductBadgeLabel; ?></td>
                                                    <td style="text-align: right;"><?php echo $ProductUnitPrice; ?></td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <?php if ($PaymentStatus=='0') {?>
                                                                <form id="Product-Minus" method="POST">
                                                                    <input type="hidden" value="<?php echo $InvoiceProductId; ?>" name="invoice_product_id">
                                                                    <input type="hidden" value="<?php echo $InvoiceDetailsId; ?>" name="invoice_id">
                                                                    <input type="hidden" value="<?php echo $InvoiceBadgeId; ?>" name="product_badge_id">
                                                                    <button type="submit" id="btn-minus" class="btn btn-danger btn-burger add_order">-</button> 
                                                                </form>
                                                                <?php }else{}?>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <font style="margin-right: 8px; margin-left: 8px;"><?php echo $InvoiceQty; ?></font>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <?php if ($PaymentStatus=='0') {?>
                                                                <form id="Product-Plus" method="POST">
                                                                    <input type="hidden" value="<?php echo $InvoiceProductId; ?>" name="invoice_product_id">
                                                                    <input type="hidden" value="<?php echo $InvoiceDetailsId; ?>" name="invoice_id">
                                                                    <input type="hidden" value="<?php echo $InvoiceBadgeId; ?>" name="product_badge_id">
                                                                    <button type="submit" id="btn-plus" class="btn btn-success btn-burger add_order">+</button> 
                                                                </form>
                                                                <?php }else{}?>
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
                                                    $TotalServiceCharge = ((double)$SubTotal * (double)$ServiceCharge)/100;
                                                    $SubTotalWithServiceCharge = (double)$SubTotal + (double)$TotalServiceCharge;
                                                    //Discount
                                                    $TotalDiscount = ((double)$SubTotal * (double)$InvoiceDiscount)/100;
                                                    $FullTotal = (double)$SubTotalWithServiceCharge - (double)$TotalDiscount;
                                                ?>
                                                <!-----------------End Calculations---------------------------->


                                            <?php if ($ProductCountList+=1>0) { ?>


                                                

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

                                            <?php if ($ServiceCharge>0) { ?>
                                            <tfoot>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="border-style: hidden !important;"></th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;">Service Charge (<?php echo $ServiceCharge; ?>%)</th>
                                                <th style="text-align: right; font-size: 20px; color: #000; font-weight: 700;" id="service-charge"><?php echo number_format($TotalServiceCharge,2); ?></th>
                                            </tfoot>
                                            <?php }else{} ?>
                                            <?php if ($InvoiceDiscount>0) { ?>
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
                                            <?php if ($PaymentStatus=='0') {?>

                                            <form id="Save-Invoice" method="POST">
                                                <input type="hidden" value="<?php echo $InvoiceDetailsId; ?>" name="invoice_id">
                                                <button type="submit" id="invoice-save-btn" class="btn btn-primary"><i class="material-icons notranslate">save</i>Save & Print</button>
                                            </form>
 
                                            <?php }else{ ?>
                                                <div class="row">
                                                    <div class="col-xl-8"></div>
                                                    <div class="col-xl-2">
                                                        <button onclick="window.print();" class="btn btn-primary"><i class="material-icons notranslate">print</i>Print</button>
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <form id="Paid-Invoice" method="POST">
                                                            <input type="hidden" value="<?php echo $InvoiceDetailsId; ?>" name="invoice_id">
                                                            <input type="hidden" value="<?php echo $ResturentTableId; ?>" name="table_id">
                                                            <button type="submit" id="btn-paid" class="btn btn-success"><i class="material-icons notranslate">payments</i>Paid</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                            <?php } ?>
                                        </div>
                                        

                                        </div>
                                    </div>
                               
                            </div>
                            
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body" style="padding: 0px 0px;">
                                        
                                        <div class="accordion accordion-flush" id="accordionFlushExample">


                                            <?php
                                                $getProductCategoryQuery=$conn->query("SELECT * FROM product_category ORDER BY category_id ASC");
                                                while ($GPCrs=$getProductCategoryQuery->fetch_array()) {
                                                    $ProductCategoryId=$GPCrs[0];
                                                    $ProductCategoryName=$GPCrs[1];

                                            ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading-<?php echo $ProductCategoryId; ?>">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php echo $ProductCategoryId; ?>" aria-expanded="true" aria-controls="flush-collapse-<?php echo $ProductCategoryId; ?>">
                                                        <?php echo $ProductCategoryName; ?>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse-<?php echo $ProductCategoryId; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading-<?php echo $ProductCategoryId; ?>" data-bs-parent="#accordionFlushExample" style="">
                                                    <div class="accordion-body">

                                                        <style>
                                                            /* width */
                                                            #sbar::-webkit-scrollbar {
                                                              width: 5px;
                                                            }

                                                            /* Track */
                                                            #sbar::-webkit-scrollbar-track {
                                                              background: #f1f1f1; 
                                                            }
                                                             
                                                            /* Handle */
                                                            #sbar::-webkit-scrollbar-thumb {
                                                              background: #888; 
                                                            }

                                                            /* Handle on hover */
                                                            #sbar::-webkit-scrollbar-thumb:hover {
                                                              background: #555; 
                                                            }
                                                        </style>
                                                        
                                                      
                                                        <div class="card-body widget-list" id="sbar" style="padding: 0px 0px; height: 40vh; overflow-y: auto;">
                                                            <ul class="widget-list-content list-unstyled">
                                                                <?php
                                                                    $getProductDetailsQuery=$conn->query("SELECT * FROM product_details WHERE product_category='$ProductCategoryName' ORDER BY product_id DESC ");
                                                                    while ($GPDrs=$getProductDetailsQuery->fetch_array()) {
                                                                        $ProductId=$GPDrs[0];
                                                                        $ProductName=$GPDrs[1];
                                                                        $ProductCode=$GPDrs[2];
                                                                        $ProductPrepTime=$GPDrs[5];
                                                                        $ProductCalories=$GPDrs[6];
                                                                        $ProductImage=$GPDrs[7];
                                                                ?>

                                                                <li class="widget-list-item">
                                                                    <span class="widget-list-item-icon">
                                                                        <div class="widget-list-item-icon-image" style="background: url('product_images/<?php echo $ProductImage; ?>')"></div>
                                                                    </span>
                                                                    <span class="widget-list-item-description">
                                                                        <a href="#" class="widget-list-item-description-title">
                                                                            <?php echo $ProductName; ?>
                                                                        </a>
                                                                    </span>
                                                                    <!-- Button trigger modal -->
                                                                    <?php if ($PaymentStatus=='0') {?>
                                                                    <button type="button" class="btn btn-primary btn-style-light" data-bs-toggle="modal" data-bs-target="#PriceBadgeModel<?php echo $ProductId; ?>">
                                                                        <i class="material-icons notranslate">add</i>Add
                                                                    </button>
                                                                <?php }else{} ?>


                                                                    <!-- Modal -->
                                                                    <div class="modal fade products" id="PriceBadgeModel<?php echo $ProductId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                            <div class="modal-content" style="background-color: #E7ECF8;">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel" style="font-weight: 800; font-size: 18px;"><?php echo $ProductName; ?></h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    

                                                                                <div class="row">
                                                                                    <?php
                                                                                        $getProductBadgeDetailsQuery=$conn->query("SELECT * FROM product_badge_details WHERE product_name_id='$ProductId' ORDER BY product_badge_id ASC ");
                                                                                        while ($GPBDrs=$getProductBadgeDetailsQuery->fetch_array()) {
                                                                                            $ProductBadgeId=$GPBDrs[0];
                                                                                            $ProductBadgeLable=$GPBDrs[2];
                                                                                            $ProductBadgeSellingPrice=number_format($GPBDrs[4],2);
                                                                                            $ProductBadgeStat=$GPBDrs[5];
                                                                                            $ProductBadgeQty=$GPBDrs[6];
                                                                                    ?>
                                                                                    <?php if ($ProductBadgeStat=='1') {?>
                                                                                    <div class="col-xl-6">
                                                                                        <div class="card widget widget-info-navigation">
                                                                                            <div class="card-body">
                                                                                                <div class="widget-info-navigation-container">
                                                                                                    <div class="widget-info-navigation-content">
                                                                                                        <center><span class="text-dark" style="font-weight: 800;"><?php echo $ProductName; ?> <br> <?php echo $ProductBadgeLable; ?></span><br>
                                                                                                        <span class="text-primary fw-bolder fs-3">Rs. <?php echo $ProductBadgeSellingPrice; ?></span></center>
                                                                                                        <?php if ($ProductBadgeQty>'0') { ?>
                                                                                                            <form id="Add-Invoice-Product">
                                                                                                                <input type="hidden" name="product_badge_id" value="<?php echo $ProductBadgeId; ?>">
                                                                                                                <input type="hidden" name="invoice_id" value="<?php echo $InvoiceDetailsId; ?>">
                                                                                                                <center><button type="submit" class="btn btn-success btn-burger" id="btn-invoice-product"><i class="material-icons no-m notranslate">add_circle_outline</i></button></center>
                                                                                                            </form>
                                                                                                        <?php }else{ ?>
                                                                                                            <br>
                                                                                                            <center><span style="font-size: 12px; padding: 11px;" class="badge badge-style-light rounded-pill badge-danger">Out of stock</span></center>

                                                                                                        <?php } ?>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php }else{ ?>
                                                                                    <div class="col-xl-6">
                                                                                        <div class="card widget widget-info-navigation">
                                                                                            <div class="card-body">
                                                                                                <div class="widget-info-navigation-container">
                                                                                                    <div class="widget-info-navigation-content">
                                                                                                        <center><span class="text-dark" style="font-weight: 800;"><?php echo $ProductName; ?> <br> <?php echo $ProductBadgeLable; ?></span><br>
                                                                                                        <span class="text-primary fw-bolder fs-3">Rs. <?php echo $ProductBadgeSellingPrice; ?></span></center>
                                                                                                        <form id="Add-Invoice-Product">
                                                                                                            <input type="hidden" name="product_badge_id" value="<?php echo $ProductBadgeId; ?>">
                                                                                                                <input type="hidden" name="invoice_id" value="<?php echo $InvoiceDetailsId; ?>">
                                                                                                            <center><button type="submit" class="btn btn-success btn-burger" id="btn-invoice-product"><i class="material-icons no-m">add_circle_outline</i></button></center>
                                                                                                        </form>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php } ?>
                                                                                    <?php } ?>
                                                                                </div>

                                                                                    



                                                                                </div>
                                                                                <!-- <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                                                </div> -->
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <!-- <span class="widget-list-item-product-amount">
                                                                        $79.99
                                                                    </span> -->
                                                                </li>
                                                                <hr>

                                                                <?php } ?>
                                                            </ul>
                                                        </div>

                                                        

                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                           
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="Add-Discount">
                    <div class="modal-body">
                        
                        <div class="row g-3">
                            <input type="hidden" value="<?php echo $InvoiceDetailsId; ?>" name="invoice_id">
                            <div class="col-md-12">
                                <label class="form-label">Discount *</label>
                                <input type="text" name="discount" class="form-control" value="<?php echo $InvoiceDiscount; ?>" placeholder="Add Discount" required>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary notranslate" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-add-discount"><i class="material-icons notranslate">add</i> Add</button>
                    </div>
                </form>
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



    <!-------------------------Add Product to invoice---------------------------------------->
    <script>
        
        $(document).on('submit', '#Add-Invoice-Product', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-invoice-product").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {

                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/add_product_invoice.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       $("#product-area").html(json.data);
                       $("#sub-total").html(json.SubTotal);
                       $("#service-charge").html(json.TotalServiceCharge);
                       $("#invoice-discount").html(json.TotalDiscount);
                       $("#full-total").html(json.FullTotal);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       $(".products").modal('hide');
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-invoice-product").attr("disabled",false);
                       // document.getElementById('select-product').value = '0';
                       // document.getElementById('product-quantity').value = '0';

                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-invoice-product").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <!-------------------------Add Product to Minus---------------------------------------->
    <script>
        
        $(document).on('submit', '#Product-Minus', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-minus").attr("disabled",true);
        $("#btn-plus").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {

                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/update_product_minus.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       $("#product-area").html(json.data);
                       $("#sub-total").html(json.SubTotal);
                       $("#service-charge").html(json.TotalServiceCharge);
                       $("#invoice-discount").html(json.TotalDiscount);
                       $("#full-total").html(json.FullTotal);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-minus").attr("disabled",false);
                       $("#btn-plus").attr("disabled",false);

                    }else{

                        // $("#danger_alert_msg").addClass('show');
                        setTimeout(function(){ $("#danger_alert_msg").removeClass('show'); }, 1000);
                        $("#btn-minus").attr("disabled",false);
                        $("#btn-plus").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    

<!-------------------------Add Product to Plus---------------------------------------->
    <script>
        
        $(document).on('submit', '#Product-Plus', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-minus").attr("disabled",true);
        $("#btn-plus").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {

                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/update_product_plus.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       $("#product-area").html(json.data);
                       $("#sub-total").html(json.SubTotal);
                       $("#service-charge").html(json.TotalServiceCharge);
                       $("#invoice-discount").html(json.TotalDiscount);
                       $("#full-total").html(json.FullTotal);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-minus").attr("disabled",false);
                       $("#btn-plus").attr("disabled",false);

                    }else{
                        $("#error_msg").html(json.msg);
                        $("#danger_alert_msg").addClass('show');
                        setTimeout(function(){ $("#danger_alert_msg").removeClass('show'); }, 1000);
                        $("#btn-minus").attr("disabled",false);
                        $("#btn-plus").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


    <!-------------------------Add Discount---------------------------------------->
    <script>
        
        $(document).on('submit', '#Add-Discount', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-discount").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {

                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/add_discount.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-add-discount").attr("disabled",false);
                       // document.getElementById('select-product').value = '0';
                       // document.getElementById('product-quantity').value = '0';
                       location.reload();

                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-add-discount").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <!---------------------------------------Invoice Save----------------------------------------------------->
    <script>

        $(document).ready(function(){

        $(document).on('submit', '#Save-Invoice', function(e){
        e.preventDefault(); //stop default form submission

        $("#invoice-save-btn").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {

                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/invoice_save.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       // $("#btn-area").html(json.data);
                        
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 2000);
                       $("#invoice-save-btn").attr("disabled",false);
                    //   window.print();
                       location.reload();
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 2000);
                        $("#invoice-save-btn").attr("disabled",false);
                    }
                    
                }

            });

        });

        return false;
        });
    </script>
 

    <!-------------------------Paid---------------------------------------->
    <script>
        
        $(document).on('submit', '#Paid-Invoice', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-paid").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 
                },

                url:"invoice_post/add_paid.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-paid").attr("disabled",false);
                       // document.getElementById('select-product').value = '0';
                       // document.getElementById('product-quantity').value = '0';
                       // location.reload();
                       window.location.href = 'table_list';

                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-paid").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


    <!-------------------------Cancel invoice---------------------------------------->
    <script>
        
        $(document).ready(function(){
       // e.preventDefault(); //stop default form submission

       

        $("#cancel-table-btn").click(function(){
             $("#cancel-table-btn").attr("disabled",true);

             $.ajax({
            
            
                beforeSend : function() {

                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/cancel_invoice.php",
                type: 'POST',
                data: {
                    delete_invoice_id:$("#delete_invoice_id").val(),
                    table_id:$("#table_id").val()
                },
                //async: false,
                

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#cancel-table-btn").attr("disabled",false);
                       window.location.href = 'table_list';
                       // document.getElementById('select-product').value = '0';
                       // document.getElementById('product-quantity').value = '0';

                        
                    }else{
                        $("#danger_alert_msg").html(json.msg);
                        $("#danger_alert_msg").addClass('show');
                        setTimeout(function(){ $("#danger_alert_msg").removeClass('show'); }, 1000);
                        $("#cancel-table-btn").attr("disabled",false);
                    }
                    
                }

            });


        });

      

        

      
        });
    </script>



</body>
</html>
<?php } ?>