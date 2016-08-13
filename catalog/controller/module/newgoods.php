<?php
class ControllerModuleNewgoods extends Controller {
	public function index($setting) {
		$this->load->language('module/newgoods');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_tax'] = $this->language->get('text_tax');
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$data['products'] = array();		

		$product_data = array();
		
		$query = $this->db->query("SELECT o.order_id,op.product_id,SUM(op.quantity) AS total FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE o.order_status_id = 1 OR o.order_status_id = 5 GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$setting['limit']);
		
		
		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}
					 	 		
		$results = $product_data;
		
                $count = 1;
                
		if ($results) {
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
			}
			
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}	
			
			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}
			
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
							
			$data['products'][$count] = array(
				'product_id'   => $result['product_id'],
				'thumb'   	   => $image,
				'name'         => $result['name'],
				'description'  => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
				'price'   	   => $price,
				'special' 	   => $special,
				'tax'          => $tax,
				'rating'       => $rating,
				'href'         => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				'reviews'      => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
			);
                        $count++;
		}
                
  
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newgoods.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/newgoods.tpl', $data);
			} else {
			return $this->load->view('default/template/module/newgoods.tpl', $data);
		   }
	    }
	}
}