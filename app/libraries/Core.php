<?php 

class Core{
    protected $currentController = 'Posts' ;
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
         $url = $this->getUrl();
        $c = count($url);
            // check for controller of url
         if(file_exists('../app/controllers/' . ucwords($url[0]) .'.php')){
             $this->currentController = ucwords($url[0]);
             unset($url[0]);
         }
            //REquire the controller
         require_once '../app/controllers/' . $this->currentController . '.php';
            //instanciate controller class
         $this->currentController = new  $this->currentController;
            // check for  method of url
         if(isset($url[1])){
             if(method_exists($this->currentController, $url[1])){
                if ($url[1] != 'confirm' && $url[1] != 'delete' && $url[1] != 'add_like' && $url[1] != 'add_cmnt' && $url[1] != 'change_profile_pic') 
                    $this->currentMethod = $url[1];
                 unset($url[1]);
             }else
                 redirect('posts/home');
        }
        if(isset($url[2]))
            redirect('posts/home');
        
        if ($c >= 1){
        if(preg_match('{/$}',$_SERVER['REQUEST_URI'])) {
        header ('Location: '.preg_replace('{/$}', '', $_SERVER['REQUEST_URI']));
        exit();
        }}
         // check for params of url
         $this->params = $url ? array_values($url) : [];

         // call a callback with array of params
         call_user_func_array([$this->currentController, $this->currentMethod],$this->params);
    }
    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/\\');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }
}