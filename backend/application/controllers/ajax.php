<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller {

	protected $id;
	

	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->id = $this->session->userdata('id');
		$this->load->model("admin_model");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
	}

	public function login() {
		$username = $this->post["username"];
		$password = $this->post["password"];
		$result = $this->admin_model->check_usrpwd($username, $password);
		if (!$result) { //查询失败
			$json = array("code"=>1, "desc"=>"username and password cannot match");
		} else { //查询成功
			$json = array("code"=>0, "desc"=>"login success");
			$this->session->set_userdata($result[0]);
		}
		echo json_encode($json);
	}

	public function add_libcard() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$name = $this->post["name"];
			$dept = $this->post["dept"];
			$posi = $this->post["posi"];
			if (!$name || !$dept || !$posi) {
				$json = array("code"=>2, "desc"=>"信息不完整");
			} else {
				$result = $this->admin_model->add_libcard($name, $dept, $posi);
				if ($result === true)
					$json = array("code"=>0, "desc"=>"success");
				else
					$json = array("code"=>3, "desc"=>$result);
			}
		}
		echo json_encode($json);
	}

	public function del_libcard() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$id = $this->post["id"];
			$result = $this->admin_model->del_libcard($id);
			if ($result === true)
				$json = array("code"=>0, "desc"=>"success");
			else
				$json = array("code"=>2, "desc"=>$result);
		}
		echo json_encode($json);
	}

	public function rec_libcard() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$id = $this->post["id"];
			$result = $this->admin_model->rec_libcard($id);
			if ($result === true)
				$json = array("code"=>0, "desc"=>"success");
			else
				$json = array("code"=>2, "desc"=>$result);
		}
		echo json_encode($json);
	}

	public function get_libcard() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			$result = $this->admin_model->get_libcard($data);
			if ($result)
				$json = array("code"=>0, "desc"=>$result);
			else
				$json = array("code"=>2, "desc"=>"empty records");
		}
		echo json_encode($json);
	}

	public function add_book() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			if (!$data["isbn"]  || !$data["category"] || !$data["name"]   ||
				!$data["press"] || !$data["year"]     || !$data["author"] ||
				!$data["price"] || !$data["amount"]) {
				$json = array("code"=>2, "desc"=>"信息不完整");
			} else {
				$result = $this->admin_model->add_book($data);
				if ($result === true)
					$json = array("code"=>0, "desc"=>"success");
				else
					$json = array("code"=>3, "desc"=>$result);
			}
		}
		echo json_encode($json);
	}

	public function get_book() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$offset = $this->post["offset"];
			$limit = $this->post["limit"];
			$result = $this->admin_model->get_book($offset, $limit);
			if ($result)
				$json = array("code"=>0, "desc"=>$result);
			else
				$json = array("code"=>2, "desc"=>"empty records");
		}
		echo json_encode($json);
	}

	public function search_book() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			$result = $this->admin_model->search_book($data);
			if ($result)
				$json = array("code"=>0, "desc"=>$result);
			else
				$json = array("code"=>2, "desc"=>"empty records");
		}
		echo json_encode($json);
	}

	public function borrow() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			$result = $this->admin_model->borrow($data);
			if ($result === true)
				$json = array("code"=>0, "desc"=>"借书成功");
			else
				$json = array("code"=>2, "desc"=>$result);
		}
		echo json_encode($json);
	}

	public function get_record() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			$result = $this->admin_model->get_record($data);
			if ($result)
				$json = array("code"=>0, "desc"=>$result);
			else
				$json = array("code"=>2, "desc"=>"empty records");
		}
		echo json_encode($json);
	}

	public function search_record() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			$result = $this->admin_model->search_record($data);
			if ($result)
				$json = array("code"=>0, "desc"=>$result);
			else
				$json = array("code"=>2, "desc"=>"empty record");
		}
		echo json_encode($json);
	}

	public function give_back() {
		if ($this->id === false) {
			$json = array("code"=>1, "desc"=>"please login first");
		} else {
			$data = $this->post;
			$result = $this->admin_model->give_back($data);
			if ($result===true)
				$json = array("code"=>0, "desc"=>"还书成功");
			else
				$json = array("code"=>2, "desc"=>$result);
		}
		echo json_encode($json);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */