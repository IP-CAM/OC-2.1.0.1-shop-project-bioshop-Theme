<?php
class Action {
	private $file;
	private $class;
	private $method;
	private $args = array();

	public function __construct($route, $args = array()) {
                    
                static $recursion = TRUE;
              
		$parts = explode('/', str_replace('../', '', (string)$route));

		// Break apart the route
		while ($parts) {
                    
                        if ($recursion) {
                    
                             $file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';
                        } else {
                            
                             $file = $_SERVER['DOCUMENT_ROOT'] . '/admin/controller/' . implode('/', $parts) . '.php';
                        }
			

			if (is_file($file)) {
				$this->file = $file;

				$this->class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', implode('/', $parts));
				break;
			} else {
				$this->method = array_pop($parts);
			}
		}

		if (!$this->method) {
			$this->method = 'index';
		}
                
                if (empty($this->file) || empty($this->class) || empty($this->method)) {
                    
                    if ($recursion) {
                       $recursion = FALSE;
                       Action::__construct($route, $args);  
                    }
                   
                   
                }

		$this->args = $args;
	}

	public function execute($registry) {
		// Stop any magical methods being called
		if (substr($this->method, 0, 2) == '__') {
			return false;
		}

		if (is_file($this->file)) {
			include_once(modification($this->file));

			$class = $this->class;

			$controller = new $class($registry);

			if (is_callable(array($controller, $this->method))) {
				return call_user_func(array($controller, $this->method), $this->args);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
