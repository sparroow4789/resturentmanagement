<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];

    if($_POST)
    {
        $product_badge_id = htmlspecialchars($_POST['product_badge_id']); 
        $product_badge_label = htmlspecialchars($_POST['product_badge_label']);
        $cost_price = htmlspecialchars($_POST['cost_price']);
        $selling_price = htmlspecialchars($_POST['selling_price']);
           

        $sql = "UPDATE product_badge_details SET product_badge_label='$product_badge_label', cost_price='$cost_price', selling_price='$selling_price' WHERE product_badge_id='$product_badge_id' ";

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