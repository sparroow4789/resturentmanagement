<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];

    if($_POST)
    {
        $user_id = htmlspecialchars($_POST['user_id']);
        $password = htmlspecialchars($_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $sql = "UPDATE users_login SET password='$hashed_password' WHERE user_id='$user_id' ";

        if ($conn->query($sql) === TRUE) {
        //   echo "Record updated successfully";

            $output['result']=true;
            $output['msg']="Record updated successfully.";
    
        }else{  
            // echo 'Error';   
            
            $output['result'] = false;
            $output['msg'] = 'Error activate please reload the page'; 
        }

        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>