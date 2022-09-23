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
                                    <h1>Dashboard</h1>
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
                                            <div class="widget-stats-icon widget-stats-icon-danger">
                                                <i class="material-icons-outlined notranslate">schedule</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title"><?php echo date('Y-m-d') ?></span>
                                                <span class="widget-stats-amount" id="txt"></span>
                                                <span class="widget-stats-info">Date & Time</span>
                                            </div>
                                            <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                                <i class="material-icons notranslate">today</i> <?php echo date('D') ?>
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
    <script src="assets/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script>
        function startTime() {
          var today = new Date();
          var h = today.getHours();
          var m = today.getMinutes();
          var s = today.getSeconds();
          m = checkTime(m);
          s = checkTime(s);
          document.getElementById('txt').innerHTML =
          h + ":" + m + ":" + s;
          var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
          if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
          return i;
        }
    </script>

</body>
</html>