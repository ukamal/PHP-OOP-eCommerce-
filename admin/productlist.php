<?php 
	include 'inc/header.php';
 	include 'inc/sidebar.php';
    include_once('../classes/product.php');
    include_once('../helpers/format.php');

     $pd = new product();
     $fm = new format();


 	if (isset($_GET['delPro'])) {
	$id = $_GET['delPro'];
	//$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['delcat']);
	$delPro = $pd->delProByID($id);
	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Product List</h2>
        <div class="block">  
        	<?php
        	if (isset($delPro)) {
        		echo $delPro;
        	}
        	?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>SL</th>
					<th>Product Name</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Price</th>
					<th>Image</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$getPd = $pd->getAllProduct();
				if ($getPd) {
					$i = 0;
					while ($result = $getPd->fetch_assoc()) {
						$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['productName']; ?></td>
					<td><?php echo $result['catName']; ?></td>
					<td><?php echo $result['brandName']; ?></td>
					<td><?php echo $fm->textShorten($result['body'], 50); ?></td>
					<td>$<?php echo $result['price']; ?></td>
					<td><img src="<?php echo $result['image']; ?>" width="100px" alt="img"></td>
					<td>
						<?php 
						if ($result['type'] == 0) {
							echo "featured";
						}else{
							echo "general";
						}
						?>
					</td>
						<td><a href="productedit.php?proId=<?php echo $result['productId']; ?>">Edit</a> || 
					<a onclick="return confirm('Are you sure to delete?')" href="?delPro=<?php echo $result['productId']; ?>">Delete</a></td>
				</tr>
			<?php } } ?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
