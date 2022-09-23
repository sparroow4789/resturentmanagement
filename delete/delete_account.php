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

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // sql to delete a record
        $sql = "DELETE FROM users_login WHERE user_id='$user_id'";

        if ($conn->query($sql) === TRUE) {
        
            // echo 'Completed';
        
            //get users
            
                    $getAccountDetails=$conn->query("SELECT * FROM users_login ORDER BY user_id ASC");
                    while($grRs = $getAccountDetails->fetch_array()){
                        
                        $UserId = $grRs[0];
                        $UserName = $grRs[1];
                        $UserEmail = $grRs[2];
                        $UserRole = $grRs[4];
                        $UserTel = $grRs[5];
                        $UserDate = $grRs[6];

                        if($UserRole=='1'){
                            $UserRoleDesign='<span class="badge light badge-secondary">ADMIN</span>';
                        }else{
                            $UserRoleDesign='<span class="badge light badge-primary">USER ACCOUNT</span>';
                        }

                        if($UserEmail=='admin@mail.com' || $UserEmail=='demo@mail.com') {
                            $DeleteBtn='<td></td>';
                        }else{
                            $DeleteBtn='
                                        <td>
                                            <form id="Delete-Account" method="POST">
                                                <input type="hidden" name="user_id" value="'.$UserId.'" required readonly>
                                                <button type="submit" id="btn-add-delete-user" class="btn light btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                        ';
                        }
                        
                        
                        $row='
                            <tr>
                                <td>'.$UserId.'</td>
                                <td>'.$UserName.'</td>
                                <td>'.$UserEmail.'</td>
                                <td>'.$UserRoleDesign.'</td>
                                <td><b>'.$UserTel.'</b></td>
                                <td><b>'.$UserDate.'</b></td>
                                '.$DeleteBtn.'
                            </tr>
                            ';
                            
                            array_push($dataArray,$row);
                
                
            }
            
            /////////////////
            
            
            $output['result'] = true;
            $output['msg'] = 'Successfully delete reminder.';
            $output['data'] = $dataArray;


        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error deleting reminder.";
        }


    }

    $conn->close();

    echo json_encode($output);

    ?>