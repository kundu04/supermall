<?php 
$tableName = "category";
$columnName = "*";
$whereValue["parent_id"] = 0;
$queryResult = $coreModel->selectData($columnName, $tableName, $whereValue);
?>

<!--Start header top area -->
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="box-right">
                            <ul><li>
                                <div class="language-currency">
                                <div class="form-language">
                                    <div class="select-lang"> 
                                    <?php 
                                    if (!empty($_SESSION['cust_name'])) {
                                        echo '<a onclick="return false;" href=""> '.$_SESSION["cust_name"].'</a>';
                                    }else{
                                        echo '<a title="Login or Register" href="login.php"><i class="fa fa-user"></i></a>';
                                    }
                                    ?> 
                                    </div>
                                    <?php 
                                    if (!empty($_SESSION['cust_name'])) {
                                        echo 
                                        '<ul class="select-option">
                                            <li><a href="profile.php">Profile</a></li>
                                            <li><a href="change-password.php">Setting</a></li>
                                            <li><a href="address.php">Address Book</a></li>
                                            <li><a href="orders.php">Orders</a></li>
                                            <li><a href="?logout=yes">Logout</a></li>
                                        </ul>';
                                    }else{}
                                    ?>
                                </div>
                            </div>
                            </li>
                                <li><a title="Wishlist" href="wishlist.php"><i class="fa fa-heart"></i></a></li>
                                <li><a title="Shopping Cart" href="shopping-cart.php"><i class="fa fa-cart-arrow-down"></i></a></li>
                                <li><a title="Checkout" href="checkout.php"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End header top area -->
        <!-- start header mid area -->
        <div class="header-mid-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <div class="logo-container">
                            <div class="logo-area">
                                <a class="logo" href="index.php"><img src="img/logo/logo.png"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                        <div class="header-bottom">
                            <div class="quick-access">
                                <form action="search.php" method="get">
                                    <div class="form-search">                                    
                                        <input required id="search" name="search" class="input-text" type="text" placeholder="Search products..." />
                                        <button class="button" title="Search" type="submit">
                                            <span>
                                                <span>Search</span>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header mid area