<?php

class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
    }

    public function index(){
        redirect('posts/index');
    }
     public function profile(){
        
       $data = $this->postModel->getPostsById(); 
        $this->view('users/profile',$data);
    }
      public function logout(){
        if ($_GET['token'] == $_SESSION['token']){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_profile']);
            unset($_SESSION['recieve']);
            unset($_SESSION['nb_post']);
            unset($_SESSION['token']);
            session_destroy();
            redirect('users/login');
        }else
            redirect('posts/index');
    }
    public function register(){
    	//Check for post
    	if($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
         $data =[
                'name' => trim($_POST['User']),
                'email' => trim($_POST['Mail']),
                'pass' => trim($_POST['Pass']),
                'date' => trim($_POST['date']),
                'token' => substr(md5(openssl_random_pseudo_bytes(20)), 10),
                'name_error' => '',
                'email_error' => '',
                'pass_error' => '',
                'date_error' => ''
            ];
            if (empty($data['email'])){
                $data['email_error'] = 'Please entre email';
            }else{
                //check email
                if ($this->userModel->findUserByEmail($data['email']))
                {
                    $data['email_error'] = 'Email is already taken';
                }
            }
             if (empty($data['pass'])){
                $data['pass_error'] = 'Please entre Password';
            }
            else{
                $uppercase = preg_match('@[A-Z]@', $data['pass']);
                $lowercase = preg_match('@[a-z]@', $data['pass']);
                $number    = preg_match('@[0-9]@', $data['pass']);
                if(!$uppercase || !$lowercase || !$number || strlen($data['pass']) < 6)
                $data['pass_error'] = "Wrong Fromat Example: Mn1234";
            }
             if (empty($data['name'])){
                $data['name_error'] = 'Please entre name';
            }else{
                //check email
                if ($this->userModel->findUserByName($data['name']))
                {
                    $data['name_error'] = 'Name is already Existe';
                }
                if(strlen($data['name']) > 30)
                    $data['name_error'] = "Too Long";
                if(!ctype_alnum($data['name']))
                    $data['name_error'] = "Please Chose another name";
             }
             if (empty($data['date'])){
                $data['date_error'] = 'Please entre date';
            }
            if (empty($data['name_error']) && empty($data['pass_error']) && empty($data['date_error']) && empty($data['email_error']) && preg_match("/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",$data['email'])){
                //done
                $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
                //regiter
                if ($this->userModel->register($data)){
                    $this->confirm($data['email'], $data['token']);
                    flash('register_success', 'You are registered and can Log in');
                    redirect('users/login');
                }else{
                    die('something went wrong');
                }
            }
            else{
                $this->view('users/register',$data);
            }
        }else {
            $data =[
                'name' => '',
                'email' => '',
                'pass' => '',
                'date' => '',
                'name_error' => '',
                'email_error' => '',
                'pass_error' => '',
                'date_error' => ''
            ];
            //load view
            $this->view('users/register',$data);
        }
    }
     public function login(){
         //Check for post
    	if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data =[
                'name' => trim($_POST['username']),
                'pass' => trim($_POST['password']), 
                'name_error' => '',    
                'pass_error' => '',
            ];
            if (empty($data['pass'])){
                $data['pass_error'] = 'Please entre Password';
            }
            elseif(strlen($data['pass']) < 6){ 
                $data['pass_error'] = "Password must be at least 6 characters";
            }
            if (empty($data['name'])){
                $data['name_error'] = 'Please entre name';
            }
            //check user name
            
            if ($res = $this->userModel->findUserByName($data['name']))
            {
                if ($res->validate != 1)
                    $data['pass_error'] = 'You account is not verified please check your email first';
            }else{
                $data['name_error'] = 'No User Found';
            }
            if (empty($data['name_error']) && empty($data['pass_error']))
            {
               //Validated
                $logedInUser = $this->userModel->login($data['name'], $data['pass']);
                if($logedInUser){
                    //Create session
                    if($this->creatUserSession($logedInUser))
                        redirect("posts/home");
                }else{
                    $data['pass_error'] = 'Password Incorrect';
                    $this->view('users/login',$data);
                }
            }
            else{
                $this->view('users/login',$data);
            }
        }else {
            $data =[
                'name' => '',
                'pass' => '', 
                'name_error' => '',    
                'pass_error' => '',
            ];
            //load view
            $this->view('users/login',$data);
        }
    }
    
    
    public function edit(){
    	//Check for post
    	if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data =[
                'id' => $_SESSION['user_id'],
                'name' => trim($_POST['new_user']),
                'newpass' => trim($_POST['new_pass']), 
                'email' => trim($_POST['new_email']),    
                'oldpass' => trim($_POST['old_pass']),
                'newpass_error' => '', 
                'email_error' => '',    
                'oldpass_error' => '',
                'name_error' => '',
                'recieve' => ''
            ];
            $infos = $this->userModel->findUserByName($_SESSION['user_name']);
            echo $data['recieve'];
            if (!empty($data['oldpass']))
            {
                if (password_verify($data['oldpass'], $infos->password))
                    {}
                else
                    $data['oldpass_error'] = 'Wrong Password';
                
            }else{
                $data['oldpass_error'] = 'You must write Your current password';
            }
            /*******check box********/
            if ($_POST['recieve'] == 'on')
                $data['recieve'] = 1;
            else
                $data['recieve'] = 0;
            /*******check Email******/
            if (!empty($data['email'])){
                if(preg_match("/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",$data['email'])){
                    if($this->userModel->findUserByEmail($data['email']))
                        $data['email_error'] = "This Email is already existe";
                }
                else
                    $data['email_error'] = "Wrong Format";
            }else{
                $data['email'] = $_SESSION['user_email'];
            }
            /*******check name******/
            if(!empty($data['name'])){
                if($this->userModel->findUserByName($data['name'])){
                 $data['name_error'] = "This name is already existe";
                }
                if(strlen($data['name']) > 30)
                    $data['name_error'] = "Too Long";
                if(!ctype_alnum($data['name']))
                    $data['name_error'] = "Please Chose another name, it's should be Alphanum";
            }else{
                $data['name'] = $_SESSION['user_name'];
            }
            /*******check new pass******/
            if(!empty($data['newpass'])){
                $uppercase = preg_match('@[A-Z]@', $data['newpass']);
                $lowercase = preg_match('@[a-z]@', $data['newpass']);
                $number    = preg_match('@[0-9]@', $data['newpass']);
                if(!$uppercase || !$lowercase || !$number || strlen($data['newpass']) < 6)
                    $data['newpass_error'] = "Wrong Fromat Example: Mn1234";
                else
                    $data['newpass'] = password_hash($data['newpass'], PASSWORD_DEFAULT);
                    
            }else{
                $data['newpass'] = $infos->password;
            }
            if (empty($data['name_error']) && empty($data['email_error']) && empty($data['newpass_error']) && empty($data['oldpass_error']))
            {
                
                if($this->userModel->edit($data))
                {                    
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_email'] = $data['email'];
                    $_SESSION['recieve'] = $data['recieve'];
                    redirect('posts/home');
                }
                else
                    die("Error");
            }
            $this->view('users/edit', $data);
        }
         else{
             $data = [
                'id' => '',
                'name' => '',
                'newpass' => '', 
                'email' => '',    
                'oldpass' => '',
                'newpass_error' => '', 
                'email_error' => '',
                'oldpass_error' => '',
                'name_error' => ''
                ];
         }
         $this->view('users/edit', $data);
}
    
    public function creatUserSession($user){
        if (!empty($user))
        {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_profile'] = $user->profilepic;
                $_SESSION['recieve'] = $user->recieve;
                $_SESSION['nb_post'] = $user->nb_post;
                $_SESSION['token'] = str_shuffle($user->token);
                redirect('posts/home');
        }
    }
    
    public function take_pic(){
        $data = $this->postModel->getPostsById();
        $this->view('users/take_pic', $data);
    }
    
    
  
    
    public function change_profile_pic(){
            $test = getimagesize("../public/img/".$_POST['file']);
            $upload_dir = "../public/img/".$_POST['file'];
            if($test['mime'] == "image/png" || $test['mime'] == "image/jpg" || 
            $test['mime'] == "image/jpeg" || $test['mime'] == "image/gif")
            {
                $dt = ['id' => $_SESSION['user_id'],
                         'path' => $upload_dir];
                  if($this->userModel->changepic($dt))
                {
                    $_SESSION['user_profile'] = $upload_dir;
                    redirect('users/profile');
                }else
                    die("ERROR");
                }
            }
        
    
    public function check(){
        if (isset($_GET['cle']) && isset($_GET['email'])){
            $cle = trim($_GET['cle']);
            $mail = trim($_GET['email']);
            if($this->userModel->check_tk($cle, $mail)){
                if($this->userModel->putone($mail)){
                    $str = str_shuffle($cle);
                    $this->userModel->add_forget_tk($str, $mail);
                    $this->view('users/check');   
                }else
                    redirect('users/login');
            }
        }else
            redirect('users/login');
    }
    
    public function confirm($mail, $token){
    if($result = $this->userModel->findUserByEmail($mail))
    {
        $str = str_shuffle($token);
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        $to = $mail;
        $sujet = "Confirm Account 'Camagru'";
        $message = '<h1><strong>Camagru</strong></h1>   To Confirm your Account click in the link below! <a href="http://localhost/Camagru/users/check/?cle='.$str.'&email='.urlencode($mail).'">Link</a>';
        if(mail($to, $sujet, $message, $headers))
        {
        if ($this->userModel->add_forget_tk($str, $mail))
        {
            flash('register_success', 'Check your mail');
            redirect ('users/login');
        }else
            die('ERROR');
        }
    }
    }
    
    
    
    public function forget_pass(){
        $data = ['error' => '',
                'email' => $_POST['email_recovery']
                ];
        if(isset($_POST['email_recovery'])){
            if (empty($data['email']))
                $data['error'] = "You must write your Email";
            if (preg_match("/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",$data['email'])){
                
                if($result = $this->userModel->findUserByEmail($data['email']))
                {
                    if($result->validate == 1){
                    $str = str_shuffle($result->token);
                    $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $to = $result->email;
                    $sujet = "Forget Password 'Camagru'";
                    $message = '<h1><strong>Camagru</strong></h1>   To change your password click in the link below! <a href="http://localhost/Camagru/users/reset/?cle='.urlencode($str).'&email='.urlencode($data['email']).'">Link</a>';
                    if(mail($to, $sujet, $message, $headers))
                    {
                        if ($this->userModel->add_forget_tk($str, $data['email']))
                            flash('register_success', 'Check Your mail');
                        else
                            alert('Error!');
                    }
                    }else
                        $data['error'] = 'You Must confirm Your account First';
                }else{
                    $data['error'] = 'Email doesnt existe';
                }
            }else{
                $data['error'] = "Wrong Format";
            }
        }
        $this->view("users/forget_pass",$data);
    }
    
    public function reset(){
         $data = ['new_mt' => '',
                'new_cnf' => '',
                'new_error' => '',
                'cnf_error' => ''];
        if (isset($_GET['cle']) && isset($_GET['email']))
        {
            $cle = trim($_GET['cle']);
            $mail = trim($_GET['email']);
            if ($this->userModel->check_tk($cle, $mail))
            {
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $data = ['cle'=> trim($_GET['cle']),
                            'email' => trim($_GET['email']),
                            'new_mt' => trim($_POST['new_mt']),
                            'new_cnf' => trim($_POST['new_cnf']),
                            'new_error' => '',
                            'cnf_error' => '',
                            'new_token' => ''];
                if (empty($data['new_mt']))
                    $data['new_error'] = 'Please entre Password';
                else{
                    $uppercase = preg_match('@[A-Z]@', $data['new_mt']);
                    $lowercase = preg_match('@[a-z]@', $data['new_mt']);
                    $number    = preg_match('@[0-9]@', $data['new_mt']);
                    if(!$uppercase || !$lowercase || !$number || strlen($data['new_mt']) < 6)
                    $data['new_error'] = "Wrong Fromat Example: Mn1234";
                } 
                if (empty($data['new_cnf']))
                    $data['cnf_error'] = 'Please entre Confirm Password';
                if ($data['new_mt'] != $data['new_cnf'])
                    $data['cnf_error'] = "The Password not Identical";
                if (empty($data['new_error']) && empty($data['cnf_error']))
                {
                    $data['new_mt'] = password_hash($data['new_mt'], PASSWORD_DEFAULT);
                    $data['new_token'] = substr(md5(openssl_random_pseudo_bytes(20)), 10);
                    if ($this->userModel->update_pass($data)){
                        if($this->userModel->add_forget_tk($data['new_token'], $data['email'])){
                        flash('register_success', 'you can log in right now');
                        redirect('users/login');
                        }
                    }else
                        die ('Please Try Again');
                    
                }else{
                    $this->view("users/reset", $data);
                }
                 $this->view('users/reset',$data);
          
            }else
                $this->view('users/reset',$data);
        }else
        {
            redirect('users/login');
        }
        }
    }
    
    
    

}

        