<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];

    if($_POST)
    {
        $product_batch_id = htmlspecialchars($_POST['product_batch_id']);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // sql to delete a record
        $sql = "DELETE FROM product_badge_details WHERE product_badge_id='$product_batch_id'";

        if ($conn->query($sql) === TRUE) {
       
            $output['result'] = true;
            $output['msg'] = 'Successfully deleted product batch.';

        }else{   
            $output['result']=false;
            $output['msg']="Error deleting product batch.";
        }


    }

    $conn->close();
    echo json_encode($output);

    ?>