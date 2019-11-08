<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function  __construct(){
		parent::__construct();
		
    }
	public function index()
	{
		$users = $this->db->query("SELECT name,id FROM user");
		$names = $users->result();
		$data['names'] = $names;
		$product = $this->db->query("SELECT * FROM product");
		$products = $product->result();
		$data['products'] = $products;

		$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id) 
									ORDER BY o.date");

		$orders = $query->result();
        
		$data['orders'] = $orders;

		$this->load->view('orders',$data);
	}
	public function add() {
		$user_id = $this->input->post('user');
		$product_id = $this->input->post('product');
		$quantity = $this->input->post('quantity');
		$query = $this->db->query('SELECT price FROM product WHERE id='.$product_id);
		$result = $query->result();
		$price = $result[0]->price;
		$total = $price*$quantity;
		if($product_id==2 && $quantity>=3) {
			$total = $total * 0.8;
		}
		$this->db->query("INSERT INTO orders(id,user_id,product_id,quantity,total,date) VALUES(NULL,$user_id,$product_id,$quantity,'$total',NOW())");

		redirect('/orders');
	}
	public function edit() {
		$order_id = $this->uri->segment(3);
		$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id)
									WHERE o.id=".$order_id);
		$result = $query->result();
		$data['order'] = $result[0];
		$users = $this->db->query("SELECT name,id FROM user");
		$names = $users->result();
		$data['names'] = $names;
		$product = $this->db->query("SELECT * FROM product");
		$products = $product->result();
		$data['products'] = $products;

		$this->load->view('orders_edit',$data);
	}
	public function delete() {
		$order_id = $this->uri->segment(3);

		$this->db->query("DELETE FROM orders WHERE id=".$order_id);

		redirect('/orders');
	}
	public function update() {
		$order_id = $this->input->post('order_id');
		$user_id = $this->input->post('user');
		$product_id = $this->input->post('product');
		$quantity = $this->input->post('quantity');
		
		$query = $this->db->query('SELECT price FROM product WHERE id='.$product_id);
		$result = $query->result();
		$price = $result[0]->price;
		$total = (float)$price*(float)$quantity;
		if($product_id==2 && $quantity>=3) {
			$total = $total * 0.8;
		}
		$this->db->query("UPDATE orders SET user_id=$user_id, 
											product_id=$product_id, 
											quantity=$quantity, 
											total='$total' 
											WHERE id=$order_id");
		redirect('/orders');
	}
	public function search()
	{
		$query = $this->input->post('query');
		$time = $this->input->post('time');
		
		$users = $this->db->query("SELECT name,id FROM user");
		$names = $users->result();
		$data['names'] = $names;
		$product = $this->db->query("SELECT * FROM product");
		$products = $product->result();
		$data['products'] = $products;
		if($time=='all' && !empty($query)) {
			$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id)
									WHERE p.product_name='$query' OR u.name='$query' 
									ORDER BY o.date");

			$orders = $query->result();
		}
		else if($time=='today' && !empty($query)) {
			$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id)
									WHERE (p.product_name='$query' OR u.name='$query')
									AND date >= '".date('Y-m-d')." 00:00:00'");

			$orders = $query->result();
		}
		else if($time=='today' && empty($query)) {
			$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id)
									WHERE date >= '".date('Y-m-d')." 00:00:00'");

			$orders = $query->result();
		}
		else if($time=='7' && !empty($query)) {
			$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id)
									WHERE (p.product_name='$query' OR u.name='$query')
									AND date >= '".date('Y-m-d', strtotime('-7 days'))." 00:00:00'
									ORDER BY o.date");

			$orders = $query->result();
		}
		else if($time=='7' && empty($query)) {
			$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id)
									WHERE date >= '".date('Y-m-d', strtotime('-7 days'))." 00:00:00' 
									ORDER BY o.date");

			$orders = $query->result();
		}
		else {
			$query = $this->db->query("SELECT o.*,p.product_name,p.price,u.name FROM orders AS o
									INNER JOIN product p ON (p.id=o.product_id)
									INNER JOIN user u ON (u.id=o.user_id) 
									ORDER BY o.date");

			$orders = $query->result();
		}
        
		$data['orders'] = $orders;

		$this->load->view('search',$data);
	}
}
