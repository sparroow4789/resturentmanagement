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
                                    <h1>Grocery Stock</h1>
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
                                                    <th>Item Name</th>
                                                    <th><font style="float: right;">Available Stock</font></th>
                                                    <th><font style="float: right;">Move to Kitchen</font></th>
                                                </tr>
                                            </thead>
                                            <tbody id="grocery-area">
                                                <?php
                                                    $sql = "SELECT * FROM grocery_item ORDER BY grocery_item_id DESC";
                                                    $rs=$conn->query($sql);
                                                    while($row =$rs->fetch_array())
                                                    {
                                                        $GroceryItemId=$row[0];
                                                        $GroceryItemName=$row[1];
                                                        $GroceryItemUnit=$row[2];
                                                        $GroceryItemQuantity=$row[3];
                                                        $GroceryItemDateTime=$row[4];

                                                ?>
                                                <tr>
                                                    <td><?php echo $GroceryItemId; ?></td>
                                                    <td><?php echo $GroceryItemName; ?></td>
                                                    <td><b style="float: right;"><?php echo $GroceryItemQuantity.' '.$GroceryItemUnit; ?></b></td>
                                                    <td>
                                                        <form class="row" id="Move-Kitchen">
                                                            <div class="col-md-8">
                                                               <!-- <input type="number" class="form-control" name="quantity" max="<?php echo $GroceryItemQuantity; ?>" min="1" value="1" style="text-align: right;" onKeyDown="return false" required>  -->
                                                               <input type="hidden" name="grocery_item_id" value="<?php echo $GroceryItemId; ?>" required readonly>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" name="quantity_send" max="<?php echo $GroceryItemQuantity; ?>" min="1" value="1" style="text-align: right;" onKeyDown="return false" aria-describedby="basic-addon2" required>
                                                                    <span class="input-group-text" id="basic-addon2"><?php echo $GroceryItemUnit; ?></span>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <button type="submit" id="btn-move-kitchen" class="btn btn-primary btn-sm" style="float: right;"><i class="material-icons">send</i>Move</button>
                                                            </div>
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
        
        $(document).on('submit', '#Move-Kitchen', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-move-kitchen").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"update/grocery_move_kitchen.php",
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

                       $("#grocery-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-move-kitchen").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-move-kitchen").attr("disabled",false);
                     
                    }
                    
                }

            });

        return false;
        });
    </script>


</body>

</html>