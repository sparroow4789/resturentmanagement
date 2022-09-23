<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();

    $output=[];

    if($_POST)
    {
        $invoice_id = htmlspecialchars($_POST['invoice_id']);
        $discount = htmlspecialchars($_POST['discount']);

        $ProductQuantityPlusSql = "UPDATE invoice_details SET discount='$discount' WHERE invoice_details_id='$invoice_id' ";

        if ($conn->query($ProductQuantityPlusSql) === TRUE) 
        {
            // echo 'Completed';
            $output['result'] = true;
            $output['msg'] = 'Successfully added discount.';

        }else{

            $output['result']=false;
            $output['msg']="Error updating record 456.";

        }


    }else{
            $output['result']=false;
            $output['msg']="Invalid request, Please try again.";
    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>