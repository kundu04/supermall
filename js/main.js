(function($) {
    "use strict";

	/*----------------------------
		Tooltip
    ------------------------------ */
    $('[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        placement: 'top',
        container: 'body'
    });
 
	/*----------------------------
		jQuery MeanMenu
    ------------------------------ */
    $(".mobile-menu-area .container nav").meanmenu();

	/*----------------------------
		wow js active
    ------------------------------ */
    new WOW().init();

    /*----------------------------
		owl active
    ------------------------------ */
    $(".owl-container").owlCarousel({
        autoPlay: false,
        items: 1,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
    });
    /*----------------------------
		bestseller
    ------------------------------ */
    $(".bestseller-owl-active").owlCarousel({
        autoPlay: false,
        items: 3,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		bestseller
    ------------------------------ */
    $(".testimonial-content-owl").owlCarousel({
        autoPlay: false,
        items: 1,
        slideSpeed: 2000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [767, 1],
        itemsMobile: [767, 1],
    });
    /*----------------------------
		bestseller
    ------------------------------ */
    $(".single-blog-area-owl").owlCarousel({
        autoPlay: false,
        items: 3,
        slideSpeed: 4000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [767, 2],
        itemsMobile: [767, 1],
    });
    /*----------------------------
		bestseller
    ------------------------------ */
    $(".single-Sale-products").owlCarousel({
        autoPlay: false,
        items: 5,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		brand
    ------------------------------ */
    $(".brand-list ul.brand-type").owlCarousel({
        autoPlay: false,
        items: 6,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 4],
        itemsTablet: [767, 3],
        itemsMobile: [767, 2],
    });
    /*----------------------------
		single product
    ------------------------------ */
    $(".single-product-owl-active ").owlCarousel({
        autoPlay: false,
        items: 1,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		single product active-home-3 
    ------------------------------ */
    $(".single-product-owl-active-home-3").owlCarousel({
        autoPlay: false,
        items: 4,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		tab-container-list-owl
    ------------------------------ */
    $(".tab-container-list-owl").owlCarousel({
        autoPlay: false,
        items: 1,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: true,
        scrollPerPage: true,
        loop: true,
        navigation: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 1],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		feature area
    ------------------------------ */
    $(".feature-area-owl-active").owlCarousel({
        autoPlay: false,
        items: 4,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		feature-area home-3
    ------------------------------ */
    $(".bestseller-owl-active-home-3").owlCarousel({
        autoPlay: false,
        items: 4,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		feature-area
    ------------------------------ */
    $(".bestseller-active-home-3").owlCarousel({
        autoPlay: false,
        items: 1,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 3],
        itemsMobile: [767, 1],
    });
    /*----------------------------
		bestseller style-4
    ------------------------------ */
    $(".bestseller-owl-active-style-4").owlCarousel({
        autoPlay: false,
        items: 4,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		hot-product style-4
    ------------------------------ */
    $(".hot-product-style-4-owl-active").owlCarousel({
        autoPlay: false,
        items: 2,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [767, 2],
        itemsMobile: [460, 1],
    });
    /*----------------------------
		Tab container
    ------------------------------ */
    $(".tab-container-owl-active").owlCarousel({
        autoPlay: false,
        items: 4,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: true,
        scrollPerPage: true,
        loop: true,
        navigation: false,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 3],
        itemsMobile: [767, 1],
    });
    /*----------------------------
		Gallery image
    ------------------------------ */
    $("#gallery_01").owlCarousel({
        autoPlay: false,
        items: 4,
        slideSpeed: 3000,
        stopOnHover: true,
        pagination: false,
        scrollPerPage: true,
        loop: true,
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [767, 3],
        itemsMobile: [767, 2],
    });
    /*-----------------------------
		Slider range
    ------------------------------*/
    $("#slider-range").slider({
        range: true,
        min: 500,
        max: 90000,
        values: [500, 70000],
        slide: function(event, ui) {
            $("#amount").val("BDT " + ui.values[0] + " - BDT " + ui.values[1]);
			$("#amount1").val(ui.values[0]);
			$("#amount2").val(ui.values[1]);
		var cat_id = $(".changeshow").attr('data-ajax');
		
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("txtHint").innerHTML = this.responseText;
				$("#ajaxContent").html(this.responseText);
            }
        };
        xmlhttp.open("GET", 'ajax_loader.php?amount1='+ui.values[0]+"&amount2="+ui.values[1]+'&'+cat_id+'&view=' + $('#view_value').val(), true);
        xmlhttp.send();
    
		
        }
    });
    $("#amount").val("BDT " + $("#slider-range").slider("values", 0) +
        " - BDT " + $("#slider-range").slider("values", 1));
    /*--------------------------------------
		Back-top
    ---------------------------------------- */
    $("#back-top").hide();
    
    $(window).on("scroll", function() {
        if ($(this).scrollTop() > 100) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
    $("#back-top").on("click", function() {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    /*--------------------------------------
		data-countdown
    ----------------------------------------*/
    $("[data-countdown]").each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<div class="box-time-date day"><div class="box-time-date-inner"><span class="time-num">%-D</span>Days</div></div> <div class="box-time-date hour"><div class="box-time-date-inner"><span class="time-num">%-H</span> Hours</div></div> <div class="box-time-date minutes"><div class="box-time-date-inner"><span class="time-num">%-M</span>Mins</div></div> <div class="box-time-date second"> <div><div class="box-time-date-inner"><span class="time-num">%-S</span>Secs</div></div>'));
        });
    });
    /*--------------------------------------
		Showcoupon toggle
    ----------------------------------------*/
    $("#showcoupon").on("click", function() {
        $("#checkout_coupon").slideToggle(900);
    });
    /*---------------------------------------
		Create an account
    ----------------------------------------*/
    $("#cbox").on("click", function() {
        $("#cbox_info").slideToggle(900);
    });
    /*--------------------------------------
		Create an account
    ----------------------------------------*/
    $("#ship-box").on("click", function() {
        $("#ship-box-info").slideToggle(1000);
    });
	/*-----------------------------------
		fancybox active
    -------------------------------------*/
    $(".fancybox").fancybox();
    /*-----------------------------------
		Elevate Zoom active
    ------------------------------------ */
    $("#zoom_03").elevateZoom({
        constrainType: "height",
        zoomType: "lens",
        containLensZoom: true,
        gallery: "gallery_01",
        cursor: "pointer",
        galleryActiveClass: "active"
    });
	/*-------------------------------------
		pass the images to Fancybox
    ---------------------------------------*/
    $("#zoom_03").on("click", function(e) {
        var ez = $("#zoom_03").data("elevateZoom");
        $.fancybox(ez.getGalleryList());
        return false;
    });
    /*------------------------------------
		showlogin toggle function
    --------------------------------------*/
    $("#showlogin").on("click", function() {
        $("#checkout-login").slideToggle(900);
    });
	/*-------------------------
		cart-plus-minus-button
    --------------------------*/
    $(".cart-plus-minus").append('<div class="dec qtybutton">-</i></div><div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });
	/*-------------------------
		Social button share
    --------------------------*/
    $("#share").jsSocials({
        shares: ["twitter", "facebook", "googleplus", "linkedin", "pinterest", ]
    });

})(jQuery);