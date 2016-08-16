<?php echo $header; ?>
  <div class="container break-stripe filters-stripe">  
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>
      <?php if ($categories) { ?>
      <h3><?php echo $text_refine; ?></h3>
      <?php if (count($categories) <= 5) { ?>
      <div class="row">
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } else { ?>
      <div class="row">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php if ($products) { ?>
      <div class="row">
         	<div class="col-lg-6 col-lg-offset-6">
		     <div class="col-lg-5 col-lg-offset-1 sorting-by-price">
			 <p><?php echo $text_sort; ?></p>
			 <li class="dropdown">
                             <?php if (is_array($sorts)) { ?>
			     <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $sorts[0]['href']; ?>"><?php echo $sorts[0]['text']; ?><b class="caret-custom"></b></a>
			     <?php } ?>
                             <ul class="dropdown-menu">
                             <?php foreach ($sorts as $sorts) { ?>
                             <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                             <a href="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></a>
                             <?php } else { ?>
                             <a href="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></a>
                             <?php } ?>
                             <?php } ?>
			    </ul>
			  </li>
		     </div>
		     <div class="col-lg-5 sorting-item">
		       <p><?php echo $text_limit; ?></p>
		       <li class="dropdown">
                          <?php if (is_array($limits)) { ?>
			  <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $limits[0]['href']; ?>"><?php echo $limits[0]['text']; ?><b class="caret-custom"></b></a>
			  <?php } ?>
                          <ul class="dropdown-menu">
                          <?php foreach ($limits as $limits) { ?>
                          <?php if ($limits['value'] == $limit) { ?>
                          <a href="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></a>
                          <?php } ?>
                          <?php } ?>    
			 </ul>
		     </li>
		  </div>
	      </div> 
      <br />
      <div class="row">
        <?php foreach ($products as $product) { ?>
         <div class="item-container">
          <div class="item-content">
             <div class="content-image">
                 <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
             </div>
             <div class="content-discription">
		<p><?php echo $product['name']; ?></p>
		<p class="discr">
		<?php echo $product['description']; ?>
		</p>
                <?php if ($product['price']) { ?>
		<div class="prise">
                     <?php if (!$product['special']) { ?>
                     <?php echo $product['price']; ?>
                     <?php } else { ?>
                     <span class="prise-1"><?php echo $product['special']; ?></span> <span class="prise-2"><?php echo $product['price']; ?></span>
                     <?php } ?>
		</div>
                <?php } ?>
	    </div> 
            <div class="buy-action">
                   <a onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></a>
	    </div> 
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
