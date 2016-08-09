<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="container-fluid">
  <?php if ($success) { ?>
	    <div class="alert alert-success">
		    <i class="fa fa-check-circle"></i>
			<?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">×</button>
	    </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
    <div class="alert alert-warning">
	    <i class="fa fa-exclamation-circle"></i>
	    <?php echo $error_warning; ?>
	    <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
  <?php } ?>
  </div>
  <div class="page-header">
     <div class = "container-fluid"> 
        <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>

    </div>
  </div>
    <div class="col-md-12">
	    <div class ="col-md-5" style ="border: 2px solid #6495ED">
	    <?php if ($categories): ?>
      	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          	<div class="categories_list">
				<h2>Выберите категории</h2>
				<?php echo $categories; ?>
			</div>
		</div>
		<div class ="col-md-1"></div>
		<div class ="col-md-6" style ="border: 2px solid #6495ED">
		      
	            <h2>Параметры</h2>
			            <div class="col-md-7" style ="border: 2px solid #6495ED">
						    <div class = "col-md-12">
					             <div class = "col-md-2">
					                 <input  checked type="radio" name="action" value="addict" ></input>
						         </div>
					             <div class = "col-md-4">    
								     Прибавить
					             </div>
							</div>	         
				        <div class = "col-md-12">
						         <div class = "col-md-2">
					                  <input  type="radio" name="action" value="deduct" ></input>
					             </div>
                                 <div class = "col-md-5">     								 
					                  Вычесть
							     </div>
						</div>
						<div class = "col-md-12">
						         <div class = "col-md-2">
					                   <input  type="radio" name="action" value="multiply" ></input>
					             </div>
                                 <div class = "col-md-10">     								 
					                  Умножить на
							     </div>
						</div>
					   	<div class = "col-md-12">
						         <div class = "col-md-2">
					                 <input  input type="radio" name="action" value="divide" ></input>
					             </div>
                                 <div class = "col-md-10">     								 
					                 Разделить на
							     </div>
						</div>
					</div>
					<div class="col-md-5">
					    <div class ="row">
					     <div class = "col-md-12">
						      <input required  type="text" name="num" placeholder="Введите число" ></input>
					     </div>
				         <div class = "col-md-12">
				                <div class = "col-md-2">
					                <input checked type="radio" name="unit" value="percent" ></input>
								</div>
                                <div class = "col-md-8">
								%
                                </div>								
						</div>
                        <div class = "col-md-12">
                            <div class = "col-md-2">						
					             <input type="radio" name="unit" value="number" ></input>
				            </div> 
							<div class = "col-md-8">
							  число
                            </div>
					   </div>
                       <div class = "col-md-12">					   
				         <button class="btn btn-primary" style ="margin-bottom: 20px;" type="submit">Выполнить</button>
					   </div>
			        </form>
                   </div>					
			    </div>

		</div>
      </div>		
	<?php endif; ?>
    </div>
 </div>
</div>
<?php echo $footer; ?>