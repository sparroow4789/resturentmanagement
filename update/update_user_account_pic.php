<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $user_id = htmlspecialchars($_POST['user_id']);

        $time=time();

        //Image Uploading
        $DocumentFile = $_FILES['img']['name'];
        $fileElementName = 'photo';
        $path = '../user_profile_pic/';
        // $location = $path . $_FILES['doc']['name'];
        $extension = pathinfo($DocumentFile, PATHINFO_EXTENSION);
        $location = $path . $time. "." .$extension; 
        $locationForDb = $time. "." .$extension;
        move_uploaded_file($_FILES['img']['tmp_name'], $location);


        $checkProfilePicCount = $conn->query("SELECT count(*) FROM users_profile_pic WHERE user_id='$user_id'");
            if($cppcRS = $checkProfilePicCount->fetch_array()){
            $ProfilePicCount = (int)$cppcRS[0];

            if($ProfilePicCount == 0){

                $InserProfilePicsql = "INSERT INTO `users_profile_pic`(`users_profile_pic_id`, `user_id`, `profile_image`, `profile_pic_datetime`) VALUES (null, '$user_id', '$locationForDb','')";
                if ($conn->query($InserProfilePicsql) === TRUE) {

                        //get user pro pic
            
                        $getUserProPic=$conn->query("SELECT profile_image FROM users_profile_pic WHERE user_id='$user_id' ");
                        if($gunRs = $getUserProPic->fetch_array()){
                            
                            $ProPic = $gunRs[0];
                            
                            $row='
                                <img alt="image" width="50" src="user_profile_pic/'.$ProPic.'" style="width: 50px; height: 50px; object-fit: cover;">
                                ';
                                
                                array_push($dataArray,$row);
                            
                            
                        }
                        
                        /////////////////
                        
                        
                        $output['result'] = true;
                        $output['msg'] = 'Successfully added.';
                        $output['data'] = $dataArray;

                        
                        
                        /////////////////
                        
                        
                        
                        // echo 'Completed';
                    }else{  
                        // echo 'Error';   
                        
                        $output['result'] = false;
                        $output['msg'] = 'Error activate please reload the page'; 
                    }



            }else{


        $UpdateProfilePicsql = "UPDATE users_profile_pic SET profile_image='$locationForDb' WHERE user_id='$user_id' ";

        if ($conn->query($UpdateProfilePicsql) === TRUE) {
        //   echo "Record updated successfully";
        
            //get user pro pic
            
            $getUserProPic=$conn->query("SELECT profile_image FROM users_profile_pic WHERE user_id='$user_id' ");
            if($gunRs = $getUserProPic->fetch_array()){
                
                $ProPic = $gunRs[0];
                
                $row='
                    <img alt="image" width="50" src="user_profile_pic/'.$ProPic.'" style="width: 50px; height: 50px; object-fit: cover;">
                    ';
                    
                    array_push($dataArray,$row);
                
                
            }
            
            /////////////////
            
            
            $output['result'] = true;
            $output['msg'] = 'Successfully added.';
            $output['data'] = $dataArray;

            
            
            /////////////////
            
            
                
                    // echo 'Completed';
                }else{  
                    // echo 'Error';   
                    
                    $output['result'] = false;
                    $output['msg'] = 'Error activate please reload the page'; 
                }

                $conn->close();

            }
        }
    }
    
    echo json_encode($output);


    ?>