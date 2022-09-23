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
        $resturent_type_id = htmlspecialchars($_POST['resturent_type_id']);
        $resturent_table_number = htmlspecialchars($_POST['resturent_table_number']);


            $DataADDResturentTable = "INSERT INTO `resturent_table`(`resturent_table_id`, `resturent_type_id`, `resturent_table_number`, `resturent_table_datetime`)
            VALUES ('', '$resturent_type_id', '$resturent_table_number', '$currentDate')";

            if ($conn->query($DataADDResturentTable) === TRUE) {
                // echo "New record created successfully";

                $lastId=0;
                $getLast=$conn->query("SELECT resturent_table_id FROM resturent_table ORDER BY resturent_table_id DESC LIMIT 1");
                if($lRs=$getLast->fetch_array()){
                $lastId=$lRs[0];

                    $DataADDResturentTableAvailability = "INSERT INTO `resturent_table_availability`(`table_availability_id`, `resturent_table_id`, `availability`)
                    VALUES (null, '$lastId', '0')";

                    if ($conn->query($DataADDResturentTableAvailability) === TRUE) {

                        //get all experiences
                        $getResturentTable=$conn->query("SELECT * FROM resturent_table rt INNER JOIN resturent_type rest ON rt.resturent_type_id=rest.resturent_type_id ORDER BY rt.resturent_table_id ASC");
                        while($grtRs = $getResturentTable->fetch_array()){

                            $ResturentTableId=$grtRs[0];
                            $ResturentTypeId=$grtRs[1];
                            $ResturentTableNumber=$grtRs[2];
                            $ResturentTableDateTime=$grtRs[3];
                            $ResturentTypeName=$grtRs[5];
                            $ResturentTypeLocation=$grtRs[6];

                            $row='
                                    <tr>
                                        <th scope="row">'.$ResturentTableId.'</th>
                                        <td>'.$ResturentTypeName.'</td>
                                        <td>'.$ResturentTableNumber.'</td>
                                        <td>'.$ResturentTypeLocation.'</td>
                                        <td>
                                            <form id="Delete-Resturent-Table" method="POST">
                                                <input type="hidden" name="resturent_table_id" value="'.$ResturentTableId.'" required readonly>
                                                <button type="submit" id="btn-delete-resturent-table" class="btn light btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                ';
                                
                                array_push($dataArray,$row);
                            
                        }
                        
                        /////////////////
                    
                    
                    $output['result'] = true;
                    $output['msg'] = 'Successfully added resturent type.';
                    $output['data'] = $dataArray;
                
                    // echo 'Completed';
        
                    

                    }else{  
                        // echo 'Error';
                        $output['result'] = false;
                        $output['msg'] = 'Error added resturent type please reload the page 123'; 
                    }


            }else{  
                // echo 'Error';
                $output['result'] = false;
                $output['msg'] = 'Error added resturent type please reload the page 456'; 
            }

        }else{  
            // echo 'Error';   
                
            $output['result'] = false;
            $output['msg'] = 'Error added resturent type please reload the page 789'; 
        }

        

        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>