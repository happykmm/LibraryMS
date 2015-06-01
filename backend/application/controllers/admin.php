<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	protected $id;

	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->id = $this->session->userdata('id');
	}

	public function index()
	{
		if ($this->id === false) {
			$this->login();
		} else {
			$this->overview();
		}
	}

	public function login() {
		$this->load->view("login.php");
	}

	public function overview() {
		if ($this->id === false) {
			$this->login();
		} else {
			$this->load->view('overview');
		}
	}

	public function borrow() {
		if ($this->id === false) {
			$this->login();
		} else {
			$this->load->view('borrow');
		}
	}

	public function giveback() {
		if ($this->id === false) {
			$this->login();
		} else {
			$this->load->view('giveback');
		}
	}

	public function instore() {
		if ($this->id === false) {
			$this->login();
		} else {
			$this->load->view('instore');
		}
	}

	public function libcard() {
		if ($this->id === false) {
			$this->login();
		} else {
			$this->load->view('libcard');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */