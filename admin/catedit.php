<?php 
    include('../classes/category.php');
    include 'inc/header.php';
    include 'inc/sidebar.php';


    if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
        echo "<script>window.location = 'catlist.php'; </script>";
    }else{
        $id = $_GET['catid'];
        //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
    }

    $cat = new category();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $catName = $_POST['catName'];

        $updateCat = $cat->catUpdate($catName,$id);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Category</h2>
       <div class="block copyblock"> 
        <?php
        if (isset($updateCat)) {
            echo $updateCat;
        }

        $getcat = $cat->getCatById($id);
        if ($getcat) {
            while ($result = $getcat->fetch_assoc()) {
        ?>
         <form action="" method="POST">
            <table class="form">					
                <tr>
                    <td>
                        <input type="text" name="catName" value="<?php echo $result['catName'] ?>" class="medium" />
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