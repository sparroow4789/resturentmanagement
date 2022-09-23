 <?php

    $path = $_SERVER['PHP_SELF'];
    $page = basename($path);
    $page = basename($path, '.php');

 ?>

            <a href="#" class="content-menu-toggle btn btn-primary"><i class="material-icons">menu</i> content</a>
                <div class="content-menu content-menu-left">
                    <ul class="list-unstyled">
                        <li><a href="settings" <?php if ($page == 'settings') echo 'class="active"';?>>Account Settings</a></li>
                        <li><a href="user_accounts" <?php if ($page == 'user_accounts') echo 'class="active"';?>>User Accounts</a></li>
                        <li><a href="add_resturent_type" <?php if ($page == 'add_resturent_type') echo 'class="active"';?>>Add Resturent Type</a></li>
                        <li><a href="manage_resturent_table" <?php if ($page == 'manage_resturent_table') echo 'class="active"';?>>Manage Resturant Tables</a></li>
                        <li><a href="manage_service_charge" <?php if ($page == 'manage_service_charge') echo 'class="active"';?>>Manage Service Charge</a></li>
                        <li><a href="manage_product_category" <?php if ($page == 'manage_product_category') echo 'class="active"';?>>Manage Product Category</a></li>
                        <!-- <li><a href="#">Add Rooms</a></li>
                        <li><a href="#">Storage</a></li>
                        <li><a href="#">Control Centre</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Account Settings</a></li>
                        <li><a href="#">Saved Tickets</a></li>
                        <li><a href="#">Active Tasks</a></li>
                        <li><a href="#">My Collections</a></li>
                        <li><a href="#">Earning Reports</a></li> -->
                    </ul>
                </div>