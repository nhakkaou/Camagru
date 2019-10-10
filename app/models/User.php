<?php 
    class User {
        private $db;
        public function __construct(){
            $this->db = new Database;
        }
        
        //find User by name
        public function findUserByName($name){
            $this->db->query('SELECT * FROM login WHERE name = :name');
            $this->db->bind(':name', $name);
            
            $row = $this->db->single();
            if ($this->db->rowCount() > 0){
                return $row;
            }
            else
                return false;
            
        }
        
        public function findUserById($id){
            $this->db->query('SELECT * FROM login WHERE id = :name');
            $this->db->bind(':name', $id);
            
            $row = $this->db->single();
            if ($this->db->rowCount() > 0){
                return $row;
            }
            else
                return false;
        }
        
        public function edit($data){
            try{
             $this->db->query('UPDATE `login` SET `name`=:name,`password`= :password,`email`=:email, `recieve`=:r WHERE id= :id');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['newpass']);
            $this->db->bind(':r', $data['recieve']);
            $this->db->bind(':id', $data['id']);
            if ($this->db->execute()){
                return true;
            }else{
                return false;
            }
            }catch (PDOException $e)
            {
                echo 'Error: ' . $e->getMessage() . '\n';
                die();
            }
        }
         public function findUserByEmail($email){
            $this->db->query('SELECT * FROM login WHERE email = :email');
            $this->db->bind(':email', $email);
            
            $row = $this->db->single();
            if ($this->db->rowCount() > 0){
                return $row;}
            else
                return false;
            }

        public function register($data){
            try{
            $this->db->query('INSERT INTO login (name, password, email, date, token) VALUES(:name, :password, :email, :date, :token)');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['pass']);
            $this->db->bind(':date', $data['date']);
            $this->db->bind(':token', $data['token']);
            if ($this->db->execute()){
                return true;
            }else{
                return false;
            }
            }catch (PDOException $e)
            {
                echo 'Error: ' . $e->getMessage() . '\n';
                die();
            }    
        }
        
        public function add_forget_tk($str, $mail){
            $this->db->query('UPDATE login SET forget_tk =:str where email=:mail');
            $this->db->bind(":str", $str);
            $this->db->bind(":mail", $mail);
            if($this->db->execute())
                return TRUE;
            return FALSE;
        }
        public function check_tk($str, $mail){
            $this->db->query('SELECT * from login WHERE forget_tk =:str AND email=:mail');
            $this->db->bind(":str", $str);
            $this->db->bind(":mail", $mail);
            if ($this->db->execute())
            {
                if($this->db->rowCount() > 0)
                    return TRUE;
            }
            return FALSE;
        }
        public function login($name, $password) {
            $this->db->query('SELECT * FROM login WHERE name = :name');
            $this->db->bind(':name', $name);
            $row = $this->db->single();
            $hash_pass = $row->password;  
            if (password_verify($password, $hash_pass))
            {
                return $row;
            }else
                return false;
        }
        public function changepic($data)
        {
            $this->db->query('UPDATE `login` SET `profilepic`=:pic WHERE id= :id');
             $this->db->bind(':id', $data['id']);
             $this->db->bind(':pic', $data['path']);
            if($this->db->execute())
                return TRUE;
            else
                return FALSE;
        }
        public function update_pass($data){
            $this->db->query('UPDATE `login` SET `password`=:password WHERE email= :email');
             $this->db->bind(':password', $data['new_mt']);
             $this->db->bind(':email', $data['email']);
            if($this->db->execute())
                return TRUE;
            else
                return FALSE;
        }
        public function putone($mail){
            $this->db->query('UPDATE login SET validate =1 where email=:mail');
            $this->db->bind(":mail", $mail);
            if ($this->db->execute())
                return TRUE;
            return FALSE;
        }
        
    }
    
?>