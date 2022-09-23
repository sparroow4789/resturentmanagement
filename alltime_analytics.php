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
                                    <h1>All Time Analytics</h1>
                                </div>
                            </div>
                        </div>



                        <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Income Check</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">

                                            <style>
                                                .example-container {
                                                    border: 0px solid #f4f7fa;
                                                    border-radius: 10px;
                                                }
                                            </style>

                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Start Date *</label>
                                                                <input type="date" id="income-start-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">End Date *</label>
                                                                <input type="date" id="income-end-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-get-income" class="btn btn-primary">Get Income</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-success">
                                                                        <i class="material-icons-outlined notranslate">table_bar</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">Table<br>Income</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-table-total">Rs.0.00</span>
                                                                        <span class="widget-stats-info"><span id="lbl-table-count">0</span> Bill Total</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                                                        <i class="material-icons-outlined notranslate">receipt</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">Takeaway<br>Income</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-takeaway-total">Rs.0.00</span>
                                                                        <span class="widget-stats-info"><span id="lbl-takeaway-count">0</span> Bill Total</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-dark">
                                                                        <i class="material-icons-outlined notranslate">receipt_long</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">UBER/PickMe<br>Income</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-uber-total">Rs.0.00</span>
                                                                        <span class="widget-stats-info"><span id="lbl-uber-count">0</span> Bill Total</span>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                                                        <i class="material-icons-outlined notranslate">payments</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">Full<br>Income</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-grand-total">Rs.0.00</span>
                                                                        <span class="widget-stats-info"><span id="lbl-all-bill-count">0</span> Bill Total</span>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <canvas id="TotalIncomePieChart" width="100%" height="50"></canvas>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <canvas id="TotalIncomeBarChart" width="100%" height="50"></canvas>
                                                    </div>
                                                    
                                                </div>



                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>









                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Cost Check</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">

                                            <style>
                                                .example-container {
                                                    border: 0px solid #f4f7fa;
                                                    border-radius: 10px;
                                                }
                                            </style>

                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Start Date *</label>
                                                                <input type="date" id="cost-start-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">End Date *</label>
                                                                <input type="date" id="cost-end-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-get-cost" class="btn btn-primary">Get Income</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-success">
                                                                        <i class="material-icons-outlined notranslate">table_bar</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">Stock Cost</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-stock-cost">Rs.0.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                                                        <i class="material-icons-outlined notranslate">receipt</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">Grocery Cost</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-grocery-cost">Rs.0.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="card widget widget-stats" style="background-color: #e7ecf8;">
                                                            <div class="card-body">
                                                                <div class="widget-stats-container d-flex">
                                                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                                                        <i class="material-icons-outlined notranslate">payments</i>
                                                                    </div>
                                                                    <div class="widget-stats-content flex-fill">
                                                                        <span class="widget-stats-title">Full Cost</span>
                                                                        
                                                                        <span class="widget-stats-amount" id="lbl-full-cost">Rs.0.00</span>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Product Cost List</h6>
                                                        <div class="table-responsive">
                                                            <table class="table" id="table1" style="width:100%;">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th scope="col">Item Name</th>
                                                                        <th scope="col">Product Number</th>
                                                                        <th scope="col" style="text-align: right;">Qty</th>
                                                                        <th scope="col" style="text-align: right;">Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="product-t-body">
                                                                    <!-- <tr>
                                                                        <td>gfdsg dsg sd</td>
                                                                        <td>151515</td>
                                                                        <td>10</td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Grocery Cost List</h6>
                                                        <div class="table-responsive">
                                                            <table class="table" id="table1" style="width:100%;">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th scope="col">Grocery Item Name</th>
                                                                        <th scope="col" style="text-align: right;">Qty</th>
                                                                        <th scope="col" style="text-align: right;">Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="grocery-t-body">
                                                                    <!-- <tr>
                                                                        <td>gfdsg dsg sd</td>
                                                                        <td>151515</td>
                                                                        <td>10</td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <canvas id="myStockPieChart" width="100%" height="50"></canvas>
                                                        <canvas id="myStockBarChart" width="100%" height="50"></canvas>
                                                    </div> -->
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- <canvas id="TotalIncomePieChart" width="100%" height="50"></canvas> -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- <canvas id="TotalIncomeBarChart" width="100%" height="50"></canvas> -->
                                                    </div>
                                                    
                                                </div>



                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>



















                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Stock Selling Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">

                                            <style>
                                                .example-container {
                                                    border: 0px solid #f4f7fa;
                                                    border-radius: 10px;
                                                }
                                            </style>

                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Start Date *</label>
                                                                <input type="date" id="stock-start-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">End Date *</label>
                                                                <input type="date" id="stock-end-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-get-stock" class="btn btn-primary">Get Stock</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    

                                                </div>

                                                <hr>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table class="table" id="table1" style="width:100%;">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th scope="col">Item Name</th>
                                                                        <th scope="col">Product Number</th>
                                                                        <th scope="col" style="text-align: right;">Selling Count</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="stock-container">
                                                                    <!-- <tr>
                                                                        <td>gfdsg dsg sd</td>
                                                                        <td>151515</td>
                                                                        <td>10</td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <canvas id="myStockPieChart" width="100%" height="50"></canvas>
                                                        <canvas id="myStockBarChart" width="100%" height="50"></canvas>
                                                    </div>
                                                </div>



                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Kitchen Products Selling Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">

                                            <style>
                                                .example-container {
                                                    border: 0px solid #f4f7fa;
                                                    border-radius: 10px;
                                                }
                                            </style>

                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Start Date *</label>
                                                                <input type="date" id="kitchen-products-start-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">End Date *</label>
                                                                <input type="date" id="kitchen-products-end-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-get-kitchen-products" class="btn btn-primary">Get Stock</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    

                                                </div>

                                                <hr>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table class="table" id="table1" style="width:100%;">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th scope="col">Product Name</th>
                                                                        <th scope="col">Product Number</th>
                                                                        <th scope="col" style="text-align: right;">Selling Count</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="kitchen-products-container">
                                                                    <!-- <tr>
                                                                        <td>gfdsg dsg sd</td>
                                                                        <td>151515</td>
                                                                        <td>10</td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <canvas id="myKitchenStockPieChart" width="100%" height="50"></canvas>
                                                        <canvas id="myKitchenStockBarChart" width="100%" height="50"></canvas>
                                                    </div>
                                                </div>



                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Monthly Income Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">

                                            <style>
                                                .example-container {
                                                    border: 0px solid #f4f7fa;
                                                    border-radius: 10px;
                                                }
                                            </style>

                                            <div class="example-content">

                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                        <canvas id="MonthlyInvoiceSummaryBarChart" width="100%" height="30"></canvas>
                                                    </div>
                                                </div>



                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>



                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Waiter Performance Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">

                                            <style>
                                                .example-container {
                                                    border: 0px solid #f4f7fa;
                                                    border-radius: 10px;
                                                }
                                            </style>

                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Start Date *</label>
                                                                <input type="date" id="waiter-start-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">End Date *</label>
                                                                <input type="date" id="waiter-end-date" value="<?php echo date('Y-m-d'); ?>" class="form-control" min="0" placeholder="Start Date" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-get-waiter" class="btn btn-primary">Get Waiter Performance</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    

                                                </div>

                                                <hr>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table class="table" id="table1" style="width:100%;">
                                                                <thead class="table-dark">
                                                                    <tr>
                                                                        <th scope="col">Waiter Name</th>
                                                                        <!-- <th scope="col">Product Number</th> -->
                                                                        <th scope="col" style="text-align: right;">Bill Count</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="waiter-container">
                                                                    <!-- <tr>
                                                                        <td>gfdsg dsg sd</td>
                                                                        <td>151515</td>
                                                                        <td>10</td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <canvas id="myWaiterPieChart" width="100%" height="50"></canvas>
                                                        <canvas id="myWaiterBarChart" width="100%" height="50"></canvas>
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

    <script src="assets/js/sweetalert2.js"></script>

    <!------------------ Start Total Income---------------------------------------->
    <script type="text/javascript">
            $(document).ready(function () {

               loadChart(0,0,0);

                $("#btn-get-income").click(function(){

                    var startDate = $("#income-start-date").val();
                    var endDate = $("#income-end-date").val();

                    $.ajax({

                        url:'analytics/get_income_summary.php',
                        type:'POST',
                        data:{
                            start_date:startDate,
                            end_date:endDate
                        },
                        beforeSend:function(){
                            Swal.fire({
                              text: "Please wait...",
                              imageUrl:"assets/images/income.gif",
                              showConfirmButton: false,
                              allowOutsideClick: false
                            });
                        },
                        success:function(data){
                            var json = JSON.parse(data);
                            var table_total = 0.00;
                            var takeaway_total = 0.00;
                            var uber_total = 0.00;
                            var grand_total = 0.00;

                            var table_count = 0;
                            var takeaway_count = 0;
                            var uber_count = 0;
                            var all_bill_count = 0;


                            if(json.result){

                                if(json.table_total != 'null'){
                                    table_total = json.table_total;
                                }else{
                                    table_total = 0.00;
                                }

                                if(json.takeaway_total != 'null'){
                                    takeaway_total = json.takeaway_total;
                                }else{
                                    takeaway_total = 0.00;
                                }

                                if(json.uber_total != 'null'){
                                    uber_total = json.uber_total;
                                }else{
                                    uber_total = 0.00;
                                }

                                if(json.grand_total != 'null'){
                                    grand_total = json.grand_total;
                                }else{
                                    grand_total = 0.00;
                                }

                                if(json.table_count != 'null'){
                                    table_count = json.table_count;
                                }else{
                                    table_count = 0;
                                }

                                if(json.takeaway_count != 'null'){
                                    takeaway_count = json.takeaway_count;
                                }else{
                                    takeaway_count = 0;
                                }

                                if(json.uber_count != 'null'){
                                    uber_count = json.uber_count;
                                }else{
                                    uber_count = 0;
                                }

                                if(json.all_bill_count != 'null'){
                                    all_bill_count = json.all_bill_count;
                                }else{
                                    all_bill_count = 0;
                                }

                                $("#lbl-table-total").html('Rs.'+parseFloat(table_total).toFixed(2));
                                $("#lbl-takeaway-total").html('Rs.'+parseFloat(takeaway_total).toFixed(2));
                                $("#lbl-uber-total").html('Rs.'+parseFloat(uber_total).toFixed(2));
                                $("#lbl-grand-total").html('Rs.'+parseFloat(grand_total).toFixed(2));

                                $("#lbl-table-count").html(table_count);
                                $("#lbl-takeaway-count").html(takeaway_count);
                                $("#lbl-uber-count").html(uber_count);
                                $("#lbl-all-bill-count").html(all_bill_count);

                                loadChart(table_total,takeaway_total,uber_total);
                               
                            }

                            Swal.close();
                        },
                        error:function(err){
                            console.log(err);
                        }


                    });



                });




            } );
       
        </script>


        <script>

            function loadChart(table_total,takeaway_total,uber_total){

                var ctx = document.getElementById('TotalIncomePieChart');
                var TotalIncomePieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        'Table Income',
                        'Takeaway Income',
                        'Uber/PickMe Income'
                    ],
                    datasets: [{
                        data: [table_total,takeaway_total,uber_total],
                        backgroundColor: ["#4BAD48", "#FF9500", "#000000"]
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: "Income Summary"
                    }
                }
            });


                var ctx = document.getElementById('TotalIncomeBarChart');
                    var TotalIncomeBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Table Income', 'Takeaway Income', 'Uber/PickMe Income'],
                            datasets: [{
                                label: 'Income Summary',
                                data: [table_total,takeaway_total,uber_total],
                                backgroundColor: [
                                    '#4BAD48',
                                    '#FF9500',
                                    '#000000'
                                ],
                                borderColor: [
                                    '#4BAD48',
                                    '#FF9500',
                                    '#000000'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });




            }

        </script>

        <!------------------ End Total Income---------------------------------------->


        <!------------------ Start Cost Income---------------------------------------->
    <script type="text/javascript">
            $(document).ready(function () {

               // loadChart(0,0,0);

                $("#btn-get-cost").click(function(){

                    var startDate = $("#cost-start-date").val();
                    var endDate = $("#cost-end-date").val();

                    $.ajax({

                        url:'analytics/get_cost_summary.php',
                        type:'POST',
                        data:{
                            cost_start_date:startDate,
                            cost_end_date:endDate
                        },
                        beforeSend:function(){
                            Swal.fire({
                              text: "Please wait...",
                              imageUrl:"assets/images/income.gif",
                              showConfirmButton: false,
                              allowOutsideClick: false
                            });
                        },
                        success:function(data){
                            var json = JSON.parse(data);
                            var total_stock_cost = 0.00;
                            var total_grocery_cost = 0.00;
                            var total_cost = 0.00;


                            if(json.result){

                                if(json.total_stock_cost != 'null'){
                                    total_stock_cost = json.total_stock_cost;
                                }else{
                                    total_stock_cost = 0.00;
                                }

                                if(json.total_grocery_cost != 'null'){
                                    total_grocery_cost = json.total_grocery_cost;
                                }else{
                                    total_grocery_cost = 0.00;
                                }

                                if(json.total_cost != 'null'){
                                    total_cost = json.total_cost;
                                }else{
                                    total_cost = 0.00;
                                }

                                // alert(json.product_data);

                                $("#product-t-body").html(json.product_data);
                                $("#grocery-t-body").html(json.grocery_data);

                                $("#lbl-stock-cost").html('Rs.'+parseFloat(total_stock_cost).toFixed(2));
                                $("#lbl-grocery-cost").html('Rs.'+parseFloat(total_grocery_cost).toFixed(2));
                                $("#lbl-full-cost").html('Rs.'+parseFloat(total_cost).toFixed(2));

                                // loadChart(total_stock_cost,total_grocery_cost,uber_total);
                               
                            }

                            Swal.close();
                        },
                        error:function(err){
                            console.log(err);
                        }


                    });



                });




            } );
       
        </script>


        

        <!------------------ End Cost Income---------------------------------------->


        <!----------------------Start Stock Summery------------------------------------------>

        <script type="text/javascript">

            function downloadStockData(){
            }

      
          $(document).ready(function(){
            downloadStockData();


            $("#btn-get-stock").click(function(event){
              event.preventDefault();


              Swal.fire({
                  text: "Please wait...",
                  imageUrl:"assets/images/grocery.gif",
                  showConfirmButton: false,
                  allowOutsideClick: false
                });


              

              $.ajax({
              url:'analytics/get_stock_summary.php',
              type:'POST',
              data:{
                    stock_start_date:$("#stock-start-date").val(),
                    stock_end_date:$("#stock-end-date").val()
              },
              success:function(data){
                console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                  $("#stock-container").html(json.data);

                  var productName = json.productName;
                  var productQtySum = json.productQtySum;
                  loadStockChart(productName,productQtySum);

                  // loadStockChart(itemName,itemQtySum);

                }
                
                Swal.close();


              },
              error:function(err){
                console.log(err);
              }


            });

            });





          });

    </script>

    <script>

            function loadStockChart(productName,productQtySum){


            var ctx = document.getElementById('myStockPieChart');
            var myStockPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: productName,
                    datasets: [{
                        data: productQtySum,
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: "Stock Selling Summary",
                    },
                    plugins: {
                          colorschemes: {
                            scheme: 'brewer.DarkTwo3'
                        }
                    }
                }
            });


            var ctx = document.getElementById('myStockBarChart');
                    var myStockBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productName,
                            datasets: [{
                                label: 'Stock Summary',
                                data: productQtySum,
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

        </script>


    <!----------------------End Stock Summery------------------------------------------>


    <!----------------------Start Kitchen Stock Summery------------------------------------------>

        <script type="text/javascript">

            function downloadKichenStockData(){
            }

      
          $(document).ready(function(){
            downloadKichenStockData();


            $("#btn-get-kitchen-products").click(function(event){
              event.preventDefault();


              Swal.fire({
                  text: "Please wait...",
                  imageUrl:"assets/images/kitchen.gif",
                  showConfirmButton: false,
                  allowOutsideClick: false
                });


              

              $.ajax({
              url:'analytics/get_kitchen_stock_summary.php',
              type:'POST',
              data:{
                    stock_start_date:$("#kitchen-products-start-date").val(),
                    stock_end_date:$("#kitchen-products-end-date").val()
              },
              success:function(data){
                console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                  $("#kitchen-products-container").html(json.data);

                  var productKitchenName = json.productKitchenName;
                  var productKitchenQtySum = json.productKitchenQtySum;
                  loadKitchenStockChart(productKitchenName,productKitchenQtySum);

                  // loadStockChart(itemName,itemQtySum);

                }
                
                Swal.close();


              },
              error:function(err){
                console.log(err);
              }


            });


              
            });





          });

    </script>

    <script>

            function loadKitchenStockChart(productKitchenName,productKitchenQtySum){


            var ctx = document.getElementById('myKitchenStockPieChart');
            var myKitchenStockPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: productKitchenName,
                    datasets: [{
                        data: productKitchenQtySum,
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: "Stock Selling Summary",
                    },
                    plugins: {
                          colorschemes: {
                            scheme: 'brewer.Paired12'
                        }
                    }
                }
            });


            var ctx = document.getElementById('myKitchenStockBarChart');
                    var myKitchenStockBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productKitchenName,
                            datasets: [{
                                label: 'Stock Summary',
                                data: productKitchenQtySum,
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

        </script>


    <!----------------------End Kitchen Stock Summery------------------------------------------>

    <!--------------------------Start Monthly Line Chart------------------------------------------->

        <script>

            loadMonthleyJobsChart();

            function loadMonthleyJobsChart(){

                $.ajax({
              url:'analytics/get_all_invoice_month_by_month.php',
              type:'POST',
              data:{},
              success:function(data){
                // console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                    var summary = json.summary_data;
                 
                    var janInvoice = summary.jan;
                    if(janInvoice === null){
                        janInvoice = 0;
                    }
                    var febInvoice = summary.feb;
                    if(febInvoice === null){
                        febInvoice = 0;
                    }
                    var marInvoice = summary.mar;
                    if(marInvoice === null){
                        marInvoice = 0;
                    }
                    var aprInvoice = summary.apr;
                    if(aprInvoice === null){
                        aprInvoice = 0;
                    }
                    var mayInvoice = summary.may;
                    if(mayInvoice === null){
                        mayInvoice = 0;
                    }
                    var junInvoice = summary.jun;
                    if(junInvoice === null){
                        junInvoice = 0;
                    }
                    var julInvoice = summary.jul;
                    if(julInvoice === null){
                        julInvoice = 0;
                    }
                    var augInvoice = summary.aug;
                    if(augInvoice === null){
                        augInvoice = 0;
                    }
                    var sepInvoice = summary.sep;
                    if(sepInvoice === null){
                        sepInvoice = 0;
                    }
                    var octInvoice = summary.oct;
                    if(octInvoice === null){
                        octInvoice = 0;
                    }
                    var novInvoice = summary.nov;
                    if(novInvoice === null){
                        novInvoice = 0;
                    }
                    var decInvoice = summary.dec;
                    if(decInvoice === null){
                        decInvoice = 0;
                    }

                var ctx = document.getElementById('MonthlyInvoiceSummaryBarChart');
                var MonthlyInvoiceSummaryBarChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
                        'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'
                        ],
                        datasets: [{
                        label: 'Monthly Income Summary',
                        data: [janInvoice,febInvoice,marInvoice,aprInvoice,mayInvoice,junInvoice,julInvoice,augInvoice,sepInvoice,octInvoice,novInvoice,decInvoice],
                        // data: [100,10,1000,5000,100000,3500,150000,150,9000,10000,15000,10000],
                        fill: false,
                        borderColor: 'rgb(4, 9, 176)',
                        // tension: 0.1
                    }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                            }, 

                          title: {
                            display: true,
                            text: 'Monthly Income Summary'
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


        <!--------------------------Start Monthly Line Chart------------------------------------------->


        <!----------------------Start Waiter Summery------------------------------------------>

        <script type="text/javascript">

            function downloadWaiterData(){
            }

      
          $(document).ready(function(){
            downloadWaiterData();


            $("#btn-get-waiter").click(function(event){
              event.preventDefault();


              Swal.fire({
                  text: "Please wait...",
                  imageUrl:"assets/images/waiter.gif",
                  showConfirmButton: false,
                  allowOutsideClick: false
                });


              

              $.ajax({
              url:'analytics/get_waiter_summary.php',
              type:'POST',
              data:{
                    waiter_start_date:$("#waiter-start-date").val(),
                    waiter_end_date:$("#waiter-end-date").val()
              },
              success:function(data){
                console.log(data);

                // alert(data);

                var json=JSON.parse(data);
                
                if(json.result){

                  $("#waiter-container").html(json.data);

                  var waiterName = json.waiterName;
                  var waiterQtySum = json.waiterQtySum;
                  loadWaiterChart(waiterName,waiterQtySum);

                  // loadStockChart(itemName,itemQtySum);

                }
                
                Swal.close();


              },
              error:function(err){
                console.log(err);
              }


            });

            });





          });

    </script>

    <script>

            function loadWaiterChart(waiterName,waiterQtySum){


            var ctx = document.getElementById('myWaiterPieChart');
            var myWaiterPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: waiterName,
                    datasets: [{
                        data: waiterQtySum,
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: "Waiter Summary",
                    },
                    plugins: {
                          colorschemes: {
                            scheme: 'brewer.DarkTwo3'
                        }
                    }
                }
            });


            var ctx = document.getElementById('myWaiterBarChart');
                    var myWaiterBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: waiterName,
                            datasets: [{
                                label: 'Waiter Summary',
                                data: waiterQtySum,
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

        </script>


    <!----------------------End Waiter Summery------------------------------------------>




</body>
</html>