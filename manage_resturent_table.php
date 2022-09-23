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

      $getEmpQuery=$conn->query("SELECT user_id,name,email,role,tel FROM users_login WHERE email='$user_email' ");
      while ($emp=$getEmpQuery->fetch_array()) {

        $user_id = $emp['0']; 
        $user_name = $emp['1']; 
        $user_email = $emp['2']; 
        $user_role = $emp['3']; 
        $user_tel = $emp['4']; 
        

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
    <link href="assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
    <?php include_once('controls/meta.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <?php include_once('controls/settings_nav.php'); ?>
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h1>Manage Resturent Table</h1>
                                    <span>This page showcases an example of content layout with left menu.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            
                            <div class="col-xl-12">

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Register Restaureat Table Form</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">
                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="row g-3" id="Resturent-Table-Add" method="POST">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Select Restaureat Name *</label>
                                                                <select class="form-select" name="resturent_type_id">
                                                                    <option selected disabled>Choose...</option>
                                                                    <?php
                                                                        $CategoryQuery=$conn->query("SELECT DISTINCT resturent_type_id,resturent_name FROM resturent_type");
                                                                        while ($row=$CategoryQuery->fetch_array()) {
                                                                    ?>
                                                                        <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Type Table Number *</label>
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text">Table Number</span>
                                                                    <input type="text" class="form-control" name="resturent_table_number" id="resturent_table_number" aria-label="Type Table Number" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <button type="submit" id="btn-add-resturent-table" class="btn btn-primary">Add Resturent Table</button>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>

                                                </div>

                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <!-- <ul class="list-group list-group-flush">
                                      <li class="list-group-item">An item</li>
                                      <li class="list-group-item">A second item</li>
                                      <li class="list-group-item">A third item</li>
                                    </ul> -->

                                    <div class="card-header">
                                        <h4 class="card-title">Resturent Table List</h4>
                                    </div>
                                    <div class="card-body">
                                        
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Resturent Name</th>
                                                        <th>Resturent Table Number</th>
                                                        <th>Resturent Place</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                                <tbody id="resturent-table-area">
                                                    <?php
                                                        $sql = "SELECT * FROM resturent_table rt INNER JOIN resturent_type rest ON rt.resturent_type_id=rest.resturent_type_id ORDER BY rt.resturent_table_id ASC";
                                                        $rs=$conn->query($sql);
                                                        while($row =$rs->fetch_array())
                                                        {
                                                            $ResturentTableId=$row[0];
                                                            $ResturentTypeId=$row[1];
                                                            $ResturentTableNumber=$row[2];
                                                            $ResturentTableDateTime=$row[3];
                                                            $ResturentTypeName=$row[5];
                                                            $ResturentTypeLocation=$row[6];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $ResturentTableId; ?></td>
                                                        <td><?php echo $ResturentTypeName; ?></td>
                                                        <td><?php echo $ResturentTableNumber; ?></td>
                                                        <td><?php echo $ResturentTypeLocation; ?></td>
                                                        <td>
                                                            
                                                            <form id="Delete-Resturent-Table" method="POST">
                                                                <input type="hidden" name="resturent_table_id" value="<?php echo $ResturentTableId; ?>" required readonly>
                                                                <button type="submit" id="btn-delete-resturent-table" class="btn light btn-danger btn-sm">Delete</button>
                                                            </form>
                                                    
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>

                                                <!-- <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Product Name</th>
                                                        <th>Product Number</th>
                                                        <th>Product Quantity</th>
                                                        <th>Product Cost (.Rs)</th>
                                                        <th>Product Selling (.Rs)</th>
                                                    </tr>
                                                </tfoot> -->
                                            </table>
                                     
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
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>

    <script>

        $(document).on('submit', '#Resturent-Table-Add', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-resturent-table").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"post/add_resturent_table.php",
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

                       $("#resturent-table-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-add-resturent-table").attr("disabled",false);
                       document.getElementById('resturent_table_number').value = '';
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-add-resturent-table").attr("disabled",false);
                     
                    }

                    
                }

            });

        return false;
        });
    </script>

    <script>
        
        $(document).on('submit', '#Delete-Resturent-Table', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-delete-resturent-table").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"delete/delete_resturent_table.php",
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

                       $("#resturent-table-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-delete-resturent-table").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-delete-resturent-table").attr("disabled",false);
                     
                    }

                    
                }

            });

        return false;
        });
    </script>



</body>

</html>