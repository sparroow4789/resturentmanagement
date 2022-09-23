  <?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    date_default_timezone_set('Asia/Colombo');
    $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');


    $output=[];
    // $datalist=array();
    $waiterNameList = array();
    $waiterBillCountList = array();

        $query="SELECT invoice_id, invoice_waiter_id, COUNT(invoice_waiter_id) FROM invoice_save WHERE invoice_save_datetime LIKE '%$currentDate%' GROUP BY invoice_waiter_id ORDER BY COUNT(invoice_waiter_id) DESC";
        $GetWaiterBillsql=$conn->query($query);
        while ($GWBSrow=$GetWaiterBillsql->fetch_array()) {

          $InvoiceId=$GWBSrow[0];
          $WaiterId=$GWBSrow[1];
          $WaiterBillCount=$GWBSrow[2];
        

            $getWaiterDetails = $conn->query("SELECT * FROM users_login WHERE user_id = '$WaiterId'");
            if($GWD = $getWaiterDetails->fetch_array()){

                $WaiterName=$GWD[1];


                if ($WaiterId==null) { }else{
                    array_push($waiterNameList,$WaiterName);
                    array_push($waiterBillCountList,$WaiterBillCount);
                }

            }


      
    }


    $output['result']=true;
    // $output['data']=$datalist;
    

    $output['waiterName'] = $waiterNameList;
    $output['waiterBillCount'] = $waiterBillCountList;



    echo json_encode($output);
    
    
    