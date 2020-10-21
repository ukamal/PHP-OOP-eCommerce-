<?php
	include('inc/header.php');

	$login = Session::get("userLogin");
	if ($login == false) {
		header("Location:login.php");
	}

	if (isset($_GET['orderId']) && $_GET['orderId'] == 'order') {
		$userId = Session::get("userId");
		$insOrder = $ct->orderProduct($userId);
		$delData = $ct->delUserCart();
		header("Location:success.php");
	}
?>
<style>
	.division{
		width: 50%;
		float: left;
	}
	.tblone tr td{
		text-align: justify;
	}
	.tblTwo{
		float:right;
		text-align:left;
		width: 60%;
		border:2px solid #ddd;
		border-top: none;
    margin-top: -12px;
	}
	.tblTwo tr td{
		text-align: justify;
		padding:5px 10px;
	}

	.ordernow a{
		width: 150px;
		margin: 20px auto 0;
		text-align: center;
		padding: 5px;
		font-size: 30px;
		display: flex;
		background: green;
		color: #fff;
		border-radius: 3px;
	}
</style>
<div class="main">
	<div class="content">
		<div class="section group">
			<div class="division">
				<table class="tblone" style="border: 2px solid #ddd;">
					<tr>
						<th>No</th>
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>
					<?php 
					$getPro = $ct->cartProduct();
					if ($getPro) {
						$i   = 0;
						$sum = 0;
						$qty = 0;
						while ($result = $getPro->fetch_assoc()) {
							$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $result['productName']; ?></td>
						<td>$<?php echo $result['price']; ?></td>
						<td><?php echo $result['quantity']; ?></td>
						<td>$<?php 
								$total = $result['price'] * $result['quantity'];
								echo $total; 
							?>
							
						</td>
					</tr>
					<?php
						$qty  = $qty + $result['quantity'];
						$sum = $sum + $total; 
						?>
					<?php } } ?>

				</table>
				
				<table class="tblTwo">
					<tr>
						<td>Total Quantity</td>
						<td>:</td>
						<td><?php echo $qty; ?></td>
					</tr>
					<tr>
						<td>Total Price</td>
						<td>:</td>
						<td>$ <?php echo $sum; ?></td>
					</tr>
					<tr>
						<td>VAT</td>
						<td>:</td>
						<td>15% &nbsp;( $ <?php echo $vat = $sum * 0.1; ?> )</td>
					</tr>
					<tr>
						<td>Grand Total</td>
						<td>:</td>
						<td>
							<?php 
							$vat = $sum * 0.1;
							$gTotal = $sum + $vat;
							echo $gTotal;
							?>
						</td>
					</tr>
				</table>
			</div>

			<!----------------->

			<div class="division">
			<?php
				$id = Session::get('userId');
				$getUser = $cmr->getUserData($id);
				if ($getUser) {
					while ($result = $getUser->fetch_assoc()) {
			?>
			<table class="tblone" style="width: 500px;margin:  0 auto;border:2px solid #ddd;">
				<tr>
					<td colspan="3" style="text-align: center;">User Profile</td>
				</tr>
				<tr>
					<td width="15%">Name</td>
					<td width="5%">:</td>
					<td><?php echo $result['name']; ?></td>
				</tr>
				<tr>
					<td>Phone</td>
					<td>:</td>
					<td><?php echo $result['phone']; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td>:</td>
					<td><?php echo $result['email']; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>:</td>
					<td><?php echo $result['address']; ?></td>
				</tr>
				<tr>
					<td>City</td>
					<td>:</td>
					<td><?php echo $result['city']; ?></td>
				</tr>
				<tr>
					<td>ZipCode</td>
					<td>:</td>
					<td><?php echo $result['zipcode']; ?></td>
				</tr>
				<tr>
					<td>Country</td>
					<td>:</td>
					<td><?php echo $result['country']; ?></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><a href="editproile.php">Update Details</a></td>
				</tr>
			</table><br>
			<?php } } ?>
			</div>

			<div class="ordernow">
				<a href="?orderId=order">Order Now</a>
			</div>
		</div>
	</div>
</div>

<?php
	include('inc/footer.php');
?>