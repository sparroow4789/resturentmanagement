<?php

	require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    //$today=date('Y-m-d');

    $productList = array();
    $groceryList = array();
    
    
    if(isset($_POST['cost_start_date']) && isset($_POST['cost_end_date'])){
        
        $start_date=htmlspecialchars($_POST['cost_start_date']);
        $end_date=htmlspecialchars($_POST['cost_end_date']);

        $totalStockCost = 0.0;
        $totalGroceryCost = 0.0;
        $fullCost = 0.0;

        $output['result'] = true;

        //invoice_save is -->ti ////////


        //get Product Stock Cost/////////
        $getProductCost = $conn->query("SELECT  psh.product_quantity,psh.product_cost FROM product_stock_history psh WHERE DATE(psh.stock_history_datetime) BETWEEN '$start_date' AND '$end_date'");
        while($gpc = $getProductCost->fetch_array()){
            $ProductQty = $gpc[0];
            $ProductCost = $gpc[1];

            $ProductPrice = $ProductCost * $ProductQty;
            $totalStockCost += $ProductPrice;

        }
        ////////////////////////
        //get table invoice count/////////
        $getGroceryCost = $conn->query("SELECT stock,cost FROM grocery_bill_item gbi INNER JOIN grocery_bill_details gbd ON gbi.grocery_bill_id=gbd.grocery_bill_id WHERE DATE(gbd.grocery_bill_datetime) BETWEEN '$start_date' AND '$end_date'");
        while($ggc = $getGroceryCost->fetch_array()){
            $GroceryQty = $ggc[0];
            $GroceryCost = $ggc[1];


            $GroceryPrice = $GroceryQty * $GroceryCost;
            $totalGroceryCost += $GroceryPrice;
        }
        ////////////////////////


        ///////Full Cost////////

        $fullCost = $totalStockCost + $totalGroceryCost;

        ///////////////////////


        //get Product Stock Cost List/////////
        $getProductListCost = $conn->query("SELECT SUM(psh.product_quantity),pd.product_name,pbd.product_badge_label,pd.product_code,psh.product_cost FROM product_stock_history psh INNER JOIN product_badge_details pbd ON psh.product_badge_id=pbd.product_badge_id INNER JOIN product_details pd ON pbd.product_name_id=pd.product_id WHERE DATE(psh.stock_history_datetime) BETWEEN '$start_date' AND '$end_date' GROUP BY psh.product_badge_id ORDER BY SUM(psh.product_quantity) DESC");
        $dataRowProduct = "";
        $ProductGetCostTotal = 0;
        while($gplc = $getProductListCost->fetch_array()){
            $ProductGetQty = $gplc[0];
            $ProductGetName = $gplc[1];
            $ProductGetBadgeName = $gplc[2];
            $ProductGetCode = $gplc[3];
            $ProductGetCost = $gplc[4];

            $ProductGetCostTotal = number_format($ProductGetCost * $ProductGetQty,2);

            $dataRowProduct .= ' 
                                <tr>
                                    <td>'.$ProductGetName.' - '.$ProductGetBadgeName.'</td>
                                    <td>'.$ProductGetCode.'</td>
                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;">'.$ProductGetQty.'</span></b></td>
                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;">'.$ProductGetCostTotal.'</span></b></td>
                                </tr>
                              ';

                              array_push($productList, $dataRowProduct);

        }
        ////////////////////////


        //get Grocery Stock Cost List/////////
        $getGroceryListCost = $conn->query("SELECT SUM(gbi.stock),gi.grocery_item_name,gi.item_unit_type,SUM(gbi.cost) FROM grocery_bill_item gbi INNER JOIN grocery_bill_details gbd ON gbi.grocery_bill_id=gbd.grocery_bill_id INNER JOIN grocery_item gi ON gbi.grocery_item_id=gi.grocery_item_id WHERE DATE(gbd.grocery_bill_datetime) BETWEEN '$start_date' AND '$end_date' GROUP BY gbi.grocery_item_id ORDER BY SUM(gbi.stock) DESC");
        $dataRowGrocery = "";
        $GroceryGetCostTotal = 0;
        while($gglc = $getGroceryListCost->fetch_array()){
            $GroceryGetQty = $gglc[0];
            $GroceryGetName = $gglc[1];
            $GroceryGetUnitType = $gglc[2];
            $GroceryGetCost = $gglc[3];

            $dataRowGrocery .= ' 
                                <tr>
                                    <td>'.$GroceryGetName.'</td>
                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;">'.$GroceryGetQty.' '.$GroceryGetUnitType.'</span></b></td>
                                    <td><b><span style="float: right; font-size: 20px; color: #03AC13;">'.$GroceryGetCost.'</span></b></td>
                                </tr>
                              ';

                              array_push($groceryList, $dataRowGrocery);

        }
        ////////////////////////





        
        $output['total_stock_cost'] = $totalStockCost;
        $output['total_grocery_cost'] = $totalGroceryCost;
        $output['product_data'] = $dataRowProduct;
        $output['grocery_data'] = $dataRowGrocery;
        $output['total_cost'] = $fullCost;
        

        //////////////////////////////////////////////////

        
    }else{
        $output['result']=false;
        $output['msg']="Invalid request, Please try again.";
    }
    
    echo json_encode($output);
    
    
    