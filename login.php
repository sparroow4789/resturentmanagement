<?php
   require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    
    
    if(isset($_COOKIE['zxadfggh']) && isset($_COOKIE['jyuongga'])){

        $_SESSION['Logged'] = true;
        $_SESSION['email'] = $_COOKIE['zxadfggh'];
        $_SESSION['password'] = base64_decode($_COOKIE['jyuongga']);
                    
    ?>
                    
    <script>
        location.href = 'index';
    </script>
                    
<?php } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('controls/meta.php'); ?>
</head>
<body>


    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="index">Restaurant Management</a>
            </div>
            <!-- <p class="auth-description">Please sign-in to your account and continue to the dashboard.<br>Don't have an account? <a href="sign-up.html">Sign Up</a></p> -->
            <form id="login-form">
                <div class="auth-credentials m-b-xxl">
                    <label for="signInEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control m-b-md" name="email" id="email" aria-describedby="signInEmail" placeholder="example@neptune.com">

                    <label for="signInPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" aria-describedby="signInPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">

                    <div class="custom-control">       
                        <input type="checkbox" class="custom-control-input" id="show-psw" onclick="showPasswordInput()">  
                        <label class="custom-control-label" for="show-psw">Show Password</label>
                    </div>

                    <br>
                    <div class="custom-control custom-checkbox ml-1 remember">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                        <label class="custom-control-label" for="remember">Remember my preference</label>
                    </div>
                

                </div>

                <div class="auth-submit">
                    <!-- <a href="#" class="btn btn-primary" name="btn_lg">Sign In</a> -->
                    <button type="submit" name="btn_lg" class="btn btn-primary">Sign Me In</button>
                    <!-- <a href="#" class="auth-forgot-password float-end">Forgot password?</a> -->
                </div>
            </form>

            <div class="divider"></div>
            <div class="auth-alts">
                <a href="https://amazoft.com/" target="_blank"><img src="assets/images/a_logo.png" style="width: 600%;"></a>
                <!-- <a href="#" class="auth-alts-facebook"></a>
                <a href="#" class="auth-alts-twitter"></a> -->
            </div>
        </div>
    </div>
    
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>

    <script src="assets/js/sweetalert2.js"></script>

    <script>
  $(document).on('submit', '#login-form', function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
                            url:'controls/login.php',
                            type:'POST',
                            data:formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success:function(data){
                                
                                var json=JSON.parse(data);
                                if(json.result){
                                    location.href="index";
                                }else{
                                    Swal.fire({
                                        text:json.msg,
                                        icon:'error',
                                        title:'Warning !'
                                    });
                                }
                                
                                
                            },
                            error:function(err,xhr,data){
                                    alert("err "+data);
                            }



                        });


    });
    
</script>

<script>
    /////////////////Show Password//////////////////////////////


            function showPasswordInput() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }

        /////////////////////////////////////////////////////////
</script>


</body>
</html>