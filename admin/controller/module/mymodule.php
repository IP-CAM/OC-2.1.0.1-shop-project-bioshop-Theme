<?php

	class ControllerModuleMyModule extends Controller {
	
	
	   public function index() {
	   
	   
	        $this->language->load('module/mymodule');
	        $this->document->setTitle($this->language->get('heading_title'));
	   }

	    public function install() {

	        $this->load->model('extension/event');
                
                $this->event->register('my.module.event', 'module/mymodule/on_customer_add');

	        $this->model_extension_event->addEvent('mymodule', 'pre.customer.login', 'module/mymodule/on_customer_add');

	    }

	     

	    public function uninstall() {

	        $this->load->model('extension/event');

            $this->model_extension_event->deleteEvent('mymodule');

	    }

	     

	    public function on_store_delete($store_id) {

	        $this->load->model('setting/store');

	        $store_info = $this->model_setting_store->getStore($store_id);
                
                $test = 22;

	        $admin_mail = $this->config->get('config_email');

	        mail($admin_mail, "A store has been deleted", "The store " . $store_info['url'] . " was deleted.");

	    }

	}