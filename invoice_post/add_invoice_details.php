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
        $resturent_table_id = htmlspecialchars($_POST['resturent_table_id']);
        $payment_status='0';
        $invoice_type='1';
        $waiter_id='1';
        $discount='0';

        $sql = "INSERT INTO `invoice_details`(`resturent_table_id`, `payment_status`, `invoice_type`, `waiter_id`, `discount`, `invoice_datetime`) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $resturent_table_id, $payment_status, $invoice_type, $waiter_id, $discount, $currentDate);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {
            // echo 'Completed';

            $lastId=0;
        
            $ProductQuantitysql = "UPDATE resturent_table_availability SET availability='1' WHERE resturent_table_id='$resturent_table_id' ";
            if ($conn->query($ProductQuantitysql) === TRUE) {


              $output['result']=true;
              $output['msg']="Table booked";

              }else{

                $output['result']=true;
                $output['msg']="Error table booking. 999";

            }

        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error table booking.";
        }


    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>