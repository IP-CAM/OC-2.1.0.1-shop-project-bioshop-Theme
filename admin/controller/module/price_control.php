<?php

class ControllerModulePriceControl extends Controller {
	private $error = array(); 
	private $count = 0;
	
	public function index() {   
		
		$this->load->language('module/price_control');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['categories']=$this->getCategories(0);
		
	 	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$post_categories=array();
			foreach ($this->request->post['selected'] as $category_id) {
				if (is_numeric((int)$category_id) && (int)$category_id!=0) {
					$post_categories[]=(int)$category_id;
				}
			}
			$post_action=$this->request->post['action'];
			switch($post_action) {
				case 'addict':
					$post_action='+';
					break;
				case 'deduct':
					$post_action='-';					
					break;
				case 'multiply':
					$post_action='*';
					break;
				case 'divide':
					$post_action='/';
					break;
				default:
					$post_action=null;
				}
			$post_num=$this->request->post['num'];
			$post_unit=$this->request->post['unit'];
			switch($post_unit) {
				case 'percent':
					break;
				case 'number':
					break;
				default:
					$post_unit=null;
			}
			if (!empty($post_categories) && $post_action && is_numeric($post_num) && $post_unit) {
				if ($this->updatePrices($post_categories,$post_action,$post_num,$post_unit)) {
					$this->session->data['success'] = $this->language->get('text_success');			
					$this->response->redirect($this->url->link('module/price_control', 'token=' . $this->session->data['token'], 'SSL'));
				}
			} else {
				$this->error['warning']=$this->language->get('error_data');
				$data['error_warning']=$this->error['warning'];
			}
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$data['button_close'] = $this->language->get('button_close');
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
			'href'      => $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$data['action'] = $this->url->link('module/price_control', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
						
		
	    $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');;
				
		$this->response->setOutput($this->load->view('module/price_control.tpl', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/price_control')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!empty($this->request->post)) {
			if (!isset($this->request->post['selected']) && empty($this->request->post['selected'])) {
				$this->error['warning'] = $this->language->get('error_data');
			}
			if (!isset($this->request->post['action']) && empty($this->request->post['action'])) {
				$this->error['warning'] = $this->language->get('error_data');
			}
			if (!isset($this->request->post['num']) && empty($this->request->post['num'])) {
				$this->error['warning'] = $this->language->get('error_data');
			} else {
				$this->request->post['num']=str_replace(",",".",$this->request->post['num']);
				if (!is_numeric(floatval($this->request->post['num'])) || floatval($this->request->post['num'])==0) {
					$this->error['warning'] = $this->language->get('error_data');
				}
			}
			if (!isset($this->request->post['unit']) && empty($this->request->post['unit'])) {
				$this->error['warning'] = $this->language->get('error_data');
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function getCategories($parent_id, $current_path = '',$separator=0,$floatleft='float:left;') {
		$margin='';
		if ($separator==1) {
			$this->count++;
		}
		$this->load->model('module/price_control');
        $output = '';
        $results = $this->model_module_price_control->getCategories($parent_id);
         if ($results) {
            $output .= '<ul style="list-style:none;">';
        }
        foreach ($results as $result) {    
            if (!$current_path) {
                $new_path = $result['category_id'];
            } else {
                $new_path = $current_path . '_' . $result['category_id'];
            }
            $output .= '<li><label><input type="checkbox" name="selected[]" value="'.$result['category_id'].'" />'.$result['name']."</label></li>";
            $output .= $this->getCategories($result['category_id'], $new_path,$separator+1,'');
		 }
		if ($results) {
            $output .= '</ul>';
        }
         return $output;
    }
	
	protected function updatePrices($categories,$action,$num,$unit) {
			$this->load->model('module/price_control');
			return $this->model_module_price_control->updatePrices($categories,$action,$num,$unit);
	}
}

?>