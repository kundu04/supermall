<?php include ('views/header-script.php'); ?>
<!--Start Code for category option with pagination-->
<?php 
if(isset($_GET['search'])){
	
	$search_word = mysql_escape_string($_GET['search']);

}
?>


<style>
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

</style>
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
        
        <!-- start page area -->
        <section class="page-content">
            <div class="main-content mb-30 main-content-2">
                <!-- breadcrumbs area -->
                <div class="breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="breadcrumb-inner">
                                    <ul>
                                        <li class="home"><a title="Go to Home Page" href="#">home</a><span></span></li>
                                        
                                        <li class="last"><strong>headphone</strong></li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end breadcrumbs area -->
                <div class="container">
                    <div class="main">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <!--start breadcrumbs area -->
                                <div class="block block-layered-nav">
                                    <div class="block-title">
                                        <strong><span>Shop By</span></strong>
                                    </div>
                                    <div class="block-content">
                                        <div class="narrow-by-list">
                                            <div class="layered layered-Category">
                                                <h2>Category</h2>
                                                <div class="content-shopby">
                                                    <ul>
                                                        <?php 
														
														$catListSidebar = $myModel->customQuery("
														SELECT pc.category_id, c.cat_name, count(p.product_id) as total
														FROM product as p 
														left join product_to_category as pc
															ON p.product_id = pc.product_id 
														left join category as c
															ON pc.category_id = c.category_id 
														left join product_description as pd 
															ON p.product_id = pd.product_id	
														WHERE  pd.name LIKE '%$search_word%' AND p.status='Active' 
														GROUP BY pc.category_id");  
														
														
														foreach($catListSidebar as $catList) { 
														
														?> 
                                                                                                          
                                                        <li>
															<a href="javascript:void(0)" class="search_catId" catId="<?php echo $catList["category_id"];?>"><?php echo $catList['cat_name']; ?></a>(<?php echo $catList['total']; ?>)
														
														</li>

														<?php } ?>
														<input type="hidden" id="setcatId" value=""/>
                                                    </ul>
                                                </div>
                                            </div>
                                            
											<!--Start Brand Sidebar -->
											<?php 
											

                                            $brands = $myModel->customQuery("
											SELECT p.manufacturer_id, count(p.product_id) as total, m.brand_name as brand 
											FROM product as p 
                                            left join manufacturer as m 
												ON p.manufacturer_id = m.manufacturer_id 
											left join product_description as pd 
												ON p.product_id = pd.product_id	
                                            WHERE  pd.name LIKE '%$search_word%' AND p.status='Active' 
											GROUP BY manufacturer_id 
											ORDER BY brand");  
											
											
											
                                            ?>
											
											<?php if(count($brands) > 0){ ?>
                                            
											<div class="layered layered-Category">
                                                <h2>Brand</h2>
                                                <div class="content-shopby">
                                                    <ul>                                                        
                                                        <?php foreach($brands as $brand){ ?>    
                                                           <li>
																<a href="javascript:void(0)" class="search_brandId" brandId="<?php echo $brand['manufacturer_id']; ?>">
																
																<?php if($brand['manufacturer_id'] == 0 ) { echo 'No-Brand';}else{ echo $brand['brand'];} ?>
																
																</a>
																(<?php echo $brand['total']; ?>)
															</li>			
                                                        <?php } ?>
														<input type="hidden" id="setbrandId" value=""/>
                                                    </ul>                                                  
                                                </div>
                                            </div>
                                            <?php } ?>                                            
                                            
											<!--End Brand Sidebar -->
                                            
											<!--Start Color Sidebar -->
                                            <?php 
											$productsId = $myModel->customQuery("
											SELECT p.product_id 
											FROM product as p 
											left join product_description as pd 
												ON p.product_id = pd.product_id	
											WHERE  pd.name LIKE '%$search_word%' AND p.status='Active'");
													
											$col = array();													
											foreach($productsId as $value){
												$proId = $value['product_id'];
												$proColor = $myModel->customQuery("SELECT color.* FROM color
												LEFT JOIN product_color ON color.color_id = product_color.color_id 
												WHERE product_id = $proId");	
												foreach($proColor as $value){
												$col[] = array('color_name'=>$value['color_name'], 'color_id'=>$value['color_id']);
												}
											}													
											$serialize = array_map("serialize", $col);
													
											$count = array_count_values ($serialize);
											$colorArray = array_unique($serialize);

											foreach($colorArray as &$u){
												$u_count = $count[$u];
												$u = unserialize($u);
												$u['count'] = $u_count;
											}
											asort($colorArray);?>
											
											<?php if(count($colorArray) > 0){ ?>
                                            
											<div class="layered layered-brand">
                                                <h2>Color</h2>
                                                <div class="content-shopby">												
													<ul>                                                       
                                                    
													<?php foreach($colorArray as $color){ ?>    
														<li>
															<a href="javascript:void(0)" class="search_colorId" colorId="<?php echo $color['color_id']; ?>">
																												
															<?php echo $color['color_name']; ?>
															</a>
															
															(<?php echo $color['count']; ?>)
														</li>
                                                    <?php } ?>
													<input type="hidden" id="setcolorId" value=""/>
                                                    
													</ul>                                                  
                                                </div>
                                            </div>
											
											<?php } ?>
											
                                            <!--End Color Sidebar -->
                                            
											<!--Start Size Sidebar -->
                                            <?php
											$siz = array();													
											foreach($productsId as $value){
											$proId = $value['product_id'];
											$proSize = $myModel->customQuery("SELECT size.* FROM size
											LEFT JOIN product_size ON size.size_id = product_size.size_id 
											WHERE product_id = $proId");	
												foreach($proSize as $value){
												$siz[] = array('size_name'=>$value['size_name'], 'size_id'=>$value['size_id']);
												}
											}													
											$serialize = array_map("serialize", $siz);
											$count     = array_count_values ($serialize);
											$sizeArray    = array_unique($serialize);

											foreach($sizeArray as &$u){
												$u_count = $count[$u];
												$u = unserialize($u);
												$u['count'] = $u_count;
											}
											asort($sizeArray);?>
											
											<?php if(count($sizeArray) > 0){ ?>
											
											<div class="layered layered-brand">
                                                <h2>Size</h2>
                                                <div class="content-shopby">                                                
													<ul>                                                       
                                                    
													<?php foreach($sizeArray as $size){ ?>    
														<li>
															<a href="javascript:void(0)" class="search_sizeId" sizeId="<?php echo $size['size_id'];?>">
															
															<?php echo $size['size_name']; ?>
															</a>
															(<?php echo $size['count']; ?>)
														</li>
                                                    <?php } ?>
                                                    <input type="hidden" id="setsizeId" value=""/>
													</ul>                                                   
                                                </div>
                                            </div>
											
											<?php } ?>											
                                            <!--End Size Sidebar -->
											
											<!--Start Price range Sidebar -->
                                            <div class="layered layered-price" style="padding-top:15px">
                                                <h2>Price Range</h2>
                                                <div class="content-shopby">
                                                    <div class="amount">                                             
                                                        <input type="text" id="amount" name="amount" readonly style="border:0; font-weight:500;">
                                                    </div>
                                                    <div id="slider-range" style="margin-bottom: 10px"></div>
                                                </div>
                                            </div>											
											<!--End Price range Sidebar -->
											
                                        </div>
                                    </div>                                    
                                </div>
                                <!--end breadcrumbs area -->
                                
                                <!--start block list-->
                                <div class="block block-list block-compare">
                                    <div class="block-title">
                                        <strong>
                                            <span>Compare</span>
                                        </strong>
                                    </div>
                                    <div class="block-content">
                                        <p class="empty">You have no items to compare.</p>
                                    </div>
                                </div>
                                <!--end block list-->
                                
                            </div>
                            <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                               
								<!--Searching word -->
								<h3>Searching : <span style="color: #f45c5d;"><?php echo @$search_word; ?></span></h3>
								<h4>Filter by:  <span class="label label-warning" id="catName"></span>
												<span class="label label-warning" id="brandName"></span>
												<span class="label label-warning" id="colorName"></span><span id="sizeName"></span>
											</h4>
								
								<div class="product-view-mode">
									<div class="product-option">
										<div class="row">
											<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
												<!-- Nav tabs -->
												<div class="floatleft tabviewport">
													<ul class="view-mode-menu clearfix">
														<li class="active">
															<a href="#grid" class="view" aria-controls="grid" data-toggle="tab">
																<i title="grid"  class="fa fa-th-large "></i>
															</a>
														</li>
														<li>
															<a href="#list" class="view" aria-controls="list" data-toggle="tab">
																<i title="list" class="fa fa-list"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>
											<div class="col-md-4  col-sm-4 col-lg-4 col-xs-12">
												<div class="sort-by floatright">
													<label>Sort By:</label>
													<select  class="cust-select-1 changessort" >
													   <option selected="selected" value="">Position</option>
													   <option value="asc-name">A-Z</option>
													   <option value="desc-name">Z-A</option>
													   <option value="desc-price">High - Low</option>
													   <option value="asc-price">Low - High</option>
												   </select>
													<div class="custm-select-icon">
														<a title="Set Descending Direction" href="#">
															<img src="img/icon/gif-img/i_asc_arrow.gif" alt="">
														</a>
													</div>
												</div>
											</div>
											<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
												<div class="sort-by floatright">
													<label>Show:</label>
													<select class="cust-select-1 changeshow" >
													   <option selected="selected" value="9">9</option>
													   <option value="3">3</option>
													   <option value="24">24</option>
													   <option value="36">36</option>
												   </select>
												</div>
											</div>
										</div>

									</div>
									

									<!-- Tab panes -->
									<div class="loader" id="loading" style="display:none"></div>
									
									<!-- PRODUCT VIEW -->
									<div id="product_view"></div>
									<!--  PRODUCT VIEW -->
									
								</div>
								<!--End product-view-mode -->

								<!--end buttom toolbar  -->

								
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start footer content -->
        <?php include('views/footer.php'); ?>
        <!-- End footer content area -->
        <div class="hidden-xs" id="back-top"><i class="fa fa-angle-up"></i></div>
		
        <!-- end wrapper-->
    </div>
    <!-- QUICKVIEW PRODUCT -->
    <?php include('views/quick-view.php') ?>
    <!-- END QUICKVIEW PRODUCT -->
    <input type="hidden" id="view_value" value="grid" />
    <?php include('views/footer-script.php'); ?>
	<input type="hidden" id="amount1" value="0" />
	<input type="hidden" id="amount2" value="0" />

	<script type="text/javascript">
$(document).ready(function(){
   
	
	var search_word = '<?php echo $search_word;?>';
	$("#loading").show();
	$("#product_view" ).load("ajax_search.php",{"keyword":search_word},function(){$("#loading").hide();});
	
	$(".changessort").change(function(){
		var position = $('.changessort').val();
		filterData(position, '0', '0', '0', '0', '0');
	});
	
	$(".changeshow").change(function(){
		var show = $('.changeshow').val();
		filterData('0', show, '0', '0', '0', '0');
    });
	
	$(".search_brandId").click(function(){
		var brandId = $(this).attr('brandId');
		var brandName = $(this).text();
		$('#setbrandId').val(brandId);
		$('#brandName').text(' Brand-'+brandName);
        filterData('0', '0', brandId, '0', '0', '0');
    });
	
	$("#brandName").click(function(){
		var brandId = '';
		$('#setbrandId').val(brandId);
        filterData('0', '0', brandId, '0', '0', '0');
		$(this).text('');
    });
	
	$(".search_colorId").click(function(){
		var colorId = $(this).attr('colorId');
		var colorName = $(this).text();
		$('#setcolorId').val(colorId);
		$('#colorName').text(' Color-'+colorName);
        filterData('0', '0', '0', colorId, '0', '0');
    });
	
	$("#colorName").click(function(){
		var colorId = '';
		$('#setcolorId').val(colorId);
         filterData('0', '0', '0', colorId, '0', '0');
		$(this).text('');
    });
	
	$(".search_sizeId").click(function(){
		var sizeId = $(this).attr('sizeId');
		var sizeName = $(this).text();
		$('#setsizeId').val(sizeId);
		$('#sizeName').text(' Size-'+sizeName);
        filterData('0', '0', '0', '0', sizeId, '0');
    });
	
	$("#sizeName").click(function(){
		var sizeId = '';
		$('#setsizeId').val(sizeId);
        filterData('0', '0', '0', '0', sizeId, '0');
		$(this).text('');
    });
	
	$(".search_catId").click(function(){
		var catId = $(this).attr('catId');
		var catName = $(this).text();
		$('#setcatId').val(catId);
		$('#catName').text(' Category-'+catName);
       filterData('0', '0', '0', '0', '0', catId);
    });
	
	$("#catName").click(function(){
		var catId = '';
		$('#setcatId').val(catId);
        filterData('0', '0', '0', '0', '0', catId);
		$(this).text('');
    });
	
	
	function filterData(position, show, brandId, colorId, sizeId, catId){
		
		$("#loading").show();
		
		if(position=='0'){
			var position = $('.changessort').val();
		} 
        if(show=='0'){
			var show = $('.changeshow').val();
		}
		if(brandId=='0'){
			var brandId = $('#setbrandId').val();
		}
		if(colorId=='0'){
			var colorId = $('#setcolorId').val();
		}
		if(sizeId=='0'){
			var sizeId = $('#setsizeId').val();
		}
		if(catId=='0'){
			var catId = $('#setcatId').val();
		}
	
		$.ajax({  
			 url:"ajax_search.php",  
			 method:"POST",  
			 data:{"keyword":search_word, "position":position, "sort":show, "brandId":brandId, "color_id":colorId, "size_id":sizeId, "cat_id":catId},  
			 success:function(data){  
				  $("#product_view").html(data);  
				  $("#loading").hide(); 
			 }  
		});
		
		
	}
	
	
});


</script>
  
</body>
</html>