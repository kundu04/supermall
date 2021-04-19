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
        
        <!--Start page area -->
        <section class="main-content">
            <div class="container">
                <div class="main not-found-page-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="std">
                                <div class="page-not-found">
                                    <div class="page-title">
                                        <h1>Not Found !</h1>
                                    </div>
                                    <div class="page-content">
                                        <div class="page-desc">
                                            <p>You know what that means? It means the page you're looking for isn't here.</p>
                                            <h1 class="back-home"><a href="index.php">back to home</a></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End page area -->
        
        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
        <!-- End-->
    </div>
    <?php include('views/footer-script.php'); ?>
</body>
</html>