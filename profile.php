<?php
	include('inc/header.php');

	$login = Session::get("userLogin");
	if ($login == false) {
		header("Location:login.php");
	}
?>
<style>
	.tblone tr td{
		text-align: justify;
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
			<table class="tblone" style="width: 600px;margin:  0 auto;border:2px solid #ddd;">
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
			</table>
			<?php } } ?>
		</div>
	</div>
</div>

<?php
	include('inc/footer.php');
?>