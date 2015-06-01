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
Codeigniter and Smarty Bundle  
  
因为CI自带的模板功能不是很方便，所以大家普遍采用集成Smarty的方式来弥补CI这方面的不足。本人在网上看了不少CI集成Smarty的教程，包括咱们CI论坛里面的一个精华帖子http://codeigniter.org.cn/forums/forum.php?mod=viewthread&tid=10345。  
  
自己对比了一下这些教程，我认为下面这个方案是所有里面最优秀的，强烈推荐给大家(当然也是我自己采取的方案)  
出处:http://www.cnmiss.cn/?p=261  
原文里面的一些错误，我在本文里面已经做了修正   
------------------------------------------------------------------
下面说下我认为它更加优秀的原因，对比下这个方案和我们论坛的方案，你会发现，这个方案多了一点就是它扩展了核心类，
它将Smarty类方法assign和display扩展到Ci的控制器中，所以我们在CI中使用Smarty的时候可以像这样使用：
<pre><code>
    public function index()
    {
        //$this->load->view('welcome_message');
        $data['title'] = '标题';
        $data['num'] = '123456789';
        //$this->cismarty->assign('data',$data); // 也可以
        $this->assign('data',$data);
        $this->assign('tmp','hello');
        //$this->cismarty->display('test.html'); // 也可以
        $this->display('test.html');
    }
</code></pre>
通过对核心控制器类的简单扩展，大家在CI中使用Smary的时候和直接使用Smarty的用法习惯是一样的，这是一个很大的优点啊。   
而且从核心类库的扩展来看，大家也可以看出该文作者对于CI框架的理解是很好的。  
根据这篇文章，我不仅成功集成了Smaty，而且也进一步加强了对于CI的理解。  

而且该方案将Smarty的配置文件放到了CI框架的config目录下，对于两者，使用都很规范。   
最终实现了"CI和Smaty的无缝结合"。  
<br/>
######配置方法
CI版本：2.2 // 此时的最新版本  
Smarty版本：Smarty-2.6.28 // 因为我之前用这个版本，为了照顾自己的使用习惯，这里没有使用最新的Smaty版本，大家理解了扩展原理，可以选择自己想用的Smatry版本。  
<br/>
1.  到相应站点下载Smarty的源码包； // 我这里用的是 Smarty-2.6.28  
2.  将源码包里面的libs文件夹copy到CI的项目目录下面的libraries文件夹下，并重命名为Smarty-2.6.28； 
3.  在项目目录的libraries文件夹内新建文件Cismarty.php，里面的内容如下：
<pre><code>
&lt;?php if(!defined('BASEPATH')) EXIT('No direct script asscess allowed'); 
require_once( APPPATH . 'libraries/Smarty-2.6.28/libs/Smarty.class.php'); 
class Cismarty extends Smarty { 
    protected $ci; 
    public function  __construct() { 
        $this->ci = & get_instance(); 
        $this->ci->load->config('smarty');//加载smarty的配置文件 
        //获取相关的配置项 
        $this->template_dir   = $this->ci->config->item('template_dir'); 
        $this->complie_dir    = $this->ci->config->item('compile_dir'); 
        $this->cache_dir      = $this->ci->config->item('cache_dir'); 
        $this->config_dir     = $this->ci->config->item('config_dir'); 
        $this->template_ext   = $this->ci->config->item('template_ext'); 
        $this->caching        = $this->ci->config->item('caching'); 
        $this->cache_lifetime = $this->ci->config->item('lefttime'); 
    } 
} 
</code></pre>

4.  在项目目录的config文件夹内新建文件smarty.php文件,里面的内容如下： 
<pre><code>
&lt;?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$config['theme']        = 'default'; 
$config['template_dir'] = APPPATH . 'views'; 
$config['compile_dir']  = FCPATH . 'templates_c'; 
$config['cache_dir']    = FCPATH . 'cache'; 
$config['config_dir']   = FCPATH . 'configs'; 
$config['template_ext'] = '.html'; 
$config['caching']      = false; 
$config['lefttime']     = 60; 
</code></pre>  

5.  入口文件所在目录新建文件夹templates_c、cache、configs；   
6.  在项目目录下面的config目录中找到autoload.php文件   
修改这项
<pre><code>
$autoload['libraries'] = array('Cismarty');//目的是：让系统运行时，自动加载，不用人为的在控制器中手动加载   
</code></pre>

7.  在项目目录的core文件夹中新建文件MY_Controller.php 内容如下： // 扩展核心控制类   
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
-------------------------------------------------------------------  
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
        //$this-&gt;cismarty-&gt;assign('data',$data); // 亦可 
        $this-&gt;assign('data',$data); 
        $this-&gt;assign('tmp','hello'); 
        //$this-&gt;cismarty-&gt;display('test.html'); // 亦可 
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
    &lt;title&gt;{ $data.title}&lt;/title&gt; // 原文是 &lt;title&gt;{$test['title']}&lt;/title&gt;，是错误的写法，也有可能是Smarty版本的原因 
&lt;/head&gt; 
&lt;body&gt; 
    {$data.num|md5} // 原文这里也写错了 
    &lt;br&gt; 
    {$tmp} 
&lt;/body&gt; 
&lt;/html&gt; 
</code></pre>
