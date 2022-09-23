<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];

    if($_POST)
    {
        $user_id = htmlspecialchars($_POST['user_id']);
        $user_tel = htmlspecialchars($_POST['user_tel']);


        $sql = "UPDATE users_login SET tel='$user_tel' WHERE user_id='$user_id' ";

        if ($conn->query($sql) === TRUE) {
        //   echo "Record updated successfully";
        
            //get user name
            
            $getUserName=$conn->query("SELECT * FROM users_login WHERE user_id='$user_id' ");
            if($gunRs = $getUserName->fetch_array()){
                
                // $UserName = $gunRs[0];
                
                $usertel=$gunRs['tel'];

                $output['result']=true;
                $output['msg']="Record updated successfully.";

                $output['usertel']=$usertel;
                
                    
                
                
                
            }else{

                $output['result']=true;
                $output['msg']="Record updated successfully, please re-load to see changes.";
                
                
                $output['usertel']='';

            }
            
            /////////////////
            
            
            
            // echo 'Completed';
        }else{  
            // echo 'Error';   
            
            $output['result'] = false;
            $output['msg'] = 'Error activate please reload the page'; 
        }

        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>