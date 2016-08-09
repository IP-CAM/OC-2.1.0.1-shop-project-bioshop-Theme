<?php

	class ControllerModuleMyModule extends Controller {

	    public function on_customer_add($customer_id) {

                  
                    $test = 'It is work';
	            $this->event->trigger('my.module.event', $test);

	    }
            
	}
        