<?php 
    include 'inc/header.php';
    include 'inc/sidebar.php';
    include('../classes/brand.php');


    if (!isset($_GET['brandId']) || $_GET['brandId'] == NULL) {
        echo "<script>window.location = 'brandlist.php'; </script>";
    }else{
        $id = $_GET['brandId'];
        //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['brandId']);
    }

    $brand = new brand();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $brandName = $_POST['brandName'];

        $updateBrand = $brand->brandUpdate($brandName,$id);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Brand</h2>
       <div class="block copyblock"> 
        <?php
        if (isset($updateBrand)) {
            echo $updateBrand;
        }

        $getbrand = $brand->getBrandById($id);
        if ($getbrand) {
            while ($result = $getbrand->fetch_assoc()) {
        ?>
         <form action="" method="POST">
            <table class="form">					
                <tr>
                    <td>
                        <input type="text" name="brandName" value="<?php echo $result['brandName'] ?>" class="medium" />
                    </td>
                </tr>

				<tr> 
                    <td>
                        <input type="submit" name="submit" Value="Save" />
                    </td>
                </tr>
            </table>
            </form>
            <?php } } ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>