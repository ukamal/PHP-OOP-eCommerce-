<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/format.php');
	include_once ($filepath.'/../lib/session.php');
	
	Session::checkLogin();


/**
 * Admin Login
 */

class adminLogin
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function adminLogin($user,$password){
		$user = $this->fm->validation($user);
		$password = $this->fm->validation($password);

		$user = mysqli_real_escape_string($this->db->link, $user);
		$password = mysqli_real_escape_string($this->db->link, $password);

		if (empty($user) || empty($password)) {
			$loginmsg = "Username or Password must be not empty!";
			return $loginmsg;
		}else{
			$query = "SELECT * FROM admin WHERE user = '$user' AND password = '$password'";
			$result = $this->db->select($query);
			if ($result != false) {
				$value = $result->fetch_assoc();
				Session::set("adminLogin", true);
				Session::set("id", $value['id']);
				Session::set("user", $value['user']);
				Session::set("name", $value['name']);

				header("Location:dashboard.php");
			}else{
				$loginmsg = "Username or Password not match!";
				return $loginmsg;
			}
		}
	}

}