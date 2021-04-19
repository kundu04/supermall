    
    <!-- all js here -->
    <!-- jquery latest version -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- owl.carousel js -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- meanmenu js -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- jquery-ui js -->
  
    <!-- nivo slider js -->
    <script src="slider/js/jquery.nivo.slider.js"></script>
    <script src="slider/home.js"></script>
    <!-- wow js -->
    <script src="js/wow.min.js"></script>
    <!-- countdown js -->
    <script src="js/countdown.js"></script>
    <!-- fancybox js -->
    <script src="js/jquery.fancybox.pack.js"></script>
    <!-- elevateZoom js -->
    <script src="js/jquery.elevateZoom-3.0.8.min.js"></script>
    <!-- plugins js -->
    <script src="js/plugins.js"></script>
    <!-- main js -->
    <script src="js/main.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <script>  
    // Quick view
    $(document).ready(function(){
        $(".quick-view").click(function(){
            var product_id = $(this).attr('product-id');

            $.ajax({
                type: "GET",
                url: "secure/ajax_loader.php",
                data:{quick_view:product_id}
            }).done(function(response){
               $("#modal-body").html(response);
            });
        });
		
		$(".star-1").click(function(){
            var rating = $(this).attr('data-rating');
            $("#rating_value").val(rating);
        });
    });
	
    </script>
	
	<script>  
    // Cart popup
    $(document).ready(function(){
        $(".cartpopup").click(function(){
            var product_id = $(this).attr('product-id');

            $.ajax({
                type: "GET",
                url: "secure/ajax_loader.php",
                data:{cart_popup:product_id}
            }).done(function(response){
               $("#cart-body").html(response);
            });
        });
    });
	</script>
	
	<script>
	// Wishlist add
	$(document).ready(function(){
        $(".addwishlist").click(function(){
            var product_id = $(this).attr('pro');

            $.ajax({
                type: "GET",
                url: "secure/ajax_loader.php",
                data:{pro_id:product_id}
            }).done(function(response){
				if(response=='Success')
                        alert('Successfully added to Wishlist');
				else {
					window.location = 'login.php';
				}
            });
        });
    });
	
    </script>

     <script>  
    //Auto Search
    $(document).ready(function(){
		$("#search").autocomplete({
			source: "auto_search.php",
			minLength: 2,
			select: function( event, ui ) {
            
			}
		});
    });
	
	</script>
	
	<script> 
	//Ajax addToCart
	
	function addToCart(proId, proQnt=0, price, proColor='0', proSize='0'){
		var flagC = 0;
		var mgsC = '';
		var flagS = 0;
		var mgsS = '';
		
		if(proQnt == 0){
			
			var qnt = $('#proQnt').val();
		
		}else{
			var qnt = proQnt;
		}
		
		if(proColor != '0'){
			
			proColor = $("#color").val();
			if(proColor == "" || proColor == 'undefined'){
				 var mgsC = "Please select Color";
				 flagC = 1;
			 }		
		}else{
				proColor = ""; 
		}
		
		if(proSize != '0'){
			proSize = $("#size").val();
			 if(proSize == "" || proSize == 'undefined' ){
				 var mgsS = "Please select Size";
				 flagS = 1;
			 }	
		}else{
				proSize = "";
		}
		
		if(flagC == 0 && flagS == 0){
	    
		var data = 'proId=' + proId + "&qnt=" + qnt+ "&price=" + price + "&colorID="+proColor + "&sizeID="+proSize;
	        
				$.ajax({
					type: "GET",
					url: "ajax_cart.php",
					data:data
				}).done(function(response){
						getSubtotal();
					$("#mini-cart-body").html(response);
				});
			
			$("#showmsgC").html(mgsC);
			$("#showmsgS").html(mgsS);
			$('#cartpopup').modal('hide');
			$('#productModal').modal('hide');	
		
		}else{
				$("#showmsgC").html(mgsC);
				$("#showmsgS").html(mgsS);
		}
		
	}
	
	//addToCart Subtotal
	function getSubtotal(setCartUpdatePage=0){
		$.ajax({
                type: "GET",
                url: "ajax_subtotal.php",
                data:{}
            }).done(function(response){
			   var data = response.split('@');
			   $('#mini-cart-subtotal').html(data[0]);
			   $('#mini-cart-items').html(data[1]);
			   if(setCartUpdatePage==1){
				   $('#mini-cart-subtotal-cartpage').html(data[0]);
			   }
             
            });
	}
	//removeCart
	function removeCart(proID){
		
		var data = 'proId=' + proID;
	        $.ajax({
                type: "GET",
                url: "ajax_cart_remove.php",
                data:data
            }).done(function(response){
				    getSubtotal();
               $("#mini-cart-body").html(response);
            });
			
			$.ajax({
                type: "GET",
                url: "ajax_shop_cart_remove.php",
                data:data
            }).done(function(response){
				    getSubtotal();
               $("#shop-cart-body").html(response);
            });	
	}
	
	
	function update_cart(){

		 var data = $("#frm_cart").serialize();

               $.ajax({
					type: "POST",
					url: "ajax_cart_update.php",
					data:data
				}).done(function(response){
				   getSubtotal(1);
						
					$("#mini-cart-body").html(response);
		
				});
	}
	
	function setSum(id){
		
		var qnt = parseInt($('#qnt'+id).val());
		var amount = parseFloat($('#amount_1'+id).html());
		$('#subtotal'+id).html(amount*qnt);
	
	}
	
	//Cart Coupon
	function getCoupon(){

		var coupon = $("#coupon_code").val();
		
		var data = 'coupon=' + coupon;
		
	        $.ajax({
                type: "GET",
                url: "ajax_coupon.php",
                data:data
            }).done(function(response){
				  
				  if(response > 0){
					  
                $("#coupon_amount").html(response);
			    var grand_total = parseFloat($('#mini-cart-subtotal-cartpage').html()) - parseFloat(response);
				$('#grand_total').html(grand_total.toFixed(2));
				$('#coupon_msg').html("Coupon Amount Added");
				
				  }
				 else{
					 $('#coupon_msg').html("Invalid Coupon Code");
				 }
            });
			
	
	}
	
	function setShipping(value){
		
		    var grand_total = parseFloat($('#grand_total').html()) + parseFloat(value);
			$('#grand_total_show').html(grand_total.toFixed(2));
			$('#amount_1').html(grand_total.toFixed(2));	
		
	}
	</script>
	
	<script>
$(document).ready(function(){
        $("#country").change(function(){
            var country_id = $("#country").val();
            $.ajax({
                type: "GET",
                url: "secure/ajax_loader.php",
                data:{get_cityList:country_id}
            }).done(function(data){
			   $("#city").html(data);
            });
        });
		
		$("#ship_country").change(function(){
            var scountry_id = $("#ship_country").val();
            $.ajax({
                type: "GET",
                url: "secure/ajax_loader.php",
                data:{get_ship_cityList:scountry_id}
            }).done(function(data){
			   $("#ship_city").html(data);
            });
        });
    });
</script>
<script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=40498758"></script>