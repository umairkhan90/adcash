<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Orders Management App</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	.container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	td {
		margin:0 10px;
		text-align:center;
	}
	</style>
</head>
<body>

<div class="container">
	<h1>Add new Order</h1>

	<div id="body">
		<form name="myform" action="<?=base_url('orders/add');?>" method="post">
			<p>
				User 
				<select name="user">
					<?php foreach($names as $name) { ?>

						<option value="<?=$name->id;?>"><?=$name->name;?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				Product 
				<select name="product">
					<?php foreach($products as $product) { ?>
						<option value="<?=$product->id;?>"><?=$product->product_name;?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				Quantity 
				<input type="number" name="quantity" min="1" value="1" />
			</p>
			<input type="submit" name="submit" value="Add" />
		</form>
	</div>

	
</div>
<div class="container">
	<h1>Search</h1>

	<div id="body">
		<form name="myform1" action="<?=base_url('orders/search');?>" method="post">
			<p>
				 
				<select name="time">
					<option value="all">All Time</option>
					<option value="7">Last 7 days</option>
					<option value="today">Today</option>
				</select>
				&nbsp;&nbsp;&nbsp;
				<input type="text" name="query" />
				&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="search" />
			</p>
			
			</form>
	</div>

	
</div>
<div class="container">
	

	<div id="body">
		<table>
			<tr>
				<th>User</th>
				<th>Product</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
				<th>Date</th>
				<th>Actions</th>
			</tr>
			
			<?php foreach($orders as $order) { ?>
				<tr>
			    <td><?=$order->name;?></td>
			    <td><?=$order->product_name;?></td>
			    <td><?php echo number_format((float) $order->price, 2, '.', '');?> EUR</td>
			    <td><?=$order->quantity;?></td>
			    <td><?=number_format((float) $order->total, 2,'.','');?> EUR</td>
			    <td><?php 
			    $newdate = DateTime::createFromFormat('Y-m-d H:i:s', $order->date);
			    echo date_format($newdate,"d M Y H:iA");?></td>
			    <td><a href="orders/edit/<?=$order->id;?>">Edit</a>&nbsp;&nbsp;&nbsp;<a href="orders/delete/<?=$order->id;?>">Delete</a></td>
			    </tr>
			<?php } ?>
			

	</div>

	
</div>

</body>
</html>