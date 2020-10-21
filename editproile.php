<?php
	include('inc/header.php');

	$login = Session::get("userLogin");
	if ($login == false) {
		header("Location:login.php");
	}

	$userId = Session::get("userId");
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
      $update = $cmr->userUpdate($_POST,$userId);
	}
?>
<style>
	.tblone tr td{
		text-align: justify;
	}
	.tblone input[type="text"]{
		width: 400px;
		padding: 5px;
		font-size: 15px;
	}
</style>
<div class="main">
	<div class="content">
		<div class="section group">
			<?php
				$id = Session::get('userId');
				$getUser = $cmr->getUserData($id);
				if ($getUser) {
					while ($result = $getUser->fetch_assoc()) {
					
			?>
			<form action="" method="post">
<table class="tblone" style="width: 600px;margin:  0 auto;border:2px solid #ddd;">
	<?php
	if (isset($update)) {
		echo "<tr><td colspan='3' style='text-align: center;'>".$update."</td></tr>";
	}
	?>
	<tr>
		<td width="15%">Name</td>
		<td><input type="text" name="name" value="<?php echo $result['name']; ?>"></td>
	</tr>
	<tr>
		<td>Phone</td>
		<td><input type="text" name="phone" value="<?php echo $result['phone']; ?>"></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><input type="text" name="email" value="<?php echo $result['email']; ?>"></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><input type="text" name="address" value="<?php echo $result['address']; ?>"></td>
	</tr>
	<tr>
		<td>City</td>
		<td><input type="text" name="city" value="<?php echo $result['city']; ?>"></td>
	</tr>
	<tr>
		<td>ZipCode</td>
		<td><input type="text" name="zipcode" value="<?php echo $result['zipcode']; ?>"></td>
	</tr>
	<tr>
		<td>Country</td>
		<td><input type="text" name="country" value="<?php echo $result['country']; ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="save"></td>
	</tr>
</table>
			</form>
			<?php } } ?>
		</div>
	</div>
</div>

<?php
	include('inc/footer.php');
?>