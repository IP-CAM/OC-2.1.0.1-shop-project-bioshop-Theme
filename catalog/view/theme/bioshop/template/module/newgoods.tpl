				   <?php $size = count($products); ?>
                                   <?php if ($size > 0) { ?>
                                    <div class="buy-item">
					<p class="buy-header">Новые товары:</p>
					<div class="slider-wrapper">
						<div id="carousel-example-generic1" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner" role="listbox">
								<div class="item active">
									<div class="wrapper-item">
                                                                        <?php  
                                                                             $rows = 1;
                                                                             $active_item = ($size >= 3)? 3 : $size;
                                                                         ?>                   
                                                                         <?php for ($m = 1; $m <= $active_item; $m++) { ?>
                                                                                    <div>
											<div class="item-content">
												<div class="item-image">
                                                                                                      <img src="<?php echo $products[$rows]['thumb']; ?>" alt="<?php echo $products[$rows]['name']; ?>" title="<?php echo $products[$rows]['name']; ?>" />
												</div>
												<div class="item-discription">
													<?php echo $products[$rows]['name']; ?>
													<p>
													 <?php echo $products[$rows]['description']; ?>
													</p>
                                                                                                                <?php if ($products[$rows]['price']) { ?>
                                                                                                                <p class="price">
                                                                                                                <?php if (!$products[$rows]['special']) { ?>
                                                                                                                <?php echo $products[$rows]['price']; ?>
                                                                                                                <?php } else { ?>
                                                                                                                <span class="price-new"><?php echo $products[$rows]['special']; ?></span> <span class="price-old"><?php echo $products[$rows]['price']; ?></span>
                                                                                                                <?php } ?>
                                                                                                                <?php } ?>
											         </div>
											</div>
											<div class="buy-action">
										              <a onclick="cart.add('<?php echo $products[$rows]['product_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></a>
											</div>
										   </div>
                                                                             <?php $rows++; ?>
                                                                             <?php } ?>
                                                                        </div>  
								</div>
                                                                <?php $number_row = intval(ceil(($size - 3)/3));?> 
                                                                <?php if ($number_row > 0) { ?>
                                                                     <?php for($rows = 4; $rows < $size + 1; $rows) { ?>
                                                                         <div class="item">
									     <div class="wrapper-item">
								          <?php $item = $rows; ?>
                                                                               <?php  for ($k = $item; $k < $item + 3; $k++) { ?> 
                                                                                     <?php  if ($rows > $size) { ?>
                                                                                          <?php break; ?>
                                                                                     <?php } ?>
										      <div>
                                                                                            <div class="item-content">
												<div class="item-image">
											            <img src="<?php echo $products[$rows]['thumb']; ?>" alt="<?php echo $products[$rows]['name']; ?>" title="<?php echo $products[$rows]['name']; ?>" />
												</div>
												<div class="item-discription">
													<?php echo $products[$rows]['name']; ?>
													<p>
													 <?php echo $products[$rows]['description']; ?>
													</p>
													   <?php if ($products[$rows]['price']) { ?>
                                                                                                                <p class="price">
                                                                                                                <?php if (!$products[$rows]['special']) { ?>
                                                                                                                <?php echo $products[$rows]['price']; ?>
                                                                                                                <?php } else { ?>
                                                                                                                <span class="price-new"><?php echo $products[$rows]['special']; ?></span> <span class="price-old"><?php echo $products[$rows]['price']; ?></span>
                                                                                                                <?php } ?>
                                                                                                                <?php } ?>
												</div>
											    </div>
											<div class="buy-action">
											     <a onclick="cart.add('<?php echo $products[$rows]['product_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></a>
											</div>
										   </div>
                                                                                   <?php $rows++; ?>  
                                                                               <?php } ?>
                                                                               	</div>
								             </div>
                                                                               <?php  if ($rows > $size) { ?>
                                                                                      <?php break; ?>
                                                                                <?php } ?>
			                                                  <?php } ?>
                                                                 <?php } ?>
						</div>
                                                <a class="left carousel-control" href="#carousel-example-generic1" role="button" data-slide="prev">
								<img src="catalog/view/theme/bioshop/image/arrow-left.png" alt="left">
					        </a>
					        <a class="right carousel-control" href="#carousel-example-generic1" role="button" data-slide="next">
								<img src="catalog/view/theme/bioshop/image/arrow-right.png" alt="right">
					       </a>    
					  </div>
				     </div>
                                </div>
                            <?php } ?>
 
