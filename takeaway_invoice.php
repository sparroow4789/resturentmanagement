<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');

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
<?php
    $getInvoiceOngoingQuery=$conn->query("SELECT COUNT(*) FROM invoice_details WHERE payment_status='0' AND invoice_type='2' OR invoice_type='3' ORDER BY invoice_details_id DESC LIMIT 1");
    if ($GIOrs=$getInvoiceOngoingQuery->fetch_array()) {
        $InvoiceOngoingTakeawayCount=$GIOrs[0];
    }
?>
<?php if($InvoiceOngoingTakeawayCount=='0'){ ?>
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
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h1>Create Takeaway Invoice</h1>
                                </div>
                            </div>
                        </div>
             
                
                  
                    
                   
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Select Takeaway Category</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">
                                            <div class="example-content">

                                                <div class="row">
                                                    
                                                        <div class="col-xl-6">
                                                            <div class="card widget widget-info-navigation" style="background-color: #E7ECF8;">
                                                                <div class="card-body">
                                                                    <div class="widget-info-navigation-container notranslate">
                                                                        <div class="widget-info-navigation-content">
                                                                                <center><img src="assets/images/icons/take-away.png" style="width: 15%;"><br>
                                                                                <span class="text-primary fw-bolder fs-3">Takeaway</span></center>
                                                                            <form id="Add-Invoice-Product">
                                                                                <input type="hidden" name="invoice_type" value="2" readonly required>
                                                                                <center><button type="submit" class="btn btn-success btn-burger" id="btn-takeaway-product"><i class="material-icons no-m notranslate">keyboard_tab</i></button></center>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-6">
                                                            <div class="card widget widget-info-navigation" style="background-color: #E7ECF8;">
                                                                <div class="card-body">
                                                                    <div class="widget-info-navigation-container">
                                                                        <div class="widget-info-navigation-content notranslate">
                                                                                <center><img src="assets/images/icons/uber.png" style="width: 15%;"><br>
                                                                                <span class="text-primary fw-bolder fs-3">UBER/Pick Me</span></center>
                                                                            <form id="Add-Invoice-Product">
                                                                                <input type="hidden" name="invoice_type" value="3" readonly required>
                                                                                <center><button type="submit" class="btn btn-success btn-burger" id="btn-takeaway-product"><i class="material-icons no-m notranslate">keyboard_tab</i></button></center>
                                                                            </form>
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

                            </div>

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
        
        $(document).on('submit', '#Add-Invoice-Product', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-takeaway-product").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"takeaway_post/add_takeaway_invoice_details.php",
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
                       var id = json.lastId;
                       // alert (id);
                       window.location.href = "takeaway_orders?p="+id;
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-takeaway-product").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>
</html>

<?php }else{ ?>

<?php
    $getInvoiceOngoingIdQuery=$conn->query("SELECT invoice_details_id FROM invoice_details WHERE payment_status='0' AND invoice_type='2' OR invoice_type='3' ORDER BY invoice_details_id DESC LIMIT 1");
    if ($GIOIrs=$getInvoiceOngoingIdQuery->fetch_array()) {
        $InvoiceId=$GIOIrs[0];
    }
?>
    <script>
        window.location.href = "takeaway_orders?p=<?php echo(base64_encode($InvoiceId)) ?>";
    </script>

<?php }?>