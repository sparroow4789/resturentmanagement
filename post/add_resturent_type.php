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
        $resturent_name = htmlspecialchars($_POST['resturent_name']);
        $resturent_place = htmlspecialchars($_POST['resturent_place']);


            $DataADDResturentType = "INSERT INTO `resturent_type`(`resturent_type_id`, `resturent_name`, `resturent_place`, `resturent_datetime`)
            VALUES (null, '$resturent_name', '$resturent_place', '$currentDate')";

            if ($conn->query($DataADDResturentType) === TRUE) {
                // echo "New record created successfully";
        
                //get all experiences
                $getResturentType=$conn->query("SELECT * FROM resturent_type ORDER BY resturent_type_id ASC");
                while($grtRs = $getResturentType->fetch_array()){

                    $ResturentTypeId=$grtRs[0];
                    $ResturentTypeName=$grtRs[1];
                    $ResturentTypePlace=$grtRs[2];
                    $ResturentTypeDateTime=$grtRs[3];

                    $row='
                            <tr>
                                <th scope="row">'.$ResturentTypeId.'</th>
                                <td>'.$ResturentTypeName.'</td>
                                <td>'.$ResturentTypePlace.'</td>
                                <td>
                                    <form id="Delete-Resturent-Type" method="POST">
                                        <input type="hidden" name="resturent_type_id" value="'.$ResturentTypeId.'" required readonly>
                                        <button type="submit" id="btn-delete-resturent-type" class="btn light btn-danger btn-sm">Delete</button>
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
                $output['msg'] = 'Error added resturent type please reload the page'; 
            }

        




        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>