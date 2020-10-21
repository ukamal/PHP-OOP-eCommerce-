<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/format.php');


class Cart 
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function addToCart($quantity,$id){
		$quantity = $this->fm->validation($quantity);
		$quantity  = mysqli_real_escape_string($this->db->link, $quantity);
		$productId = mysqli_real_escape_string($this->db->link, $id);
		$sessionId = session_id();

		$query = "SELECT * FROM product WHERE productId = '$productId'";
		$result = $this->db->select($query)->fetch_assoc();

		$productName = $result['productName'];
		$price		 = $result['price'];
		$image		 = $result['image'];

		$chQuery = "SELECT * FROM cart WHERE productId = '$productId' AND sessionId ='$sessionId'";
		$getPro = $this->db->select($chQuery);
		if ($getPro) {
			$msg = "Product Already Added!";
			return $msg;
		}else{

	    $query = "INSERT INTO cart(sessionId, productId, productName, price, quantity, image) 
		    VALUES('$sessionId','$productId','$productName','$price','$quantity','$image')";
		    $inserted_rows = $this->db->insert($query);
		    if ($inserted_rows) {
		     header("Location:cart.php");
		    }else {
		      header("Location:404.php");
		    }
		   }
	}

	public function cartProduct(){
		$sessionId = session_id();
		$query = "SELECT * FROM cart WHERE sessionId='$sessionId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function updateCartQuantity($cartId, $quantity){
		$cartId = mysqli_real_escape_string($this->db->link, $cartId);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);

		$query = "UPDATE cart SET quantity = '$quantity'
			WHERE cartId = '$cartId'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				echo "<script>window.location = 'cart.php';</script>";
			}else{
				$msg = "<span class='error'>Quantity Not Updated!</span>";
				return $msg;
			}

	}

	public function delProductByCart($delId){
		$delId = mysqli_real_escape_string($this->db->link, $delId);
		$query = "DELETE FROM cart WHERE cartId = '$delId'";
		$deldata = $this->db->delete($query);
		if ($deldata) {
			echo "<script>window.location = 'cart.php';</script>";
		}else{
			$msg = "<span class='error'>Product Not Deleted!</span>";
				return $msg;
		}
	}

	public function checkCartTable(){
		$sessionId = session_id();
		$query = "SELECT * FROM cart WHERE sessionId='$sessionId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function delUserCart(){
		$sessionId = session_id();
		$query = "DELETE FROM cart WHERE sessionId='$sessionId'";
		$this->db->delete($query);
	}

	public function orderProduct($userId){
		$sessionId = session_id();
		$query = "SELECT * FROM cart WHERE sessionId='$sessionId'";
		$getPro = $this->db->select($query);
		if ($getPro) {
			while ($result = $getPro->fetch_assoc()) {
				$userId 	 = $result['userId'];
				$productId 	 = $result['productId'];
				$productName = $result['productName'];
				$quantity 	= $result['quantity'];
				$price 		= $result['price'] * $quantity;
				$image 		= $result['image'];
				
			$query = "INSERT INTO Payorder(userId, productId, productName, quantity, price, image) 
		    VALUES('$userId','$productId','$productName','$quantity', '$price', '$image')";
		    $inserted_rows = $this->db->insert($query);
			}
		}
	}

	public function payableAmount($userId){
		$query = "SELECT price FROM payorder WHERE userId='$userId' AND date = now()";
		$result = $this->db->select($query);
		return $result;
	}

	public function getOrderProduct($userId){
		$query = "SELECT * FROM payorder ORDER BY date DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function checkOrder($userId){
		$query = "SELECT * FROM payorder WHERE userId ='$userId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function getAllOrderProduct(){
		$query = "SELECT * FROM payorder ORDER BY date DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function productShifted($id, $date, $price){
		$id    = mysqli_real_escape_string($this->db->link, $id);
		$date  = mysqli_real_escape_string($this->db->link, $date);
		$price = mysqli_real_escape_string($this->db->link, $price);

		$query = "UPDATE payorder SET status = '1'
		WHERE userId = '$id' AND date='$date' AND price='$price'";
		$updated_row = $this->db->update($query);
		if ($updated_row) {
			$msg = "<span class='success'>Update successfully!</span>";
			return $msg;
		}else{
			$msg = "<span class='error'> Not Updated!</span>";
			return $msg;
		}
	}

	public function delProShifted($id, $time, $price){
		$id    = mysqli_real_escape_string($this->db->link, $id);
		$date  = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);

		$query = "DELETE FROM payorder WHERE userId = '$id' AND date='$date' AND price='$price'";
		$deldata = $this->db->delete($query);
		if ($deldata) {
			$msg = "<span class='success'> Deleted  successfully!</span>";
				return $msg;
		}else{
			$msg = "<span class='error'> Not Deleted!</span>";
				return $msg;
		}
	}

	public function productShiftConfirm($id, $time, $price){
		$id    = mysqli_real_escape_string($this->db->link, $id);
		$date  = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);

		$query = "UPDATE payorder SET status = '2'
		WHERE userId = '$id' AND date='$date' AND price='$price'";
		$updated_row = $this->db->update($query);
		if ($updated_row) {
			$msg = "<span class='success'>Update successfully!</span>";
			return $msg;
		}else{
			$msg = "<span class='error'> Not Updated!</span>";
			return $msg;
		}
	}

	
}