<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    $currentDate=date('Y-m-d H:i:s');

    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $service_charge_price = htmlspecialchars($_POST['service_charge_price']);


            $DataADDServiceCharge = "INSERT INTO `service_charge`(`service_charge_id`, `service_charge_price`, `service_charge_datetime`)
            VALUES (null, '$service_charge_price', '$currentDate')";

            if ($conn->query($DataADDServiceCharge) === TRUE) {
                // echo "New record created successfully";
        
                //get all service charge
                $getServiceCharge=$conn->query("SELECT * FROM service_charge ORDER BY service_charge_id ASC");
                while($gscRs = $getServiceCharge->fetch_array()){

                    $ServicechargeId=$gscRs[0];
                    $Servicecharge=$gscRs[1];
                    $ServicechargeDateTime=$gscRs[2];

                    $row='
                            <tr>
                                <th scope="row">'.$ServicechargeId.'</th>
                                <td><b style="float: right;">'.$Servicecharge.'</b></td>
                                <td><font style="float: right;">'.$ServicechargeDateTime.'</font></td>
                            </tr>
                        ';
                        
                        array_push($dataArray,$row);
                    
                }
                
                /////////////////
                
                
                $output['result'] = true;
                $output['msg'] = 'Successfully added service charge.';
                $output['data'] = $dataArray;
            
            // echo 'Completed';
            }else{  
                // echo 'Error';   
                
                $output['result'] = false;
                $output['msg'] = 'Error added service charge please reload the page'; 
            }

        




        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>