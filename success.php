<?php
	include('inc/header.php');

	$login = Session::get("userLogin");
	if ($login == false) {
		header("Location:login.php");
	}
?>
<style>
	.success {
    text-align: center;
    font-size: 35px;
    color: green;
    font-family: cursive;
    width: 600px;
    margin: 0 auto;
}
.success h1{
	text-shadow: 2px 2px #ff0000;
}
.success p{
	line-height: 25px;
	text-align: justify;
	font-size: 18px;
}
</style>
<div class="main">
	<div class="content" style="background-image: url('images/sucess.jpg');width: 100%;    height: 500px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;">
		<div class="section group">
			<div class="success">
				<h1>Payment Successfully</h1>
				<?php 
					$userId = Session::get("userId");
					$amount = $ct->payableAmount($userId);
					if ($amount) {
						$sum = 0;
						while ($result = $amount->fetch_assoc()) {
							$price = $result['price'];
							$sum = $sum+$price;
						}
					}
				  ?>
				<p>Total Payable Amount (Including Vat):
					<?php
					$sum = 0;
						$vat   = $sum * 0.1;
						$total = $sum+$vat;
						echo $total;
					?>
				</p>
				
				<p>Thanks for purchase.... <a href="orderdetails.php">Visit Here</a> </p>
				
			</div>
		</div>
	</div>
</div>

<?php
	include('inc/footer.php');
?>