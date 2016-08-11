<?php 
class ControllerModuleExcelMaker extends Controller { 
	private $error = array();
	private $value = array();
	private $setting = array();
	
	public function index() {
		$this->load->language('module/excel_maker');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('module/excel_maker');
		$this->OutWiev();
	}

	//Function that will be call during install module
	public function install()
	{
	    $this->load->model('module/excel_maker');
	    $this->model_module_excel_maker->install();
		$path = substr_replace(__DIR__, '/excelmaker', strpos(__DIR__, "admin") - 1);
		//Creating the folder for file of price
		if (!mkdir($path, 0755)) {
            
			error_log(date('Y-m-d H:i:s - ', time()).'The folder cannot be created!'."\n",3,DIR_LOGS."error.log");
        }
		
	   
	}
	
	//Function will be call during uninstall module
	public function uninstall()
	{
	    $this->load->model('module/excel_maker');
	    $this->model_module_excel_maker->uninstall();
		
		//Removes spreadsheet file and his folder
	    $path = substr_replace(__DIR__, '/excelmaker', strpos(__DIR__, "admin") - 1);
						
	    $this->deletedir($path);
	
	}
	
	//Deletes folder
	private function deletedir($dir)
    {
        if (is_dir($dir))
        {
            $files = scandir($dir);
            foreach ($files as $file)
            {
                if ($file != "." && $file != "..")
                {
                    if (filetype($dir."/".$file) == "dir")
                    {
                        $this->deletedir($dir."/".$file);
                    }
                    else
                    {
                        unlink($dir."/".$file);
                    }
                }
            }
         
            if(rmdir($dir))
            {
                 error_log(date('Y-m-d H:i:s - ', time()).'Folder excelmaker was removed'."\n",3,DIR_LOGS."error.log");
            }
            else
            {
                error_log(date('Y-m-d H:i:s - ', time()).'Delete failed folder excelmaker'."\n",3,DIR_LOGS."error.log");
            }
        }
        else
        {
                error_log(date('Y-m-d H:i:s - ', time()).'Folder of excelmaker was not found'."\n",3,DIR_LOGS."error.log");
        }
    }
	
	//This function making import file into DB
	protected function executeFile(){
	 
	               $this->load->model('module/excel_maker');
				   $this->load->language('module/excel_maker');  
	               //$file = '../excelmaker/export_price.xlsx';
				 
                   $path = substr_replace(__DIR__, '/excelmaker/export_price.xlsx', strpos(__DIR__, "admin") - 1);
					 
					  if (!file_exists($path))
					  {
					     error_log(date('Y-m-d H:i:s - ', time()).'The file export_price.xlsx is not existed'."\n",3,DIR_LOGS."error.log");
					    $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
					  }
		
			         return $this->model_module_excel_maker->execute($path, $this->session->data['value'], $this->session->data['settings']);
	}
	
	
	//This function ending import
    protected function endImport(){
	
	           $this->load->model('module/excel_maker');
			   $this->load->language('module/excel_maker');
			   $path = substr_replace(__DIR__, '/excelmaker/export_price.xlsx', strpos(__DIR__, "admin") - 1);
			    
				if ($this->model_module_excel_maker->endExecute($path)== TRUE) {
					
				    return true;
				}	
				else 
				{
				    return false;
					        
				}
			  
	
	}
	
	protected function calculateRows(){
	
	                
					  $path = substr_replace(__DIR__, '/excelmaker/export_price.xlsx', strpos(__DIR__, "admin") - 1);
					  if (!file_exists($path))
					  {
					     error_log(date('Y-m-d H:i:s - ', time()).'The file export_price.xlsx is not existed'."\n",3,DIR_LOGS."error.log");
					     return false;
					  }
					  
					
	               
					     $this->load->model('module/excel_maker');
						$this->load->language('module/excel_maker');
						
	     		        return $this->model_module_excel_maker->calculate($path);
					       

			  
		        
	        }
	
	protected function checkFile(){
	
	                 
					  $file = substr_replace(__DIR__, '/excelmaker/export_price.xlsx', strpos(__DIR__, "admin") - 1);
					  
					  if (!file_exists($file))
					  {
					     error_log(date('Y-m-d H:i:s - ', time()).'The file export_price.xlsx is not existed'."\n",3,DIR_LOGS."error.log");
					     return false;
					  }
					  
					
	               
					     $this->load->model('module/excel_maker');
						$this->load->language('module/excel_maker');
						
	     		        if ($this->model_module_excel_maker->check($file, $this->session->data['value'], $this->session->data['settings'])==TRUE) {
					       
						   return true;
				        }	
				        else 
				        {
						    return false;
					        
				        }
			  
		        
	        }
			
		protected function upload(){
	
	     		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			        if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
   
                      
                        // If this request falls under any of them, treat it invalid.
                        if (!isset($this->request->files['upload']['error']) || is_array($this->request->files['upload']['error'])) 
						{
						  
                            error_log(date('Y-m-d H:i:s - ', time()).'Invalid parameters of upload file'."\n",3,DIR_LOGS."error.log");
                            return false;
					   }

                        
                        switch ($this->request->files['upload']['error']) 
						{
                              case UPLOAD_ERR_OK:
                              break;
							  
                              case UPLOAD_ERR_NO_FILE:
							    
							       error_log(date('Y-m-d H:i:s - ', time()).'No file sent'."\n",3,DIR_LOGS."error.log");
						           return false;
							  break;
							  
                              case UPLOAD_ERR_INI_SIZE:
							  break;
							  
                              case UPLOAD_ERR_FORM_SIZE:
							     
							       error_log(date('Y-m-d H:i:s - ', time()).'Exceeded filesize limit'."\n",3,DIR_LOGS."error.log");							  
							       return false;
							  break;
							  
                        }

                        //Check filesize here.
                        if ($this->request->files['upload']['size'] > 81920000) 
						{
						   error_log(date('Y-m-d H:i:s - ', time()).'Exceeded filesize limit'."\n",3,DIR_LOGS."error.log");							    
                           return false;
						}

                        // Check MIME Type.
						 $extentions = array(".xlsx");
						if(!in_array(strrchr($this->request->files['upload']['name'], "."),$extentions))
						{
						   error_log(date('Y-m-d H:i:s - ', time()).'Incorrect type of upload file'."\n",3,DIR_LOGS."error.log");						   
		                   return false;
		                }
						
                        //Save file in folder with name "export_price"
						
						$type = $this->request->files['upload']['name'];
						$type = substr($type, strpos($type, '.') + 1);
						$ext = 'export_price' . '.' . $type;
						$uploads_dir = substr_replace(__DIR__, '/excelmaker/', strpos(__DIR__, "admin") - 1); '../excelmaker/';
						$path = $uploads_dir . $ext;
						
						if (file_exists($path))
						{
						   unlink($path);
						}
						
                        if (!move_uploaded_file($this->request->files['upload']['tmp_name'], $uploads_dir . $ext)) 
						{
						      return false;
						      error_log(date('Y-m-d H:i:s - ', time()).'Failed to move uploaded file'."\n",3,DIR_LOGS."error.log");	
                      
                        }
						
						chmod($path, 0777);
						
						return true;
			       }
				   else
				   {
				       return false;
				   }
		        }
				else
				{
				    return false;
				}
	        }

    protected function OutWiev(){	

		if (!empty($this->session->data['export_error']['errstr'])) {
			$this->error['warning'] = $this->session->data['export_error']['errstr'];
			if (!empty($this->session->data['export_nochange'])) {
				$this->error['warning'] .= '<br />'.$this->language->get( 'text_nochange' );
			}
			$this->error['warning'] .= '<br />'.$this->language->get( 'text_log_details' );
		}
		unset($this->session->data['export_error']);
		unset($this->session->data['export_nochange']);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['setting_import'] = $this->language->get('setting_import');
		$data['import_title'] = $this->language->get('import_title');
		$data['entry_restore'] = $this->language->get('entry_restore');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['image_field'] = $this->language->get('image_field');
		$data['name_field'] = $this->language->get('name_field');
		$data['model_field'] = $this->language->get('model_field'); 
		$data['price_field'] = $this->language->get('price_field');
		$data['guantity_field'] = $this->language->get('guantity_field');
		$data['statusenabled_field'] = $this->language->get('statusenabled_field');
		$data['sku_field'] = $this->language->get('sku_field');
		$data['manufacturer_field'] = $this->language->get('manufacturer_field');
		$data['description_field'] = $this->language->get('description_field');
		$data['categories_field'] = $this->language->get('categories_field');
		$data['row_size'] = $this->language->get('row_size');
		$data['min_size_comment'] = $this->language->get('min_size_comment');
		$data['max_size_comment'] = $this->language->get('max_size_comment');
		$data['separator_export'] = $this->language->get('separator_export');
		$data['separator_import'] = $this->language->get('separator_import');
		$data['button_import'] = $this->language->get('button_import');
		$data['button_export'] = $this->language->get('button_export');
		$data['button_enter'] = $this->language->get('button_enter');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['error_select_file'] = $this->language->get('error_select_file');
		$data['error_post_max_size'] = str_replace( '%1', ini_get('post_max_size'), $this->language->get('error_post_max_size') );
		$data['error_upload_max_filesize'] = str_replace( '%1', ini_get('upload_max_filesize'), $this->language->get('error_upload_max_filesize') );
        $data['url'] = $this->session->data['token'];
		$data['setting_export'] = $this->language->get('setting_export');
		$data['export_title'] = $this->language->get('export_title');
		$data['max_execution_time'] = $this->language->get('max_execution_time');
		$data['time_description'] = $this->language->get('time_description');
		$data['row_size_export'] = $this->language->get('row_size_export');
		$data['number_column'] = $this->language->get('number_column');
		
		If (empty($this->session->data['value'])){
		    $this->session->data['value']['image']= $this->language->get('not_data');
		    $this->session->data['value']['value']= $this->language->get('not_data');
	        $this->session->data['value']['name']= $this->language->get('not_data');
		    $this->session->data['value']['model']=$this->language->get('not_data');
	        $this->session->data['value']['price']=$this->language->get('not_data');
	        $this->session->data['value']['guantity']=$this->language->get('not_data');
		    $this->session->data['value']['statusenabled']=$this->language->get('not_data');
		    $this->session->data['value']['sku']=$this->language->get('not_data');
	        $this->session->data['value']['manufacturer']=$this->language->get('not_data');
		    $this->session->data['value']['description']=$this->language->get('not_data');
		    $this->session->data['value']['categories']=$this->language->get('not_data');
		    $this->session->data['value']['max_size'] = 30;
		    $this->session->data['value']['image_export']= $this->language->get('not_data');
		    $this->session->data['value']['value_export']= $this->language->get('not_data');
	        $this->session->data['value']['name_export']= $this->language->get('not_data');
		    $this->session->data['value']['model_export']=$this->language->get('not_data');
	        $this->session->data['value']['price_export']=$this->language->get('not_data');
	        $this->session->data['value']['guantity_export']=$this->language->get('not_data');
		    $this->session->data['value']['statusenabled_export']=$this->language->get('not_data');
		    $this->session->data['value']['sku_export']=$this->language->get('not_data');
	        $this->session->data['value']['manufacturer_export']=$this->language->get('not_data');
		    $this->session->data['value']['description_export']=$this->language->get('not_data');
		    $this->session->data['value']['categories_export']=$this->language->get('not_data');
			$this->session->data['value']['image_number']= $this->language->get('not_number');
		    $this->session->data['value']['value_number']= $this->language->get('not_number');
	        $this->session->data['value']['name_number']= $this->language->get('not_number');
		    $this->session->data['value']['model_number']=$this->language->get('not_number');
	        $this->session->data['value']['price_number']=$this->language->get('not_number');
	        $this->session->data['value']['guantity_number']=$this->language->get('not_number');
		    $this->session->data['value']['statusenabled_number']=$this->language->get('not_number');
		    $this->session->data['value']['sku_number']=$this->language->get('not_number');
	        $this->session->data['value']['manufacturer_number']=$this->language->get('not_number');
		    $this->session->data['value']['description_number']=$this->language->get('not_number');
		    $this->session->data['value']['categories_number']=$this->language->get('not_number');
		}
		
		If (empty($this->session->data['settings'])){
		    $this->session->data['settings']['image']=0;
            $this->session->data['settings']['name']=0;
		    $this->session->data['settings']['model']=0;
	        $this->session->data['settings']['price']=0;
	        $this->session->data['settings']['guantity']=0;
	        $this->session->data['settings']['statusenabled']=0;
		    $this->session->data['settings']['sku']=0;
	        $this->session->data['settings']['manufacturer']=0;
		    $this->session->data['settings']['description']=0;
		    $this->session->data['settings']['categories']=0;
		    $this->session->data['settings']['image_export']=0;
            $this->session->data['settings']['name_export']=0;
		    $this->session->data['settings']['model_export']=0;
	        $this->session->data['settings']['price_export']=0;
	        $this->session->data['settings']['guantity_export']=0;
	        $this->session->data['settings']['statusenabled_export']=0;
		    $this->session->data['settings']['sku_export']=0;
	        $this->session->data['settings']['manufacturer_export']=0;
		    $this->session->data['settings']['description_export']=0;
		    $this->session->data['settings']['categories_export']=0;
	    }
		
		if (empty($this->session->data['settings_on'])){
		
		    $this->session->data['settings_on']=0;
		}
		
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => FALSE
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/excel_maker', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$data['action'] = $this->url->link('module/excel_maker/main&command=3', 'token=' . $this->session->data['token'], 'SSL');
		$data['export'] = $this->url->link('module/excel_maker/download', 'token=' . $this->session->data['token'], 'SSL');
		$data['post_max_size'] = $this->return_bytes( ini_get('post_max_size') );
	    $data['text_modified_ok'] = $this->language->get('text_modified_ok');
		$data['text_modified_error'] = $this->language->get('text_modified_error');
		$data['text_error_end_row'] = $this->language->get('text_error_end_row');
		$data['text_error_max_row'] = $this->language->get('text_error_max_row');
	    $data['text_row_number_zero'] = $this->language->get('text_row_number_zero');
		$data['text_export_started'] = $this->language->get('text_export_started');
		$data['text_help_export'] = $this->language->get('text_help_export');
		$data['upload_max_filesize'] = $this->return_bytes( ini_get('upload_max_filesize') );
		$data['text_settings_ok'] = $this->language->get('text_settings_ok');
		$data['error_interrupt_import'] = $this->language->get('error_interrupt_import');
		$data['settings_on'] =  $this->session->data['settings_on'];
		
		$this->Output($data);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/excel_maker.tpl', $data)); 
	}
	
	protected function detect_encoding( $str ) {
		// auto detect the character encoding of a string
		return mb_detect_encoding( $str, 'UTF-8,ISO-8859-15,ISO-8859-1,cp1251,KOI8-R' );
	}
	
	 protected function Output(&$data){		
		$data['image'] = $this->session->data['value']['image'];
		$data['name'] = $this->session->data['value']['name'];
		$data['model'] = $this->session->data['value']['model'];
		$data['price'] = $this->session->data['value']['price'];
		$data['guantity'] = $this->session->data['value']['guantity'];
		$data['statusenabled'] = $this->session->data['value']['statusenabled'];
		$data['sku'] = $this->session->data['value']['sku'];
		$data['manufacturer'] = $this->session->data['value']['manufacturer'];
		$data['description'] = $this->session->data['value']['description'];
		$data['categories'] = $this->session->data['value']['categories'];
		$data['max_size'] = $this->session->data['value']['max_size'];
		$data['image_checked'] = $this->session->data['settings']['image'];
		$data['name_checked'] = $this->session->data['settings']['name'];
		$data['model_checked'] = $this->session->data['settings']['model'];
		$data['price_checked'] = $this->session->data['settings']['price'];
		$data['guantity_checked'] = $this->session->data['settings']['guantity'];
		$data['statusenabled_checked'] = $this->session->data['settings']['statusenabled'];
		$data['sku_checked'] = $this->session->data['settings']['sku'];
		$data['manufacturer_checked'] = $this->session->data['settings']['manufacturer'];
		$data['description_checked'] = $this->session->data['settings']['description'];
		$data['categories_checked'] = $this->session->data['settings']['categories'];
		$data['settings_on'] = $this->session->data['settings_on'];
		$data['image_export'] = $this->session->data['value']['image_export'];
		$data['name_export'] = $this->session->data['value']['name_export'];
		$data['model_export'] = $this->session->data['value']['model_export'];
		$data['price_export'] = $this->session->data['value']['price_export'];
		$data['guantity_export'] = $this->session->data['value']['guantity_export'];
		$data['statusenabled_export'] = $this->session->data['value']['statusenabled_export'];
		$data['sku_export'] = $this->session->data['value']['sku_export'];
		$data['manufacturer_export'] = $this->session->data['value']['manufacturer_export'];
		$data['description_export'] = $this->session->data['value']['description_export'];
		$data['categories_export'] = $this->session->data['value']['categories_export'];
		$data['image_number'] = $this->session->data['value']['image_number'];
		$data['name_number'] = $this->session->data['value']['name_number'];
		$data['model_number'] = $this->session->data['value']['model_number'];
		$data['price_number'] = $this->session->data['value']['price_number'];
		$data['guantity_number'] = $this->session->data['value']['guantity_number'];
		$data['statusenabled_number'] = $this->session->data['value']['statusenabled_number'];
		$data['sku_number'] = $this->session->data['value']['sku_number'];
		$data['manufacturer_number'] = $this->session->data['value']['manufacturer_number'];
		$data['description_number'] = $this->session->data['value']['description_number'];
		$data['categories_number'] = $this->session->data['value']['categories_number'];
		$data['image_checked_export'] = $this->session->data['settings']['image_export'];
		$data['name_checked_export'] = $this->session->data['settings']['name_export'];
		$data['model_checked_export'] = $this->session->data['settings']['model_export'];
		$data['price_checked_export'] = $this->session->data['settings']['price_export'];
		$data['guantity_checked_export'] = $this->session->data['settings']['guantity_export'];
		$data['statusenabled_checked_export'] = $this->session->data['settings']['statusenabled_export'];
		$data['sku_checked_export'] = $this->session->data['settings']['sku_export'];
		$data['manufacturer_checked_export'] = $this->session->data['settings']['manufacturer_export'];
		$data['description_checked_export'] = $this->session->data['settings']['description_export'];
		$data['categories_checked_export'] = $this->session->data['settings']['categories_export'];
		}
	

	//Main final switch of conditions
	
    public function main(){
	
	      $this->load->model('module/excel_maker');
		
        if(($this->model_module_excel_maker->excelMakerRead('switch') == 2) && empty($this->session->data['excel_maker']['run'])){
		
		     $this->model_module_excel_maker->excelMakerUpdate('switch', 0);
		}
		
		if (empty($this->session->data['excel_maker']['run'])){
		
		    $this->session->data['excel_maker']['run']= 1;
		}
	
	     $command = 0;
		 
		 $message = 0;
		 
		 $execute = 0;
		 
		 $out = array ( 'status' => '0', 
		                'result' => 'Action not exists!', 
						'message' => 'Action has not been done',
						'import'  => '0',
						'check'  => '0',
						'action'  => '0',
						'progress' => '0'
					   );
		 

		 
		 //If with client side data has transmitted in GET format
		 
		 if (($this->request->server['REQUEST_METHOD'] == 'GET') &&  ($this->validate()) && (($this->request->get['command'] == 5) || ($this->request->get['command'] == 3)))  
		 {
		 
		     $command = $this->request->get['command'];
		 }
		 
		 //If with client side data has transmitted in POST format
		 
		 if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) 
		 {
		     if(!empty($this->request->post['command']))
			 {
		        $command = $this->request->post['command'];
			 }
			 else
			 {
			   $command = $this->request->get['command'];
			 }
		 }
		 
		 
		 if ($this->validate()) 
		 {
		    
			//Decoding received data
			
			for ($count = 0; $count < 2; $count++)
			{
			
		         switch ($this->model_module_excel_maker->excelMakerRead('switch'))
			     {
			 
			           //Default state
				
			           case 0:
				              if ($command == 1)
					          {
					              $this->model_module_excel_maker->excelMakerUpdate('switch', 1);
					          }
							  else if($command == 5)
							  {
							       $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
								   $message = 1;
							  }
					          else
					          {
					              $message = 0;
					          }
				   
			            break;
				
				        //Set settings for import or export;
				
				        case 1:
				               if ($command == 1)
					           {
						
						           //Checking set of settings
						   
						           if ($this->settings())              
						           {
								      $this->model_module_excel_maker->excelMakerUpdate('switch', 2);//Settings has been set  
									  $message = 2;
						           }
						           else
						           {
								        
						               $this->model_module_excel_maker->excelMakerUpdate('switch', 6); //Settings has not been set
									   $message = 4;
						          
						           }
					            }
								else if($command == 5)
							    {
								   $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
								   $message = 1;
							    }
	                            else
					            {
								    
					                   $message = 0;
					            }
			             break;
				
				         //Module is ready
				
				         case 2:
				     	        if ($command == 1)
					            {
								    $this->model_module_excel_maker->excelMakerUpdate('switch', 1);
					               
					               
					            }
					            else if ($command == 3)
		                        {
								     $this->model_module_excel_maker->excelMakerUpdate('switch', 3);
					               
					                 
					            }
								else if ($command == 4)
		                        {
								     $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
					                
					                
					            }
						        else if ($command == 5)
						        {
								     $this->model_module_excel_maker->excelMakerUpdate('switch', 5);
						           
					                
						
						        }
						        else
					            {
								    
					                 $message = 0;
					            }
			             break;
				
				         //Download file on the server;
				
				         case 3:
				    	        if ($command == 3)
					            {
								    if ($this->upload())
									{
									     $message = 4;
										 $this->model_module_excel_maker->excelMakerUpdate('switch', 2);
										 $this->index();
									}
									else
									{
									     $message = 5;
										 $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
									   
									}
									
					          
					            }
								else if($command == 5)
							    {
								   $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
								   $message = 1;
							    }
	                            else
					            {
								   
					                $message = 0;
					            }
			             break;
				
				         //Import file
				
				         case 4:
				      	        if (($command == 4) || ($command == 7) || ($command == 0) || ($command == 1))
					            {
								   
									
								    switch ($this->model_module_excel_maker->excelMakerRead('import'))
									{
									   //First action = check file on existence of errors
									   
									   case 0:
									           if ($command == 4)
											   {
											    switch ($this->model_module_excel_maker->excelMakerRead('control'))
												{
												   case 0:
												 
									                      if ($this->checkFile())
									                      {
					                                         $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
													         $this->model_module_excel_maker->excelMakerUpdate('progress', 0);
															 $this->model_module_excel_maker->excelMakerUpdate('control', 1);
													         $message = 10;
					                   
					                                      }
									                      else
									                      {
									                          $message = 11;
									                          $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
													          $this->model_module_excel_maker->excelMakerUpdate('progress', 0);
															  $this->model_module_excel_maker->excelMakerUpdate('control', 0);
									                      }
													break;
													
													case 1:
													
													      if($command == 4)
														  {
														     $make = $this->calculateRows();
															 
													         if ($make['action'] == 'Finish')//Process of calculate rows have been finished
									                         {
											                     $message = 8;
					                                             $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
																 $this->model_module_excel_maker->excelMakerUpdate('control', 2);
					                   
					                                         }
									                         else if ($make['action'] == 'Continue') //Process of calculate rows are continuing
									                         {
									                              $message = 10;
														          $command = 0;
									                              $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
														          $this->model_module_excel_maker->excelMakerUpdate('control', 1);
									                         }
													       }
														   else
												           {
												               $message = 10;
												           }
													
													
													break;
													
													case 2;
													        if ($command == 4)
												            {
															      $message = 10;
														          $command = 0;
									                              $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
														          $this->model_module_excel_maker->excelMakerUpdate('control', 2);
																  $this->model_module_excel_maker->excelMakerUpdate('import', 1);
															
															}
															else
												            {
												               $message = 10;
												            }
															
													break;
												   }
												}
												else
												{
												    $message = 0;
												
												}
											  
									   
									   break;
									   
									   //This function is executing process of import of file into DB
									   
									   case 1:
									           if ($command == 7)
											   {
											       $execute = $this->executeFile();
												   $this->model_module_excel_maker->excelMakerUpdate('control', 0);
												   
									               if ($execute['action'] == 'Finish')//      //Process of import has been finished
									               {
											           $message = 8;
													   $this->model_module_excel_maker->excelMakerUpdate('progress', $execute['progress']);
					                                   $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
										               $this->model_module_excel_maker->excelMakerUpdate('import', 2);
													   $this->model_module_excel_maker->excelMakerUpdate('rows', 0);
													 
					                   
					                               }
									               else if ($execute['action'] == 'Continue') //Process of import is continuing
									               {
									                    $message = 10;
														$command = 0;
														$this->model_module_excel_maker->excelMakerUpdate('progress', $execute['progress']);
									                    $this->model_module_excel_maker->excelMakerUpdate('switch', 4);
														$this->model_module_excel_maker->excelMakerUpdate('import', 1);
									               }
 
												}
												else if ($command == 1)
												{
												       $this->model_module_excel_maker->excelMakerUpdate('import', 0);
												       $this->model_module_excel_maker->excelMakerUpdate('switch', 1); 
												}
												else
												{
												        $message = 10;
												  
												}
									   
									   break;
									   
									   case 2:
									             if ($command == 7)
												 {
												 
												    if ($this->endImport()) //The import has been finished
													{
													    $message = 8;
									                    $this->model_module_excel_maker->excelMakerUpdate('switch', 2);
														$this->model_module_excel_maker->excelMakerUpdate('import', 0);
														$command == 0;
													
													}
													else  //The import has not been finished
													{
													    $message = 9;
									                    $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
														$this->model_module_excel_maker->excelMakerUpdate('import', 0);
														$command == 0;
													
													}
												 }
												 else
												 {
												     $message = 0;
												 
												 }
										 break;
									}
								}
								else if($command == 5)
							    {
							       $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
								   $message = 1;
							    }
	                            else
					            {
								 
					                $message = 0;
					            }
			             break;
				
				         //Export file
				
				         case 5:
				      	        if ($command == 5)
					            {
								   if ($this->exportFile())
								   {
								       
					                   $this->model_module_excel_maker->excelMakerUpdate('switch', 2);
									   $message = 6;
									   
									   
					               }
								   else
								   {
								       $this->model_module_excel_maker->excelMakerUpdate('switch', 6);
									   $message = 7;
                                      
								   }
								}
	                            else
					            {
					             
									  $message = 0;
					            }
			              break;
				
				         //Error
				
				         case 6:
				                if ($command == 6)
					            {
					                 $this->model_module_excel_maker->excelMakerUpdate('switch', 0);
									 $this->model_module_excel_maker->excelMakerUpdate('control', 0);
									 $this->model_module_excel_maker->excelMakerUpdate('import', 0);
					               
					            }

			             break;
				

				}
			}

                //Return messages
                   switch ($message)
				   {
				
				        case 0:
					
					         $out['message'] = 'Have not been done any actions'; 
					
					    break; 
					
					    case 1:
					
					         $out['message'] = 'You cannot do this action'; 
					
					    break;
					
				        case 2:
					
					         $out['message'] = 'Settings have been set'; 
					
					    break; 
					
					    case 3:
					
					         $out['message'] = 'Settings have not been set'; 
					
					    break;

						case 4:
						      $out['message'] = 'The file has been downloaded';
						break;
						
						case 5:
						       $out['message'] = 'The file has not been downloaded';
						break;
						
						case 6:
						       $out['message'] = 'The export has been done';
						break;
						
					    case 7:
						       $out['message'] = 'The export has not been done';
						break;
						
						case 8:
						       $out['message'] = 'The import has been done';
						break;
						
					    case 9:
						       $out['message'] = 'The import has not been done';
						break;
						
						case 10:
						
						        $out['message'] = 'The import is continuing. Please wait';
						break;
						
					    case 11:
						
						        $out['message'] = 'Error during checking file';
						break;
				
				     }
					 
				//Return description of status of import_request_variables
				
				switch ($this->model_module_excel_maker->excelMakerRead('import'))
				{
				
				   case 0:
				               $out['import'] = 0;
							   $out['progress'] = $this->model_module_excel_maker->excelMakerRead('progress');
				   break;
				   
				   case 1:
				               $out['import'] = 1;
							   $out['progress'] = $this->model_module_excel_maker->excelMakerRead('progress');
				   break;
				   
				   case 2:
				               $out['import'] = 2;
							   $out['progress'] = $this->model_module_excel_maker->excelMakerRead('progress');
				   break;
				
				
				}
				
			    //Return description of status of check
				
				switch ($this->model_module_excel_maker->excelMakerRead('control'))
				{
				
				   case 0:
				               $out['check'] = 0;
							   
				   break;
				   
				   case 1:
				               $out['check'] = 1;
							  
				   break;
				   
				   case 2:
				               $out['check'] = 2;
							  
				   break;
				
				
				}


				
				//Return description of status of module
				
				switch ($this->model_module_excel_maker->excelMakerRead('switch'))
			    {
			      case 0: 
				  
				          $out['status'] = 'Default state. Please, enter settings';
						  $out['action'] = 0;
						  $this->response->setOutput(json_encode($out));
			      break;
				  
				  case 1: 
				  
				          $out['status'] = 'Set settings. Please, wait';
						  $out['action'] = 1;
						  $this->response->setOutput(json_encode($out));
			      break;
				  
				  case 2: 
				         
				          $out['status'] = 'Module ready. Please select action';
						  $out['action'] = 2;
						  
						  if (($command != 5) && ($command != 3))
						  {
						     $this->response->setOutput(json_encode($out));
						  }
						  else if ($command == 3)
						  {
						     $this->session->data['success'] = $out['message'];
						     $this->index();
						  }
			      break;
				  
				  case 3: 
				  
						  $out['action'] = 3;
						  exit;
			      break;
				  
				  case 4: 
				  
				          $out['status'] = 'Import file. Please wait. This action may take several minutes!';
						  $out['action'] = 4;
						  $this->response->setOutput(json_encode($out));
			      break;
				  
				  case 5: 
				           $out['action'] = 5; 
				           exit;
						  
			      break;
				  
				  case 6: 
				  
				         
						  
						  if (($command != 5) && ($command != 3))
						  {
						      $out['status'] = 'Error';
							  $out['action'] = 6;
						      $this->response->setOutput(json_encode($out));
						  }
						  else if($command = 5)
						  {
						       $this->load->language('module/excel_maker');
						       $this->error['warning'] = $out['message'];
							   $this->index();
						  }
						  else if($command = 3)
						  {
						       $this->load->language('module/excel_maker');
						       $this->error['warning'] = $out['message'];
							   $this->index();
						  }
			      break;
				 
				  
		     }
				 
				 
				
          }
   }

   //Function is setting settings import or export
   
	protected function settings(){

          if ($this->validate()) {
                 
             	 $value_temp = $this->request->post['value'];
				 $value_temp = str_replace('&quot;', '"' , $value_temp);
				 $this->value = json_decode($value_temp);
				 $settings_temp = $this->request->post['settings'];
				 $settings_temp = str_replace('&quot;', '"' , $settings_temp);
				 $this->settings = json_decode($settings_temp);
				 
				 $this->session->data['value']['image'] = htmlentities( $this->value->image, ENT_QUOTES, $this->detect_encoding($this->value->image));
		         $this->session->data['value']['name'] = htmlentities( $this->value->name, ENT_QUOTES, $this->detect_encoding($this->value->name));
		         $this->session->data['value']['model'] = htmlentities( $this->value->model, ENT_QUOTES, $this->detect_encoding($this->value->model));
		         $this->session->data['value']['price'] = htmlentities( $this->value->price, ENT_QUOTES, $this->detect_encoding($this->value->price));
		         $this->session->data['value']['guantity'] = htmlentities( $this->value->guantity, ENT_QUOTES, $this->detect_encoding($this->value->guantity));
		         $this->session->data['value']['statusenabled'] = htmlentities( $this->value->statusenabled, ENT_QUOTES, $this->detect_encoding($this->value->statusenabled));
		         $this->session->data['value']['sku'] = htmlentities( $this->value->sku, ENT_QUOTES, $this->detect_encoding($this->value->sku));
		         $this->session->data['value']['manufacturer'] = htmlentities( $this->value->manufacturer, ENT_QUOTES, $this->detect_encoding($this->value->manufacturer));
		         $this->session->data['value']['description'] = htmlentities( $this->value->description, ENT_QUOTES, $this->detect_encoding($this->value->description));
		         $this->session->data['value']['categories'] = htmlentities( $this->value->categories, ENT_QUOTES, $this->detect_encoding($this->value->categories));
		         $this->session->data['value']['max_size'] = htmlentities( $this->value->max_size, ENT_QUOTES, $this->detect_encoding($this->value->max_size));
				 $this->session->data['settings']['image'] = $this->settings->image;
		         $this->session->data['settings']['name'] = $this->settings->name;
		         $this->session->data['settings']['model'] = $this->settings->model;
		         $this->session->data['settings']['price'] = $this->settings->price;
		         $this->session->data['settings']['guantity'] = $this->settings->guantity;
		         $this->session->data['settings']['statusenabled'] = $this->settings->statusenabled;
		         $this->session->data['settings']['sku'] = $this->settings->sku;
		         $this->session->data['settings']['manufacturer'] = $this->settings->manufacturer;
		         $this->session->data['settings']['description'] = $this->settings->description;
		         $this->session->data['settings']['categories'] = $this->settings->categories;
				 $this->session->data['value']['image_export'] = htmlentities( $this->value->image_export, ENT_QUOTES, $this->detect_encoding($this->value->image_export));
		         $this->session->data['value']['name_export'] = htmlentities( $this->value->name_export, ENT_QUOTES, $this->detect_encoding($this->value->name_export));
		         $this->session->data['value']['model_export'] = htmlentities( $this->value->model_export, ENT_QUOTES, $this->detect_encoding($this->value->model_export));
		         $this->session->data['value']['price_export'] = htmlentities( $this->value->price_export, ENT_QUOTES, $this->detect_encoding($this->value->price_export));
		         $this->session->data['value']['guantity_export'] = htmlentities( $this->value->guantity_export, ENT_QUOTES, $this->detect_encoding($this->value->guantity_export));
		         $this->session->data['value']['statusenabled_export'] = htmlentities( $this->value->statusenabled_export, ENT_QUOTES, $this->detect_encoding($this->value->statusenabled_export));
		         $this->session->data['value']['sku_export'] = htmlentities( $this->value->sku_export, ENT_QUOTES, $this->detect_encoding($this->value->sku_export));
		         $this->session->data['value']['manufacturer_export'] = htmlentities( $this->value->manufacturer_export, ENT_QUOTES, $this->detect_encoding($this->value->manufacturer_export));
		         $this->session->data['value']['description_export'] = htmlentities( $this->value->description_export, ENT_QUOTES, $this->detect_encoding($this->value->description_export));
		         $this->session->data['value']['categories_export'] = htmlentities( $this->value->categories_export, ENT_QUOTES, $this->detect_encoding($this->value->categories_export));
		         $this->session->data['value']['image_number'] = htmlentities( $this->value->image_number, ENT_QUOTES, $this->detect_encoding($this->value->image_number));
		         $this->session->data['value']['name_number'] = htmlentities( $this->value->name_number, ENT_QUOTES, $this->detect_encoding($this->value->name_number));
		         $this->session->data['value']['model_number'] = htmlentities( $this->value->model_number, ENT_QUOTES, $this->detect_encoding($this->value->model_number));
		         $this->session->data['value']['price_number'] = htmlentities( $this->value->price_number, ENT_QUOTES, $this->detect_encoding($this->value->price_number));
		         $this->session->data['value']['guantity_number'] = htmlentities( $this->value->guantity_number, ENT_QUOTES, $this->detect_encoding($this->value->guantity_number));
		         $this->session->data['value']['statusenabled_number'] = htmlentities( $this->value->statusenabled_number, ENT_QUOTES, $this->detect_encoding($this->value->statusenabled_number));
		         $this->session->data['value']['sku_number'] = htmlentities( $this->value->sku_number, ENT_QUOTES, $this->detect_encoding($this->value->sku_number));
		         $this->session->data['value']['manufacturer_number'] = htmlentities( $this->value->manufacturer_number, ENT_QUOTES, $this->detect_encoding($this->value->manufacturer_number));
		         $this->session->data['value']['description_number'] = htmlentities( $this->value->description_number, ENT_QUOTES, $this->detect_encoding($this->value->description_number));
		         $this->session->data['value']['categories_number'] = htmlentities( $this->value->categories_number, ENT_QUOTES, $this->detect_encoding($this->value->categories_number));
				 $this->session->data['settings']['image_export'] = $this->settings->image_export;
		         $this->session->data['settings']['name_export'] = $this->settings->name_export;
		         $this->session->data['settings']['model_export'] = $this->settings->model_export;
		         $this->session->data['settings']['price_export'] = $this->settings->price_export;
		         $this->session->data['settings']['guantity_export'] = $this->settings->guantity_export;
		         $this->session->data['settings']['statusenabled_export'] = $this->settings->statusenabled_export;
		         $this->session->data['settings']['sku_export'] = $this->settings->sku_export;
		         $this->session->data['settings']['manufacturer_export'] = $this->settings->manufacturer_export;
		         $this->session->data['settings']['description_export'] = $this->settings->description_export;
		         $this->session->data['settings']['categories_export'] = $this->settings->categories_export;
				 $this->session->data['settings_on']= 1;
				 
          
				 
				return true;

		} 
		else 
		{

			// return error
			
			   return false;
		}


    }	
	


	function return_bytes($val)
	{
		$val = trim($val);
	
		switch (strtolower(substr($val, -1)))
		{
			case 'm': $val = (int)substr($val, 0, -1) * 1048576; break;
			case 'k': $val = (int)substr($val, 0, -1) * 1024; break;
			case 'g': $val = (int)substr($val, 0, -1) * 1073741824; break;
			case 'b':
				switch (strtolower(substr($val, -2, 1)))
				{
					case 'm': $val = (int)substr($val, 0, -2) * 1048576; break;
					case 'k': $val = (int)substr($val, 0, -2) * 1024; break;
					case 'g': $val = (int)substr($val, 0, -2) * 1073741824; break;
					default : break;
				} break;
			default: break;
		}
		return $val;
	}
	
	
	//Upload from server
	protected function exportFile() {
	  
        $this->load->language('module/excel_maker');
		$this->document->setTitle($this->language->get('heading_title'));
		 $this->load->model('module/excel_maker');	  
		
		if ($this->validate()) {
           
			// send the categories, products and options as a spreadsheet file
		    if ($this->model_module_excel_maker->download($this->session->data['value'], $this->session->data['settings']))
		    {
		         //$this->session->data['success'] = $this->language->get('text_success');
				  $this->session->data['success'] = 'The export has been done';
			      return true;
			}
			else 
			{
			    //$this->error['warning'] = $this->language->get('error_upload');
			    //$this->OutWiev();
			    return false;
			}
		} 
		else 
		{
		   
            // return error
			   return false;
               //return $this->forward('error/permission');

		}
	
		
	}




	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/excel_maker')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>