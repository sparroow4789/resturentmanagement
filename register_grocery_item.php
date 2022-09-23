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
                                    <h1>Register Grocery Item</h1>
                                    <span>Give your forms some structure—from inline to horizontal to custom grid implementations—with our form layout options.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Grocery Item Form</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">
                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <form class="row g-3" id="Add-Grocery-Item">
                                                            <div class="col-md-12">
                                                                <label class="form-label">Grocery Item Name *</label>
                                                                <input type="text" name="grocery_item_name" class="form-control" placeholder="Carrot" required>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Select Item Unit Type *</label>
                                                                <select class="form-select" name="item_unit_type">
                                                                    <option disabled>Choose...</option>
                                                                    <option value="kg" selected>kg (Kilogram)</option>
                                                                    <option value="g">g (Gram)</option>
                                                                    <option value="L">L (Liters)</option>
                                                                    <option value="mL">mL (Milliliters)</option>
                                                                    
                                                                </select>
                                                            </div>

                                                            <div class="col-12">
                                                                <button type="submit" id="btn-add-grocery-item" class="btn btn-primary">Add Grocery Item</button>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="alert alert-custom alert-indicator-left indicator-info" role="alert">
                                                            <div class="alert-content">
                                                                <span class="alert-title">Info!</span>
                                                                <span class="alert-text">Custom alert with info state indicator on left...</span>
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-custom alert-indicator-left indicator-info" role="alert">
                                                            <div class="alert-content">
                                                                <span class="alert-title">Info!</span>
                                                                <span class="alert-text">Custom alert with info state indicator on left...</span>
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
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>


    <script>
        
        $(document).on('submit', '#Add-Grocery-Item', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-grocery-item").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"post/add_grocery_item.php",
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
                        $("#btn-add-grocery-item").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>

</html>