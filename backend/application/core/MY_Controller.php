<?php if (!defined('BASEPATH')) exit('No direct access allowed.'); 
class MY_Controller extends CI_Controller {  
	
	protected $post;

	public function __construct() { 
	    parent::__construct(); 
	    $this->post = json_decode(file_get_contents('php://input'),true);
		if ($this->input->post())
			$this->post = array_merge($this->post, $this->input->post());
	} 

	public function assign($key,$val) { 
	    $this->cismarty->assign($key,$val); 
	} 

	public function display($html) { 
	    $this->cismarty->display($html); 
	} 
} 