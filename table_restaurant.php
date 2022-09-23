<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');
    $ResturentId= base64_decode($_GET['t']);
    include_once('controls/time_ago.php');
    

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
    
    function rand_code($len)
    {
     $min_lenght= 0;
     $max_lenght = 100;
     $bigL = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     //$smallL = "abcdefghijklmnopqrstuvwxyz";
     $number = "0123456789";
     $bigB = str_shuffle($bigL);
     // $smallS = str_shuffle($smallL);
     $numberS = str_shuffle($number);
     $subA = substr($bigB,0,5);
     $subB = substr($bigB,6,5);
     $subC = substr($bigB,10,5);
     // $subD = substr($smallS,0,5);
     // $subE = substr($smallS,6,5);
     // $subF = substr($smallS,10,5);
     $subG = substr($numberS,0,5);
     $subH = substr($numberS,6,5);
     $subI = substr($numberS,10,5);
     $RandCode1 = str_shuffle($subA.$subB.$subC.$subG.$subH.$subI);
     $RandCode2 = str_shuffle($RandCode1);
     $RandCode = $RandCode1.$RandCode2;
     if ($len>$min_lenght && $len<$max_lenght)
     {
     $CodeEX = substr($RandCode,0,$len);
     }
     else
     {
     $CodeEX = $RandCode;
     }
     return $CodeEX;
    }
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
    <link href="assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
    <?php include_once('controls/meta.php'); ?>
</head>
<body>
    <div class="app align-content-stretch d-flex flex-wrap">


        <?php include_once('controls/side_nav.php'); ?>



        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header">


                <?php include_once('controls/top_nav.php'); ?>


            </div>

            <?php
                $getRestaurantTypeSql = $conn->query("SELECT * FROM resturent_type WHERE resturent_type_id='$ResturentId'");
                while($grtRS = $getRestaurantTypeSql->fetch_array()){
                    $RestaurantTypeId = $grtRS[0];
                    $RestaurantName = $grtRS[1];
                    $RestaurantPlace = $grtRS[2];
            ?>

            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h1 class="notranslate"><?php echo $RestaurantName; ?> Restaurant <font style="font-size: 20px;">(<?php echo $RestaurantPlace; ?>)</font></h1>
                                </div>
                            </div>
                        </div>
             


                            <div class="row">

                            <?php
                                $getResturentTableQuery=$conn->query("SELECT * FROM resturent_table rt INNER JOIN resturent_table_availability rta ON rt.resturent_table_id=rta.resturent_table_id WHERE rt.resturent_type_id='$RestaurantTypeId'");
                                while ($GRTrs=$getResturentTableQuery->fetch_array()) {
                                    $ResturentTableId=$GRTrs[0];
                                    $ResturentTypeId=$GRTrs[1];
                                    $ResturentTableNumber=$GRTrs[2];
                                    $ResturentTableDateTime=$GRTrs[3];
                                    $ResturentTableAvailabilityId=$GRTrs[4];
                                    $ResturentTableAvailabilityStatus=$GRTrs[6];
                            ?>

                            
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <?php
                                        $getInvoiceDetailsOngiongQuery=$conn->query("SELECT * FROM invoice_details WHERE resturent_table_id='$ResturentTableId' AND (payment_status='0' OR payment_status='1')");
                                        if ($GIDOrs=$getInvoiceDetailsOngiongQuery->fetch_array()) {
                                            $InvoiceDetailsId=$GIDOrs[0];
                                            $PaymentStatus=$GIDOrs[2];
                                            $InvoiceType=$GIDOrs[3];
                                            $InvoiceWaiterId=$GIDOrs[4];
                                            $InvoiceDiscount=$GIDOrs[5];
                                            $InvoiceDateTime=$GIDOrs[6];

                                            $time_ago = strtotime($InvoiceDateTime);
                                        }

                                    ?>

                                    <div class="card-header">
                                        <h5 class="card-title notranslate">Table Number <?php echo $ResturentTableNumber; ?>
                                            <?php if ($ResturentTableAvailabilityStatus=='1') { ?>
                                            <span class="badge badge-secondary badge-style-light notranslate"><?php echo timeAgo($time_ago); ?> </span>
                                        <?php }else{} ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">

                                        <?php if ($ResturentTableAvailabilityStatus=='1') { ?>

                                            
                                            <div class="widget-stats-container d-flex">
                                                <div class="widget-stats-icon widget-stats-icon-primary">
                                                    <i class="material-icons-outlined notranslate">payments</i>
                                                </div>
                                                <div class="widget-stats-content flex-fill">
                                                    <span class="widget-stats-title">Current Cost</span>

                                                    <?php
                                                        $getInvoiceQuery=$conn->query("SELECT * FROM invoice_product ip INNER JOIN product_badge_details pbd ON ip.product_badge_id=pbd.product_badge_id INNER JOIN invoice_details id ON id.invoice_details_id=ip.invoice_id WHERE ip.invoice_id='$InvoiceDetailsId' AND id.resturent_table_id='$ResturentTableId' ");
                                                        $FullTotal = 0;
                                                        $ProductCount=0;
                                                        $SubTotal=0;
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
                                                                                          
                                                            

                                                            $ItemPriceWithQty = (double)$ProductPrice * (double)$InvoiceQty;

                                                            $SubTotal += (double)$ItemPriceWithQty;


                                                            $ProductCountList=$ProductCount+=1;
                                                    ?>

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





                                                    <?php } ?>
                                                    

                                                    <span class="widget-stats-amount">Rs.<?php echo number_format($FullTotal,2); ?></span>
                                                    <span class="widget-stats-info"><?php echo $ProductCount; ?> Orders Total</span>

                                                    

                                                </div>
                                            </div>
                                            <div class="widget-connection-request-actions d-flex">

                                                <a href="orders?o=<?php echo base64_encode($InvoiceDetailsId); ?>" class="btn btn-success btn-style-light flex-grow-1 m-r-xxs"><i class="material-icons notranslate">fastfood</i>Order Meal or Beverage</a>
                                                <!-- <a href="#" class="btn btn-danger btn-style-light flex-grow-1 m-l-xxs"><i class="material-icons">close</i>Ignore</a> -->
                                            </div>
                               

                                        <?php }else{ ?>

                                            <div class="widget-stats-container d-flex">
                                                <div class="widget-stats-icon widget-stats-icon-warning">
                                                    <i class="material-icons-outlined notranslate">table_bar</i>
                                                </div>
                                                <div class="widget-stats-content flex-fill">
                                                    <span class="widget-stats-amount notranslate" style="margin-top: 20px;">Table <?php echo $ResturentTableNumber; ?> Free</span>
                                                </div>
                                            </div>
                                            <div class="widget-connection-request-actions d-flex" style="margin-top: 20px;">
                                                <button type="button" class="btn btn-primary btn-style-light flex-grow-1 m-r-xxs" data-bs-toggle="modal" data-bs-target="#exampleModalCenter<?php echo $ResturentTableId; ?>">
                                                    <i class="material-icons notranslate" data-bs-toggle="modal" data-bs-target="#exampleModal">add_circle_outline</i>Create New Bill
                                                </button>
                                            </div>





                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalCenter<?php echo $ResturentTableId; ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header notranslate">
                                                                <h5 class="modal-title" id="exampleModalCenterTitle">Table Number <?php echo $ResturentTableNumber; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php //echo rand_code(6); ?>
                                                                <p style="font-size: 25px;">
                                                                    Book this Table<br>
                                                                    Are you sure to proceed this?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer notranslate">
                                                                <form id="Create-Invoice-Details">
                                                                    <input type="hidden" name="resturent_table_id" value="<?php echo $ResturentTableId; ?>" required readonly>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                                                                    <button type="submit" id="btn-invoice-details" class="btn btn-primary">YES</button>
                                                                </form>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>






                                        <?php } ?>


                                        <!-- <div class="widget-connection-request-actions d-flex">
                                            <a href="#" class="btn btn-primary btn-style-light flex-grow-1 m-r-xxs"><i class="material-icons">done</i>Accept</a>
                                            <a href="#" class="btn btn-danger btn-style-light flex-grow-1 m-l-xxs"><i class="material-icons">close</i>Ignore</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>


                            <?php } ?>


                        </div>




                            
                    
                   
                        
                        

                    </div>
                </div>
            </div>
        <?php } ?>
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
    
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script>
        
        $(document).on('submit', '#Create-Invoice-Details', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-invoice-details").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"invoice_post/add_invoice_details.php",
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
                       location.reload();
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-invoice-details").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>
</html>