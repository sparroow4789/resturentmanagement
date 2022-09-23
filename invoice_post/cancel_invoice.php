<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();

    $output=[];

    if($_POST)
    {
        $delete_invoice_id = htmlspecialchars($_POST['delete_invoice_id']);
        $table_id = htmlspecialchars($_POST['table_id']);

        //Start Get Invoice Details
        $getProductCountQuery=$conn->query("SELECT COUNT(*) FROM invoice_product WHERE invoice_id='$delete_invoice_id'");
        if ($GPCrs=$getProductCountQuery->fetch_array()) {
            $ProductCount=$GPCrs[0];
        }
        //End Get Invoice Details

            if ($ProductCount>0) {

                $output['result']=false;
                $output['msg']="Please remove the items first, Then try again.";

            }else{

                $InvoicePaySql = "DELETE FROM invoice_details WHERE invoice_details_id='$delete_invoice_id' ";

                if ($conn->query($InvoicePaySql) === TRUE) 
                {

                    $InvoicePaySql = "UPDATE resturent_table_availability SET availability='0' WHERE resturent_table_id='$table_id'";

                        if ($conn->query($InvoicePaySql) === TRUE) 
                        {
                            $output['result'] = true;
                            $output['msg'] = 'Successfully cancel booking.';

                        }else{

                            $output['result']=false;
                            $output['msg']="Error updating record 456.";

                        }

                }else{

                    $output['result']=false;
                    $output['msg']="Error updating record 456.";

                }

            }


    }else{
            $output['result']=false;
            $output['msg']="Invalid request, Please try again.";
    }

    mysqli_close($conn);
    echo json_encode($output);

    ?>