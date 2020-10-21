<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/format.php');


class brand
{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function brandInsert($brandName){
		$brandName = $this->fm->validation($brandName);
		$brandName = mysqli_real_escape_string($this->db->link, $brandName);
		if (empty($brandName)) {
			$msg = "<span class='error'>Category field must be not empty!</span>";
			return $msg;
		}else{
			$query = "INSERT INTO brand(brandName) VALUES('$brandName')";
			$insertBrand = $this->db->insert($query);
			if ($insertBrand) {
				$msg = "<span class='success'>Brand name Inserted successfully!</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Brand name Not!</span>";
				return $msg;
			}
		}
	}

	public function getAllBrand(){
		$query = "SELECT * FROM brand ORDER BY brandId DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function getBrandById($id){
		$query = "SELECT * FROM brand WHERE brandId='$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function brandUpdate($brandName, $id){
		$brandName = $this->fm->validation($brandName);
		$brandName = mysqli_real_escape_string($this->db->link, $brandName);
		$id 	   = mysqli_real_escape_string($this->db->link, $id);
		if (empty($brandName)) {
			$msg = "<span class='error'>Brand field must be not empty!</span>";
			return $msg;
		}else{
			$query = "UPDATE brand SET brandName = '$brandName'
			WHERE brandId = '$id'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				$msg = "<span class='success'>Brand updated successfully!</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Brand Not Updated!</span>";
				return $msg;
			}
		}
	}

	public function delBrandByID($id){
		$query = "DELETE FROM brand WHERE brandId = '$id'";
		$deldata = $this->db->delete($query);
		if ($deldata) {
			$msg = "<span class='success'>Brand Deleted  successfully!</span>";
				return $msg;
		}else{
			$msg = "<span class='error'>Brand Not Deleted!</span>";
				return $msg;
		}
	}

}