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
        $grocery_item_name = htmlspecialchars($_POST['grocery_item_name']);
        $item_unit_type = htmlspecialchars($_POST['item_unit_type']);

        $quantity = 0;


        $sql = "INSERT INTO `grocery_item`(`grocery_item_name`, `item_unit_type`, `quantity`, `grocery_item_datetime`) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $grocery_item_name, $item_unit_type, $quantity, $currentDate);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {
            // echo 'Completed';
              $output['result']=true;
              $output['msg']="Grocery item added successfully.";

        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error Grocery item adding.";
        }


    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>