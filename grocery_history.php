<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');

    $GroceryTotalCost=0;
    $ItemCount=0;

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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h1>Grocery Buying History</h1>
                                    <span>DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">

                                <style>
                                    #datatable4_wrapper{
                                        overflow-x: scroll !important;
                                    }
                                </style>
                            
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable1" class="display" style="width:100%;">
                                            <thead>
                                                <tr>   
                                                    <th>ID</th>
                                                    <th>Shop Name</th>
                                                    <th>Bill Cost</th>
                                                    <th>Date Time</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="stock-area">
                                                <?php
                                                    $sql = "SELECT * FROM grocery_bill_details ORDER BY grocery_bill_id DESC";
                                                    $rs=$conn->query($sql);
                                                    while($row =$rs->fetch_array())
                                                    {
                                                        $GroceryBillId=$row[0];
                                                        $GroceryBillName=$row[1];
                                                        $GroceryBillDate=$row[2];
                                                ?>
                                                <tr>
                                                    <td><?php echo $GroceryBillId; ?></td>
                                                    <td><?php echo $GroceryBillName ?></td>
                                                    <td>151</td>
                                                    <td><?php echo $GroceryBillDate; ?></td>
                                                    <td>
                                                        <a href="#!" data-bs-toggle="modal" data-bs-target="#BillViewModal<?php echo $GroceryBillId; ?>" class="btn btn-primary btn-style-light">View</a>


                                                        <!-- Modal -->
                                                        <div class="modal fade" id="BillViewModal<?php echo $GroceryBillId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $GroceryBillName ?> Bill <?php echo $GroceryBillDate; ?></h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        

                                                                <?php
                                                                                
                                                                    $getGroceryBillCost = "SELECT * FROM grocery_bill_item WHERE grocery_bill_id='$GroceryBillId'";
                                                                    $gbcRs=$conn->query($getGroceryBillCost);
                                                                    $ResultCount = 0;
                                                                    while($gbcRsrow =$gbcRs->fetch_array())
                                                                    {
                                                                        $ResultCount += 1;
                                                                        $GroceryTotalCost+=$gbcRsrow[4];
                                                                    }
                                                                ?>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="card widget widget-info-navigation" style="background-color: #e7ecf8;">
                                                                            <div class="card-body">
                                                                                <div class="widget-info-navigation-container">
                                                                                    <div class="widget-info-navigation-content">
                                                                                        <span class="text-dark">Item Count</span><br>
                                                                                        <span class="text-danger fw-bolder fs-2" id="grocery-item-count"><?php echo $ResultCount; ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card widget widget-info-navigation" style="background-color: #e7ecf8;">
                                                                            <div class="card-body">
                                                                                <div class="widget-info-navigation-container">
                                                                                    <div class="widget-info-navigation-content">
                                                                                        <span class="text-dark">Total Cost</span><br>
                                                                                        <span class="text-danger fw-bolder fs-2" id="grocery-total-cost"><?php echo number_format($GroceryTotalCost,2); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                

                                                                <div class="example-content">
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Item</th>
                                                                                <th scope="col"><font style="float: right;">How much</font></th>
                                                                                <th scope="col"><font style="float: right;">Cost (Rs)</font></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="grocery-item-area">
                                                                            <?php
                                                                                
                                                                                $getGroceryBillItems = "SELECT * FROM grocery_bill_item gbi INNER JOIN grocery_item gi ON gbi.grocery_item_id=gi.grocery_item_id WHERE gbi.grocery_bill_id='$GroceryBillId' ORDER BY gbi.grocery_bill_item_id DESC";
                                                                                $gbiRs=$conn->query($getGroceryBillItems);
                                                                                while($gbiRsrow =$gbiRs->fetch_array())
                                                                                {
                                                                                    $GroceryBillItemId=$gbiRsrow[0];
                                                                                    $GroceryBillId=$gbiRsrow[1];
                                                                                    $GroceryItemId=$gbiRsrow[2];
                                                                                    $GroceryStock=$gbiRsrow[3];
                                                                                    $GroceryCost=$gbiRsrow[4];

                                                                                    $GroceryItemName=$gbiRsrow[6];
                                                                                    $GroceryItemUnityType=$gbiRsrow[7];


                                                                            ?>
                                                                            <tr>
                                                                                <th scope="row"><?php echo $ItemCount+=1; ?></th>
                                                                                <td><?php echo $GroceryItemName; ?></td>
                                                                                <td><b style="float: right;"><?php echo $GroceryStock.' '.$GroceryItemUnityType; ?></b></td>
                                                                                <td><b style="float: right;"><?php echo number_format($GroceryCost,2); ?></b></td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>





                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <!-- <button type="button" onclick="window.print();" class="btn btn-primary">Print</button> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </td>
                                                </tr>



                                                <?php } ?>
                                            </tbody>
                                            
                                        </table>
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
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/datatables.js"></script>

</body>

</html>