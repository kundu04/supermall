<?php include ('views/header-script.php'); ?>
</head>
<body>
    <div class="wrapper">
        <!-- Start header area -->
        <header id="header" class="header-area">
            <?php include('views/header-top.php') ?>

            <!-- start main-menu area -->
            <?php include 'views/main-menu.php'; ?>

            <!-- Start mobile menu -->
            <?php include('views/mobile-menu.php'); ?>
        </header>
        <!-- End header area -->
        
        <!-- entry-header-area start -->
        <div class="entry-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="entry-header"><br>
                            <h1 class="entry-title">Order History</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- entry-header-area end -->
        <!-- cart-main-area start -->
        <div class="cart-main-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product Name</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-subtotal">Status</th>
                                        <th class="product-remove">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="#"><img src="img/product/product-img/23_2.jpg" alt="" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">Vestibulum suscipit</a></td>
                                        <td class="product-price"><span class="amount">£165</span></td>
                                        <td class="product-quantity">1</td>
                                        <td class="product-subtotal">£165</td>
                                        <td class="product-subtotal">Paid</td>
                                        <td class="product-remove"><a title="View" href="#"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="#"><img src="img/product/product-img/3_1.jpg" alt="" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">Vestibulum dictum magna</a></td>
                                        <td class="product-price"><span class="amount">£50</span></td>
                                        <td class="product-quantity">2</td>
                                        <td class="product-subtotal">£100</td>
                                        <td class="product-subtotal">Unpaid</td>
                                        <td class="product-remove"><a title="View" href="#"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->

        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    </div>

    <?php include('views/footer-script.php'); ?>
</body>
</html>