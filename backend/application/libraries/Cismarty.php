<?php   
if(!defined('BASEPATH')) EXIT('No direct script asscess allowed');   
require_once( APPPATH . 'libraries/Smarty-3.1.21/libs/Smarty.class.php' );   
  
class Cismarty extends Smarty {   
    protected $ci;   

    public function  __construct(){   
        parent::__construct();
        $this->ci = & get_instance();
        $this->ci->load->config('smarty');//加载smarty的配置文件
        //获取相关的配置项
        $this->cache_lifetime  = $this->ci->config->item('cache_lifetime');
        $this->caching          = $this->ci->config->item('caching');
        $this->template_dir    = $this->ci->config->item('template_dir');
        $this->compile_dir     = $this->ci->config->item('compile_dir');
        $this->cache_dir       = $this->ci->config->item('cache_dir');
        $this->use_sub_dirs    = $this->ci->config->item('use_sub_dirs');
        $this->left_delimiter  = $this->ci->config->item('left_delimiter');
        $this->right_delimiter = $this->ci->config->item('right_delimiter');
    }   

}   