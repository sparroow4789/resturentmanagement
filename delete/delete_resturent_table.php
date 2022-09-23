<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $resturent_table_id = htmlspecialchars($_POST['resturent_table_id']);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // sql to delete a record
        $sql = "DELETE FROM resturent_table WHERE resturent_table_id='$resturent_table_id'";

        if ($conn->query($sql) === TRUE) {
            // echo 'Completed';

            // sql to delete a record
            $DeleteAvailabilitysql = "DELETE FROM resturent_table_availability WHERE resturent_table_id='$resturent_table_id'";

            if ($conn->query($DeleteAvailabilitysql) === TRUE) {
                // echo 'Completed';

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
            $output['msg'] = 'Successfully delete resturent type.';
            $output['data'] = $dataArray;


            }else{  
                // echo 'Error';   
                $output['result']=false;
                $output['msg']="Error deleting resturent type 999.";
            }


        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error deleting resturent type 888.";
        }


    }

    $conn->close();

    echo json_encode($output);

    ?>