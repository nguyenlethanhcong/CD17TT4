<?php
class Db{
	//Tao bien $conn ket noi
	public static $conn;
	//Tao ket noi trong ham construct
	public function __construct(){
		self::$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		self::$conn->set_charset('utf8');
	}
	public function __destruct(){
		self::$conn->close();
	}
	public function getData($obj){
		$arr = array();
		while($row = $obj->fetch_assoc()){
			$arr[]=$row;
		}
		return $arr;
	}
	//Viet ham lay ra tên và giá sản phẩm của hãng “Apple”	
	public function product1($page, $per_page){
		//Viet cau SQL
		//cau 1:
		$first_link = ($page - 1) * $per_page; 

		$sql = "SELECT * FROM `products`, `manufactures`,`protypes` WHERE `products`.`manu_ID`= `manufactures`.`manu_ID` AND `products`.`type_ID`= `protypes`.`type_ID` ORDER BY `ID` DESC LIMIT $first_link, $per_page"; 


		$result = self::$conn->query($sql);        

		return $this->getData($result);    
	}

	//Viet ham lay ra chi tiet san pham theo ID
	public function detail($id){
		$sql = "SELECT * FROM `products`, `manufactures`,`protypes` WHERE `products`.`manu_ID`= `manufactures`.`manu_ID` AND `products`.`type_ID`= `protypes`.`type_ID` AND `ID`= $id";
		$result = self::$conn->query($sql);
		return $this->getData($result);
	}
	public function delete($id){
		$sql="DELETE FROM `products` WHERE `ID`= $id";
		$result = self::$conn->query($sql);
		return $result;
	}
	public function search($key, $page, $per_page){
		$first_link = ($page - 1) * $per_page; 
		$sql = "SELECT * FROM `products`, `manufactures`,`protypes` WHERE `products`.`manu_ID`= `manufactures`.`manu_ID` AND `products`.`type_ID`= `protypes`.`type_ID` AND `name` LIKE '%".$key."%'  ORDER BY `ID` DESC LIMIT $first_link, $per_page";
		$result = self::$conn->query($sql);
		return $this->getData($result);
	}

	public function count1(){
		$sql = "SELECT * FROM `products`";
		$result = self::$conn->query($sql);
		return $result->num_rows;
	}

	public function count2($key){
		$sql = "SELECT * FROM `products`, `manufactures`,`protypes` WHERE `products`.`manu_ID`= `manufactures`.`manu_ID` AND `products`.`type_ID`= `protypes`.`type_ID` AND `name`LIKE '%".$key."%'";
		$result = self::$conn->query($sql);
		return $result->num_rows;
	}


	public function paginate($url, $total, $page, $per_page)
	{
		if($total <= 0) {
			return "";
		}
		$total_links = ceil($total/$per_page);
		if($total_links <= 1) {
			return "";
		}

		$first_link = ""; $prev_link =""; $last_link=""; $next_link=""; 

		if ($page > 1) { 


			$first_link = "<a href='$url'> << </a>"; 


			$prev = $page - 1; 


			$prev_link = "<a href='$url?page=$prev'> < </a>"; 

		} 

		if($page < $total_links) { 


			$last_link = "<a href='$url?page=$total_links'> 
			>> </a>"; 
			$next = $page + 1;
			$next_link = "<a href ='$url?page=$next'> 
			> </a>";

		}
		return $first_link.$prev_link.$next_link.$last_link;
	} 

	public function paginate1($key, $url, $total, $page, $per_page)
	{
		if($total <= 0) {
			return "";
		}
		$total_links = ceil($total/$per_page);
		if($total_links <= 1) {
			return "";
		}

		$first_link = ""; $prev_link =""; $last_link=""; $next_link=""; 

		if ($page > 1) { 


			$first_link = "<a href='$url?key=".$key."$page='> << </a>"; 


			$prev = $page - 1; 


			$prev_link = "<a href='$url?key=".$key."&page=$prev'> < </a>"; 

		} 

		if($page < $total_links) { 


			$last_link = "<a href='$url?key=".$key."&page=$total_links'> 
			>> </a>"; 
			$next = $page + 1;
			$next_link = "<a href ='$url?key=".$key."&page=$next'> 
			> </a>";

		}
		return $first_link.$prev_link.$next_link.$last_link;
	} 

}