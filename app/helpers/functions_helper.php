<?php 
        function send_mail($dt){
            $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
            $to = $dt['email_r'];
            $sujet = "NEW NOTIFICATION 'Camagru'";
            $message = '<h1><strong>Camagru</strong></h1>   Hello '.$dt['recipteur'].' You have a new notification from '.$dt['name_s'];
        if(mail($to, $sujet, $message, $headers))
                return TRUE;
            else
                return FALSE;
        }

        

         function creatUserSession($user){
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
    