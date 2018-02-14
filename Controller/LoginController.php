<?php


class LoginController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        
        if(isset($_POST['email'],$_POST['password'])){
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            //do login procces
            if(LoginManager::loginProcess($email,$password)){
            die('jo');
            }
        }

        $this->view = 'Login/index';
    }
}