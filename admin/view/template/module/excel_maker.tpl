<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
    <div class="page-header">
	    <div class = "container-fluid">
		    <div class = "pull-right">
			     <button class = "btn btn-primary" onclick="upload();" type="button">Upload<?php //echo $button_import; ?></button>
                 <button class = "btn btn-primary" onclick="importFile();" type="button"><?php echo $button_import; ?></button>
				 <button class = "btn btn-primary" onclick="exportFile();" type="button"><?php echo $button_export; ?></button>
            </div>
			<h1><?php echo $heading_title; ?></h1>
		</div>
	</div>
    <div class="container-fluid">
	    <div class = "panel panel-default">
		    <div class = "panel-heading">
			    <h3 class = "panel-title"><?php echo $entry_description; ?></h3>
			</div>
			<div class = "panel-body">
                 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                      <table class="form">
                           <tr>
                               <td width="25%"><?php echo $entry_restore; ?></td>
                               <td><input type="file" name="upload" id="upload" /></td>
                           </tr>
                      </table>
                 </form>
            </div>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class = "panel panel-default">
		    <div class = "panel-heading">
			    <h3 class = "panel-title">Condition module<?php //echo $entry_description; ?></h3>
			</div>
			<table class="table table-bordered table-hover">
                        <tr>
                             <td class="text-left" width="21%"><div class = "panel-body">Status<?php //echo $image_field; ?></div></td>
                             <td class = "text-left" width="30%"><div class = "panel-body" id = "status_module"></div></td>
			                 <td class = "text-center"><button class = "btn btn-primary" onclick="resetError();" type="button">Reset<?php //echo $button_enter; ?></button></td>
		                </tr>
			</table>
		</div>
	</div>
		<div class="container-fluid">
	    <div class = "panel panel-default">
		    <div class = "panel-heading">
			    <h3 class = "panel-title">Messages<?php //echo $entry_description; ?></h3>
			</div>
			<table class="table table-bordered table-hover">
                        <tr>
                             <td class="text-left" width="21%"><div class = "panel-body">Message<?php //echo $image_field; ?></div></td>
                             <td class = "text-left" width="79%"><div class = "panel-body" id = "message_module"></div></td>
		                </tr>
			</table>
		</div>
	</div>
	<div class="container-fluid">
	    <div class = "panel panel-default">
		    <div class = "panel-heading">
			    <h3 class = "panel-title">Import file into DB<?php //echo $entry_description; ?></h3>
			</div>
		
		</div>
	</div>
    <div class="container-fluid">
			<div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                      0%
                 </div>
           </div>
    </div>

 
	
	
	
	
	
	<div class="page-header">
	    <div class = "container-fluid">
		    <div class = "pull-right">
                <button class = "btn btn-primary" onclick="EnterSetting();" type="button"><?php echo $button_enter; ?></button>
            </div>
			<h1><?php echo $setting_import; ?></h1>
		</div>
	</div>
	
     <div class="container-fluid">
	    <div class = "panel panel-default">
		    <div class = "panel-heading">
			    <h3 class = "panel-title"><?php echo $import_title; ?></h3>
			</div>
		<div class = "panel-body">	
                 <form action="<#>" method="post" id="setting_import" name = "form_settings">
                     <table class="table table-bordered table-hover">
                          <tr>
                               <td class = "text-left" width="25%"><?php echo $image_field; ?></td>
                               <td class = "text-left"><input type="text" size ="30"  class = "settings_value" name="image" value = "<?php echo $image ?>"/></td>
			                   <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="image" <?php if ($image_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr>
		                 <tr>
                               <td class = "text-left" width="25%"><?php echo $name_field; ?></td>
                               <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="name" value = "<?php echo $name ?>"/></td>
			                   <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="name" <?php if ($name_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr>
		                 <tr>
                                <td class = "text-left" width="25%"><?php echo $model_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="model" value = "<?php echo $model ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="model" <?php if ($model_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr>
		                 <tr>
                                <td class = "text-left" width="25%"><?php echo $price_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="price" value = "<?php echo $price ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="price" <?php if ($price_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr>
		                 <tr>
                                <td class = "text-left" width="25%"><?php echo $guantity_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="guantity" value = "<?php echo $guantity ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="guantity" <?php if ($guantity_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr> 
		                 <tr>
                                <td class = "text-left" width="25%"><?php echo $statusenabled_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="statusenabled" value = "<?php echo $statusenabled ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="statusenabled" <?php if ($statusenabled_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr> 
		                 <tr>
                                <td class = "text-left" width="25%"><?php echo $sku_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="sku" value = "<?php echo $sku ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="sku" <?php if ($sku_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr>
                         <tr>
                                <td class = "text-left" width="25%"><?php echo $manufacturer_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30"  class = "settings_value" name="manufacturer" value = "<?php echo $manufacturer ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="manufacturer" <?php if ($manufacturer_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr>
                         <tr>
                                <td class = "text-left" width="25%"><?php echo $description_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30" class = "settings_value" name="description" value = "<?php echo $description ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name="description" <?php if ($description_checked){ ?> checked = "checked" <?php } ?>/></td>
                         </tr> 
                         <tr>
                                <td class = "text-left" width="25%"><?php echo $categories_field; ?></td>
                                <td class = "text-left"><input type="text"  size ="30" class = "settings_value" name="categories"  value = "<?php echo $categories ?>"/></td>
			                    <td class = "text-left" width = "55%"><input type="checkbox" class="checked_setting" name = "categories" <?php if ($categories_checked){ ?> checked = "checked" <?php } ?> /></td>
                         </tr>
						 <tr>
                            <td class = "text-left" width="25%"><?php echo $max_execution_time; ?></td>
		                    <td class = "text-left"><input type="text"  size ="10" class = "settings_value"  name="max_size" value = "<?php echo $max_size ?>"/>&nbsp; <?php echo $time_description; ?></td>
                        </tr> 					
	               </table>  
             </form>
		 </div>
	  </div>	
    </div>
	<div class="page-header">
	    <div class = "container-fluid">
		    <div class = "pull-right">
                <button class = "btn btn-primary" onclick="EnterSetting();" type="button"><?php echo $button_enter; ?></button>
            </div>
			<h1><?php echo $setting_export; ?></h1>
		</div>
	</div>
	<div class="container-fluid">
	    <div class = "panel panel-default">
		    <div class = "panel-heading">
			    <h3 class = "panel-title"><?php echo  $export_title; ?></h3>
			</div>
		<div class = "panel-body">	
		     <form action="<#>" method="post" id="setting_import" name = "form_settings">
			      <table class="table table-bordered table-hover">
                        <tr>
                             <td class="text-left"><?php echo $image_field; ?></td>
                             <td class = "text-left"><input type="text" size ="30"  class = "settings_value_export" name="image_export" value = "<?php echo $image_export ?>"/></td>
			                 <td class = "text-left"><input type="checkbox" class="checked_setting_export" name="image_export" <?php if ($image_checked_export){ ?> checked = "checked" <?php } ?>/></td>
		                </tr>
		                <tr>
                              <td class = "text-left"><?php echo $name_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30"  class = "settings_value_export" name="name_export" value = "<?php echo $name_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="name_export" <?php if ($name_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr>
		                <tr>
                              <td class = "text-left"><?php echo $model_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30"  class = "settings_value_export" name="model_export" value = "<?php echo $model_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="model_export" <?php if ($model_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr>
		                <tr>
                              <td class = "text-left"><?php echo $price_field; ?></td>
                              <td class = "text-left" ><input type="text"  size ="30"  class = "settings_value_export" name="price_export" value = "<?php echo $price_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="price_export" <?php if ($price_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr>
		                <tr>
                              <td class = "text-left" ><?php echo $guantity_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30"  class = "settings_value_export" name="guantity_export" value = "<?php echo $guantity_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="guantity_export" <?php if ($guantity_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr> 
		                <tr>
                              <td class = "text-left"><?php echo $statusenabled_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30"  class = "settings_value_export" name="statusenabled_export" value = "<?php echo $statusenabled_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="statusenabled_export" <?php if ($statusenabled_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr> 
		                <tr>
                              <td class = "text-left"><?php echo $sku_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30"  class = "settings_value_export" name="sku_export" value = "<?php echo $sku_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="sku_export" <?php if ($sku_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr>
                        <tr>
                              <td class = "text-left"><?php echo $manufacturer_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30"  class = "settings_value_export" name="manufacturer_export" value = "<?php echo $manufacturer_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="manufacturer_export" <?php if ($manufacturer_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr>
                        <tr>
                              <td class = "text-left"><?php echo $description_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30" class = "settings_value_export" name="description_export" value = "<?php echo $description_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name="description_export" <?php if ($description_checked_export){ ?> checked = "checked" <?php } ?>/></td>
                        </tr> 
                        <tr>
                              <td class = "text-left"><?php echo $categories_field; ?></td>
                              <td class = "text-left"><input type="text"  size ="30" class = "settings_value_export" name="categories_export"  value = "<?php echo $categories_export ?>"/></td>
			                  <td width = "55%"><input type="checkbox" class="checked_setting_export" name = "categories_export" <?php if ($categories_checked_export){ ?> checked = "checked" <?php } ?> /></td>
                        </tr>
		                <tr>
                              <td colspan = "3" class = "text-left">
							  	   <div class = "panel-heading">
			                            <h3 class = "panel-title"><?php echo $number_column; ?></h3>
			                        </div>
							   </td>
                        </tr>
		                <tr>
                               <td width="25%"><?php echo $image_field; ?></td>
                               <td><input type="text" size ="30"  class = "settings_value_export" name="image_number" value = "<?php echo $image_number ?>"/></td>
		                </tr>
		                <tr>
                               <td width="25%"><?php echo $name_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="name_number" value = "<?php echo $name_number ?>"/></td>
                        </tr>
		                <tr>
                               <td width="25%"><?php echo $model_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="model_number" value = "<?php echo $model_number ?>"/></td>
                        </tr>
		                <tr>
                               <td width="25%"><?php echo $price_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="price_number" value = "<?php echo $price_number ?>"/></td>
                        </tr>
		                <tr>
                               <td width="25%"><?php echo $guantity_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="guantity_number" value = "<?php echo $guantity_number ?>"/></td>
                        </tr> 
		                <tr>
                               <td width="25%"><?php echo $statusenabled_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="statusenabled_number" value = "<?php echo $statusenabled_number ?>"/></td>
                        </tr> 
		                <tr>
                               <td width="25%"><?php echo $sku_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="sku_number" value = "<?php echo $sku_number ?>"/></td>
                        </tr>
                        <tr>
                               <td width="25%"><?php echo $manufacturer_field; ?></td>
                               <td><input type="text"  size ="30"  class = "settings_value_export" name="manufacturer_number" value = "<?php echo $manufacturer_number ?>"/></td>
                        </tr>
                        <tr>
                               <td width="25%"><?php echo $description_field; ?></td>
                               <td><input type="text"  size ="30" class = "settings_value_export" name="description_number" value = "<?php echo $description_number ?>"/></td>
                        </tr> 
                        <tr>
                               <td width="25%"><?php echo $categories_field; ?></td>
                               <td><input type="text"  size ="30" class = "settings_value_export" name="categories_number"  value = "<?php echo $categories_number ?>"/></td>
	        </table> 
          </form>
        </div>
	  </div>
    </div>
</div>
<script type="text/javascript">

var allow = "<?php echo $settings_on; ?>";
var execImport = false; 
var send = {};
setTimeout(function(){receiveAjax('', '', 8) }, 1000);

function checkFileSize(id) {
	//
	var input, file, file_size;
	

	if (!window.FileReader) {
		// The file API isn't yet supported on user's browser
		return true;
	}

	input = document.getElementById(id);
	if (!input) {
		// couldn't find the file input element
		return true;
	}
	else if (!input.files) {
		// browser doesn't seem to support the `files` property of file inputs
		return true;
	}
	else if (!input.files[0]) {
		// no file has been selected for the upload
		alert( "<?php echo $error_select_file; ?>" );
		return false;
	}
	else {
		file = input.files[0];
		file_size = file.size;
		<?php if (!empty($post_max_size)) { ?>
		// check against PHP's post_max_size
		post_max_size = <?php echo $post_max_size; ?>;
		if (file_size > post_max_size) {
			alert( "<?php echo $error_post_max_size; ?>" );
			return false;
		}
		<?php } ?>
		<?php if (!empty($upload_max_filesize)) { ?>
		// check against PHP's upload_max_filesize
		upload_max_filesize = <?php echo $upload_max_filesize; ?>;
		if (file_size > upload_max_filesize) {
			alert( "<?php echo $error_upload_max_filesize; ?>" );
			return false;
		}
		<?php } ?>
		return true;
	}
}

//Show progress of process of import
function progressBar(n) {
  
  
      var bar = $('.progress-bar');
	  
	  var width = n;
	  
	  bar.attr({'aria-valuenow':width});
	  
      $(bar).each(function(){
            $(this).width(width + '%');
		    $(this).text(width + '%');
	  });

}
  
//Reset error  
function resetError() {
   
	receiveAjax('', '', 6); 
}

//Send AJAX for changing mode of work	  
function receiveAjax(value, settings, command){

          $.ajax({ url:'index.php?route=module/excel_maker/main&token=<?php echo $url; ?>',
           type: "Post",
		   data: {'command': command, 'value':JSON.stringify(value), 'settings':JSON.stringify(settings)},
		   dataType: "json",
		   cache:false,
		   timeout: 60000,
           success: function(data){ 
		                            
									if (data) {
									
									   if (data.action == '2') {                          //Is module ready?
									   
									       allow = true;                                  //Yes
										   
									   } else { 
									   
									       allow = false;                                 //No
									                                     
									   }
									}  
									   var error = "<?php echo $error_warning; ?>";
									   var sucess = "<?php echo $success; ?>";
									   
									   if(data.status !== 'Error') {
									   
									      if (sucess == '') {
										  
										      statusModule(data.status, '#32CD32');
										      messageModule(data.message, '#32CD32');
										     
											  
										  } else {
										  
										       statusModule(data.status, '#32CD32');
										       messageModule(data.message, '#32CD32');
											   sucess = "";
										  }
									      
										
									   } else {
									   
									        if (error == '') {
										  
										        statusModule(data.status, '#FF6347');
										        messageModule(data.message, '#FF6347');
										    
										  
										    } else {
										  
										        statusModule(data.status, '#FF6347');
										        messageModule(data.message, '#FF6347');
										        error = "";
											
										    }
				
										  
									   }
									   
									   if ((data.action == '4') && (data.check == '2')) {                     //Is import continuing?
									   
									     progressBar(data.progress);
										 messageModule(data.message, '#32CD32');
										 execImport = true;                                                   //Yes
										 makeImport();
										  
									   } else if ((data.action == '4') && (data.check == '1')) {              //Is import continuing?
									   
									       receiveAjax('', '', 4);
										   messageModule(data.message, '#32CD32');
			                         
									   } else if((data.import == '1') && (data.check == '0')) {                //Does check finish?
									   
									        execImport = false;                                                //No
											statusModule(data.status, '#FF6347');
											messageModule("<?php echo $error_interrupt_import; ?>",'#FF6347');
						       
									   } else {
									   
									        execImport = false; //No
										     
									   }
									   
								  },
		   error: function(){ alert("<?php echo $text_modified_error; ?>");}					  
           								  
           });
  
    } 
	
	
//Enter setting for module
function EnterSetting() {

  var settings = {};
  
  var value = {};
  
  var settings_value = document.getElementsByClassName("settings_value");
 
  var status = document.getElementsByClassName("checked_setting");
  
  for (var i = 0; i < status.length; i++){
  
       if (status[i].type == 'checkbox'){
	   
	      settings[status[i].name] = status[i].checked;
	   
	   }
   }
   
     
   
     for (var i = 0; i < settings_value.length; i++){
  
          value[settings_value[i].name] = settings_value[i].value;
	   
	}
	
	settings_value = document.getElementsByClassName("settings_value_export");
 
    status = document.getElementsByClassName("checked_setting_export");
  
    for (var i = 0; i < status.length; i++) {
  
         if (status[i].type == 'checkbox') {
	   
	         settings[status[i].name] = status[i].checked;
	   
	     }
   }
   
     
   
     for (var i = 0; i < settings_value.length; i++){
  
          value[settings_value[i].name] = settings_value[i].value;
	   
	}
	

    if (Number(value['max_size']) < 30) {
	
	        alert("<?php echo $text_error_max_row; ?>");
			
	} else {
	
	    if (!execImport) {
		 
	        receiveAjax(value, settings, 1);
	    }
	}
}

//Show status of module
function statusModule(status, color) {

       var status;
       var color;

	   $("#status_module").text(status).css({'color': color}); 

}

//Show message of module
function messageModule(message, color) {

     var message;
     var color;

     $("#message_module").text(message).css({'color': color});
}
	
//Executing export of file	
function exportFile() {

    if (allow) { 
	
	    alert("<?php echo $text_export_started; ?>");
		document.location = "index.php?route=module/excel_maker/main&command=5&token=<?php echo $url; ?>";
	} else {
    
	    alert("<?php echo $text_help_export; ?>");
	}
        

}

   
//Executing import of file
function makeImport() {

     if (execImport) {
	 
	       var action = 7;
	       $.ajax({ url:'index.php?route=module/excel_maker/main&token=<?php echo $url; ?>',
           type: "Post",
		   data: {'command': action},
		   dataType: "json",
		   cache:false,
		   timeout: 600000,
           success: function(data){
		   
		   
		      if(data.status !== 'Error') {
			  
		          if (data.action == '4') {
			      
				      progressBar(data.progress);
					  statusModule(data.status, '#32CD32');
			          messageModule(data.message, '#32CD32');
					  makeImport();
					  
			      } else {
			     
			          if (data.action == '2') {                                          //Is module ready?
		             
						   allow = true;                                                  //Yes
				      }
					 
			          statusModule(data.status, '#32CD32');
					  messageModule(data.message, '#32CD32');
					  progressBar(data.progress);
			          execImport = false;
				  }
			  } else {
			  
			       statusModule(data.status, '#FF6347');
			       messageModule(data.message, '#FF6347');
				   execImport = false;
				   
				   if (data.action !== '2') {                                            //Is module ready?
		           
						 allow = false;                                                  //No
						 
				   }
				   
			  
			  }
	  
		   }
	 
	     })
	 }
   
  }
  
//Execute import of file
function importFile() {

    
	if (allow) {
	   
		receiveAjax('', '', 4);
		
	}
}

//Upload file into server
function upload() {

    
	if (checkFileSize('upload') && allow) {
	   
		$('#form').submit();
		
	}
}
</script>
<?php echo $footer; ?>