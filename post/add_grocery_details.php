<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    $currentDate=date('Y-m-d H:i:s');

    $output=[];

    if($_POST)
    {
        $grocery_name = htmlspecialchars($_POST['grocery_name']);

        $sql = "INSERT INTO `grocery_bill_details`(`grocery_name`, `grocery_bill_datetime`) VALUES (?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $grocery_name, $currentDate);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {
            // echo 'Completed';

            $lastId=0;
        
            $getLast=$conn->query("SELECT grocery_bill_id FROM grocery_bill_details ORDER BY grocery_bill_id DESC LIMIT 1");
            if($lRs=$getLast->fetch_array()){

              $lastId=$lRs[0];
              $encodelastId=base64_encode($lastId);


              $output['result']=true;
              $output['lastId']=$encodelastId;
              $output['msg']="Grocery details added successfully.";

              }else{

                $output['result']=true;
                $output['msg']="Error Grocery details adding. 999";

            }

        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error Grocery details adding.";
        }


    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>