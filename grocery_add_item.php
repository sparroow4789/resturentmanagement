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
    $GroceryBillId= base64_decode($_GET['p']);


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
    $getDataQuery=$conn->query("SELECT * FROM grocery_bill_details WHERE grocery_bill_id = '$GroceryBillId' ");
    while ($rs=$getDataQuery->fetch_array()) {

        $GroceryName=$rs[1];
        $GroceryDateTime=$rs[2];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link href="assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">
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
                                    <h1>Add Grocery Bill</h1>
                                    <span>Give your forms some structure—from inline to horizontal to custom grid implementations—with our form layout options.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">



                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title"><?php echo $GroceryName; ?> Grocery Bill Form - <?php echo $GroceryDateTime; ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">
                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <form class="row g-3" id="Add-Grocery-Bill-Item">
                                                            <input type="hidden" name="grocery_bill_id" value="<?php echo $GroceryBillId;?>" required readonly>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Select Grocery Item *</label>
                                                                <select class="js-states form-control" tabindex="-1" style="display: none; width: 100%" name="grocery_item_id">
                                                                    <option selected disabled>Choose...</option>
                                                                    <?php
                                                                        $CategoryQuery=$conn->query("SELECT DISTINCT grocery_item_id,grocery_item_name FROM grocery_item");
                                                                        while ($row=$CategoryQuery->fetch_array()) {
                                                                    ?>
                                                                        <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">How Much to Stock *</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="stock" aria-describedby="basic-addon2" placeholder="10" style="text-align: right;" id="stock-input" required>
                                                                    <span class="input-group-text" id="basic-addon2">kg</span>
                                                                </div>
                                                                <span style="color: #FF0000; font-size: 12px;">Don't put Unit Type</span>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Cost *</label>
                                                                <input type="text" name="cost" id="cost-input" class="form-control" placeholder="1500" required>
                                                            </div>


                                                            <div class="col-12">
                                                                <button type="submit" id="btn-add-grocery-bill-item" class="btn btn-primary">Add</button>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>

                                                    <div class="col-md-8">

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
                                                                            <div class="widget-info-navigation-action">
                                                                                <a href="#" class="btn btn-light btn-rounded"><i class="material-icons no-m">downloading</i></a>
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
                                                                            <div class="widget-info-navigation-action">
                                                                                <a href="#" class="btn btn-light btn-rounded"><i class="material-icons no-m">toll</i></a>
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
                                                                        <th></th>
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
                                                                        <td>
                                                                            <form id="Delete-Grocery-Bill-Item" method="POST">
                                                                                <input type="hidden" name="grocery_bill_item_id" value="<?php echo $GroceryBillItemId; ?>" required readonly>
                                                                                <input type="hidden" name="grocery_bill_id" value="<?php echo $GroceryBillId; ?>" required readonly>
                                                                                <input type="hidden" name="grocery_stock" value="<?php echo $GroceryStock; ?>" required readonly>
                                                                                <input type="hidden" name="grocery_item_id" value="<?php echo $GroceryItemId; ?>" required readonly>
                                                                                <button type="submit" id="btn-delete-grocery-bill-item" class="btn btn-danger btn-sm" style="float: right;"><i class="material-icons">delete_outline</i>Remove</button>   
                                                                            </form>
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
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>

    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="assets/js/pages/select2.js"></script>

  

    <script>
        
        $(document).on('submit', '#Add-Grocery-Bill-Item', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-grocery-bill-item").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"post/add_grocery_bill_item.php",
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
                    
                       $("#grocery-item-area").html(json.data);
                       $("#grocery-total-cost").html(json.GroceryTotalCost);
                       $("#grocery-item-count").html(json.ResultCount);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show');
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-add-grocery-bill-item").attr("disabled",false);
                       document.getElementById('stock-input').value = '';
                       document.getElementById('cost-input').value = '';
                       // alert (id);
                       // window.location.href = "grocery_add_item?p="+id;
                       // location.reload();

                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-add-grocery-bill-item").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <script>
        
        $(document).on('submit', '#Delete-Grocery-Bill-Item', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-delete-grocery-bill-item").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"delete/delete_grocery_item.php",
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

                       $("#grocery-item-area").html(json.data);
                       $("#grocery-total-cost").html(json.GroceryTotalCost);
                       $("#grocery-item-count").html(json.ResultCount);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);

                       // window.location.href = "products";
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-delete-grocery-bill-item").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>
</html>
<?php } ?>