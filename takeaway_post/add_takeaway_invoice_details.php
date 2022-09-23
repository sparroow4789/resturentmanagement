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
        $invoice_type = htmlspecialchars($_POST['invoice_type']);
        $payment_status='0';
        $waiter_id=null;
        $discount='0';

        $sql = "INSERT INTO `invoice_details`(`resturent_table_id`, `payment_status`, `invoice_type`, `waiter_id`, `discount`, `invoice_datetime`) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $resturent_table_id, $payment_status, $invoice_type, $waiter_id, $discount, $currentDate);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {
            // echo 'Completed';

            $lastId=0;
        
            $getLast=$conn->query("SELECT invoice_details_id FROM invoice_details ORDER BY invoice_details_id DESC LIMIT 1");
            if($lRs=$getLast->fetch_array()){

              $lastId=$lRs[0];
              $encodelastId=base64_encode($lastId);


              $output['result']=true;
              $output['lastId']=$encodelastId;
              $output['msg']="Created invoice number.";

              }else{

                $output['result']=true;
                $output['msg']="Error Created invoice number. 999.";

            }

              

        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error Created invoice number. 888.";
        }


    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>