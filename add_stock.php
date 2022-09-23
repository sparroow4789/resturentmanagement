<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
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
                                    <h1>Stock</h1>
                                    <span>DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Add Stock</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">
                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="row g-3" id="Add-Stock" method="POST">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Select Product Badge *</label>
                                                                <select class="form-select" name="product_badge_cost_selling" required>
                                                                    <option selected disabled>Choose...</option>
                                                                    <?php
                                                                        $ProductQuery=$conn->query("SELECT DISTINCT product_badge_id,product_badge_label,product_name,cost_price,selling_price FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.enable_stat='1'");
                                                                        while ($row=$ProductQuery->fetch_array()) {
                                                                    ?>
                                                                        <option value="<?php echo $row[0].','.$row[3].','.$row[4];?>"><?php echo $row[2].' - '.$row[1];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Quantity *</label>
                                                                <input type="number" name="product_quantity" class="form-control" placeholder="100" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="btn-add-stock" class="btn btn-primary">Add Stock</button>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>

                                                    

                                                </div>

                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>

                                <style>
                                    #datatable4_wrapper{
                                        overflow-x: scroll !important;
                                    }
                                </style>
                            
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable4" class="display" style="width:100%;">
                                            <thead>
                                                <tr>   
                                                    <th>ID</th>
                                                    <th>Product Name</th>
                                                    <th>Product Number</th>
                                                    <th>Product Quantity</th>
                                                    <th>Product Cost (.Rs)</th>
                                                    <th>Product Selling (.Rs)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="stock-area">
                                                <?php
                                                    $sql = "SELECT * FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.enable_stat='1' ORDER BY pd.product_id DESC";
                                                    $rs=$conn->query($sql);
                                                    while($row =$rs->fetch_array())
                                                    {
                                                        $ProductBatchId=$row[0];
                                                        $ProductBatchLabel=$row[2];
                                                        $ProductCostPrice=$row[3];
                                                        $ProductSellingPrice=$row[4];
                                                        $ProductQuantity=$row[6];
                                                        $ProductDateTime=$row[7];
                                                        $ProductId=$row[8];
                                                        $ProductName=$row[9];
                                                        $ProductCode=$row[10];

                                                ?>
                                                <tr>
                                                    <td><?php echo $ProductBatchId; ?></td>
                                                    <td><?php echo $ProductName.' - '.$ProductBatchLabel; ?></td>
                                                    <td><?php echo $ProductCode; ?></td>
                                                    <td><b><span style="float: right;"><?php echo $ProductQuantity; ?></span></b></td>
                                                    <td><b><span style="float: right;"><?php echo number_format($ProductCostPrice,2); ?></b></span></td>
                                                    <td><b><span style="float: right;"><?php echo number_format($ProductSellingPrice,2); ?></span></b></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Product Name</th>
                                                    <th>Product Number</th>
                                                    <th>Product Quantity</th>
                                                    <th>Product Cost (.Rs)</th>
                                                    <th>Product Selling (.Rs)</th>
                                                </tr>
                                            </tfoot>
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

    <script>
        
        $(document).on('submit', '#Add-Stock', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-stock").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"update/update_product_quantity.php",
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

                       $("#stock-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-add-stock").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-add-stock").attr("disabled",false);
                     
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>

</html>