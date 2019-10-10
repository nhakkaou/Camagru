<?php 
class Posts extends Controller {
    public function __construct(){
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }
    
    public function index(){
        redirect('posts/home');
    }
    
    public function home(){
        $nmParPage = 5;
        $picTotales = $this->postModel->countpost();
        $pageTotales = ceil($picTotales/$nmParPage);
        if(isset($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pageTotales AND !empty($_GET['page']))
        {
            $_GET['page'] = intval($_GET['page']);
            $pageCourante = $_GET['page'];
        }else{
            $pageCourante = 1;
        }
        $depart = ($pageCourante - 1) * $nmParPage;
        $posts = $this->postModel->getPosts($depart);
        $cmnts = $this->postModel->getCmnts();
        $likes = $this->postModel->getlikes();
        $data = ['posts' => $posts,
                'cmnts' => $cmnts,
                'likes' => $likes,
                'total' => $pageTotales];
        
        $this->view('posts/index',$data);
    }
    

    
    
    public function take_pic()
       {
           if(isset($_POST['imgBase64']))
           {
               $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
               $upload_dir = "../public/img/";
               $img = $_POST['imgBase64'];
               $img = str_replace('data:image/png;base64,', '', $img);
               $img = str_replace(' ', '+', $img);
               $data = base64_decode($img);
               $file = $upload_dir . mktime().'.png';  
               file_put_contents($file, $data);
               $_POST['stick'] = str_replace('http://localhost/Camagru/clip-arts/', '', $_POST['stick']);
               $sourceImage = "../public/clip-arts/".$_POST['stick'];
               $destImage = $file;
               list($srcWidth, $srcHeight) = getimagesize($sourceImage);
               @$src = imagecreatefrompng($sourceImage);
               @$dest = imagecreatefrompng($destImage);
               @imagecopyresized($dest, $src, 0, 0, 0, 0, 200, 200, $srcWidth, $srcHeight);
               @imagepng($dest, $file, 9);
               move_uploaded_file($dest, $file);
             
               $dt = ['user_id' => $_SESSION['user_id'],
                      'user_name' => $_SESSION['user_name'],
                      'path' =>$file
               ];
               if (!empty($data)) {
                   if ($this->postModel->addposts($dt) == true) {
                       $infos = $this->userModel->findUserByName($_SESSION['user_name']);
                       $nb = $infos->nb_post + 1;
                       $_SESSION['nb_post'] = $nb;
                       if ($this->postModel->nb_post($nb, $_SESSION['user_name']))
                       {
                           
                       }else
                           die ('ERROR');
                   }
                    else{
                        die ("ERROR");
                    }
               }else
                   die("EROOR");
           }

       }
    
    public function delete(){
        if (isset($_POST['imgid'])){
           if($this->postModel->getinfobyIdimg($_POST['imgid']))
           {
                    if($this->postModel->deletePost($_POST['imgid'])){
                        $infos = $this->userModel->findUserByName($_SESSION['user_name']);
                       $nb = $infos->nb_post - 1;
                        if ($nb < 0)
                            $nb = 0;
                        $_SESSION['nb_post'] = $nb;
                       if ($this->postModel->nb_post($nb, $_SESSION['user_name']))
                       {
                           
                       }else
                           die ('ERROR');
                        flash('post_message', 'Post Removed');
                        $this->view('users/profile');
                    }else
                    die("Something went Wrong");
                }else
                {   echo "<script>alert('you cant remove This Pic!');</script>";
                    $this->view('users/take_pic');
                }
        }else{
            redirect('posts/home');
        }
    }
    
    
  
    public function send_mail($dt){
            $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
            $to = $dt['email_r'];
            $sujet = "NEW NOTIFICATION 'Camagru'";
            $message = '<h1><strong>Camagru</strong></h1>   Hello '.$dt['recipteur'].' You have a new notification from '.$dt['name_s'];
        if(mail($to, $sujet, $message, $headers))
                return TRUE;
            else
                return FALSE;
    }
    public function add_like(){
        if(isset($_SESSION['user_name'])){
        if(isset($_POST['post_id'])){
        if($this->postModel->getinfobyIdimg($_POST['post_id']))
           {
                $data = ['img_id' => $_POST['post_id'],
                         'usr_name' => $_SESSION['user_name'],
                        'usr_id' => $_SESSION['user_id']];
                if ($_POST['c'] == 'far fa-kiss-wink-heart'){
                    if($this->postModel->jaimePost($data)){
                    
                    }else
                        die('ERROR');
                }else{
                      if($this->postModel->jaimepasPost($data)){
                    
                    }else
                        die('ERROR');
                }
            }
        }
        }else
            redirect('users/login');
    }
    
    
    public function add_cmnt(){
        if(!empty($_SESSION['user_id'])){
        $_POST['aj_cmnt'] = trim($_POST['aj_cmnt']);
        if(isset($_POST['submit'])){
            if(!empty($_POST['aj_cmnt']))
            {
                $cmnt = ['user_name' => $_SESSION['user_name'],
                'img_id' => $_POST['img_id'],
                'user_id' => $_SESSION['user_id'],
                'cmnt' => $_POST['aj_cmnt']];
                if($this->postModel->add_cmnt($cmnt))
                {
                    $re = $this->postModel->findByimgId($cmnt['img_id']);
                    $mail = $this->userModel->findUserById($re->userid);
                    $data = ['recipteur' => $re->user_name,
                            'email_r' => $mail->email,
                            'name_s' => $_SESSION['user_name']];
                  
                    if ($mail->recieve != 0){
                        $this->send_mail($data);
                    }
                    redirect("posts/home?page=".$_POST['page']);
                }else
                    echo "<script>alert('something went wrong');";
            }else
                redirect("posts/home?page=".$_POST['page']);
        }       
        }else
            redirect("posts/home?page=".$_POST['page']);
    }    
}