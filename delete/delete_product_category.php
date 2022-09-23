<?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();


    $output=[];
    $dataArray = array();

    if($_POST)
    {
        $category_id = htmlspecialchars($_POST['category_id']);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // sql to delete a record
        $sql = "DELETE FROM product_category WHERE category_id='$category_id'";

        if ($conn->query($sql) === TRUE) {
            // echo 'Completed';


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
            $output['msg'] = 'Successfully delete product category.';
            $output['data'] = $dataArray;




        }else{  
            // echo 'Error';   
            $output['result']=false;
            $output['msg']="Error deleting product category.";
        }


    }

    $conn->close();

    echo json_encode($output);

    ?>