<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/format.php');


/**
 * Category
 */
class category 
{
	
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function catInsert($catName){
		$catName = $this->fm->validation($catName);
		$catName = mysqli_real_escape_string($this->db->link, $catName);
		if (empty($catName)) {
			$msg = "<span class='error'>Category field must be not empty!</span>";
			return $msg;
		}else{
			$query = "INSERT INTO category(catName) VALUES('$catName')";
			$catinsert = $this->db->insert($query);
			if ($catinsert) {
				$msg = "<span class='success'>Category Inserted successfully!</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Category Not!</span>";
				return $msg;
			}
		}
	}

	public function getAllCat(){
		$query = "SELECT * FROM category ORDER BY catId DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function getCatById($id){
		$query = "SELECT * FROM category WHERE catId='$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function catUpdate($catName, $id){
		$catName = $this->fm->validation($catName);
		$catName = mysqli_real_escape_string($this->db->link, $catName);
		$id 	 = mysqli_real_escape_string($this->db->link, $id);
		if (empty($catName)) {
			$msg = "<span class='error'>Category field must be not empty!</span>";
			return $msg;
		}else{
			$query = "UPDATE category SET catName = '$catName'
			WHERE catId = '$id'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				$msg = "<span class='success'>Category updated successfully!</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Category Not Updated!</span>";
				return $msg;
			}
		}
	}

	public function delCatByID($id){
		$query = "DELETE FROM category WHERE catId = '$id'";
		$deldata = $this->db->delete($query);
		if ($deldata) {
			$msg = "<span class='success'>Category Deleted  successfully!</span>";
				return $msg;
		}else{
			$msg = "<span class='error'>Category Not Deleted!</span>";
				return $msg;
		}
	}


}