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
        $product_name_id = htmlspecialchars($_POST['product_name_id']);
        $product_badge_label = htmlspecialchars($_POST['product_badge_label']);
        $cost_price = htmlspecialchars($_POST['cost_price']);    
        $selling_price = htmlspecialchars($_POST['selling_price']);

        if(isset($_POST['enable_stat'])){
            $enable_stat = 1;
            $quantity = 0;

        }else{
            $enable_stat = 0;
            $quantity = NULL;
        }

        $sql = "INSERT INTO `product_badge_details`(`product_name_id`, `product_badge_label`, `cost_price`, `selling_price`, `enable_stat`, `quantity`, `product_badge_datetime`) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $product_name_id, $product_badge_label, $cost_price, $selling_price, $enable_stat, $quantity, $currentDate);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {
            // echo 'Completed';
              $output['result']=true;
              $output['msg']="Product batch added successfully.";

        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error product batch adding.";
        }


    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>