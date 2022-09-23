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
                                    <h1>Account Settings</h1>
                                    <span>This page showcases an example of content layout with left menu.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            
                            <div class="col-xl-12">
                                <div class="card">
                                    <!-- <ul class="list-group list-group-flush">
                                      <li class="list-group-item">An item</li>
                                      <li class="list-group-item">A second item</li>
                                      <li class="list-group-item">A third item</li>
                                    </ul> -->




                                    <div class="row" style="margin: 15px;">
                                        <div class="col-md-4">
                                            Name
                                        </div>
                                        <div class="col-md-4" id="user-name">
                                            <?php echo $user_name; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <a id="edit-name"><span class="pull-right"><i class="fa fa-pencil"></i> Edit</span></a> -->
                                            <!-- <button type="button" id="edit-name"><span class="pull-right"><i class="fa fa-pencil"></i> Edit</span></button> -->
                                            <label class="pull-right" style="cursor: pointer;"><input type="checkbox" id="edit-name" name="edit_name" style="display: none;"> <i class="fa fa-pencil"></i> Edit</label>
                                        </div>
                                    </div>

                                    <div class="basic-form" id="Edit-Name-Form" style="display: none;">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <form method="POST" id="Update-User-Name">
                                                    <input type="hidden" name="user_id" class="form-control" value="<?php echo $user_id; ?>" readonly required>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="user_name" value="<?php echo $user_name; ?>" class="form-control" placeholder="Name" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group row">
                                                        <div class="col-sm-10">
                                                            <button type="submit" id="btn-save-name" class="btn btn-primary btn-xs">Save Changes</button>
                                                            <label class="btn btn-danger btn-xs" style="margin-top: 0px;"><input type="checkbox" id="edit-name-close" name="edit_name" style="display: none;"> Cancel</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-5"></div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row" style="margin: 15px;">
                                        <div class="col-md-4">
                                            Email Address
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo $user_email; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <span class="pull-right">Edit</span> -->
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row" style="margin: 15px;">
                                        <div class="col-md-4">
                                            Contact Number
                                        </div>
                                        <div class="col-md-4" id="user-tel">
                                            <?php echo $user_tel; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="pull-right" style="cursor: pointer;"><input type="checkbox" id="edit-tel" name="edit_tel" style="display: none;"> <i class="fa fa-pencil"></i> Edit</label>
                                        </div>
                                    </div>

                                    <div class="basic-form" id="Edit-Tel-Form" style="display: none;">
                                    <br>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <form method="POST" id="Update-User-Tel">
                                                    <input type="hidden" name="user_id" class="form-control" value="<?php echo $user_id; ?>" readonly required>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Contact Number</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="user_tel" value="<?php echo $user_tel; ?>" class="form-control" placeholder="Contact Number" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-10">
                                                            <button type="submit" id="btn-save-tel" class="btn btn-primary btn-xs">Save Changes</button>
                                                            <label class="btn btn-danger btn-xs" style="margin-top: 0px;"><input type="checkbox" id="edit-tel-close" name="edit_tel" style="display: none;"> Cancel</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-5"></div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row" style="margin: 15px;">
                                        <div class="col-md-4">
                                            Change password
                                        </div>
                                        <div class="col-md-4" id="user-name">
                                            It's a good idea to use a strong password that you don't use elsewhere
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <a id="edit-name"><span class="pull-right"><i class="fa fa-pencil"></i> Edit</span></a> -->
                                            <!-- <button type="button" id="edit-name"><span class="pull-right"><i class="fa fa-pencil"></i> Edit</span></button> -->
                                            <label class="pull-right" style="cursor: pointer;"><input type="checkbox" id="psw-change" name="psw_change" style="display: none;"> <i class="fa fa-pencil"></i> Edit</label>
                                        </div>
                                    </div>

                                    <div class="basic-form" id="Password-Change-Form" style="display: none;">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <form method="POST" id="Update-Password">
                                                    <input type="hidden" name="user_id" class="form-control" value="<?php echo $user_id; ?>" readonly required>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">New Password</label>
                                                        <div class="col-sm-9">
                                                            <input type="password" name="password" id="password" class="form-control" placeholder="New Password" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group row">
                                                        <div class="col-sm-10">
                                                            <button type="submit" id="btn-save-password" class="btn btn-primary btn-xs">Save Changes</button>
                                                            <label class="btn btn-danger btn-xs" style="margin-top: 0px;"><input type="checkbox" id="psw-change-close" name="psw_change" style="display: none;"> Cancel</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-5"></div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row" style="margin: 15px;">
                                        <div class="col-md-4">
                                            Account Picture
                                        </div>
                                        <div class="col-md-4" id="profile-pic-area">
                                        <?php
                                            $checkProfilePicCount = $conn->query("SELECT count(*) FROM users_profile_pic WHERE user_id='$user_id'");
                                            if($cppcRS = $checkProfilePicCount->fetch_array()){
                                            $ProfilePicCount = (int)$cppcRS[0];
                                            }
                                            if($ProfilePicCount == 0){
                                        ?>
                                        <img alt="image" width="50" src="assets/images/profile.jpg" style="width: 50px; height: 50px;">
                                        <?php }else{ ?>
                                        <?php
                                            $getUserProPic=$conn->query("SELECT profile_image FROM users_profile_pic WHERE user_id='$user_id' ");
                                            if($gunRs = $getUserProPic->fetch_array()){
                                                                
                                                $ProPic = $gunRs[0];
                                        ?>
                                        <img alt="image" width="50" src="user_profile_pic/<?php echo $ProPic; ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php } ?>
                                        <?php } ?>
                                        </div>
                                            <div class="col-md-4">
                                                <label class="pull-right" style="cursor: pointer;"><input type="checkbox" id="edit-pic" name="edit_pic" style="display: none;"> <i class="fa fa-pencil"></i> Edit</label>
                                            </div>
                                    </div>

                                    <div class="basic-form" id="Edit-Pic-Form" style="display: none;">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <form method="POST" id="Update-User-Pic">
                                                    <input type="hidden" name="user_id" class="form-control" value="<?php echo $user_id; ?>" readonly required>
                                                    <div class="form-group row">
                                                        <div class="col-sm-9">
                                                            <label>Upload Image <font style="color: #FF0000;">*</font></label>
                                                            <br>
                                                            <img id="img" class="please" src="assets/images/profile.jpg" width="200px" height="200px" alt="your image"/><br><br>
                                                            <input type='file' class="maybe"  accept= "image/jpeg, image/jpg" name="img" id="img" onchange="readURL1(this);" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group row">
                                                        <div class="col-sm-10">
                                                            <button type="submit" id="btn-save-pic" class="btn btn-primary btn-xs">Save Changes</button>
                                                            <label class="btn btn-danger btn-xs" style="margin-top: 0px;"><input type="checkbox" id="edit-pic-close" name="edit_pic" style="display: none;"> Cancel</label>
                                                        </div>
                                                    </div>
                                                </form><br>
                                                </div>
                                                <div class="col-md-5"></div>
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
        //edit-name
        $("#edit-name").change(function(){
            $("#Edit-Name-Form").show();
            $("#Edit-Tel-Form").hide();
            $("#Edit-Pic-Form").hide();
            $("#Password-Change-Form").hide();
        });
        $("#edit-name-close").change(function(){
            $("#Edit-Name-Form").hide();
            
        });

        //edit-tel
        $("#edit-tel").change(function(){
            $("#Edit-Tel-Form").show();
            $("#Edit-Name-Form").hide();
            $("#Edit-Pic-Form").hide();
            $("#Password-Change-Form").hide();
        });
        $("#edit-tel-close").change(function(){
            $("#Edit-Tel-Form").hide();
            
        });

        //edit-pic
        $("#edit-pic").change(function(){
            $("#Edit-Pic-Form").show();
            $("#Edit-Name-Form").hide();
            $("#Edit-Tel-Form").hide();
            $("#Password-Change-Form").hide();
        });
        $("#edit-pic-close").change(function(){
            $("#Edit-Pic-Form").hide();
            
        });

        //psw-change
        $("#psw-change").change(function(){
            $("#Password-Change-Form").show();
            $("#Edit-Name-Form").hide();
            $("#Edit-Tel-Form").hide();
            $("#Edit-Pic-Form").hide(); 
        });
        $("#psw-change-close").change(function(){
            $("#Password-Change-Form").hide();
           
        });



    </script>

    <script>
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


    <script>
        
        $(document).on('submit', '#Update-User-Name', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-save-name").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"update/update_user_account_name.php",
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

                       $("#user-name").html(json.username);

                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                        
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show');
                       $("#btn-save-name").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-save-name").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <script>
        
        $(document).on('submit', '#Update-User-Tel', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-save-tel").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"update/update_user_account_contact_number.php",
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

                       $("#user-tel").html(json.usertel);

                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                        
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show');
                       $("#btn-save-tel").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-save-tel").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <script>
        
        $(document).on('submit', '#Update-User-Pic', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-save-pic").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_upload_alert").addClass('show'); 

                },

                url:"update/update_user_account_pic.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_upload_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){

                       $("#profile-pic-area").html(json.data);

                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 2000);
                        
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show');
                       $("#btn-save-pic").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 2000);
                        $("#btn-save-pic").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

    <!--------------------------------Password Change------------------------------------------->

    <script>

        $(document).on('submit', '#Update-Password', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-save-password").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"update/update_user_account_password.php",
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
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 3000);
                       
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show');
                       $("#btn-save-password").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 3000);
                        $("#btn-save-password").attr("disabled",false);
                    }
                    
                }

            });

        return false;
        });
    </script>

</body>

</html>