<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/format.php');


class User 
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function customerRegistration($data){
		$name     = mysqli_real_escape_string($this->db->link, $data['name']);
		$address  = mysqli_real_escape_string($this->db->link, $data['address']);
		$city     = mysqli_real_escape_string($this->db->link, $data['city']);
		$country  = mysqli_real_escape_string($this->db->link, $data['country']);
		$phone    = mysqli_real_escape_string($this->db->link, $data['phone']);
		$zipcode  = mysqli_real_escape_string($this->db->link, $data['zipcode']);
		$email    = mysqli_real_escape_string($this->db->link, $data['email']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));

  		if ($name == "" || $address == "" || $city == "" || $country == "" || $phone == "" || $zipcode == "" || $email == "" || $password == "") {
		    	$msg = "<span class='error'>Field must be not empty!</span>";
				return $msg;
			}
			$mailquery = "SELECT * FROM customer WHERE email='$email' LIMIT 1";
			$mailChk = $this->db->select($mailquery);
			if ($mailChk != false) {
				$msg = "<span class='error'>Email already exist!</span>";
				return $msg;
			}
			else{
			    $query = "INSERT INTO customer(name, address, city, country, phone, zipcode, email, password) 
			    VALUES('$name','$address','$city','$country','$phone', '$zipcode', '$email', '$password')";
			    $inserted_rows = $this->db->insert($query);
			    if ($inserted_rows) {
			     echo "<span class='success'>Customer data Inserted Successfully.
			     </span>";
			    }else {
			     echo "<span class='error'>Customer data Not Inserted !</span>";
			    }
			}
	}

	public function userLogin($data){
		$email    = mysqli_real_escape_string($this->db->link, $data['email']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		if (empty($email) || empty($password)) {
			$msg = "<span class='error'>Field must be not empty!</span>";
			return $msg;
		}

		$query = "SELECT * FROM customer WHERE email='$email' AND password='$password'";
		$result = $this->db->select($query);
		if ($result != false) {
			$value = $result->fetch_assoc();
			Session::set('userLogin', true);
			Session::set('userId', $value['id']);
			Session::set('userName', $value['name']);
			header("Location:cart.php");
		}else{
			$msg = "<span class='error'>Email or Password not matched!</span>";
			return $msg;
		}
	}

	public function getUserData($id){
		$query = "SELECT * FROM customer WHERE id='$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function userUpdate($data,$userId){
		$name     = mysqli_real_escape_string($this->db->link, $data['name']);
		$address  = mysqli_real_escape_string($this->db->link, $data['address']);
		$city     = mysqli_real_escape_string($this->db->link, $data['city']);
		$country  = mysqli_real_escape_string($this->db->link, $data['country']);
		$phone    = mysqli_real_escape_string($this->db->link, $data['phone']);
		$zipcode  = mysqli_real_escape_string($this->db->link, $data['zipcode']);
		$email    = mysqli_real_escape_string($this->db->link, $data['email']);

  		if ($name == "" || $address == "" || $city == "" || $country == "" || $phone == "" || $zipcode == "" || $email == "") {
		    	$msg = "<span class='error'>Field must be not empty!</span>";
				return $msg;
			}
			else{
				$query = "UPDATE customer SET 
			   	name 	= '$name',
			   	address = '$address',
			   	city 	= '$city',
			   	country = '$country',
			   	phone 	= '$phone',
			   	zipcode = '$zipcode',
			   	email 	= '$email'
				WHERE id = '$userId'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					$msg = "<span class='success'>User data updated successfully!</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>User data Not Updated!</span>";
					return $msg;
				}
			}
	}



	
}