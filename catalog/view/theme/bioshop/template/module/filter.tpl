<div class="panel panel-default">
	<div class="col-lg-4 filters-menu">
            <p><?php echo $heading_title; ?></p>
            <?php foreach ($filter_groups as $filter_group) { ?>
	    <div class="head-filter" id = "filter-group-<?php echo $filter_group['filter_group_id']; ?>">
		<p class="toogle-p arrow-bottom"><?php echo $filter_group['name']; ?></p>
	    </div>
            <div class="content-filter" id ="content-for-filter-<?php echo $filter_group['filter_group_id']; ?>">
            <?php foreach ($filter_group['filter'] as $filter) { ?>
	         <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
		 <ul>
		    <li>
                        <input type="checkbox" id="filter-group-<?php echo $filter_group['filter_group_id']; ?>" name="filter[]" value="<?php echo $filter['filter_id']; ?>" checked="checked" />
			<label for="c1">  <?php echo $filter['name']; ?><span></span></label>
		    </li>
		</ul>
                <?php } else { ?>
                <ul>
		    <li>
			<input type="checkbox" id="filter-group-<?php echo $filter_group['filter_group_id']; ?>" name="filter[]" value="<?php echo $filter['filter_id']; ?>"/>
			<label for="c1">  <?php echo $filter['name']; ?><span></span></label>
		    </li>
		</ul>
                <?php } ?>
          <?php } ?>
          </div>
     <?php } ?> 
     <div class="bottom-part"></div>
  </div>   
</div>
<script type ="text/javascript">
   
    var action = "<?php echo $action; ?>";
  
    
</script>    