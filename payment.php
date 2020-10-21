<?php
	include('inc/header.php');

	$login = Session::get("userLogin");
	if ($login == false) {
		header("Location:login.php");
	}
?>
<style>
	.payment{
		width: 500px;
		min-height: 200px;
		text-align: center;
		border: 1px solid #ddd;
		margin: 0 auto;
		padding: 50px;
	}
	.payment h2{
		border-bottom: 1px solid #ddd;
		margin-bottom: 40px;
		padding-bottom: 10px;
	}
	.payment a{
		border-radius: 3px;
		padding: 5px 30px;
	}
	.back a {
		width: 160px;
		margin: 5px auto 0;
		padding: 7px 0;
		text-align: center;
		display: block;
		background: #555;
		border:#333;
		color: #fff;
		border-radius: 3px;
		font-size: 25px;
	}
</style>
<div class="main">
	<div class="content">
		<div class="section group">
			<div class="payment">
				<h2>Choose Payment Option</h2>
				<a href="offline.php">
					<img style="width: 150px;" src="images/offline.png" alt="">
				</a>
				<a href="online.php">
					<img style="width: 150px;" src="images/online.png" alt="">
				</a>
			</div>

			<div class="back">
				<a href="cart.php">Previous</a>
			</div>
		</div>
	</div>
</div>

<?php
	include('inc/footer.php');
?>