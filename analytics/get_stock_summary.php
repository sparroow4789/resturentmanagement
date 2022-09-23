  <?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    //$today=date('Y-m-d');


    $output=[]; 
    $datalist=array();
    $productNameList = array();
    $productQtyList = array();

    if(isset($_POST['stock_start_date']) && isset($_POST['stock_end_date'])){

        $stock_start_date=htmlspecialchars($_POST['stock_start_date']);
        $stock_end_date=htmlspecialchars($_POST['stock_end_date']);

        $query="SELECT product_badge_id, SUM(product_quantity) FROM invoice_product WHERE DATE(invoice_product_datetime) BETWEEN '$stock_start_date' AND '$stock_end_date' GROUP BY product_badge_id ORDER BY SUM(product_quantity) DESC";
        $GetAvailableQuantityProductsSql=$conn->query($query);
        while ($GAPCrow=$GetAvailableQuantityProductsSql->fetch_array()) {

          $ProductBadgeId=$GAPCrow[0];
          $AllProductSaleQty=$GAPCrow[1];
        

            $getProductDetails = $conn->query("SELECT * FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.product_badge_id = '$ProductBadgeId'");
            if($GPD = $getProductDetails->fetch_array()){

                $ProductBadgeName=$GPD[2];
                $ProductStatus=$GPD[5];
                $ProductAvailableQuantity=$GPD[6];
                $ProductName=$GPD[9];
                $ProductCode=$GPD[10];

                if ($ProductStatus=='0') { }else{
                    array_push($productNameList,$ProductName.' - '.$ProductBadgeName);
                    array_push($productQtyList,$AllProductSaleQty);





                    $obj=' 

                        <tr>
                            <td>'.$ProductName.' - '.$ProductBadgeName.'</td>
                            <td>'.$ProductCode.'</td>
                            <td><b><span style="float: right; font-size: 20px; color: #03AC13;">'.$AllProductSaleQty.'</span></b></td>
                        </tr>
                       

                      ';

                      array_push($datalist,$obj);





                }

            }


          
      

          



      
    }


    $output['result']=true;
    $output['data']=$datalist;
    

    $output['productName'] = $productNameList;
    $output['productQtySum'] = $productQtyList;




    }else{
        $output['result']=false;
        $output['data']="Invalid request.";
    }






   


    echo json_encode($output);
    
    
    