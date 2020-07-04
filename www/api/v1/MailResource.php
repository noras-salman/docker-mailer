<?php
require_once(__DIR__."/../restful/Resource.php");
class MailResource extends Resource{

    public function get(){

        

    }

 
    public function post(){
        if($_GET["token"]!==TOKEN){
            error(401);
        }
        required($_POST['email']);
        required($_POST['title']);
        required($_POST['template']);

        $options=(array) $_POST['options'];
       $status= Mailer::sendEmail($_POST['email'], 
        $_POST['title'], 
        Template::render($_POST['template'],
        $options,
        true));

        if($status===true){
            finish(201);
        }else{
            error(400,$status);
        }
    }

    public function put() {
        global $_PUT;

    }

    public function delete() {
        global $_DELETE;
    
    }
}
?>