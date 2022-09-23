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
        $user_id = htmlspecialchars($_POST['user_id']);
        $subject = htmlspecialchars($_POST['subject']);
        $todo_message = htmlspecialchars($_POST['todo_message']);

            $DataADDTodo = "INSERT INTO `todo`(`todo_id`, `user_id`, `subject`, `todo_message`, `todo_datetime`)
            VALUES (null, '$user_id', '$subject', '$todo_message', '$currentDate')";

            if ($conn->query($DataADDTodo) === TRUE) {
                // echo "New record created successfully";
        
                //get all todo
                $gettodo=$conn->query("SELECT * FROM todo WHERE user_id='$user_id' ORDER BY todo_id DESC");
                while($gpRs = $gettodo->fetch_array()){

                    $TodoId =$gpRs[0];
                    $TodoUserId=$gpRs[1];
                    $TodoSubject=$gpRs[2];
                    $TodoMessage=nl2br($gpRs[3]);
                    $TodoDatetime=$gpRs[4];
                    
                    
                    $row='

                            <li class="todo-item">
                                <div class="todo-item-content">
                                    <span class="todo-item-title">'.$TodoSubject.'<span class="badge badge-style-light rounded-pill badge-warning">other</span></span>
                                    <span class="todo-item-subtitle">'.$TodoMessage.'</span>
                                </div>
                                <div class="todo-item-actions">
                                    <a href="#" class="todo-item-delete"><i class="material-icons-outlined no-m">close</i></a>
                                </div>
                            </li>

                        ';
                        
                        array_push($dataArray,$row);
                    
                    
                }
                
                /////////////////
                
                
                $output['result'] = true;
                $output['msg'] = 'Successfully added quantity.';
                $output['data'] = $dataArray;
            
            
            
            

        }else {

            $output['result'] = false;
            $output['msg'] = 'Error added please reload the page'; 
              
        }




        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>