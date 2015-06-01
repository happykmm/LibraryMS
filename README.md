# Library-Management-System
<br />
#####Solve problem: origin PHP can't understand "application/json"
    $this->post = array();  
    $json = json_decode(file_get_contents('php://input'),true);  
    if ($json)	  
    　　$this->post = array_merge($this->post, $json);  
    if ($this->input->post())  
    　　$this->post = array_merge($this->post, $this->input->post());  
<br />
##### CI-Smarty
######配置方法
CI版本：2.2   
Smarty版本：Smarty-3.1.21   
1.  到相应站点下载Smarty的源码包；  
2.  将源码包里面的libs文件夹copy到CI的application/libraries文件夹下，并重命名为Smarty-3.1.21；  
3.  在application/libraries内新建文件Cismarty.php，里面的内容如下：   
<pre><code>
&lt;?php if(!defined('BASEPATH')) EXIT('No direct script asscess allowed'); 
require_once( APPPATH . 'libraries/Smarty-2.6.28/libs/Smarty.class.php'); 
class Cismarty extends Smarty { 
    protected $ci; 
    public function  __construct() { 
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
</code></pre>

4.  在项目目录的config文件夹内新建文件smarty.php文件,里面的内容如下：   
<pre><code>
&lt;?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$config['cache_lifetime']		= 30*24*3600;
$config['caching']				= false;
$config['template_dir']			= APPPATH .'views';
$config['compile_dir']			= APPPATH .'views/template_c';
$config['cache_dir']			= APPPATH . 'views/cache';
$config['use_sub_dirs']			= false;		//子目录变量(是否在缓存文件夹中生成子目录)
$config['left_delimiter']		= '{{';
$config['right_delimiter']		= '}}';
</code></pre>  

5.  在项目目录下面的config目录中找到autoload.php文件   
修改这项
<pre><code>
$autoload['libraries'] = array('Cismarty'); //目的是：让系统运行时，自动加载，不用人为的在控制器中手动加载   
</code></pre>

6.  在项目目录的core文件夹中新建文件MY_Controller.php 内容如下： // 扩展核心控制类   
<pre><code>
&lt;?php if (!defined('BASEPATH')) exit('No direct access allowed.'); 
class MY_Controller extends CI_Controller {  
    public function __construct() { 
        parent::__construct(); 
    } 

    public function assign($key,$val) { 
        $this-&gt;cismarty-&gt;assign($key,$val); 
    } 

    public function display($html) { 
        $this-&gt;cismarty-&gt;display($html); 
    } 
} 
</code></pre>
配置完毕  

######使用方法实例
在控制器中如： 
<pre><code>
&lt;?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Welcome extends MY_Controller { // 原文这里写错 
    public function index() 
    { 
        //$this->load->view('welcome_message'); 
        $data['title'] = '标题'; 
        $data['num'] = '123456789'; 
        $this-&gt;assign('data',$data); 
        $this-&gt;assign('tmp','hello'); 
        $this-&gt;display('test.html'); 
    } 
} 
</code></pre>

然后再视图中：试图文件夹位于项目目录的views之下：   
新建文件test.html   
<pre><code>
&lt;!DOCTYPE html&gt; 
&lt;html&gt; 
&lt;head&gt; 
    &lt;meta charset="utf-8"&gt; 
    &lt;title&gt;{ $data.title}&lt;/title&gt;   
&lt;/head&gt; 
&lt;body&gt; 
    {$data.num|md5}  
    &lt;br&gt; 
    {$tmp} 
&lt;/body&gt; 
&lt;/html&gt; 
</code></pre>
