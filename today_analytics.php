<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');


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
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('controls/meta.php'); ?>
</head>
<body onload="startTime()">
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
                                    <h1>Today Analytics <font style="font-size: 15px;"><?php echo $currentDate; ?></font></h1>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-primary">
                                                <i class="material-icons-outlined notranslate">table_bar</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Today's Table Income</span>
                                                <?php
                                                    $GetTableInvoicesql = "SELECT * FROM invoice_save ins INNER JOIN invoice_details ind ON ins.invoice_id=ind.invoice_details_id INNER JOIN users_login ul ON ins.invoice_waiter_id=ul.user_id WHERE ind.invoice_type='1' AND ins.invoice_save_datetime LIKE '%$currentDate%' ORDER BY ins.invoice_save_id DESC";
                                                    $TableInvoicers=$conn->query($GetTableInvoicesql);
                                                    $TodayTableIncome=0;
                                                    $TableCount=0;
                                                    while($Tblrow =$TableInvoicers->fetch_array())
                                                    {
                                                        $GrandTotalTable=$Tblrow[6];
                                                        $TodayTableIncome += (double)$GrandTotalTable;
                                                        $TableCountList=$TableCount+=1;
                                                    }
                                                ?>
                                                <span class="widget-stats-amount">Rs.<?php echo number_format($TodayTableIncome,2); ?></span>
                                                <span class="widget-stats-info"><?php echo $TableCount; ?> Table Bill Total</span>
                                            </div>
                                            <!-- <div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
                                                <i class="material-icons">keyboard_arrow_down</i> 4%
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-warning">
                                                <i class="material-icons-outlined notranslate">receipt</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Today's Takeaway Income</span>
                                                <?php
                                                    $GetTakeawaysql = "SELECT * FROM invoice_save insv INNER JOIN invoice_details inde ON insv.invoice_id=inde.invoice_details_id WHERE inde.invoice_type='2' AND insv.invoice_save_datetime LIKE '%$currentDate%' ORDER BY insv.invoice_save_id DESC";
                                                    $Takeawayrs=$conn->query($GetTakeawaysql);
                                                    $TodayTakeawayIncome=0;
                                                    $TakeawayCount=0;
                                                    while($Takerow =$Takeawayrs->fetch_array())
                                                    {
                                                        $GrandTotalTakeaway=$Takerow[6];
                                                        $TodayTakeawayIncome += (double)$GrandTotalTakeaway;
                                                        $TakeawayCountList=$TakeawayCount+=1;
                                                    }
                                                ?>
                                                <span class="widget-stats-amount">Rs.<?php echo number_format($TodayTakeawayIncome,2); ?></span>
                                                <span class="widget-stats-info"><?php echo $TakeawayCount; ?> Takeaway Bill Total</span>
                                            </div>
                                            <!-- <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                                <i class="material-icons">keyboard_arrow_up</i> 12%
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-dark">
                                                <i class="material-icons-outlined notranslate">receipt_long</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Today's UBER/PickMe Income</span>
                                                <?php
                                                    $GetUberPickmeTakeawaysql = "SELECT * FROM invoice_save insv INNER JOIN invoice_details inde ON insv.invoice_id=inde.invoice_details_id WHERE inde.invoice_type='3' AND insv.invoice_save_datetime LIKE '%$currentDate%' ORDER BY insv.invoice_save_id DESC";
                                                    $TakeawayUberPickMers=$conn->query($GetUberPickmeTakeawaysql);
                                                    $TodayTakeawayUberPickMeIncome=0;
                                                    $TakeawayUberPickMeCount=0;
                                                    while($Takerow =$Takeawayrs->fetch_array())
                                                    {
                                                        $GrandTotalTakeaway=$Takerow[6];
                                                        $TodayTakeawayUberPickMeIncome += (double)$GrandTotalTakeaway;
                                                        $TakeawayUberPickMeCountList=$TakeawayUberPickMeCount+=1;
                                                    }
                                                ?>
                                                <span class="widget-stats-amount">Rs.<?php echo number_format($TodayTakeawayUberPickMeIncome,2); ?></span>
                                                <span class="widget-stats-info"><?php echo $TakeawayUberPickMeCount; ?> UBER/PickMe Bill Total</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <h5>Today Sale's Products</h5>
                                        
                                        <table class="table" id="table1" style="width:100%;">
                                            <thead class="table-dark">
                                                <tr>   
                                                    <th>ID</th>
                                                    <th>Product Name</th>
                                                    <th>Product Number</th>
                                                    <th><span style="float: right;">Available Quantity</span></th>
                                                    <th><span style="float: right;">Sales Quantity</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $GetAvailableQuantityProductssql = "SELECT product_badge_id, SUM(product_quantity) FROM invoice_product WHERE invoice_product_datetime LIKE '%$currentDate%' GROUP BY product_badge_id ORDER BY SUM(product_quantity) DESC";
                                                    $gaqprs=$conn->query($GetAvailableQuantityProductssql);
                                                    $AllProductSaleQty=0;
                                                    $TodaySaleProductsCount=0;
                                                    while($GAPCrow =$gaqprs->fetch_array())
                                                    {
                                                        $ProductBadgeId=$GAPCrow[0];
                                                        $AllProductSaleQty=$GAPCrow[1];
                                                        
                                                        $getProductDetails = $conn->query("SELECT * FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.product_badge_id = '$ProductBadgeId'");
                                                        if($GPD = $getProductDetails->fetch_array()){

                                                            $ProductBadgeName=$GPD[2];
                                                            $ProductStatus=$GPD[5];
                                                            $ProductAvailableQuantity=$GPD[6];
                                                            $ProductName=$GPD[9];
                                                            $ProductCode=$GPD[10];

                                                        }

                                                ?>
                                                <?php if ($ProductStatus=='0') { }else{ ?>
                                                <tr>
                                                    <td><?php echo $TodaySaleProductsCount+=1; ?></td>
                                                    <td><?php echo $ProductName.' - '.$ProductBadgeName; ?></td>
                                                    <td><?php echo $ProductCode; ?></td>
                                                    <td><b><span style="float: right; font-size: 20px; color: #FF0000;"><?php echo $ProductAvailableQuantity; ?></span></b></td>
                                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;"><?php echo $AllProductSaleQty; ?></b></span></td>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <canvas id="TodaySalesProductsPieChart" width="100%" height="70"></canvas>
                                            </div>
                                            <div class="col-xl-6">
                                                <canvas id="TodaySalesProductsBarChart" width="100%" height="70"></canvas>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <h5>Today Sale's Kitchen Products</h5>
                                        
                                        <table class="table" style="width:100%;">
                                            <thead class="table-dark">
                                                <tr>   
                                                    <th>ID</th>
                                                    <th>Product Name</th>
                                                    <th>Product Number</th>
                                                    <th><span style="float: right;">Sales Quantity</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $GetSalesQuantityKitchenProductssql = "SELECT product_badge_id, SUM(product_quantity) FROM invoice_product WHERE invoice_product_datetime LIKE '%$currentDate%' GROUP BY product_badge_id ORDER BY SUM(product_quantity) DESC";
                                                    $gsqkprs=$conn->query($GetSalesQuantityKitchenProductssql);
                                                    $AllProductSaleKitchenQty=0;
                                                    $TodaySaleKitchenProductsCount=0;
                                                    while($GSQKPCrow =$gsqkprs->fetch_array())
                                                    {
                                                        $ProductBadgeIdKitchen=$GSQKPCrow[0];
                                                        $AllProductSaleKitchenQty=$GSQKPCrow[1];
                                                        
                                                        $getProductDetails = $conn->query("SELECT * FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.product_badge_id = '$ProductBadgeIdKitchen'");
                                                        if($GPD = $getProductDetails->fetch_array()){

                                                            $ProductKitchenBadgeName=$GPD[2];
                                                            $ProductKitchenStatus=$GPD[5];
                                                            $ProductKitchenName=$GPD[9];
                                                            $ProductKitchenCode=$GPD[10];

                                                        }

                                                ?>
                                                <?php if ($ProductKitchenStatus=='1') { }else{ ?>
                                                <tr>
                                                    <td><?php echo $TodaySaleKitchenProductsCount+=1; ?></td>
                                                    <td><?php echo $ProductKitchenName.' - '.$ProductKitchenBadgeName; ?></td>
                                                    <td><?php echo $ProductKitchenCode; ?></td>
                                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;"><?php echo $AllProductSaleKitchenQty; ?></b></span></td>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <canvas id="TodaySalesKitchenProductsPieChart" width="100%" height="70"></canvas>
                                            </div>
                                            <div class="col-xl-6">
                                                <canvas id="TodaySalesKitchenProductsBarChart" width="100%" height="70"></canvas>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <h5>Today Waiter Performance</h5>
                                        
                                        <table class="table" style="width:100%;">
                                            <thead class="table-dark">
                                                <tr>   
                                                    <th>ID</th>
                                                    <th>Waiter Name</th>
                                                    <th><span style="float: right;">Bill Count</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $GetWaiterBillsql = "SELECT invoice_id, invoice_waiter_id, COUNT(invoice_waiter_id) FROM invoice_save WHERE invoice_save_datetime LIKE '%$currentDate%' GROUP BY invoice_waiter_id ORDER BY COUNT(invoice_waiter_id) DESC";
                                                    $gwbs=$conn->query($GetWaiterBillsql);
                                                    $TodayWaiterPerformanceCount=0;
                                                    while($GWBSrow =$gwbs->fetch_array())
                                                    {
                                                        $InvoiceId=$GWBSrow[0];
                                                        $WaiterId=$GWBSrow[1];
                                                        $WaiterBillCount=$GWBSrow[2];
                                                        
                                                        $getWaiterDetails = $conn->query("SELECT * FROM users_login WHERE user_id = '$WaiterId'");
                                                        if($GWD = $getWaiterDetails->fetch_array()){

                                                            $WaiterName=$GWD[1];

                                                        }

                                                ?>
                                                <?php if ($WaiterId==null) { }else{ ?>
                                                <tr>
                                                    <td><?php echo $TodayWaiterPerformanceCount+=1; ?></td>
                                                    <td><?php echo $WaiterName; ?></td>
                                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;"><?php echo $WaiterBillCount; ?></b></span></td>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <canvas id="TodayWaiterPerformancePieChart" width="100%" height="70"></canvas>
                                            </div>
                                            <div class="col-xl-6">
                                                <canvas id="TodayWaiterPerformanceBarChart" width="100%" height="70"></canvas>
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
    
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>
    <script src="assets/plugins/chartjs/chart.bundle.min.js"></script>
    <script src="assets/js/pages/charts-chartjs.js"></script>
    <script src="assets/js/pages/chartjs-color.js"></script>




     <!--------------------------Start Today Sale's Products Summary----------------------------------------------------->


        <script>

            TodaySalesProductsChart();

            function TodaySalesProductsChart(){

                $.ajax({
              url:'analytics/get_today_sale_products.php',
              type:'POST',
              data:{},
              success:function(data){
                console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                    var productName = json.productName;
                    var productQtySum = json.productQtySum;

                var ctx = document.getElementById('TodaySalesProductsPieChart');
                var TodaySalesProductsPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: productName,
                        datasets: [{
                        data: productQtySum,
                        // backgroundColor: [getRandomColorHex()]
                    }]
                    },
                    options: {
                        responsive: true,
                        title:{
                            display: true,
                            text: "Today Products Summary",
                        },

                        plugins: {
                          colorschemes: {
                            scheme: 'brewer.DarkTwo3'
                          }
                        }
                    }
                });


                var ctx = document.getElementById('TodaySalesProductsBarChart');
                    var TodaySalesProductsBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productName,
                            datasets: [{
                                label: 'Today Products Summary',
                                data: productQtySum,
                                // backgroundColor: ["#6765D3", "#0D0C59"],
                                // borderColor: ["#6765D3", "#0D0C59"],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                    }
                                }]
                            },
                            plugins: {
                            colorschemes: {
                                scheme: 'brewer.DarkTwo3'
                                }

                            }
                        }
                    });

                 

                }
                
                Swal.close();


              },
              error:function(err){
                console.log(err);
              }


            });



            

            }

        </script>

        <!--------------------------End Today Sale's Products Summary----------------------------------------------------->

        <!--------------------------Start Today Kitchen Sale's Products Summary----------------------------------------------------->


        <script>

            TodaySalesProductsChart();

            function TodaySalesProductsChart(){

                $.ajax({
              url:'analytics/get_today_sale_kitchen_products.php',
              type:'POST',
              data:{},
              success:function(data){
                console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                    var productKitchenName = json.productKitchenName;
                    var productKitchenQtySum = json.productKitchenQtySum;

                var ctx = document.getElementById('TodaySalesKitchenProductsPieChart');
                var TodaySalesKitchenProductsPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: productKitchenName,
                        datasets: [{
                        data: productKitchenQtySum,
                        // backgroundColor: [getRandomColorHex()]
                    }]
                    },
                    options: {
                        responsive: true,
                        title:{
                            display: true,
                            text: "Today Kitchen Products Summary",
                        },

                        plugins: {
                          colorschemes: {
                            scheme: 'brewer.PiYG4'
                          }
                        }
                    }
                });


                var ctx = document.getElementById('TodaySalesKitchenProductsBarChart');
                    var TodaySalesKitchenProductsBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productKitchenName,
                            datasets: [{
                                label: 'Today Products Kitchen Summary',
                                data: productKitchenQtySum,
                                // backgroundColor: ["#6765D3", "#0D0C59"],
                                // borderColor: ["#6765D3", "#0D0C59"],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                    }
                                }]
                            },
                            plugins: {
                            colorschemes: {
                                scheme: 'brewer.PiYG4'
                                }

                            }
                        }
                    });

                 

                }
                
                Swal.close();


              },
              error:function(err){
                console.log(err);
              }


            });



            

            }

        </script>

        <!--------------------------End Today Kitchen Sale's Products Summary----------------------------------------------------->


        <!--------------------------Start Today Kitchen Sale's Products Summary----------------------------------------------------->


        <script>

            TodayWaiterPerformanceChart();

            function TodayWaiterPerformanceChart(){

                $.ajax({
              url:'analytics/get_today_waiter_performace.php',
              type:'POST',
              data:{},
              success:function(data){
                console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                    var waiterName = json.waiterName;
                    var waiterBillCount = json.waiterBillCount;

                var ctx = document.getElementById('TodayWaiterPerformancePieChart');
                var TodayWaiterPerformancePieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: waiterName,
                        datasets: [{
                        data: waiterBillCount,
                        // backgroundColor: [getRandomColorHex()]
                    }]
                    },
                    options: {
                        responsive: true,
                        title:{
                            display: true,
                            text: "Today Kitchen Products Summary",
                        },

                        plugins: {
                          colorschemes: {
                            scheme: 'brewer.Paired12'
                          }
                        }
                    }
                });


                var ctx = document.getElementById('TodayWaiterPerformanceBarChart');
                    var TodayWaiterPerformanceBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: waiterName,
                            datasets: [{
                                label: 'Today Products Kitchen Summary',
                                data: waiterBillCount,
                                // backgroundColor: ["#6765D3", "#0D0C59"],
                                // borderColor: ["#6765D3", "#0D0C59"],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                    }
                                }]
                            },
                            plugins: {
                            colorschemes: {
                                scheme: 'brewer.Paired12'
                                }

                            }
                        }
                    });

                 

                }
                
                Swal.close();


              },
              error:function(err){
                console.log(err);
              }


            });



            

            }

        </script>

        <!--------------------------End Today Kitchen Sale's Products Summary----------------------------------------------------->


        <script>
            /**
           * function to generate random color in hex form
           */
          function getRandomColorHex() {
            var hex = "0123456789ABCDEF",
                color = "#";
            for (var i = 1; i <= 6; i++) {
              color += hex[Math.floor(Math.random() * 16)];
            }
            return color;
          }
        </script>

</body>
</html>