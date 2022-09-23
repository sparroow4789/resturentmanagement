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
        $product_badge_cost_selling = htmlspecialchars($_POST['product_badge_cost_selling']);
        $product_quantity = htmlspecialchars($_POST['product_quantity']);

        $product_badge_cost_selling_explode = explode(",",$product_badge_cost_selling);
        $product_badge_id = $product_badge_cost_selling_explode[0];
        $product_cost = $product_badge_cost_selling_explode[1];
        $product_selling = $product_badge_cost_selling_explode[2];


        $ProductQuantitysql = "UPDATE product_badge_details SET quantity=quantity+'$product_quantity' WHERE product_badge_id='$product_badge_id' ";

        if ($conn->query($ProductQuantitysql) === TRUE) {
        //   echo "Record updated successfully";

            $DataADDStockHistory = "INSERT INTO `product_stock_history`(`product_stock_history_id`, `product_badge_id`, `product_quantity`, `product_cost`, `product_selling`, `stock_history_datetime`)
            VALUES (null, '$product_badge_id', '$product_quantity', '$product_cost', '$product_selling', '$currentDate')";

            if ($conn->query($DataADDStockHistory) === TRUE) {
                // echo "New record created successfully";
        
                //get all experiences
                
                $getProducts=$conn->query("SELECT * FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.enable_stat='1' ORDER BY pd.product_id DESC");
                while($gpRs = $getProducts->fetch_array()){

                    $ProductBatchId=$gpRs[0];
                    $ProductBatchLabel=$gpRs[2];
                    $ProductCostPrice=number_format($gpRs[3],2);
                    $ProductSellingPrice=number_format($gpRs[4],2);
                    $ProductQuantity=$gpRs[6];
                    $ProductDateTime=$gpRs[7];
                    $ProductId=$gpRs[8];
                    $ProductName=$gpRs[9];
                    $ProductCode=$gpRs[10];
                    
                    
                    
                    $row='

                            <tr>
                                <td>'.$ProductBatchId.'</td>
                                <td>'.$ProductName.' - '.$ProductBatchLabel.'</td>
                                <td>'.$ProductCode.'</td>
                                <td><b><span style="float: right;">'.$ProductQuantity.'</span></b></td>
                                <td><b><span style="float: right;">'.$ProductCostPrice.'</b></span></td>
                                <td><b><span style="float: right;">'.$ProductSellingPrice.'</span></b></td>
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