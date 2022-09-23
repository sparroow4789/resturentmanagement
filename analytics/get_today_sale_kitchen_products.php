  <?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    date_default_timezone_set('Asia/Colombo');
    $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');


    $output=[];
    // $datalist=array();
    $productNameList = array();
    $productQtyList = array();

        $query="SELECT product_badge_id, SUM(product_quantity) FROM invoice_product WHERE invoice_product_datetime LIKE '%$currentDate%' GROUP BY product_badge_id ORDER BY SUM(product_quantity) DESC";
        $GetAvailableKitchenQuantityProductssql=$conn->query($query);
        while ($GAKPCrow=$GetAvailableKitchenQuantityProductssql->fetch_array()) {

          $ProductBadgeId=$GAKPCrow[0];
          $AllProductSaleQty=$GAKPCrow[1];
        

            $getProductDetails = $conn->query("SELECT * FROM product_badge_details pbd INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE pbd.product_badge_id = '$ProductBadgeId'");
            if($GPD = $getProductDetails->fetch_array()){

                $ProductBadgeName=$GPD[2];
                $ProductStatus=$GPD[5];
                $ProductAvailableQuantity=$GPD[6];
                $ProductName=$GPD[9];
                $ProductCode=$GPD[10];


                if ($ProductStatus=='1') { }else{
                    array_push($productNameList,$ProductName.' - '.$ProductBadgeName);
                    array_push($productQtyList,$AllProductSaleQty);
                }

            }

               




          // array_push($datalist);



      
    }


    $output['result']=true;
    // $output['data']=$datalist;
    

    $output['productKitchenName'] = $productNameList;
    $output['productKitchenQtySum'] = $productQtyList;









   


    echo json_encode($output);
    
    
    