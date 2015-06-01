# Library-Management-System
<br />
#####Solve problem: origin PHP can't understand "application/json"
    $this->post = array();  
    $json = json_decode(file_get_contents('php://input'),true);  
    if ($json)	  
    　　$this->post = array_merge($this->post, $json);  
    if ($this->input->post())  
    　　$this->post = array_merge($this->post, $this->input->post());  
