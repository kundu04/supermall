<?php include("config.php") ?>

<?php 
if(isset($_REQUEST['get_ship_address'])){
	
	if($_REQUEST['get_ship_address'] == 'existing'){
	
	$cust_id = $_SESSION['cust_id'];
	$custDetails = $myModel->customQuery("SELECT customer.* FROM customer WHERE customer_id = '$cust_id'");
		foreach ($custDetails AS $customer);
	
	$custLocation = $myModel->customQuery("SELECT country.country_id, country.name as countryName, city.city_id, city.name as cityName FROM customer, country, city WHERE customer.customer_id = '$cust_id' AND customer.country_id = country.country_id AND customer.city_id = city.city_id");
	
		foreach($custLocation AS $custArea);

?>
									<div class="form-group ">
                                        <label class="control-label" for="name">Full Name <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input class="form-control" id="name" name="ship_name" value="<?php echo $customer['cust_name']; ?>" type="text"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-user">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="phone">Mobile <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input  class="form-control" id="phone" name="ship_phone" value="<?php echo $customer['phone']; ?>" type="text" placeholder="Enter mobile number"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-phone">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="address">Address <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input class="form-control" id="address" name="ship_address" value="<?php echo $customer['address']; ?>" type="text" placeholder="Enter address" />
                                          <div class="input-group-addon">
                                          <i class="fa fa-location-arrow">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="control-label" for="country">Country <span class="star">*</span>
                                        </label>
                                        <select class="select form-control" id="country" name="ship_country">
                                          <option value="">Select country</option>
							
							<?php 
							$countryAll = $myModel->customQuery("SELECT * FROM country WHERE status = 1");
								
								foreach ($countryAll as $countryList) { ?>
										
											<option value="<?php echo $countryList['country_id']?>" <?php if(@$custArea['country_id']==$countryList['country_id']){ echo "selected='selected'"; } ?>><?php echo $countryList['name']?></option>
							
							<?php }	?>            
                                        </select>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="city">City <span class="star">*</span>
                                        </label>
                                        <select  class="select form-control" id="city" name="ship_city">
                                          
                                          <option value="<?php echo @$custArea['city_id']; ?>"><?php if(@$custArea['cityName'] != null) {echo $custArea['cityName'];}else{ echo 'Select City'; } ?></option>
										  
                                        </select>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="zipcode">Zip code <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input class="form-control" id="zipcode" name="ship_zipcode" value="<?php echo $customer['zipcode']; ?>" type="text" placeholder="Enter Zip Code"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-sort-numeric-desc">
                                          </i>
                                          </div>
                                        </div>
                                      </div>
	<?php } else{ ?>
									
									<div class="form-group ">
                                        <label class="control-label" for="name">Full Name <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="name" name="ship_name" type="text" placeholder="Enter full name"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-user">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="phone">Mobile <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input class="form-control" id="phone" name="ship_phone"  type="text" placeholder="Enter mobile number" required />
                                          <div class="input-group-addon">
                                          <i class="fa fa-phone">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="address">Address <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input class="form-control" id="address" required name="ship_address" type="text" placeholder="Enter address" />
                                          <div class="input-group-addon">
                                          <i class="fa fa-location-arrow">
                                          </i>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="control-label" for="country">Country <span class="star">*</span>
                                        </label>
                                        <select class="select form-control" id="ship_country" name="ship_country" required>
                                          <option value="">Select country</option>
							
							<?php 
							$countryAll = $myModel->customQuery("SELECT * FROM country WHERE status = 1");
								
								foreach ($countryAll as $countryList) { ?>
										
											<option value="<?php echo $countryList['country_id']?>" ><?php echo $countryList['name']?></option>
							
							<?php }	?>            
                                        </select>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="city">City <span class="star">*</span>
                                        </label>
                                        <select class="select form-control" id="ship_city" name="ship_city" required>
                                          
                                         										  
                                        </select>
                                      </div>

                                      <div class="form-group ">
                                        <label class="control-label" for="zipcode">Zip code <span class="star">*</span>
                                        </label>
                                        <div class="input-group">
                                          <input required class="form-control" id="zipcode" name="ship_zipcode" type="text" placeholder="Enter Zip Code"/>
                                          <div class="input-group-addon">
                                          <i class="fa fa-sort-numeric-desc">
                                          </i>
                                          </div>
                                        </div>
                                      </div>
									  
	<?php } ?>
	
	

	
<?php } ?>
<script>
$(document).ready(function(){
        
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