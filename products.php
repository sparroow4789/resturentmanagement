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
                                    <h1>Products</h1>
                                    <span>Bootstrap’s cards provide a flexible and extensible content container with multiple variants and options.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <?php
                                $getProductQuery=$conn->query("SELECT * FROM product_details ORDER BY product_id DESC ");
                                while ($GPrs=$getProductQuery->fetch_array()) {
                                    $ProductId=$GPrs[0];
                                    $ProductName=$GPrs[1];
                                    $ProductCode=$GPrs[2];
                                    $ProductDetails=$GPrs[3];
                                    $ProductCategory=$GPrs[4];
                                    $ProductPrepTime=$GPrs[5];
                                    $ProductCalories=$GPrs[6];
                                    $ProductImg=$GPrs[7];
                                    $ProductStat=$GPrs[8];
                                    $ProductDateTime=$GPrs[9];

                                    $ProductDetailsEdit = preg_replace(array('/^\[/','/\]$/'), 'nl2br',$ProductDetails);

                                ?>
                            
                            <div class="col-xl-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-xxl avatar-rounded m-r-xs">
                                            <img src="product_images/<?php echo $ProductImg; ?>" alt="">
                                        </div>
                                      <h5 class="card-title"><?php echo $ProductName; ?></h5>
                                      <p class="card-text">
                                        Product Code - <b><?php echo $ProductCode; ?></b><br>
                                        Product Category - <b><?php echo $ProductCategory; ?></b><br>
                                        Prep Time - <b><?php echo $ProductPrepTime; ?></b><br>
                                        Calories - <b><?php echo $ProductCalories; ?></b><br>
                                        <?php echo nl2br($ProductDetails); ?>
                                      </p>
                                      
                                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ProductModal<?php echo $ProductId; ?>">Edit Details</button>
                                    </div>

                                        <?php
                                            $getProductBatchQuery=$conn->query("SELECT * FROM product_badge_details WHERE product_name_id='$ProductId'");
                                            while ($GPBrs=$getProductBatchQuery->fetch_array()) {
                                                $ProductBatchId=$GPBrs[0];
                                                $ProductBatchNameId=$GPBrs[1];
                                                $ProductBatchLabel=$GPBrs[2];
                                                $ProductBatchCostPrice=$GPBrs[3];
                                                $ProductBatchSellingPrice=$GPBrs[4];
                                                $ProductBatchEnabledStat=$GPBrs[5];
                                                $ProductBatchQuantity=$GPBrs[6];
                                                $ProductBatchDateTime=$GPBrs[7];
                                            ?>

                                            <div class="example-content">
                                                <div class="accordion accordion-flush" id="accordionFlushExample">

                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="flush-heading<?php echo $ProductBatchId; ?>">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $ProductBatchId; ?>" aria-expanded="true" aria-controls="flush-collapse<?php echo $ProductBatchId; ?>">
                                                                <b><?php echo $ProductBatchLabel; ?></b>
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapse<?php echo $ProductBatchId; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $ProductBatchId; ?>" data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body" style="text-align: left; font-size: 15px;"> 
                                                                

                                                                <?php if($ProductBatchQuantity=='0'){ ?>
                                                                    Quantity - <b><?php echo $ProductBatchQuantity; ?></b>
                                                                    <span class="badge badge-style-light rounded-pill badge-danger">Out of stock</span><br>

                                                                <?php }elseif($ProductBatchQuantity>'0'){ ?>
                                                                    Quantity - <b><?php echo $ProductBatchQuantity; ?></b>
                                                                    <span class="badge badge-style-light rounded-pill badge-success">In stock</span><br>

                                                                <?php }else{ }?>


                                                                
                                                                Cost Price - <b>Rs.<?php echo number_format($ProductBatchCostPrice,2); ?></b><br>
                                                                Selling Price - <b>Rs.<?php echo number_format($ProductBatchSellingPrice,2); ?></b><br>

                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ProductBatchModal<?php echo $ProductBatchId; ?>"><i class="material-icons notranslate">edit</i>Edit Badge</button>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <form id="Delete-Batch-Product">
                                                                            <input type="hidden" name="product_batch_id" value="<?php echo $ProductBatchId; ?>">
                                                                            <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons notranslate">delete_outline</i> Delete Badge</button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <!--Start Batch Edit Modal -->
                                            <div class="modal fade" id="ProductBatchModal<?php echo $ProductBatchId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $ProductName.' '.$ProductBatchLabel; ?> Edit</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="Product-Batch-Update" method="POST">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <input type="hidden" name="product_badge_id" value="<?php echo $ProductBatchId; ?>" required readonly>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Product Badge Label *</label>
                                                                        <input type="text" name="product_badge_label" class="form-control" value="<?php echo $ProductBatchLabel; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Cost Price (Rs.) *</label>
                                                                        <input type="text" name="cost_price" style="    text-align: right;" class="form-control" value="<?php echo $ProductBatchCostPrice; ?>" required>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Selling Price (Rs.) *</label>
                                                                        <input type="text" name="selling_price" style="    text-align: right;" class="form-control" value="<?php echo $ProductBatchSellingPrice; ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" id="btn-update-product-batch" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End Batch Edit Modal -->



                                        <?php } ?>

                                </div>
                            </div>


                                            <!--Start Batch Edit Modal -->
                                            <div class="modal fade" id="ProductModal<?php echo $ProductId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $ProductName; ?> Edit</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="Product-Details-Update" method="POST">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <input type="hidden" name="product_id" value="<?php echo $ProductId; ?>" required readonly>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Product Name *</label>
                                                                        <input type="text" name="product_name" class="form-control" value="<?php echo $ProductName; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Product Code</label>
                                                                        <input type="text" name="product_code" class="form-control" value="<?php echo $ProductCode; ?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Product Category *</label>
                                                                        <select class="form-select" name="product_category">
                                                                            <option disabled>Choose...</option>
                                                                            <option value="<?php echo $ProductCategory; ?>" selected><?php echo $ProductCategory; ?></option>
                                                                            <?php
                                                                                $CategoryQuery=$conn->query("SELECT DISTINCT category_id,category FROM product_category");
                                                                                while ($row=$CategoryQuery->fetch_array()) {
                                                                            ?>
                                                                                <?php if($ProductCategory==$row[1]){ }else{ ?>
                                                                                <option value="<?php echo $row[1];?>"><?php echo $row[1];?></option>
                                                                            <?php } } ?>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Preparation Time *</label>
                                                                        <input type="text" name="prep_time" class="form-control" value="<?php echo $ProductPrepTime; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Calories *</label>
                                                                        <input type="text" name="calories" class="form-control" value="<?php echo $ProductCalories; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Product Details *</label>
                                                                        <textarea name="product_details" class="form-control" required><?php echo $ProductDetailsEdit; ?></textarea>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" id="btn-update-product" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End Batch Edit Modal -->



                            <?php } ?>
                            
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


    <script>
        
        $(document).on('submit', '#Product-Details-Update', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-update-product").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 
                },

                url:"update/product_update.php",
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

                       // window.location.href = "products";
                       location.reload();
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-update-product").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <script>
        
        $(document).on('submit', '#Product-Batch-Update', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-update-product-batch").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 
                },

                url:"update/product_batch_update.php",
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

                       // window.location.href = "products";
                       location.reload();
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-update-product-batch").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


    <script>
        
        $(document).on('submit', '#Delete-Batch-Product', function(e){
        e.preventDefault(); //stop default form submission

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"delete/delete_product_batch.php",
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

                       // window.location.href = "products";
                       location.reload();
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>

</html>