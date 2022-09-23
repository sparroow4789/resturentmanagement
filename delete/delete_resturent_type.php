<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $resturent_type_id = htmlspecialchars($_POST['resturent_type_id']);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // sql to delete a record
        $sql = "DELETE FROM resturent_type WHERE resturent_type_id='$resturent_type_id'";

        if ($conn->query($sql) === TRUE) {
        
            // echo 'Completed';
        
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
            $output['msg'] = 'Successfully delete resturent type.';
            $output['data'] = $dataArray;


        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error deleting resturent type.";
        }


    }

    $conn->close();

    echo json_encode($output);

    ?>