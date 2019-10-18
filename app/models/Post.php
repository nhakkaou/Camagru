<?php 
    class Post{
        private $db;
        
        public function __construct()
        {
            $this->db = new Database;
        }
        public function getPostsById(){
            $this->db->query('SELECT * FROM `img` WHERE userid = :id ORDER BY date_creat DESC');
            $this->db->bind(":id", $_SESSION['user_id']);
            $result = $this->db->resultSet();
            if($this->db->rowCount() > 0)
                return ($result);
            return (false);
        }
        public function getPosts($depart){
            $this->db->query('SELECT *,
            img.id_img as imgId,
            login.id as loginId
            FROM img
            INNER JOIN login
            ON img.userid = login.id
            ORDER BY img.date_creat DESC LIMIT '.$depart.',5');
            $r = $this->db->resultSet();
            if($this->db->rowCount() > 0)
                return ($r);
            return (false);
        }
        
        public function countpost(){
            $this->db->query('SELECT * FROM img');
            $this->db->execute();
            $n = $this->db->rowCount();
            if ($n)
                return $n;
            return FALSE;
        }
        public function addposts($data){
            $this->db->query('INSERT INTO `img` (`userid`, `pic`, `date_creat`,  `user_name`) VALUES (:userid, :pic, NOW(), :user_name)');
            $this->db->bind(':userid', $data['user_id']);
            $this->db->bind(':pic', $data['path']);
            $this->db->bind(':user_name', $data['user_name']);
            if ($this->db->execute()){
                    return true;
            }else{
                    return false;
            }
        }
        
        public function getinfobyIdimg($id){
            $this->db->query('SELECT * FROM `img` WHERE id_img = :id');
            $this->db->bind(":id", $id);
            $this->db->execute();
            if($this->db->rowCount() > 0)
                return (TRUE);
            return (false);
        }
        public function deletePost($id){
            $this->db->query('DELETE FROM img WHERE id_img = :id');
            $this->db->bind(":id", $id);
            if ($this->db->execute())
                return TRUE;
            else
                return FALSE;
        }
        
        public function add_cmnt($dt){
            try{
            $this->db->query('INSERT INTO `comments`(`cmt_name`,`user_id`, `img_id`, `Comment`, `cmt_time`) VALUES (:username,:id,:id_img,:cmnt, NOW())');
            $this->db->bind(':username', $dt['user_name']);
            $this->db->bind(':id', $dt['user_id']);
            $this->db->bind(':id_img', $dt['img_id']);
            $this->db->bind(':cmnt', $dt['cmnt']);
            if($this->db->execute())
                return TRUE;
            else
                return FALSE;}
            catch (PDOException $e)
            {
                echo 'Error: ' . $e->getMessage() . '\n';
                die();
            }    
        }
        
        public function getCmnts(){
            $this->db->query('SELECT *,
            comments.user_id as cmntuserId,
            img.id_img as img_imgId
            FROM comments
            INNER JOIN img
            ON comments.img_id = img.id_img
            ORDER BY comments.cmt_time ASC');
            $result = $this->db->resultSet();
            if($this->db->execute())
                return $result;
            else
                return FALSE;
        }
        public function getlikes(){
            $this->db->query('SELECT *,
            jaimex.user_id as likeusrId,
            img.id_img as img_imgId
            FROM jaimex
            INNER JOIN img
            ON jaimex.img_id = img.id_img
            ORDER BY img.date_creat ASC');
            $result = $this->db->resultSet();
            if($this->db->execute())
                return $result;
            else
                return FALSE;
        }
        public function jaimePost($dt){
            $this->db->query('INSERT INTO `jaimex`(`user_id`, `img_id`, `usr_name`) VALUES (:usr_id, :img_id,:usr_name)');
            $this->db->bind(':usr_id', $dt['usr_id']);
            $this->db->bind(':img_id', $dt['img_id']);
            $this->db->bind(':usr_name', $dt['usr_name']);
            if($this->db->execute())
                return TRUE;
            else
                return FALSE;
        }
        public function jaimepasPost($dt){
            $this->db->query('DELETE FROM `jaimex` WHERE user_id =:usr_id AND img_id =:img_id');
            $this->db->bind(':usr_id', $dt['usr_id']);
            $this->db->bind(':img_id', $dt['img_id']);
            if($this->db->execute())
                return TRUE;
            else
                return FALSE;
        }
        
        public function findByimgId($id){
            $this->db->query('SELECT * FROM img WHERE id_img = :id');
            $this->db->bind(':id', $id);
            
            $row = $this->db->single();
            if ($this->db->rowCount() > 0){
                return $row;
            }
            else
                return false;
        }
        public function nb_post($nb, $user){
            $this->db->query('UPDATE `login` SET `nb_post`=:nb WHERE `name`=:name');
            $this->db->bind(':nb', $nb);
            $this->db->bind(':name', $user);
            if ($this->db->execute())
                return TRUE;
            else
                return FALSE;
          
        }
    }
