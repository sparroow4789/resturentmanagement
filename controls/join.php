<?php

    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    $currentDate=date('Y-m-d H:i:s');

    $output=[];
    $dataArray = array();


     if($_POST)
     {
        
        // echo json_encode($_POST['name']);
         
        $name = $_POST['name'];     
        $email = $_POST['email'];
        $role = $_POST['role']; 
        $tel = $_POST['tel'];
        $cpassword = $_POST['cpassword'];
        $hashed = password_hash($cpassword, PASSWORD_DEFAULT);

        //$stat = 0;
        //$days = 0;


        $sql = "INSERT INTO  users_login (name, email, password, role, tel) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $hashed, $role, $tel);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {

 
                    // ini_set( 'display_errors', 1 );
                    // error_reporting( E_ALL );
                    // $from = "";
                    // $to = $email;
                    // $subject = "Users Login Details";
                    // $message = "
        
        
                    // Dear $name,

                    // Your Smart Auto Inventory™ Account has been created, you can use these credentials to login to your account

                    // User Name - $email
                    // Password - $cpassword
                    
                    // Regards,
                    // The Management Team,
                    // Prestige Automobile (Pvt) Ltd
                    
                    

                    // ---------------- This is a auto genereted Email by Prestige Automobile (Pvt) Ltd ----------------

                    
                    // ";
                    // $headers = "From:" . $from;
                    // mail($to,$subject,$message, $headers);


                    ////////////////////////////

                    //get all reminder
            
                    $getAccountDetails=$conn->query("SELECT * FROM users_login ORDER BY user_id DESC");
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




                    /////////////////////////////


                    $output['result'] = true;
                    $output['msg'] = 'Account create successfully.';
                    $output['data'] = $dataArray;

                }else{

                    $output['result'] = false;
                    $output['msg'] = 'Account create error'; 

                }

     }else{
         // echo 'Error 9119';
     }

    mysqli_close($conn);
    echo json_encode($output);

?>