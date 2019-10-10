<?php 

class config{
    public function __construct(){
        //echo "here";
    }
    public function setup(){
        require_once(APPROOT."/config/setup.php");
    }
}