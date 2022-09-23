 <?php

    $path = $_SERVER['PHP_SELF'];
    $page = basename($path);
    $page = basename($path, '.php');

 ?>        

        <div class="app-sidebar">
            <div class="logo">
                <a href="index" class="logo-icon"><span class="logo-text">Restaurant</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="index">

                        <?php
                            $checkProfilePicCount = $conn->query("SELECT count(*) FROM users_profile_pic WHERE user_id='$user_id'");
                            if($cppcRS = $checkProfilePicCount->fetch_array()){
                            $ProfilePicCount = (int)$cppcRS[0];
                            }
                                if($ProfilePicCount == 0){
                        ?>
                            <img alt="image" src="assets/images/profile.jpg" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
                        <?php }else{ ?>
                        <?php
                            $getUserProPic=$conn->query("SELECT profile_image FROM users_profile_pic WHERE user_id='$user_id' ");
                            if($gunRs = $getUserProPic->fetch_array()){
                                                                
                                $ProPic = $gunRs[0];
                        ?>
                            <img alt="image" src="user_profile_pic/<?php echo $ProPic; ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
                        <?php } ?>
                        <?php } ?>
                        <!-- <img src="assets/images/avatars/avatar.png"> -->
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?php echo $user_name; ?><br>
                        <span class="user-state-info">
                            <?php if ($user_role =='1') {?>Admin<?php }else{ ?>Member<?php } ?>
                        </span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Apps
                    </li>
                    <li <?php if ($page == 'index') echo 'class="active-page"';?>>
                        <a href="index" <?php if ($page == 'index') echo 'class="active"';?>><i class="material-icons-two-tone notranslate">dashboard</i>Dashboard</a>
                    </li>
                    <li <?php if ($page == 'add_products' || $page == 'products' || $page == 'add_products_badge' || $page == 'add_stock' || $page == 'stocks_history') echo 'class="active-page"';?>>
                        <a href=""><i class="material-icons-two-tone notranslate">fastfood</i>Products<i class="material-icons has-sub-menu notranslate">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="add_products" <?php if ($page == 'add_products') echo 'class="active"';?>>Register Products</a>
                            </li>
                            <li>
                                <a href="products" <?php if ($page == 'products') echo 'class="active"';?>>Products</a>
                            </li>
                            <li>
                                <a href="add_products_badge" <?php if ($page == 'add_products_badge') echo 'class="active"';?>>Product Price Badge</a>
                            </li>
                            <li>
                                <a href="add_stock" <?php if ($page == 'add_stock') echo 'class="active"';?>>Add Stock</a>
                            </li>
                            <li>
                                <a href="stocks_history" <?php if ($page == 'stocks_history') echo 'class="active"';?>>Stock Buying History</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if ($page == 'register_grocery_item' || $page == 'add_grocery_bills' || $page == 'view_grocery_items' || $page == 'kitchen_grocery_items' || $page == 'grocery_history') echo 'class="active-page"';?>>
                        <a href=""><i class="material-icons-two-tone notranslate">set_meal</i>Grocery Products<i class="material-icons has-sub-menu notranslate">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="register_grocery_item" <?php if ($page == 'register_grocery_item') echo 'class="active"';?>>Register Grocery Items</a>
                            </li>
                            <li>
                                <a href="add_grocery_bills" <?php if ($page == 'add_grocery_bills') echo 'class="active"';?>>Add Grocery Bills</a>
                            </li>
                            <li>
                                <a href="view_grocery_items" <?php if ($page == 'view_grocery_items') echo 'class="active"';?>>View Grocery Items</a>
                            </li>
                            <li>
                                <a href="kitchen_grocery_items" <?php if ($page == 'kitchen_grocery_items') echo 'class="active"';?>>Kitchen Grocery Items</a>
                            </li>
                            <li>
                                <a href="grocery_history" <?php if ($page == 'grocery_history') echo 'class="active"';?>>Grocery Bills History</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if ($page == 'takeaway_invoice') echo 'class="active-page"';?>>
                        <a href="takeaway_invoice" <?php if ($page == 'takeaway_invoice') echo 'class="active"';?>><i class="material-icons-two-tone notranslate">receipt</i>Takeaway Invoice</a>
                    </li>
                    <li <?php if ($page == 'table_list' || $page == 'table_restaurant') echo 'class="active-page"';?>>
                        <a href=""><i class="material-icons-two-tone notranslate">table_restaurant</i>Restaurant Table<i class="material-icons has-sub-menu notranslate">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="table_list" <?php if ($page == 'table_list') echo 'class="active"';?>>All Restaurant Tabels</a>
                            </li>

                            <?php
                                $getRestaurantTypeSql = $conn->query("SELECT * FROM resturent_type");
                                while($grtRS = $getRestaurantTypeSql->fetch_array()){
                                    $RestaurantTypeId = $grtRS[0];
                                    $RestaurantName = $grtRS[1];
                                    $RestaurantPlace = $grtRS[2];
                            ?>
                            <li>
                                <a href="table_restaurant?t=<?php echo base64_encode($RestaurantTypeId); ?>" <?php if ($page == 'table_restaurant') echo 'class="active"';?>><?php echo $RestaurantName; ?> Restaurant</a>
                            </li>
                        <?php } ?>

                        </ul>
                    </li>
                    <li <?php if ($page == 'table_invoice_history' || $page == 'takeaway_invoice_history') echo 'class="active-page"';?>>
                        <a href=""><i class="material-icons-two-tone notranslate">inbox</i>Invoice History<i class="material-icons has-sub-menu notranslate">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="table_invoice_history" <?php if ($page == 'table_invoice_history') echo 'class="active"';?>>Table Invoice History</a>
                            </li>
                            <li>
                                <a href="takeaway_invoice_history" <?php if ($page == 'takeaway_invoice_history') echo 'class="active"';?>>Takeaway Invoice History</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="calendar.html"><i class="material-icons-two-tone notranslate">calendar_today</i>Calendar<span class="badge rounded-pill badge-success float-end">14</span></a>
                    </li>
                    <li <?php if ($page == 'todo') echo 'class="active-page"';?>>
                        <a href="todo" <?php if ($page == 'todo') echo 'class="active"';?>><i class="material-icons-two-tone notranslate">done</i>Todo</a>
                    </li>
                    <li <?php if ($page == 'today_analytics' || $page == 'alltime_analytics') echo 'class="active-page"';?>>
                        <a href=""><i class="material-icons-two-tone notranslate">trending_up</i>Analytics<i class="material-icons has-sub-menu notranslate">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="today_analytics" <?php if ($page == 'today_analytics') echo 'class="active"';?>>Today Analytics</a>
                            </li>
                            <li>
                                <a href="alltime_analytics" <?php if ($page == 'alltime_analytics') echo 'class="active"';?>>All Time Analytics</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if ($page == 'settings' || $page == 'user_accounts' || $page == 'add_resturent_type' || $page == 'manage_resturent_table' || $page == 'manage_service_charge' || $page == 'manage_product_category') echo 'class="active-page"';?>>
                        <a href="settings"><i class="material-icons-two-tone notranslate">settings_suggest</i>Settings</a>
                    </li>
                    
                    <li class="sidebar-title">
                        Other
                    </li>
                    <li>
                        <a href="#"><i class="material-icons-two-tone notranslate">bookmark</i>Documentation</a>
                    </li>
                    <li>
                        <a href="signout"><i class="material-icons-two-tone notranslate">power_settings_new</i>Log Out</a>
                    </li>
                </ul>
            </div>
        </div>