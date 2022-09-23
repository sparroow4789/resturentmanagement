<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $grocery_bill_id = htmlspecialchars($_POST['grocery_bill_id']);
        $grocery_bill_item_id = htmlspecialchars($_POST['grocery_bill_item_id']);
        $grocery_item_id = htmlspecialchars($_POST['grocery_item_id']);
        $grocery_stock = htmlspecialchars($_POST['grocery_stock']);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $GroceryStockQuantitysql = "UPDATE grocery_item SET quantity=quantity-'$grocery_stock' WHERE grocery_item_id='$grocery_item_id' ";

        if ($conn->query($GroceryStockQuantitysql) === TRUE) {

            // sql to delete a record
        $sql = "DELETE FROM grocery_bill_item WHERE grocery_bill_item_id='$grocery_bill_item_id'";

        if ($conn->query($sql) === TRUE) {


                //get all experiences
                $GroceryTotalCost=0;
                $ItemCount=0;
                $getGroceryBillItems=$conn->query("SELECT * FROM grocery_bill_item gbi INNER JOIN grocery_item gi ON gbi.grocery_item_id=gi.grocery_item_id WHERE gbi.grocery_bill_id='$grocery_bill_id' ORDER BY gbi.grocery_bill_item_id DESC");
                $ResultCount = 0;
                while($gbiRs = $getGroceryBillItems->fetch_array()){

                    $ResultCount += 1;

                    $GroceryBillItemId=$gbiRs[0];
                    $GroceryBillId=$gbiRs[1];
                    $GroceryItemId=$gbiRs[2];
                    $GroceryStock=$gbiRs[3];
                    $GroceryCost=$gbiRs[4];

                    $GroceryItemName=$gbiRs[6];
                    $GroceryItemUnityType=$gbiRs[7];

                    $GroceryTotalCost+=$GroceryCost;

                    $ItemCountView=$ItemCount+=1;
                    
                    $row='
                            <tr>
                                <th scope="row">'.$ItemCountView.'</th>
                                <td>'.$GroceryItemName.'</td>
                                <td><b style="float: right;">'.$GroceryStock.' '.$GroceryItemUnityType.'</b></td>
                                <td><b style="float: right;">'.number_format($GroceryCost,2).'</b></td>
                                <td>
                                    <form id="Delete-Grocery-Bill-Item" method="POST">
                                        <input type="hidden" name="grocery_bill_item_id" value="'.$GroceryBillItemId.'" required readonly>
                                        <input type="hidden" name="grocery_bill_id" value="'.$GroceryBillId.'" required readonly>
                                        <input type="hidden" name="grocery_stock" value="'.$GroceryStock.'" required readonly>
                                        <input type="hidden" name="grocery_item_id" value="'.$GroceryItemId.'" required readonly>
                                        <button type="submit" id="btn-delete-grocery-bill-item" class="btn btn-danger btn-sm" style="float: right;"><i class="material-icons">delete_outline</i>Remove</button>   
                                    </form>   
                                </td>
                            </tr>
                        ';
                        
                        array_push($dataArray,$row);
                    
                }
                
                /////////////////
                
                
                $output['result'] = true;
                $output['msg'] = 'Successfully deleted grocery item.';
                $output['data'] = $dataArray;
                $output['GroceryTotalCost'] = number_format($GroceryTotalCost,2);
                $output['ResultCount'] = $ResultCount;


        }else{   
            $output['result']=false;
            $output['msg']="Error deleting product batch.";
        }



    }else{
            
        $output['result']=false;
        $output['msg']="Error deleting product batch.";            

    }


        


    }

    $conn->close();
    echo json_encode($output);

    ?>