<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Admin_model extends CI_Model {
	

	public function __construct() {
		parent::__construct();
	}
	

	/****************************
	 *Function: check_usrpwd()
	 *Params: $username, $password
	 *Returns: an empty array, for failed query;
	 *         an array with keys id and name, for successful query.
	 *****************************/
	public function check_usrpwd($username, $password)
	{
		if (!$username || !$password)
			return false;
		$this->db->select('id, name')
				 ->from("admin")
				 ->where("name", $username)
				 ->where("password", $password);
		$query = $this->db->get();
		if ($query)
			return $query->result();
		else
			return false;
	}


	//增加借书证
	public function add_libcard($name, $dept, $posi)
	{
		if (!$name || !$dept || !$posi)
			return false;
		$result =  $this->db->set("name", $name)
					 		->set("department", $dept)
					 		->set("position", $posi)
					 		->insert("user");
		if ($result) 
			return true;
		else
			return $this->db->_error_message();
	}


	//删除借书证
	public function del_libcard($id)
	{
		$this->db->select('count(isbn) as count')
			     ->from('borrow')
			     ->where('uid', $id)
			     ->where('return_time <= borrow_time');
		$query = $this->db->get();
		if (!$query) {
			return "Database inner error!";
		} else {
			$result = $query->result();
			$result = $result[0]->count + 0;
			if ($result > 0)
				return "亲~还有".$result."本书没还呢~";
		}

		$result = $this->db->set("is_del", 1)
					   	   ->where("id", $id)
					       ->update("user");
		if ($result)
			return true;
		else
			return $this->db->_error_message();
	}


	//恢复借书证
	public function rec_libcard($id)
	{
		$result = $this->db->set("is_del", 0)
					   	   ->where("id", $id)
					       ->update("user");
		if ($result)
			return true;
		else
			return $this->db->_error_message();
	}


	//查询借书证信息
	public function get_libcard($data)
	{
		if (!isset($data["limit"])  || $data["limit"] < 0)   $data["limit"] = 50;
		if (!isset($data["offset"]) || $data["offset"] < 0)  $data["offset"] = 0;
		$this->db->select('*')
				 ->from("user")
				 ->limit($data["limit"], $data["offset"]);
		$query = $this->db->get();
		if ($query)
			return $query->result();
		else
			return false;
	}


	//图书入库
	public function add_book($data) {
		$result =  $this->db->set("isbn",     $data["isbn"])
					 		->set("category", $data["category"])
					 		->set("name",     $data["name"])
					 		->set("press",    $data["press"])
					 		->set("year",	  $data["year"])
					 		->set("author",	  $data["author"])
					 		->set("price",	  $data["price"])
					 		->set("amount",	  $data["amount"])
					 		->insert("books");
		if ($result) 
			return true;
		else
			return $this->db->_error_message();
	}


	//查询所有图书
	public function get_book($offset, $limit) {
		$this->db->select('books.isbn, category, name, press, year, author, price, amount, outstore');
		$this->db->from("books LEFT OUTER JOIN (
				SELECT isbn, COUNT( * ) AS outstore
				FROM  `borrow` 
				WHERE return_time <= borrow_time
				GROUP BY isbn
			) AS t1 ON books.isbn = t1.isbn");
		if (!isset($data["limit"])  || $data["limit"] < 0)   $data["limit"] = 50;
		if (!isset($data["offset"]) || $data["offset"] < 0)  $data["offset"] = 0;
		$this->db->limit($data["limit"], $data["offset"]);
		$query = $this->db->get();
		if ($query)
			return $query->result();
		else
			return false;
	}


	//按条件查询图书
	public function search_book($data) {
		$this->db->select('books.isbn, category, name, press, year, author, price, amount, outstore');
		$this->db->from("books LEFT OUTER JOIN (
				SELECT isbn, COUNT( * ) AS outstore
				FROM  `borrow` 
				WHERE return_time <= borrow_time
				GROUP BY isbn
			) AS t1 ON books.isbn = t1.isbn");
		if (isset($data["isbn"])       && $data["isbn"]      !="")		$this->db->where("books.isbn like '%".$data["isbn"]    ."%'");
		if (isset($data["category"])   && $data["category"]  !="")		$this->db->where("category like '%"  .$data["category"]."%'");
		if (isset($data["name"])       && $data["name"]      !="")		$this->db->where("name like '%"      .$data['name']    ."%'");
		if (isset($data["press"])      && $data["press"]     !="")		$this->db->where("press like '%"     .$data["press"]   ."%'");
		if (isset($data["year_from"])  && $data["year_from"] !="")		$this->db->where("year >= "          .$data["year_from"]);
		if (isset($data["year_to"])    && $data["year_to"]   !="")		$this->db->where("year <= "          .$data["year_to"]);
		if (isset($data["author"])     && $data["author"]    !="")		$this->db->where("author like '%"    .$data["author"]  ."%'");
		if (isset($data["price_from"]) && $data["price_from"]!="")		$this->db->where("price >= "         .$data["price_from"]);
		if (isset($data["price_to"])   && $data["price_to"]  !="")		$this->db->where("price <= "         .$data["price_to"]);
		if (!isset($data["limit"])  || $data["limit"] < 0)   $data["limit"] = 50;
		if (!isset($data["offset"]) || $data["offset"] < 0)  $data["offset"] = 0;
		$this->db->limit($data["limit"], $data["offset"]);
		$query = $this->db->get();
		if ($query)
			return $query->result();
		else
			return false;
	}


	//借书
	public function borrow($data) {
		//输入数据检验
		if (!isset($data["isbn"]) || !isset($data["uid"]) ||
			$data["isbn"]==""     || $data["uid"]=="")
			return "错误的ISBN号或借书证号";
		$data["borrow_time"] = date("Y-m-d H:i:s");
		
		//校验借书证状态
		$this->db->select('count(*) as count')
				 ->from('user')
				 ->where('id', $data['uid'])
				 ->where('is_del', 0);
		$query = $this->db->get();
		if (!$query)  return false;
		$result = $query->result();
		if (empty($result))  return "借书证不可用！";
		$count = $result[0]->count + 0;
		if ($count == 0)  return "借书证不可用";

		//查询馆藏总量
		$this->db->select('amount')->from('books')->where("isbn",$data['isbn']);
		$query =  $this->db->get();
		if (!$query)  return false;
		$result =  $query->result();
		if (empty($result))  return "您要借的书不存在";
		$amount = $result[0]->amount + 0;
		
		//查询借出数量
		$this->db->select('count(*) as outstore')
				 ->from('borrow')
				 ->where('isbn',$data['isbn'])
				 ->where('return_time <= borrow_time');
		$query = $this->db->get();
		if (!$query)  return false;
		$result = $query->result();
		if (empty($result))
			$outstore = 0;
		else
			$outstore = $result[0]->outstore + 0;
		if ($outstore >= $amount)  return "库存不足";

		//尝试增加借书记录
		$result =  $this->db->set("isbn",   	$data["isbn"])
			 				->set("uid", 		$data["uid"])
			 				->set("borrow_time",$data["borrow_time"])
			 				->insert("borrow");
		if ($result)  return true;
		$errorno = $this->db->_error_number();
		switch ($errorno) {
			case 1452:
				return "错误的借书证号";			
			case 1062:
				break;
			default:
				return false;
		}
		
		//第二次借书，更新借书记录
		$this->db->select('count(*) as count')->from('borrow')
				 ->where("isbn", $data['isbn'])
				 ->where("uid",  $data["uid"])
				 ->where("return_time <= borrow_time");
		$query =  $this->db->get();
		if (!$query)  return false;
		$result =  $query->result();
		if (empty($result))  return false;
		$count = $result[0]->count + 0;
		if ($count == 0)  {  //已经还了，可以借
			$result =  $this->db->set("borrow_time",   	$data["borrow_time"])
				 				->where("isbn",			$data["isbn"])
				 				->where("uid",			$data["uid"])
				 				->update("borrow");
			return $result;
		} else { 				//没还，不能借
			return "亲~您已借过本书，请先归还";
		}
	}

	
	//查询借书记录
	public function get_record($data) {
		if (!isset($data["limit"])  || $data["limit"] < 0)   $data["limit"] = 50;
		if (!isset($data["offset"]) || $data["offset"] < 0)  $data["offset"] = 0;
		$this->db->select('isbn, uid, borrow_time')
				 ->from("borrow")
				 ->where("return_time <= borrow_time")
				 ->limit($data["limit"], $data["offset"])
				 ->order_by("borrow_time", "desc");
		$query = $this->db->get();
		if ($query)
			return $query->result();
		else
			return false;
	}

	
	//按条件查询借书记录
	public function search_record($data) {
		$this->db->select('isbn, uid, borrow_time')
				 ->from("borrow")
				 ->where("return_time <= borrow_time");
		if (isset($data["isbn"]) && $data["isbn"]!="")		$this->db->where("isbn", $data["isbn"]);
		if (isset($data["uid"])  && $data["uid"] !="")		$this->db->where("uid",  $data["uid"]);
		if (!isset($data["limit"])  || $data["limit"] < 0)   $data["limit"] = 50;
		if (!isset($data["offset"]) || $data["offset"] < 0)  $data["offset"] = 0;
		$this->db->limit($data["limit"], $data["offset"]);
		$this->db->order_by("borrow_time", "desc");
		$query = $this->db->get();
		if ($query)
			return $query->result();
		else
			return false;
	}


	//还书
	public function give_back($data) {
		if (!isset($data["isbn"]) || !isset($data["uid"]))
			return "错误的ISBN号或借书证号";
		$data["return_time"] = date("Y-m-d H:i:s");
		$result =  $this->db->set("return_time",   	$data["return_time"])
	 						->where("isbn",			$data["isbn"])
	 						->where("uid",			$data["uid"])
	 						->where("return_time <= borrow_time")
	 						->update("borrow");
	 	if ($result !== true)
	 		return false;
	 	if ($this->db->affected_rows() !== 1)
	 		return "无此借书记录或已归还";
	 	return true;
	}


}
?>
