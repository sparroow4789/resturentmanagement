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
                                    <h1>User Accounts</h1>
                                    <span>This page showcases an example of content layout with left menu.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            
                            <div class="col-xl-12">

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Create Users Form</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="example-container">
                                            <div class="example-content">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form class="row g-3" id="Create-Account" method="POST">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Type Name *</label>
                                                                <input type="text" name="name" id="name" class="form-control" placeholder="John Doe" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Email *</label>
                                                                <input type="email" class="form-control" name="email" id="email" placeholder="xxxxxxx@mail.com" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label">Contact Number *</label>
                                                                <input type="text" name="tel" id="tel" class="form-control" placeholder="Contact Number" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">User Role *</label>
                                                                <select id="role" name="role" class="form-select" required>
                                                                    <option disabled>Choose...</option>
                                                                    <option value="0" selected>User Acoount</option>
                                                                    <option value="1">Admin Account</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Password *</label>
                                                                <input type="text" name="password" id="password" class="form-control" placeholder="Password" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Confirm Password *</label><span class="pull-right" id='message'></span>
                                                                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" required>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <button type="submit" id="register" name="register" class="btn btn-primary log">Create Account</button>
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
                                        <h4 class="card-title">Users List</h4>
                                    </div>
                                    <div class="card-body">
                                        
                                            <table id="datatable1" class="display" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Role</th>
                                                        <th>Telephone Number</th>
                                                        <th>Register Date</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                                <tbody id="accounts-area">
                                                    <?php
                                                        $sql = "SELECT * FROM users_login ORDER BY user_id DESC";
                                                        $rs=$conn->query($sql);
                                                        while($row =$rs->fetch_array())
                                                        {
                                                            $UserRole=$row[4];
                                                            $UserEmail=$row[2];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row[0]; ?></td>
                                                        <td><?php echo $row[1]; ?></td>
                                                        <td><?php echo $row[2]; ?></td>
                                                        <td>
                                                            <?php if ($UserRole=='1') { ?> 
                                                            <span class="badge light badge-secondary">ADMIN</span>
                                                            <?php }else{ ?>
                                                            <span class="badge light badge-primary">USER ACCOUNT</span>
                                                            <?php } ?>  
                                                        </td>
                                                        <td><b><?php echo $row[5]; ?></b></td>
                                                        <td><b><?php echo $row[6]; ?></b></td>
                                                        <td>
                                                            <?php if ($UserEmail=='admin@mail.com' || $UserEmail=='demo@mail.com') { }else{ ?>
                                                            <form id="Delete-Account" method="POST">
                                                                <input type="hidden" name="user_id" value="<?php echo $row[0]; ?>" required readonly>
                                                                <button type="submit" id="btn-add-delete-user" class="btn light btn-danger btn-sm">Delete</button>
                                                            </form>
                                                            <?php } ?>
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


        $('#password').on('keyup', function () {
          if ($('#password').val() == $('#cpassword').val()) {

            
            $("#register").prop( "disabled", false );
            $('#message').html('Matching').css('color', 'green');
          
          } else {
            $('#message').html('Not Matching').css('color', 'red');
            $( "#register" ).prop( "disabled", true );
           } 
          
        });


        $('#cpassword').on('keyup', function () {
          if ($('#password').val() == $('#cpassword').val()) {

            
            $("#register").prop( "disabled", false );
            $('#message').html('Matching').css('color', 'green');
          
          } else {
            $('#message').html('Not Matching').css('color', 'red');
            $( "#register" ).prop( "disabled", true );
           } 
          
        });

        
        $(document).on('submit', '#Create-Account', function(e){
        e.preventDefault(); //stop default form submission

        $("#register").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"controls/join.php",
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

                       $("#accounts-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#register").attr("disabled",false);
                       document.getElementById('name').value = '';
                       document.getElementById('email').value = '';
                       document.getElementById('tel').value = '';
                       document.getElementById('password').value = '';
                       document.getElementById('cpassword').value = '';
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#register").attr("disabled",false);
                     
                    }

                    
                }

            });

        return false;
        });
    </script>

    <script>
        
        $(document).on('submit', '#Delete-Account', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-delete-user").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"delete/delete_account.php",
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

                       $("#accounts-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-add-delete-user").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-add-delete-user").attr("disabled",false);
                     
                    }

                    
                }

            });

        return false;
        });
    </script>



</body>

</html>