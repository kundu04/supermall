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
		
		<?php 

        if(isset($_POST['sendMsg'])){   
            
            if ($_POST['name'] != '' && $_POST['email'] != '' && $_POST['subject'] != '' && $_POST['message'] != '') {
                            
                # CONFIGURE THE MAIL SETTINGS / CHECKING FROM YOUR cPANEL
                $mailConfig['host'] = MAIL_HOST_1;
                $mailConfig['port'] = MAIL_PORT_1;
                $mailConfig['email'] = OUTGOING_MAIL_ID_1;
                $mailConfig['pass'] = OUTGOING_MAIL_PASS_1;
                $mailConfig['name'] = "Supermall";
                $mailConfig['type'] = "text/html"; // "text/html";
                
                # PREPARE YOUR MAIL
								
                $mailDetails['title'] = "Received an Inquiry from Supermall";
				$mailDetails['body'] = "You have received an Inquiry from <strong>".$_POST['name']."</strong><br /><br />Email: ".$_POST['email']."<br /><br />Subject: ".$_POST['subject']."<br /><br />Message: ".$_POST['message']."";
				                
                # PREPARE YOUR RECEIVERS
                $mailReceiver = "snk.kundu@gmail.com";
                # SEND THE MAIL
                $mailResult = $coreControl->smtpMail($mailConfig, $mailDetails, $mailReceiver);
								
				if($mailResult){
					
					$_SESSION['mgs'] = '<div class="alert alert-success fade in">
								<button type="button" class="close close-sm" data-dismiss="alert">
									<i class="fa fa-times"></i></button>
									Your message has been sent successfully !
							</div>';
				}
                
						
			}else{
				$_SESSION['mgs'] = '<div class="alert alert-danger fade in">
								<button type="button" class="close close-sm" data-dismiss="alert">
									<i class="fa fa-times"></i></button>
								<center>Please fillup all required field before submit !</center>
						</div>';
			}
			
            
		}
		?>
        
    
    <div class="container">
        <div class="row">
            <div class="main">
                <div class="col-md-8 col-md-offset-2">
                    <div class="contact-page-content">
                        <div class="contact-page-title">
                            <h1>Contact Us</h1>
                        </div>
						<?php if(isset($_SESSION['mgs'])){ echo $_SESSION['mgs']; } ?>
                        <form id="contactForm" action="" method="POST">
                            <div class="fieldset">
                                <h2 class="legend">Contact Information</h2>
                                <ul class="form-list">
                                    <li class="fields">
                                        <div class="field left">
                                            <label class="required" for="name">
                                                <em>*</em>name
                                            </label>
                                            <div class="input-box">
                                                <input required id="name" name="name" class="input-text required-entry" placeholder="Your Name" type="text">
                                            </div>
                                        </div>
                                        <div class="field right">
                                            <label class="required" for="email">
                                                <em>*</em>Email
                                            </label>
                                            <div class="input-box">
                                                <input required id="email" name="email" class="input-text required-entry" placeholder="Your Email" type="text">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <label class="required" for="subject"><em>*</em>Subject</label>
                                        <div class="input-box">
                                            <input required id="subject" name="subject" class="input-text required-entry" placeholder="Your Subject" type="text">
                                        </div>
                                    </li>
                                    <li class="wide">
                                        <label class="required" for="message">
                                            <em>*</em>Message
                                        </label>
                                        <div class="input-box">
                                            <textarea  class="required-entry input-text" id="message" title="message" name="message" placeholder="Your Message"></textarea>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="buttons-set">
                                <p class="required">* Required Fields</p>
                                <button class="button" type="submit" name="sendMsg">
                                    <span>
                                        <span>Submit</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="map-contacts">
        <div id="googleMap"></div>
    </div><br>

    <!-- Start footer content -->
    <?php include('views/footer.php'); ?>
    <!-- End footer content area -->
    <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
    <!--end-wrapper-->

	<?php unset($_SESSION['mgs']); ?>
	
    <?php include('views/footer-script.php'); ?>
    <!-- Google Map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuU_0_uLMnFM-2oWod_fzC0atPZj7dHlU"></script>
    <script>
        function initialize() {
            var mapOptions = {
                zoom: 15,
                scrollwheel: false,
                center: new google.maps.LatLng(51.5073509, -0.12775829999998223)
            };

            var map = new google.maps.Map(document.getElementById('googleMap'),
                mapOptions);


            var marker = new google.maps.Marker({
                position: map.getCenter(),
                animation: google.maps.Animation.BOUNCE,
                icon: 'img/icon/map.png',
                map: map
            });

        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

</body>
</html>