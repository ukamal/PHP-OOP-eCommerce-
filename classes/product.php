<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/format.php');

class product
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function productInsert($data, $file){
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body        = mysqli_real_escape_string($this->db->link, $data['body']);
		$price       = mysqli_real_escape_string($this->db->link, $data['price']);
		$type        = mysqli_real_escape_string($this->db->link, $data['type']);

		
	   if ($_SERVER["REQUEST_METHOD"] == "POST") {
		    $permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "upload/".$unique_image;

		    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
		    	$msg = "<span class='error'>Field must be not empty!</span>";
				return $msg;
			}else{
			    move_uploaded_file($file_temp, $uploaded_image);
			    $query = "INSERT INTO product(productName, catId, brandId, body, price, image, type) 
			    VALUES('$productName','$catId','$brandId','$body','$price','$uploaded_image', '$type')";
			    $inserted_rows = $this->db->insert($query);
			    if ($inserted_rows) {
			     echo "<span class='success'>Product Inserted Successfully.
			     </span>";
			    }else {
			     echo "<span class='error'>Product Not Inserted !</span>";
			    }
			}
	   }
	}

	public function getAllProduct(){
		/*Aliases*/
		$query = "SELECT p.*, c.catName, b.brandName
		FROM product as p, category as c, brand as b
		WHERE p.catId = c.catId AND p.brandId = b.brandId ORDER By p.productId DESC";

		/*
		$query = "SELECT product.*, category.catName, brand.brandName,
		FROM product 
		INNER JOIN category 
		ON product.catId = category.catId
		INNER JOIN brand 
		ON product.brandId = brand.brandId
		ORDER By product.productId DESC";
		*/
		$result = $this->db->select($query);
		return $result;
	}

	public function getProById($id){
		$query = "SELECT * FROM product WHERE productId='$id'";
		$result = $this->db->select($query);
		return $result;
	}

/**Update**/
	public function productUpdate($data, $file, $id){
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body        = mysqli_real_escape_string($this->db->link, $data['body']);
		$price       = mysqli_real_escape_string($this->db->link, $data['price']);
		$type        = mysqli_real_escape_string($this->db->link, $data['type']);

		
	   if ($_SERVER["REQUEST_METHOD"] == "POST") {
		    $permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "upload/".$unique_image;

		    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
		    	$msg = "<span class='error'>Field must be not empty!</span>";
				return $msg;
			}else{
			if (!empty($file_name)) {
			if ($file_size > 1048567) {
				echo "<span class='error'>Image size should be less then 1mb!</span>";
			}elseif (in_array($file_ext, $permited) === false) {
				echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
			}
			else{
			    move_uploaded_file($file_temp, $uploaded_image);
			    $query = "UPDATE product
			    		SET
			    		productName = '$productName',
			    		catId = '$catId',
			    		brandId = '$brandId',
			    		body = '$body',
			    		price = '$price',
			    		image = '$uploaded_image',
			    		type = '$type'
			    		WHERE productId='$id'";

			    $update_rows = $this->db->update($query);
			    if ($update_rows) {
			     $msg = "<span class='error'>Field must be not empty!</span>";
				return $msg;
			    }else {
			    $msg = "<span class='error'>Field must be not empty!</span>";
				return $msg;
			    }
			}
		}else{
			    $query = "UPDATE product
			    		SET
			    		productName = '$productName',
			    		catId = '$catId',
			    		brandId = '$brandId',
			    		body = '$body',
			    		price = '$price',
			    		type = '$type'
			    		WHERE productId='$id'";

			    $update_rows = $this->db->update($query);
			    if ($update_rows) {
			     echo "<span class='success'>Product Updated Successfully.
			     </span>";
			    }else {
			     echo "<span class='error'>Product Not Updated !</span>";
			    }
			}
		  }
		}
	  }
	  
	
/**Delete**/

	public function delProByID($id){
		$query = "SELECT * FROM product WHERE productId = '$id'";
		//delete from holder
		$getData = $this->db->select($query);
		if ($getData) {
			while ($delImg = $getData->fetch_assoc()) {
				$delLink = $delImg['image'];
				unlink($delLink);
			}
		}

		$delQuery = "DELETE FROM product WHERE productId ='$id'";
		$delData = $this->db->delete($delQuery);
		if ($delData) {
			$msg = "<span class='success'>Product Delted Successfully.</span>";
			return $msg;
		}else{
			$msg = "<span class='success'>Product Not Delted.</span>";
			return $msg;
		}
	}

	/*********/
	public function getFeaturePro(){
		$query = "SELECT * FROM product WHERE type='0' ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}

	public function getNewPro(){
		$query = "SELECT * FROM product ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}

	public function getSingleProduct($id){ 
		$query = "SELECT p.*, c.catName, b.brandName
		FROM product as p, category as c, brand as b
		WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId ='$id' ";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromIphone(){
		$query = "SELECT * FROM product WHERE brandId='1' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromSamsung(){
		$query = "SELECT * FROM product WHERE brandId='2' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromAcer(){
		$query = "SELECT * FROM product WHERE brandId='5' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}


	public function latestFromCanon(){
		$query = "SELECT * FROM product WHERE brandId='3' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function productByCat($id){
		$catId = mysqli_real_escape_string($this->db->link, $id);
		$query = "SELECT * FROM product WHERE catId='$catId'";
		$result = $this->db->select($query);
		return $result;
	}


}