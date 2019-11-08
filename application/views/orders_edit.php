<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Edit Order</title>

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
	<h1>Edit Order</h1>

	<div id="body">
		<form name="myform" action="<?=base_url('orders/update');?>" method="post">
			<p>
				User 
				<select name="user">
					<?php foreach($names as $name) { ?>
						<?php if($name->name==$order->name) { ?>
						<option value="<?=$name->id;?>" selected><?=$name->name;?></option>
						<?php } else {?>
						<option value="<?=$name->id;?>"><?=$name->name;?></option>
						<?php } ?>
						
					<?php } ?>
				</select>
				<input type="hidden" name="order_id" value="<?=$order->id;?>" />
			</p>
			<p>
				Product 
				<select name="product">
					<?php foreach($products as $product) { ?>
						<?php if($product->product_name==$order->product_name) { ?>
						<option value="<?=$product->id;?>" selected><?=$product->product_name;?></option>
						<?php } else {?>
						<option value="<?=$product->id;?>"><?=$product->product_name;?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</p>
			<p>
				Quantity 
				<input type="number" name="quantity" min="1" value="<?=$order->quantity;?>" />
			</p>
			<p>
				Total :
				<span><?php
				echo $order->total;?> EUR</span>
			</p>
			<p>
				Date and Time
				<span><?php
				$newdate = DateTime::createFromFormat('Y-m-d H:i:s', $order->date);
			    echo date_format($newdate,"d M Y H:iA");?> </span>
			</p>
			<input type="submit" name="submit" value="Update" />
		</form>
	</div>

	
</div>


</body>
</html>