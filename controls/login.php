<?php

    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output = [];


   if(isset($_POST['email'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT `email`,`password` FROM `users_login` WHERE `email` = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt,"s", $email);

            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $email, $pass);
            mysqli_stmt_fetch($stmt);

            if(mysqli_stmt_num_rows($stmt) === 1)
            {

                //$row = mysqli_stmt_fetch($stmt);

                $hash = $pass;

                //echo $hash;



                
                if(password_verify($password, $hash))
                {
                    
                    
              
                    
                    $_SESSION['Logged'] = true;

                    $_SESSION['email'] = $email;
                    //$_SESSION['name'] = $name;
                    $_SESSION['password'] = $password;
                    
                    $encoded = base64_encode($password);
                  
                    
                    if(isset($_POST['remember'])){
                        
                        setcookie("zxadfggh",$email, time() + (86400 * 30), "/");
                        setcookie("jyuongga",$encoded, time() + (86400 * 30), "/");
                        
                    }else{
                        setcookie("zxadfggh",$email, time() - 3600, "/");
                        setcookie("jyuongga",$encoded, time() - 3600, "/");
                    }
                    
                    
                    $output['result'] = true;
                    $output['msg'] = "valid";
                    
                   
                }


                else
                {
                   
                    $output['result'] = false;
                    $output['msg'] = "Email or Password do not match !";
                }
                
            }
                
            
            else 
            {
                    $output['result'] = false;
                    $output['msg'] = "Email or Password do not match !";
            }

        }else{
                    $output['result'] = false;
                    $output['msg'] = "Invalid request, Please try again.";
        }


    mysqli_close($conn);
    echo json_encode($output);
    

?>