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
        $product_name = htmlspecialchars($_POST['product_name']);
        $product_code = htmlspecialchars($_POST['product_code']);
        $product_details = htmlspecialchars($_POST['product_details']);    
        $prep_time = htmlspecialchars($_POST['prep_time']);
        $calories = htmlspecialchars($_POST['calories']);
        $product_category = htmlspecialchars($_POST['product_category']);

        $time=time();

        //Image Uploading
        $DocumentFile = $_FILES['product_img']['name'];
        $fileElementName = 'photo';
        $path = '../product_images/';
        // $location = $path . $_FILES['doc']['name'];
        $extension = pathinfo($DocumentFile, PATHINFO_EXTENSION);
        $location = $path . $time. "." .$extension; 
        $locationForDb = $time. "." .$extension;
        move_uploaded_file($_FILES['product_img']['tmp_name'], $location);

        $stat = 1;


        $sql = "INSERT INTO `product_details`(`product_name`, `product_code`, `product_details`, `product_category`, `prep_time`, `calories`, `product_img`, `stat`, `product_datetime`) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $product_name, $product_code, $product_details, $product_category, $prep_time, $calories, $locationForDb, $stat, $currentDate);
        $result = mysqli_stmt_execute($stmt);
        if($result)
        {
            // echo 'Completed';
              $output['result']=true;
              $output['msg']="Product added successfully.";

        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error product adding.";
        }


    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>