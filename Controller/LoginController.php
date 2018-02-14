<?php


class LoginController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        if(!SessionManager::isLogin()) {
            if (isset($_POST['email'], $_POST['password'])) {
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                //do login procces
                if (LoginManager::loginProcess($email, $password)) {
                    $this->redirect();
                } else{
                    //chyba vypsat
                }
            }
    
            $this->view = 'Login/index';
        } else {
            if($urlParameters[0] == 'out'){
                SessionManager::logOut();
                FlashMessage::add((new Message())->setHeader('Byl jste úspěšně odhlášen')->setText('Byl jste úspěšně odhlášen')->setType(Message::SUCCESS));
            }
            $this->redirect();
        }
    }
}