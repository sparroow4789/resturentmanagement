<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();

    $output=[];

    if($_POST)
    {
        $invoice_id = htmlspecialchars($_POST['invoice_id']);
        $table_id = htmlspecialchars($_POST['table_id']);

        $InvoicePaySql = "UPDATE invoice_details SET payment_status='2' WHERE invoice_details_id='$invoice_id' ";

        if ($conn->query($InvoicePaySql) === TRUE) 
        {
            // echo 'Completed';


            $ResturentAvailbleSql = "UPDATE resturent_table_availability SET availability='0' WHERE resturent_table_id='$table_id' ";

                if ($conn->query($ResturentAvailbleSql) === TRUE) 
                {
                    // echo 'Completed';

                    $output['result'] = true;
                    $output['msg'] = 'Successfully paid.';

                }else{

                    $output['result']=false;
                    $output['msg']="Error paid, try again.";

                }




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