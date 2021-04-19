<?php 
$slider = $coreModel->selectData('*', 'slider', array('status' => 'Active'));
 ?> 

 <div class="slider-area p-tb-30">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <div class="bend niceties preview-3">
                            <div id="ensign-nivoslider" class="slides">
							
							<?php 
							   foreach($slider as $key=>$v){ ?>
                                <img src="secure/<?php echo $v['image']; ?>" alt="" title="#slider-direction-<?php echo $key; ?>" />
							<?php } ?>
                            
							</div>
                           <?php 
                               foreach($slider as $key1=>$t){ ?>
                            <div id="slider-direction-<?php echo $key1; ?>" class="t-cn slider-direction">
                                <div class="slider-progress"></div>
                                <div class="slider-content t-lfl s-tb slider-1">
                                    <div class="title-container s-tb-c title-compress">
                                        <h1 class="title1"><?php echo $t['title']; ?></h1>
                                        <h2 class="title2"><?php echo $t['sub_title']; ?></h2>
                                        <div class="read-more">
                                            <a href="<?php echo $t['link']; ?>" class="button">Shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                           <?php } ?>
                           <!-- <div id="slider-direction-2" class="slider-direction">
                                <div class="slider-progress"></div>
                                <div class="slider-content t-lfl s-tb slider-2">
                                    <div class="title-container s-tb-c">
                                        <h1 class="title1">Get to up 80%</h1>
                                        <h3 class="title3">Your family is so clean - enhance immunity</h3>
                                        <div class="read-more">
                                            <a href="shop.php" class="button">shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --> 
                        </div>
                    </div>
                </div>
            </div>
        </div>