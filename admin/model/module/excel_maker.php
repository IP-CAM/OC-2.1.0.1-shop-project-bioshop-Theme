<?php
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
static $registry = NULL;

// Error Handler
function error_handler_for_export($errno, $errstr, $errfile, $errline) {
	global $registry;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}
	
	$config = $registry->get('config');
	$url = $registry->get('url');
	$request = $registry->get('request');
	$session = $registry->get('session');
	$log = $registry->get('log');
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	if (($errors=='Warning') || ($errors=='Unknown')) {
		return true;
	}

	if (($errors != "Fatal Error") && isset($request->get['route']) && ($request->get['route']!='tool/export/download'))  {
		if ($config->get('config_error_display')) {
			echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
		}
	} else {
		$session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
		$token = $request->get['token'];
		$link = $url->link( 'tool/export', 'token='.$token, 'SSL' );
		header('Status: ' . 302);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $link));
		exit();
	}

	return true;
}


function fatal_error_shutdown_handler_for_export()
{
	$last_error = error_get_last();
	if ($last_error['type'] === E_ERROR) {
		// fatal error
		error_handler_for_export(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
	}
}


class ModelModuleExcelMaker extends Model {

	private $error = array();
	private $value = array();
	private $settings = array();


	function clean( &$str, $allowBlanks=FALSE ) {
		$result = "";
		$n = strlen( $str );
		for ($m=0; $m<$n; $m++) {
			$ch = substr( $str, $m, 1 );
			if (($ch==" ") && (!$allowBlanks) || ($ch=="\n") || ($ch=="\r") || ($ch=="\t") || ($ch=="\0") || ($ch=="\x0B")) {
				continue;
			}
			$result .= $ch;
		}
		return $result;
	}


	function multiquery( &$database, $sql ) {
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);
			if ($sql) {
				$database->query($sql);
			}
		}
	}


	protected function getDefaultLanguageId( &$database ) {
		$code = $this->config->get('config_language');
		$sql = "SELECT language_id FROM `".DB_PREFIX."language` WHERE code = '$code'";
		$result = $database->query( $sql );
		$languageId = 1;
		if ($result->rows) {
			foreach ($result->rows as $row) {
				$languageId = $row['language_id'];
				break;
			}
		}
		return $languageId;
	}


	protected function getDefaultWeightUnit() {
		$weightUnit = $this->config->get( 'config_weight_class' );
		return $weightUnit;
	}


	protected function getDefaultMeasurementUnit() {
		$measurementUnit = $this->config->get( 'config_length_class' );
		return $measurementUnit;
	}



	protected function detect_encoding( $str ) {
		// auto detect the character encoding of a string
		return mb_detect_encoding( $str, 'UTF-8,ISO-8859-15,ISO-8859-1,cp1251,KOI8-R' );
	}
	
        function uploadPrice( $reader, $database, $startRow ){
		         // find the default language id and default units
		         $languageId = $this->getDefaultLanguageId($database);
		         $defaultWeightUnit = $this->getDefaultWeightUnit();
		         $defaultMeasurementUnit = $this->getDefaultMeasurementUnit();
		         $defaultStockStatusId = $this->config->get('config_stock_status_id'); 
		         $data = $reader->getSheet(0); 
                 $firstRowTemp = $this->session->data['column_name'];			 
		         $k = 1;				 
		         $firstColumn = array();
				 $nameColumn = array();
				 $firstRow = array();
				 
				 foreach ($firstRowTemp as $column)
				 {
				 
				    $firstRow[$k] = $column;
				    $k++;
				 }
				 
				 $amountColumn = $k - 1;
				 
		         $i = 0;
				 
		         for ($j=1; $j <= $k - 1; $j+=1) {
				 
				      
			           $firstColumn[$j] = $firstRow[$j];
					  
					  
					  foreach($this->settings as $index => $checked){
		
		                     if ($checked=='true'){
							     
							   
							    if (in_array($this->value[$index], $firstColumn)){
								
								    if (!isset($nameColumn[$index]))
									{
									
										    $nameColumn[$index] = $j;
							
									}  
								}
								
	                        }
			         }
					  
		         }
				 
				 
				 $products = array();
		         $product = array();
		         $isFirstRow = TRUE;
				 $i = $startRow;
				 
				 if ($startRow == 0) {
				 
				    $i = 1;
				 }
		         
		         $k = $i + 100;
				 $empty = 0;
				 
				
		         for ($i; $i<$k; $i+=1) {
					  
				 
					  if ($this->settings['name']=='true'){
			              $name = $this->getCell($data,$i,$nameColumn['name']);
			              $name = htmlentities( $name, ENT_QUOTES, $this->detect_encoding($name), '0' );
                          $product['name'] = addslashes($name);
						  
						  if ($product['name'] == '0'){
						     
							 $empty++;
						  
						  }
					  }
					  else
					  {
					      $product['name'] = 0;
					  
					  }
					  
					  if ($this->settings['image']=='true'){
					      $imageName = $this->getCell($data,$i,$nameColumn['image'],'0');
	                      $product['image'] = addslashes($imageName);

                         if ($product['image'] == '0'){
						     
							 $empty++;
						  
						  }						  
					  }
					  else
					  {
					      $product['image'] = 0;
					  
					  }
					  
					  if ($this->settings['model']=='true'){
					      $model = $this->getCell($data,$i,$nameColumn['model'],'0');
					      $product['model'] = addslashes($model);
						  
						 if ($product['model'] == '0'){
						     
							 $empty++;
						  
						  }	
					  }
					  else
					  {
					      $product['model'] = 0;
					  
					  }
					  
					  if ($this->settings['price']=='true'){
					      $price = $this->getCell($data,$i,$nameColumn['price'],'0');
				          $product['price'] = addslashes($price);
						  
						  		  
						 if ($product['price'] == '0'){
						     
							 $empty++;
						  
						  }
					  }
					  else
					  {
					      $product['price'] = 0;
					  
					  }
					  
					  if ($this->settings['guantity']=='true'){
					      $guantity = $this->getCell($data,$i,$nameColumn['guantity'],'0');
					      $product['guantity'] = addslashes($guantity);
						  
						 if ($product['guantity'] == '0'){
						     
							 $empty++;
						  
						  }
					  }
					  else
					  {
					      $product['guantity'] = 0;
					  
					  }
					
					  
					  if ($this->settings['statusenabled']=='true'){
					      $status = $this->getCell($data,$i,$nameColumn['statusenabled'],'1');
					      $product['status'] = addslashes($status);
						  
						   if ($product['status'] == '1'){
						     
							 $empty++;
						  
						  }
					  }
					  else
					  {
					      $product['status'] = 0;
					  
					  }
					  
					  if ($this->settings['sku']=='true'){
					      $sku = $this->getCell($data,$i,$nameColumn['sku'],'0'); 
		                  $product['sku'] = addslashes($sku);
						  
						  			  
						  if ($product['sku'] == '0'){
						     
							 $empty++;
						  
						  }
					  }
					  else
					  {
					      $product['sku'] = 0;
					  
					  }
					 
					  
					  if ($this->settings['manufacturer']=='true'){
					      $manufacturer = $this->getCell($data,$i,$nameColumn['manufacturer'],'0');
						  $product['manufacturer'] = addslashes($manufacturer);
						  
						  	  			  
						  if ($product['manufacturer'] == '0'){
						     
							 $empty++;
						  
						  }
					  }
					  else
					  {
					      $product['manufacturer'] = 0;
					  
					  }
					  
					  if ($this->settings['description']=='true'){
					      $description = $this->getCell($data,$i,$nameColumn['description'],'0');
			              $description = htmlentities( $description, ENT_QUOTES, $this->detect_encoding($description) ); 
					      $product['description'] = addslashes($description);
						  
						  			  
						  	  			  
						  if ($product['description'] == '0'){
						     
							 $empty++;
						  
						  }
					  
					  }
					  else
					  {
					      $product['description'] = 0;
					  
					  }
					  
					  if ($this->settings['categories']=='true'){
					      $categories = $this->getCell($data,$i,$nameColumn['categories'],'0');
					      $product['categories']= addslashes($categories);
						  
						  if ($product['categories'] == '0'){
						     
							 $empty++;
						  
						  }
					  
					  }
					  else
					  {
					      $product['categories'] = 0;
					  
					  }
					  
					  if ($empty >= $amountColumn - 1){
					   
					      break;
					  }
					  
					  $empty = 0;
					  
					  $products[$i]=$product;
					  
		        }
				

		              return $this->storeProductsIntoDatabase( $database, $products );
				
				 
		}
		
		
		function storeProductsIntoDatabase( &$database, &$products ) 
	    {
			// find the default language id
		    $languageId = $this->getDefaultLanguageId($database);
			
			
			
		
		   
		    foreach ($products as $product) {
			
			          $productName = $this->language->get('not_data');
			          $productImage = $this->language->get('not_image');
			          $productModel = $this->language->get('not_model'); 
					  $productPrice = '0.00';
					  $productQuantity = '0';
					  $productStatus = '1';
			          $productManufacturer = $this->language->get('not_data'); 
					  $productDescription = $this->language->get('not_data');
					  
					  
			
			          if (!empty($product['name']) && ($product['name'] !==0)){
					 
					     $productName = $product['name'];
					  }
			         
					
			          if (!empty($product['image']) && ($product['image'] !== 0)){
					      $productImage = $product['image'];
						
					  }
					  
					  if (!empty($product['model']) && ($product['model'] !==0)){
					      $productModel = $product['model'];
					      
					  }
					  
					  if (!empty($product['price']) && ($product['price'] !==0)){
					     $productPrice = $product['price'];
					  }
					  
					  if (!empty($product['guantity']) && ($product['guantity'] !==0)){
					     $productQuantity = $product['guantity'];
					  }
					  
					  if (!empty($product['status']) && ($product['status'] !==0) ){
					      $productStatus = $product['status'];
					  
					  }
					  
					  if (!empty($product['manufacturer']) && ($product['manufacturer'] !==0)){
					     $productManufacturer = $product['manufacturer'];
					  }
					  
					  if (!empty($product['description']) && ($product['description'] !==0)){
					     $productDescription = $product['description'];
					  
					  }
					  
					    
			          
			   
			         if (!empty($product['categories']) && ($product['categories'] !==0)){
					 
					     $productCategories = $product['categories'];
					  
					     $sql = "SELECT `name`,`category_id` FROM `".DB_PREFIX."category_description`";
						 
					     $result = $database->query($sql);
						 
	                    $name = array();
						$id = array();
						
						
		                if ($result->rows) {
			                foreach ($result->rows as $row) {
							
				                    $name[] = strtolower($row['name']);
									$id[strtolower($row['name'])] = $row['category_id'];
									
							}
				                    if (!in_array(strtolower($productCategories), $name )) {
										
										$temp_max = "SELECT `category_id` FROM `".DB_PREFIX."category`";
										
										$max = $database->query($temp_max);
		                               
									    $num = 0;
										
                                        foreach ($max->rows as $value){
										
										         if ($num < $value['category_id']){
												 
												     $num = $value['category_id'];
												 }
										}
										
										$num = $num+1;
										
										
										
									    $inserteCategory = "INSERT INTO`".DB_PREFIX."category` (`category_id`, `image`, `parent_id` , `top`, `column`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES ('$num','','0','1','0','0','0',NOW(),NOW())";
				
										$database->query($inserteCategory);
										
										$inserteCategoryDescription = "INSERT INTO `".DB_PREFIX."category_description` (`category_id`, `language_id`, `name` ,`description`, `meta_description`, `meta_keyword`) VALUES ('$num','$languageId','$productCategories','','','')";
										
										$database->query($inserteCategoryDescription);
										
										$categoryId = $num;
										
										
					                    goto product;
				                    } 
									else if (in_array(strtolower($productCategories), $name )) {
									
									        $categoryId = $id[strtolower($productCategories)];
					                        
				                            goto product;
									}
			                    }
		                    }
					  product:

                      //find manufacturer and id
						  
					  $sql9 = "SELECT `manufacturer_id`,`name` FROM `".DB_PREFIX."manufacturer`";
					  $manuf_temp = $database->query($sql9);
								  
					  $manuf_name = array();
					  $manuf_id = array();
						  
							
				     //find all manufacturer and them id
						  
				     if ($manuf_temp->rows) {
						  
						
							  foreach ($manuf_temp->rows as $value_manuf){
									  
									   $manuf_name[] = strtolower($value_manuf['name']);
									   $manuf_id[strtolower($value_manuf['name'])] = $value_manuf['manufacturer_id'];   
							 }
					 }
					      
					  
					      $sql2 = "SELECT `sku`,`product_id` FROM `".DB_PREFIX."product`";
						 
					      $result2 = $database->query($sql2);
						 
	                      $sku = array();
						  $productId = array();
						
						
		              if ($result2->rows) {
						
		
			                foreach ($result2->rows as $res) {
							
				                    $sku[] = $res['sku'];
									$productId[$res['sku']] = $res['product_id'];
									
							}
												  
				      }
					  
			          if (!empty($product['sku']) && ($product['sku'] !==0) ){
					  
					      $productSku = $product['sku'];
						  
					
						    if (in_array($productSku, $sku )) {
							 
					          
			                   
					            $sql3 = "SELECT `manufacturer_id` FROM `".DB_PREFIX."product` WHERE `sku` = '".$productSku."'";
					            $manufId = $database->query($sql3);
								
								
								$sql4 = "UPDATE `".DB_PREFIX."manufacturer` SET `name` = '".$productManufacturer."' WHERE `manufacturer_id` = '".$manufId->row['manufacturer_id']."'";
			                    $database->query($sql4); 
								
								$sql5  = "UPDATE `".DB_PREFIX."product` SET `quantity` = '".$productQuantity."',`model`='".$productModel."',";
			                    $sql5 .= "`manufacturer_id` = '".$manufId->row['manufacturer_id']."',`image` = '".$productImage."',`price`='".$productPrice."',`date_added`= NOW(),`date_modified` = NOW(),`status` = '".$productStatus."',`date_available`= NOW()";
			                    $sql5 .= "WHERE `sku` = '".$productSku."'";
								$database->query($sql5);
								
							    $sql6 = "SELECT `product_id` FROM `".DB_PREFIX."product` WHERE `sku` = '".$productSku."'";
					            $prodfId = $database->query($sql6);	
	
			                    $sql7 = "UPDATE `".DB_PREFIX."product_description` SET `name`='".$productName."',`description`= '".$productDescription."' WHERE `product_id` = '".$prodfId->row['product_id']."'";
			                    
			                    $database->query($sql7);
								
								$sql8 = "UPDATE `".DB_PREFIX."product_to_category` SET `category_id` = '".$categoryId."' WHERE `product_id` = '".$productId[$productSku]."'";
			                    $database->query($sql8); 
								
					  

                            }
                            else if (!in_array($productSku, $sku )) {
							
						
									  //check on existence manufacturer
									  if (in_array(strtolower($productManufacturer), $manuf_name)){
									  
									      $productManufacturerId = $manuf_id[strtolower($productManufacturer)];
									  }
									  else if (!in_array(strtolower($productManufacturer), $manuf_name)){               //Производитель существует ?    
								                                                                            //Нет
								              $db_trans = "INSERT INTO `".DB_PREFIX."manufacturer` (`name`,`sort_order`) VALUES ('$productManufacturer', '0')";
                                              $database->query($db_trans);
                                           
                                              $db_trans2 = "SELECT `manufacturer_id` FROM `".DB_PREFIX."manufacturer` WHERE `name` = '$productManufacturer'";										   
						                      $resultManufId = $database->query($db_trans2);
											  $productManufacturerId = $resultManufId->row['manufacturer_id'];
									  }
									  
									//add the goods in the table product 
									$sql10 = "INSERT INTO `".DB_PREFIX."product` (`quantity`, `model`, `manufacturer_id`,`image`,";
                                    $sql10 .= "`price`, `date_added`, `date_modified`, `status`, `sku`,`upc`,`ean`,`jan`,`isbn`,`mpn`,`stock_status_id`,`location`,";
									$sql10 .= "`tax_class_id`,`date_available`)";									
							        $sql10 .="VALUES ('$productQuantity', '$productModel', '$productManufacturerId', '$productImage',";
                                    $sql10 .="'$productPrice', NOW(), NOW(), '$productStatus', '$productSku', '','','','','','0','',";
									$sql10 .="'0',NOW())";									
							        $database->query($sql10);
	
							
							        //receive id added goods
									$tempProductId = $database->getLastId();
								
								
								    //add description added goods
			                        $sql14 = "INSERT INTO `".DB_PREFIX."product_description`  (`name`, `description`, `product_id`, `language_id`,`meta_description`, `meta_keyword`,`tag`)";
			                        $sql14 .="VALUES ('$productName', '$productDescription', '".$tempProductId."', '$languageId', '', '', '')";
								    $database->query($sql14);
								
								    //connect a category with the goods
								    $sql15 = "INSERT INTO `".DB_PREFIX."product_to_category` (`category_id`, `product_id`) VALUES ('$categoryId', '".$tempProductId."')";
			                        $database->query($sql15);

                                    //to place goods in main shop
                                    $sql16 = "INSERT INTO `".DB_PREFIX."product_to_store` (`product_id`, `store_id`) VALUES ('".$tempProductId."', '0' )";
			                        $database->query($sql16);
									
									//check existence categories in the main shop
									$sql17 = "SELECT `category_id` FROM `".DB_PREFIX."category_to_store` WHERE `category_id` = '".$categoryId."'";
					                $categoryDefault = $database->query($sql17);
									
									if (!$categoryDefault->row){
									
									//to place category in the main shop
									$sql18 = "INSERT INTO `".DB_PREFIX."category_to_store` (`category_id`, `store_id`) VALUES ('$categoryId', '0' )";
			                        $database->query($sql18);
									
									}
									
                            }							
						}  
					    else
						{
						              
								  
			                 
							 		  //check existence manufacturer
									  if (in_array(strtolower($productManufacturer), $manuf_name)){
									  
									      $productManufacturerId = $manuf_id[strtolower($productManufacturer)];
									  }
									  else if (!in_array(strtolower($productManufacturer), $manuf_name)){               //Is manufacturer exists?    
								                                                                            //No
								              $db_trans3 = "INSERT INTO `".DB_PREFIX."manufacturer` (`name`, `sort_order`,`image`) VALUES ('$productManufacturer','0','')";
                                              $database->query($db_trans3);
                                           
                                              $db_trans4 = "SELECT `manufacturer_id` FROM `".DB_PREFIX."manufacturer` WHERE `name` = '$productManufacturer'";										   
						                      $resultManufId = $database->query($db_trans4);
											  $productManufacturerId = $resultManufId->row['manufacturer_id'];
									  }
									  
									  $rand = mt_rand(100000,999999);
									  
									//Add product into table 'product' 
									$sql19 = "INSERT INTO `".DB_PREFIX."product` (`quantity`, `model`, `manufacturer_id`,`image`,";
                                    $sql19 .= "`price`, `date_added`, `date_modified`, `status`, `sku`,`upc`,`ean`,`jan`,`isbn`,`mpn`,`stock_status_id`,`location`,";
									$sql19 .= "`tax_class_id`,`date_available`)";									
							        $sql19 .="VALUES ('$productQuantity', '$productModel', '$productManufacturerId', '$productImage',";
                                    $sql19 .="'$productPrice', NOW(), NOW(), '$productStatus', '$rand', '','','','','','0','',";
									$sql19 .="'0',NOW())";									
							        $database->query($sql19);
	
							
							        //get up id have been product
									$tempProductId2 = $database->getLastId();
								
								    //add description added goods
						            $sql20 = "INSERT INTO `".DB_PREFIX."product_description`  (`name`, `description`, `product_id`, `language_id`,`meta_description`, `meta_keyword`,`tag`)";
			                        $sql20 .="VALUES ('$productName', '$productDescription', '".$tempProductId2."', '$languageId', 'Not', 'Not', 'Not')";
								    $database->query($sql20);
									
							
								    //linked category with product
								    $sql21 = "INSERT INTO `".DB_PREFIX."product_to_category` (`category_id`, `product_id`) VALUES ('$categoryId', '".$tempProductId2."')";
			                        $database->query($sql21);

                                    //added product in main shop
                                    $sql22 = "INSERT INTO `".DB_PREFIX."product_to_store` (`product_id`, `store_id`) VALUES ('".$tempProductId2."', '0' )";
			                        $database->query($sql22);
									
									//Check existence category
									$sql23 = "SELECT `category_id` FROM `".DB_PREFIX."category_to_store` WHERE `category_id` = '".$categoryId."'";
					                $categoryDefault2 = $database->query($sql23);
									
									if (!$categoryDefault2->row){
									
									//added category into main shop
									$sql24 = "INSERT INTO `".DB_PREFIX."category_to_store` (`category_id`, `store_id`) VALUES ('$categoryId', '0' )";
			                        $database->query($sql24);
									
									}
			            }	
                }					  
			 
			 return TRUE;
		    
		}
		
	function getCell(&$worksheet,$row,$col,$default_val='') {
		$col -= 1; // we use 1-based, PHPExcel uses 0-based column index
		$row += 1; // we use 0-based, PHPExcel used 1-based row index
		return ($worksheet->cellExistsByColumnAndRow($col,$row)) ? $worksheet->getCellByColumnAndRow($col,$row)->getValue() : $default_val;
	}


	function validateHeading( $data, $expected ) {
	
	    $valid = FALSE;
				
		$heading = array();
		$k = 0;
		

		
		foreach($data as $dates)
		{
		      $heading[] = strtolower($dates);
		      $k++;
		}
		
		//Count amount column in file
		$this->session->data['excel_status']['column'] = $k;
		
		$valid = TRUE;
		for ($i=0; $i < count($expected); $i+=1) {
			if (!isset($heading[$i])) {
				$valid = FALSE;
				break;
			}
			
			if (!in_array(strtolower($expected[$i]), $heading)) {
				$valid = FALSE;
				break;
			}
		}
		return $valid;
	}


    protected function expectedPriceHeading() {
	
	    $out = array();
		$control = array();
		$i=0;
		$ok = false;
	
	    foreach($this->settings as $index => $checked){
		
		        if (($checked=='true') && (strpos($index, "_export") == false)){
				
                    $out[$i] = strtolower($this->value[$index]);
				  
				  	if (in_array($out[$i], $control)){
				
				        error_log(date('Y-m-d H:i:s - ', time()).$this->language->get( 'error_name_field' )."\n",3,DIR_LOGS."error.log");
						return false;
						break;
				    }
					
					if ($out[$i] !== $this->language->get('not_data'))
					{
					   $ok = true;
					}
				    
					$control[$i] = strtolower($this->value[$index]);
					$i++;
	            }
			
		}
		
		if ($ok)
		{
		   return $out;
		}
	    else
		{
		   error_log(date('Y-m-d H:i:s - ', time()).$this->language->get('error_select_field')."\n",3,DIR_LOGS."error.log");
		   return false;
		}
	
	}



	function validatePrice( $rows )
	{
		$expectedPriceHeading = $this->expectedPriceHeading();
		return $this->validateHeading( $rows, $expectedPriceHeading );
	}





	function validateUpload($rows, $name)
	{

		$expectedWorksheet = 'Price';
		$status = true;
		
		if ($name != $expectedWorksheet) {
				error_log(date('Y-m-d H:i:s - ', time()).$this->language->get('error_incorrect_type_file')."\n",3,DIR_LOGS."error.log");
				$status =  FALSE;
				
	    }
		
		if (!$this->validatePrice( $rows )) {
			error_log(date('Y-m-d H:i:s - ', time()).$this->language->get('error_sheet_count') ."\n",3,DIR_LOGS."error.log");
			$status =  FALSE;
		}

		return $status;
	}


	function clearCache() {
		$this->cache->delete('*');
	}
	
	
	
	//This function make check of the file .xls on existence of errors
	//and is counting amount of rows in the file
	
	public function check($filename, $value, $settings)
	{
	    //I use my own error handler
		global $registry;
		$registry = $this->registry;
		$this->value = $value;
        $this->settings = $settings;		
		set_error_handler('error_handler_for_export',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');
		try {
		
			$this->session->data['export_nochange'] = 1;
			$cwd = getcwd();
            chdir( DIR_SYSTEM.'Spout' );
            require_once( 'Spout/Autoloader/autoload.php' );
            chdir( $cwd );
   
            $rows = 0;
			$name = '';
   
            $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
   
            $reader->open($filename, 0);
   
            foreach ($reader->getSheetIterator() as $sheet)
            {
                 foreach ($sheet->getRowIterator() as $row) 
				 {
				 
		             $name = $sheet->nameSheet;
		             $rows = $row;
                     break;
                 }
            
			}
			
			$numberColumn = 0;
			
			//Keep names of columns in session variable
			foreach ($rows as $column)
			{
			     $this->session->data['column_name'][$numberColumn] = $column;
			     $numberColumn++;
			}
			
			
		    //Call check that sheet is correct
			$ok = $this->validateUpload($rows, $name);
   
            //Closing opened file
            $reader->close();
		 
		    if (!$ok) {
				return FALSE;
			}
			$this->clearCache();
			$this->session->data['export_nochange'] = 0;
			
			if (!$ok) {
				return FALSE;
			}
			
			return $ok;
			
		} 
		catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->excelMakerUpdate('switch', 6);
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return FALSE;
		}
	
	
	
	}
	

	
	//This function make calculate amount rows
	
	public function calculate($filename)
	{
	    //I use my own error handler
		global $registry;
		$registry = $this->registry;		
		set_error_handler('error_handler_for_export',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');

		try {
		
			$this->session->data['export_nochange'] = 1;
			$cwd = getcwd();
            chdir( DIR_SYSTEM.'Spout' );
            require_once( 'Spout/Autoloader/autoload.php' );
            chdir( $cwd );
   
            $count = 0;
   
            $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
   
            $reader->open($filename, 0);
   
            foreach ($reader->getSheetIterator() as $sheet)
            {
                 foreach ($sheet->getRowIterator() as $row) {
		
		             //Take max row number XLSX file
		             $count = $sheet->getRowIterator()->maxRow;
                     break;
                 }
            }
			$this->excelMakerUpdate('max_row', substr($count, strpos($count, ':') + 2));
			
   
   
            $reader->close();
            $this->clearCache();
            return array ('action' => 'Finish');
	 
			
            $this->session->data['export_nochange'] = 0;
			
		} 
		catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->excelMakerUpdate('switch', 6);
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return FALSE;
		}
	
	
	
	}
	
	//This function make load of the file .xls into DB
	
	public function execute($filename, $value, $settings)
	{
	
	      //I use my own error handler
		  global $registry;
		  $registry = $this->registry;
		  $this->value = $value;
          $this->settings = $settings;
		  
          // set appropriate timeout limit
		  set_time_limit( $this->value['max_size'] );
		  
		  set_error_handler('error_handler_for_export',E_ALL);
		  register_shutdown_function('fatal_error_shutdown_handler_for_export');
		  
		  try {
		  
		        $database =& $this->db;
				
		       // we use the PHPExcel package from http://phpexcel.codeplex.com/
			
		   
		        $progress = 0;
		   
			    $cwd = getcwd();
			    chdir( DIR_SYSTEM.'PHPExcel' );
			    require_once( 'Classes/PHPExcel.php' );
			    require_once( 'Classes/myReadFilter.php' );
			    chdir( $cwd );
			
			    $fileType = 'Excel2007';
			
		       /**  Create a new Reader of the type defined in $inputFileType  **/
               $objReader = PHPExcel_IOFactory::createReader($fileType);

               /**  Define start row for begin read  **/
               $startRow = $this->excelMakerRead('count');
			   
               /**  Create a new Instance of our Read Filter  **/
               $chunkFilter = new myReadFilter();

               /**  Tell the Reader that we want to use the Read Filter that we've Instantiated  **/
               $objReader->setReadFilter($chunkFilter);
		   
		       /** Tell the Reader that we want read just data without structure **/
		       $objReader->setReadDataOnly(true);
		  

               /**  Tell the Read Filter, the limits on which rows we want to read this iteration  **/
               $chunkFilter->setRows($startRow, 100);
		   
               /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  **/
               $objPHPExcel = $objReader->load($filename);
		   
		 
   
		       
		       		

				$upperValue = $this->excelMakerRead('max_row');
			    $actualValue = $this->excelMakerRead('count');
					
				if ($actualValue < $upperValue)
				{
				    //Calculating level of progress of import in degrees
				    $ok = $this->uploadPrice( $objPHPExcel, $database,  $startRow);
					$progress =  number_format(($actualValue/$upperValue) * 100, 1, '.', '');
					
					if ($progress < 1.0)
					{
					   $progress = 1.0;
					
					}
					
					unset($objReader);
					unset($objPHPExcel);
					$this->excelMakerUpdate('count', $this->excelMakerRead('count') + 100);
					
					// Clear the spreadsheet caches
			        $this->clearSpreadsheetCache();
					
				    return array ('action' => 'Continue', 'progress' => $progress);
				}
				
				
				$progress = 100;
				$this->excelMakerUpdate('count', 0);
				unset($objReader);
				
			    // Clear the spreadsheet caches
			    $this->clearSpreadsheetCache();
			   
		        return array ('action' => 'Finish', 'progress' => $progress);
		   
		   }
		   catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->excelMakerUpdate('switch', 6);
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return FALSE;
		}
	
	}
	
	//This function is finishing process of import into DB
	
	public function endExecute($path)
	{	
	     	
		  if (file_exists($path))
		  {
			  unlink($path);
			  return true;
		  }
	      
		   error_log(date('Y-m-d H:i:s - ', time()).'Delete failed file export_price.xlsx'."\n",3,DIR_LOGS."error.log");
	       return false;
	
	}


    //this function makes validate
	public function validateLoad()
	{

		$status = true;
		
		if (!$this->expectedColumn()) {
			error_log(date('Y-m-d H:i:s - ', time()).$this->language->get('error_sheet_count')."\n",3,DIR_LOGS."error.log");
			$status =  FALSE;
		}

		return $status;
	}
	
	
	//this function makes expected column
	protected function expectedColumn() {
	
	    $out = array();
		$control = array();
		$ok = false;
		$i=0;
	
	    foreach($this->settings as $index => $checked){
		
		        if (($checked=='true') && (strpos($index, "_export") !== false)){
				
                    $out[$i] = strtolower($this->value[$index]);
				  
				  	if (in_array($out[$i], $control) && ($out[$i] !== $this->language->get('not_data'))){
				
				        error_log(date('Y-m-d H:i:s - ', time()).$this->language->get( 'error_name_field' )."\n",3,DIR_LOGS."error.log");
						return false;
						break;
				    }
				    if ($out[$i] !== $this->language->get('not_data'))
					{
					   $ok = true;
					}
					
					$control[$i] = strtolower($this->value[$index]);
					$i++;
	            }
			
		}
		
		$i = 0;
		$number = array();
		$temp = array();
		$ok = false;
		
		
	    foreach($this->value as $values => $value){

		        if (strpos($values, "_number") !== false){
					
				    $number[$i] = $this->value[$values];

				  	if (in_array($number[$i], $temp) && ($number[$i] !== $this->language->get('not_number'))){
				
				        error_log(date('Y-m-d H:i:s - ', time()).$this->language->get( 'error_number_field' )."\n",3,DIR_LOGS."error.log");
						return false;
						break;
				    }
				    if ($number[$i] !== $this->language->get('not_number'))
					{
					   $ok = true;
					}
					
					$temp[$i] = $this->value[$values];
					$i++;
	            }
			
		}
		
		
		if ($ok)
		{
		   return $out;
		}
	    else
		{
		   error_log(date('Y-m-d H:i:s - ', time()).$this->language->get('error_select_field')."\n",3,DIR_LOGS."error.log");
		   return false;
		}
		
	}
	
  public function excelMakerUpdate($name, $value){
  
  
       $database =& $this->db;
       $query = "UPDATE `".DB_PREFIX."excel_maker` SET `$name`='$value' WHERE `id` = '1'";
       $database->query( $query );
      
  
  }
  
   public function excelMakerRead($name){
  
  
       $database =& $this->db;
       $query = "SELECT * FROM `".DB_PREFIX."excel_maker` WHERE `id` = '1'";
       $result = $database->query( $query );
	   $temp = $result->row[$name];
       return $temp;
  }



	protected function getCategories( &$database, $languageId ) {
		$query  = "SELECT c.* , cd.*, ua.keyword FROM `".DB_PREFIX."category` c ";
		$query .= "INNER JOIN `".DB_PREFIX."category_description` cd ON cd.category_id = c.category_id ";
		$query .= " AND cd.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."url_alias` ua ON ua.query=CONCAT('category_id=',c.category_id) ";
		$query .= "ORDER BY c.`parent_id`, `sort_order`, c.`category_id`;";
		$result = $database->query( $query );
		return $result->rows;
	}
	
	protected function setCell( &$worksheet, $row/*1-based*/, $col/*0-based*/, $val, $style=NULL ) {
		if ($style) {
			$worksheet->getStyleByColumnAndRow($col,$row)->applyFromArray( $style );
			$cell = $worksheet->getCellByColumnAndRow( $col, $row );
			$style = $cell->getStyle();
			if ($style->getNumberFormat()->getFormatCode() == '@') {
				$cell->setValueExplicit( $val );
			} else {
				$cell->setValue( $val );
			}
		} else {
			$cell = $worksheet->getCellByColumnAndRow( $col, $row );
			$cell->setValue( $val );
		}
	}
	


		protected function populateCategoriesWorksheet( &$worksheet, &$database, $languageId, &$boxFormat, &$textFormat ) {
	
		$j = 0;
		$step = array( '1' => $this->value['image_number'],
		               '2' => $this->value['name_number'],
		               '3' => $this->value['model_number'], 
		               '4' => $this->value['price_number'],
					   '5' => $this->value['guantity_number'],
					   '6' => $this->value['statusenabled_number'],
					   '7' => $this->value['sku_number'],
					   '8' => $this->value['manufacturer_number'],
					   '9' => $this->value['description_number'],
					   '10' => $this->value['categories_number'],
		              );
					 
		$number = array(
		                 '1' => $this->settings['image_export'],
		                 '2' => $this->settings['name_export'],
		                 '3' => $this->settings['model_export'], 
		                 '4' => $this->settings['price_export'],
					     '5' => $this->settings['guantity_export'],
					     '6' => $this->settings['statusenabled_export'],
					     '7' => $this->settings['sku_export'],
					     '8' => $this->settings['manufacturer_export'],
					     '9' => $this->settings['description_export'],
					     '10' => $this->settings['categories_export'],
		
		                );
						
						
		$csv = array();
						
		for ($counter = 1; $counter <= 10; $counter++)
		{
		    if (!is_numeric($step[$counter]))
			{
			   for ($m = 1; $m <= 10; $m++)
			   {
			       if (!in_array($m, $step))
				   {
			           $step[$counter] = $m;
				   }
			   }
			}
		
		
		}
		
		// Set the column widths
		
		$step = array_flip($step);
		
		for ($counter4 = 1; $counter4 <= 10; $counter4++)
		{
		     switch ($step[$counter4])
			 {

		           case 1:
				          
	                          if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['image_export']) !== $this->language->get('not_data'))
		                          {
		                                $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['image_export'])+1); 
		                          }
		                      }
						 
		           break;
		
		
		           case 2:
				          
		                      if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['name_export']) !== $this->language->get('not_data'))
		                          {
		   
		                              $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['name_export'])+1);
		                          }
		                      }
						  
		           break;
		
		
		
		           case 3:
				         
		                      if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['model_export']) !== $this->language->get('not_data'))
		                          {
		                              $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['model_export'])+1);
		                          }
		                      }
						  
	               break;
		
		
		
		           case 4:
				       
		                      if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['price_export']) !== $this->language->get('not_data'))
		                          {
		                             $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['price_export'])+1);
		                          }
		                      }
						  
		           break;
		
		
		
		           case 5:
				          
		                      if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['guantity_export']) !== $this->language->get('not_data'))
		                          {
		                              $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['guantity_export'])+1);
		                          }
		                       }
						 
		           break;
		
		
		
		           case 6:
				        
		                      if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['statusenabled_export']) !== $this->language->get('not_data'))
		                          {
		                             $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['statusenabled_export'])+1);
		                          }
		                      }
						 
	               break;
		
		
		
		           case 7:
				          
	                          if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['sku_export']) !== $this->language->get('not_data'))
		                          {
		                              $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['sku_export'])+1); 
		                          }
		                       }
						   
		           break;
		
	
		           case 8:
				        
	                          if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['manufacturer_export']) !== $this->language->get('not_data'))
		                          {
		                            $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['manufacturer_export'])+1,$textFormat);
		                          }
		                       }
						 
		           break;
		
		
		
		           case 9:
				          
	                          if ($number[$step[$counter4]] == 'true')
		                      {
		                          if (strtolower($this->value['description_export']) !== $this->language->get('not_data'))
		                          {
		                              $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['description_export'])+1,$textFormat);
		                          }
		                       }
						  
		           break;
	
	
		           case 10:
				            
		                         if ($number[$step[$counter4]] == 'true')
		                         {
		                             if (strtolower($this->value['categories_export']) !== $this->language->get('not_data'))
		                             {
		                                 $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen($this->value['categories_export'])+1);
                                     }
		                         }
							 
		           break;
				   default:
				   ;
		
		     }
		}
		
		
		// The heading row
		$i = 1;
		$j = 0;
		
		
		for ($counter2 = 1; $counter2 <= 10; $counter2++)
		{
		     switch ($step[$counter2])
			 {

		           case 1:
				          
	                          if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['image_export']) !== $this->language->get('not_data'))
		                          {
		                               $this->setCell( $worksheet, $i, $j++, $this->value['image_export'], $boxFormat );  
		                          }
		                      }
						 
		           break;
		
		
		           case 2:
				          
		                      if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['name_export']) !== $this->language->get('not_data'))
		                          {
		   
		                               $this->setCell( $worksheet, $i, $j++, $this->value['name_export'] , $boxFormat );
		                          }
		                      }
						  
		           break;
		
		
		
		           case 3:
				         
		                      if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['model_export']) !== $this->language->get('not_data'))
		                          {
		                               $this->setCell( $worksheet, $i, $j++, $this->value['model_export'], $boxFormat );
		                          }
		                      }
						  
	               break;
		
		
		
		           case 4:
				       
		                      if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['price_export']) !== $this->language->get('not_data'))
		                          {
		                              $this->setCell( $worksheet, $i, $j++, $this->value['price_export'], $boxFormat );
		                          }
		                      }
						  
		           break;
		
		
		
		           case 5:
				          
		                      if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['guantity_export']) !== $this->language->get('not_data'))
		                          {
		                              $this->setCell( $worksheet, $i, $j++, $this->value['guantity_export'], $boxFormat );
		                          }
		                       }
						 
		           break;
		
		
		
		           case 6:
				        
		                      if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['statusenabled_export']) !== $this->language->get('not_data'))
		                          {
		                             $this->setCell( $worksheet, $i, $j++, $this->value['statusenabled_export'], $boxFormat );
		                          }
		                      }
						 
	               break;
		
		
		
		           case 7:
				          
	                          if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['sku_export']) !== $this->language->get('not_data'))
		                          {
		                              $this->setCell( $worksheet, $i, $j++, $this->value['sku_export'], $boxFormat);  
		                          }
		                       }
						   
		           break;
		
	
		           case 8:
				        
	                          if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['manufacturer_export']) !== $this->language->get('not_data'))
		                          {
		                               $this->setCell( $worksheet, $i, $j++, $this->value['manufacturer_export'], $boxFormat );
		                          }
		                       }
						 
		           break;
		
		
		
		           case 9:
				          
	                          if ($number[$step[$counter2]] == 'true')
		                      {
		                          if (strtolower($this->value['description_export']) !== $this->language->get('not_data'))
		                          {
		                               $this->setCell( $worksheet, $i, $j++, $this->value['description_export'], $boxFormat );
		                          }
		                       }
						  
		           break;
	
	
		           case 10:
				            
		                         if ($number[$step[$counter2]] == 'true')
		                         {
		                             if (strtolower($this->value['categories_export']) !== $this->language->get('not_data'))
		                             {
		                              $this->setCell( $worksheet, $i, $j++, $this->value['categories_export'], $boxFormat );
                                     }
		                         }
							 
		           break;
				   default:
				   ;
		
		     }
		}
		
		$worksheet->getRowDimension($i)->setRowHeight(30);
		
		// The actual categories data
		$i += 1;
		$j = 0;
		
		$categories = $this->getCategories( $database, $languageId );
		$products = $this->getProducts( $database, $languageId );
		foreach ($products as $row) {
			
			$worksheet->getRowDimension($i)->setRowHeight(26);
			
			for ($counter3 = 1; $counter3 <= 10; $counter3++)
			{
			     switch ($step[$counter3])
				 {

				       case 1:
					           
			                       if ($number[$step[$counter3]] == 'true')                       //image
		                           {
		                               if (strtolower($this->value['image_export']) !== $this->language->get('not_data'))
		                               {
		                                   $this->setCell( $worksheet, $i, $j++, $row['image'], $textFormat  ); 
		                               }
		                           }
							   
					   break;
						
					   case 2:
					         
			                       if ($number[$step[$counter3]] == 'true')                        //name
		                           {
		                               if (strtolower($this->value['name_export']) !== $this->language->get('not_data'))
		                               {
				                           $this->setCell( $worksheet, $i, $j++, html_entity_decode($row['name'],ENT_QUOTES,'UTF-8'),$textFormat  );
				                       }
			                       }
							  
			            break;
						
						case 3:
						        								
			                        if ($number[$step[$counter3]] == 'true')                        //model
		                            {
		                                if (strtolower($this->value['model_export']) !== $this->language->get('not_data'))
		                                {
				                            $this->setCell( $worksheet, $i, $j++,  $row['model'], $textFormat );
				                        }
			                        }
								
						break;
						
						case 4:
						       
						            if ($number[$step[$counter3]] == 'true')                         //price
		                            {
		                                if (strtolower($this->value['price_export']) !== $this->language->get('not_data'))
		                                {
			                                 $this->setCell( $worksheet, $i, $j++, $row['price'], $textFormat );
			                            }
			                        }
								
						break;
						
						case 5:
						        
			                        if ($number[$step[$counter3]] == 'true')                      //quantity
		                            {
		                                if (strtolower($this->value['guantity_export']) !== $this->language->get('not_data'))
		                                {
				                            $this->setCell( $worksheet, $i, $j++, $row['quantity'], $textFormat  );
				                        }
			                        }
								
						break;
						
						case 6:
						     
			                       if ($number[$step[$counter3]] == 'true')                 //status
		                           {
		                               if (strtolower($this->value['statusenabled_export']) !== $this->language->get('not_data'))
		                               {
			                               $this->setCell( $worksheet, $i, $j++, ($row['status']==0) ? "false" : "true", $textFormat );
			                           }
			                       }
							    
						break;
						
						case 7:
						      
			                        if ($number[$step[$counter3]] == 'true')                           //article
		                            {
		                                if (strtolower($this->value['sku_export']) !== $this->language->get('not_data'))
		                                {
			                                 $this->setCell( $worksheet, $i, $j++, $row['sku'], $textFormat  );
			                            }
			                        }
							  
						break;
						
						case 8:
						      
			                        if ($number[$step[$counter3]] == 'true')                  //manufacturer
		                            {
		                                if (strtolower($this->value['manufacturer_export']) !== $this->language->get('not_data'))
		                                {
			                                $this->setCell( $worksheet, $i, $j++, $row['manufacturer'], $textFormat );
			                            }
			                        }
								 
						break;
						
						case 9:
						       
			                        if ($number[$step[$counter3]] == 'true')                   //description
		                            {
		                                if (strtolower($this->value['description_export']) !== $this->language->get('not_data'))
		                                {
			                                $this->setCell( $worksheet, $i, $j++, html_entity_decode($row['description'],ENT_QUOTES,'UTF-8'));
			                            }
			                        }
								
						break;
						
						case 10:
						       
			                         if ($number[$step[$counter3]] == 'true')                    //categories
		                             {
		                                 if (strtolower($this->value['categories_export']) !== $this->language->get('not_data'))
		                                 {
				
				                             $num = 0;
				                             $storeIdList = '';
					                         $id = explode("," , $row['categories']);
					                         foreach ($categories as $result)
					                         {
					                                if (!empty($id[$num]))
							                        {
							                            if ($result['category_id'] == $id[$num])
								                        {
								   
								                             $storeIdList .= ($storeIdList=='') ? $result['name'] : ','.$result['name'];
								                             $num++;   
								                        }
							     
							                         }
					        
					                         }

			                                 $this->setCell( $worksheet, $i, $j++, $storeIdList, $textFormat );
				   
				                         }
		                             
								  }
							     default:
								 ;
		                  }
		    }	
			$i += 1;
			$j = 0;
		}
		
	}
	
	//Function that create DB during install module
    public function install()
	{
	    $database =&$this->db;
	    $sql = "CREATE TABLE `".DB_PREFIX."excel_maker` (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
        $sql .= "`switch` INT(10),";
		$sql .= "`import` INT(10),";
		$sql .= "`control` INT(10),";
		$sql .= "`rows` INT(10),";
		$sql .= "`max_row` INT(10),";
		$sql .= "`count` INT(10),";
		$sql .= "`progress` INT(10),";
		$sql .= "`message` VARCHAR(255))";
		$database->query( $sql );
		
		$sql = "INSERT INTO `".DB_PREFIX."excel_maker` (`id`, `switch`,`import`,";
        $sql .= "`control`, `rows`, `max_row`, `count`, `progress`, `message`)";
		$sql .= "VALUES ('1','0','0', '0', '0', '0', '0', '0', 'Not data' )";
		$database->query($sql);
	    
	}
	
	//Function that drop  DB during uninstall module
	public function uninstall()
	{
	   $database =&$this->db;
	   $sql = "DROP TABLE `".DB_PREFIX."excel_maker` ";
	   $database->query($sql);
	}


	protected function getProducts( &$database, $languageId ) {
		$query  = "SELECT ";
		$query .= "  p.product_id,";
		$query .= "  pd.name,";
		$query .= "  GROUP_CONCAT( DISTINCT CAST(pc.category_id AS CHAR(11)) SEPARATOR \",\" ) AS categories,";
		$query .= "  p.sku,";
		$query .= "  p.upc,";
		$query .= "  p.ean,";
		$query .= "  p.jan,";
		$query .= "  p.isbn,";
		$query .= "  p.mpn,";
		$query .= "  p.location,";
		$query .= "  p.quantity,";
		$query .= "  p.model,";
		$query .= "  m.name AS manufacturer,";
		$query .= "  p.image,";
		$query .= "  p.shipping,";
		$query .= "  p.price,";
		$query .= "  p.points,";
		$query .= "  p.date_added,";
		$query .= "  p.date_modified,";
		$query .= "  p.date_available,";
		$query .= "  p.weight,";
		$query .= "  wc.unit,";
		$query .= "  p.length,";
		$query .= "  p.width,";
		$query .= "  p.height,";
		$query .= "  p.status,";
		$query .= "  p.tax_class_id,";
		$query .= "  p.viewed,";
		$query .= "  p.sort_order,";
		$query .= "  pd.language_id,";
		$query .= "  ua.keyword,";
		$query .= "  pd.description, ";
		$query .= "  pd.meta_description, ";
		$query .= "  pd.meta_keyword, ";
		$query .= "  pd.tag, ";
		$query .= "  p.stock_status_id, ";
		$query .= "  mc.unit AS length_unit, ";
		$query .= "  p.subtract, ";
		$query .= "  p.minimum, ";
		$query .= "  GROUP_CONCAT( DISTINCT CAST(pr.related_id AS CHAR(11)) SEPARATOR \",\" ) AS related ";
		$query .= "FROM `".DB_PREFIX."product` p ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_description` pd ON p.product_id=pd.product_id ";
		$query .= "  AND pd.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_to_category` pc ON p.product_id=pc.product_id ";
		$query .= "LEFT JOIN `".DB_PREFIX."url_alias` ua ON ua.query=CONCAT('product_id=',p.product_id) ";
		$query .= "LEFT JOIN `".DB_PREFIX."manufacturer` m ON m.manufacturer_id = p.manufacturer_id ";
		$query .= "LEFT JOIN `".DB_PREFIX."weight_class_description` wc ON wc.weight_class_id = p.weight_class_id ";
		$query .= "  AND wc.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."length_class_description` mc ON mc.length_class_id=p.length_class_id ";
		$query .= "  AND mc.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_related` pr ON pr.product_id=p.product_id ";
		$query .= "GROUP BY p.product_id ";
		$query .= "ORDER BY p.product_id, pc.category_id; ";
		$result = $database->query( $query );
		return $result->rows;
	}









	protected function clearSpreadsheetCache() {
		$files = glob(DIR_CACHE . 'Spreadsheet_Excel_Writer' . '*');
		
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					@unlink($file);
					clearstatcache();
				}
			}
		}
	}

//upload from server
function download($value, $settings) {
        $this->value = $value;
		$this->settings = $settings;
		// we use our own error handler
		global $registry;
		$registry = $this->registry;
		set_error_handler('error_handler_for_export',E_ERROR);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');
		
		// we use the PHPExcel package from http://phpexcel.codeplex.com/
		$cwd = getcwd();
		chdir( DIR_SYSTEM.'PHPExcel' );
		require_once( 'Classes/PHPExcel.php' );
		chdir( $cwd );

		try {
		
		    // call expected columns
		    $ok = $this->validateLoad();
			
			if (!$ok)
			{
			    return false;
			}
		     
			// set appropriate timeout limit
		    set_time_limit( $this->value['max_size'] );

			$database =& $this->db;
			$languageId = $this->getDefaultLanguageId($database);
			
		    // create a new workbook
			$workbook = new PHPExcel();
			
			// set default font name and size
			$workbook->getDefaultStyle()->getFont()->setName('Arial');
			$workbook->getDefaultStyle()->getFont()->setSize(10);
			$workbook->getDefaultStyle()->getAlignment()->setIndent(1);
			
			// pre-define some commonly used styles
			$boxFormat = array(
				'font' => array(
					'name' => 'Arial',
					'size' => '10',
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
			);
			$textFormat = array(
				'font' => array(
					'name' => 'Arial',
					'size' => '10',
				),
				'numberformat' => array(
					'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
			);
			$priceFormat = array(
				'font' => array(
					'name' => 'Arial',
					'size' => '10',
				),
				'numberformat' => array(
					'code' => '######0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
			);
			$weightFormat = array(
				'font' => array(
					'name' => 'Arial',
					'size' => '10',
				),
				'numberformat' => array(
					'code' => '##0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
			);
			
			$workbook->setActiveSheetIndex(0);
			$worksheet = $workbook->getActiveSheet();
			$worksheet->setTitle( 'Price' );
			$this->populateCategoriesWorksheet( $worksheet, $database, $languageId, $boxFormat, $textFormat );
			$worksheet->freezePaneByColumnAndRow( 1, 2 );
		
		    $workbook->setActiveSheetIndex(0);
			
			// redirect output to client browser
			$objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
		    header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="export_price.xls"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output'); 
              
			// Clear the spreadsheet caches
			$this->clearSpreadsheetCache();


		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->excelMakerUpdate('switch', 6);
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return false;
		}
		return true;
	}
  }
?>