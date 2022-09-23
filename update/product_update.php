<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];

    if($_POST)
    {
        $product_id = htmlspecialchars($_POST['product_id']); 
        $product_name = htmlspecialchars($_POST['product_name']);
        $product_code = htmlspecialchars($_POST['product_code']);
        $product_category = htmlspecialchars($_POST['product_category']);
        $prep_time = htmlspecialchars($_POST['prep_time']);
        $calories = htmlspecialchars($_POST['calories']);
        $product_details = htmlspecialchars($_POST['product_details']);
           

        $sql = "UPDATE product_details SET product_name='$product_name', product_code='$product_code', product_category='$product_category', prep_time='$prep_time', calories='$calories', product_details='$product_details' WHERE product_id='$product_id' ";

        if ($conn->query($sql) === TRUE) {
   
            $output['result']=true;
            $output['msg']="Record updated successfully.";

        } else {
            
            $output['result']=false;
            $output['msg']="Error updating record.";
        }

        
    }
    
    $conn->close();
    echo json_encode($output);


    ?>