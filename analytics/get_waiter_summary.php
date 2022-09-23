  <?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    //$today=date('Y-m-d');


    $output=[]; 
    $datalist=array();
    $waiterNameList = array();
    $waiterBillCountList = array();

    if(isset($_POST['waiter_start_date']) && isset($_POST['waiter_end_date'])){

        $waiter_start_date=htmlspecialchars($_POST['waiter_start_date']);
        $waiter_end_date=htmlspecialchars($_POST['waiter_end_date']);

        $query="SELECT invoice_save_id, invoice_waiter_id, COUNT(invoice_waiter_id) FROM invoice_save WHERE DATE(invoice_save_datetime) BETWEEN '$waiter_start_date' AND '$waiter_end_date' GROUP BY invoice_waiter_id ORDER BY COUNT(invoice_waiter_id) DESC";
        $GetWaiterPeformenceSql=$conn->query($query);
        while ($GWProw=$GetWaiterPeformenceSql->fetch_array()) {

          $InvoiceSaveId=$GWProw[0];
          $WaiterId=$GWProw[1];
          $WaiterBillCount=$GWProw[2];

            $getWaiterDetails = $conn->query("SELECT * FROM users_login WHERE user_id = '$WaiterId'");
            if($GWD = $getWaiterDetails->fetch_array()){
                $WaiterName=$GWD[1];

                if ($WaiterId==null) { }else{
                    array_push($waiterNameList,$WaiterName);
                    array_push($waiterBillCountList,$WaiterBillCount);

                    $obj=' 
                        <tr>
                            <td>'.$WaiterName.'</td>
                            <td><b><span style="float: right; font-size: 20px; color: #03AC13;">'.$WaiterBillCount.'</span></b></td>
                        </tr>
                        ';

                      array_push($datalist,$obj);

                  }
 

            }


    }


    $output['result']=true;
    $output['data']=$datalist;
    

    $output['waiterName'] = $waiterNameList;
    $output['waiterQtySum'] = $waiterBillCountList;


    }else{
        $output['result']=false;
        $output['data']="Invalid request.";
    }






   


    echo json_encode($output);
    
    
    