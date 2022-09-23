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
        $product_category = htmlspecialchars($_POST['product_category']);


            $DataADDProductCategory = "INSERT INTO `product_category`(`category_id`, `category`)
            VALUES (null, '$product_category')";

            if ($conn->query($DataADDProductCategory) === TRUE) {
                // echo "New record created successfully";
        
                //get all product category
                $getProductCategory=$conn->query("SELECT * FROM product_category ORDER BY category_id ASC");
                while($gpcRs = $getProductCategory->fetch_array()){

                    $CategoryId=$gpcRs[0];
                    $ProductCategory=$gpcRs[1];

                    $row='
                            <tr>
                                <th scope="row">'.$CategoryId.'</th>
                                <td><b>'.$ProductCategory.'</b></td>
                                <td>
                                    <form id="Delete-Product-Category" method="POST">
                                        <input type="hidden" name="category_id" value="'.$CategoryId.'" required readonly>
                                        <button type="submit" id="btn-delete-product-category" class="btn light btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        ';
                        
                        array_push($dataArray,$row);
                    
                }
                
                /////////////////
                
                
                $output['result'] = true;
                $output['msg'] = 'Successfully added product category.';
                $output['data'] = $dataArray;
            
            // echo 'Completed';
            }else{  
                // echo 'Error';   
                
                $output['result'] = false;
                $output['msg'] = 'Error added product category please reload the page'; 
            }

        




        $conn->close();
    }
    
    
    echo json_encode($output);


    ?>