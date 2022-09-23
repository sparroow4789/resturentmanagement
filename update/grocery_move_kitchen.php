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
        $grocery_item_id = htmlspecialchars($_POST['grocery_item_id']);
        $quantity_send = htmlspecialchars($_POST['quantity_send']);


        $ProductQuantitysql = "UPDATE grocery_item SET quantity=quantity-'$quantity_send' WHERE grocery_item_id='$grocery_item_id' ";

        if ($conn->query($ProductQuantitysql) === TRUE) {
        //   echo "Record updated successfully";

            $DataADDGroceryItemToKitchen = "INSERT INTO `grocery_kitchen_item`(`grocery_kitchen_item_id`, `grocery_item_id`, `quantity`, `grocery_kitchen_datetime`)
            VALUES (null, '$grocery_item_id', '$quantity_send', '$currentDate')";

            if ($conn->query($DataADDGroceryItemToKitchen) === TRUE) {
                // echo "New record created successfully";
        
                //get all experiences
                
                $getBalenceGroceryItems=$conn->query("SELECT * FROM grocery_item ORDER BY grocery_item_id DESC");
                while($gpRs = $getBalenceGroceryItems->fetch_array()){

                    $GroceryItemId=$gpRs[0];
                    $GroceryItemName=$gpRs[1];
                    $GroceryItemUnit=$gpRs[2];
                    $GroceryItemQuantity=$gpRs[3];
                    $GroceryItemDateTime=$gpRs[4];
                    
                    
                    
                    $row='

                            <tr>
                                <td>'.$GroceryItemId.'</td>
                                <td>'.$GroceryItemName.'</td>
                                <td><b style="float: right;">'.$GroceryItemQuantity.' '.$GroceryItemUnit.'</b></td>
                                <td>
                                    <form class="row" id="Move-Kitchen">
                                        <div class="col-md-8">
                                           <input type="hidden" name="grocery_item_id" value="'.$GroceryItemId.'" required readonly>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="quantity_send" max="'.$GroceryItemQuantity.'" min="1" value="1" style="text-align: right;" onKeyDown="return false" aria-describedby="basic-addon2" required>
                                                <span class="input-group-text" id="basic-addon2">'.$GroceryItemUnit.'</span>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="btn-move-kitchen" class="btn btn-primary btn-sm" style="float: right;"><i class="material-icons">send</i>Move</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>


                        ';
                        
                        array_push($dataArray,$row);
                    
                    
                }
                
                /////////////////
                
                
                $output['result'] = true;
                $output['msg'] = 'Successfully added quantity.';
                $output['data'] = $dataArray;
            
            
            
            // echo 'Completed';
            }else{  
                // echo 'Error';   
                
                $output['result'] = false;
                $output['msg'] = 'Error added please reload the page'; 
            }

        }else {

            $output['result'] = false;
            $output['msg'] = 'Error added please reload the page'; 
              
        }




        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>