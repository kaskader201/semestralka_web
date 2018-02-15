<?php
namespace Semestralka {
    /**
     * Stará se Login
     * Class LoginController
     * @package Semestralka
     */
    class LoginController extends Controller
    {
        const LOGIN = 'login';
        
        /**
         * Funkce která se zavolá poté co se načte tato třída v podstatě
         * @param array $urlParameters
         */
        public function controlProcess(array $urlParameters)
        {
            if (!SessionManager::isLogin()) {
                //pokud není přihlášen a zkusí se odhlásit bude přesměrován na login
                if (isset($urlParameters[0]) && strtolower($urlParameters[0]) == 'out'){
                    $this->redirect('login');
                }
                
                if (isset($_POST[CSRF::INPUT_NAME]) && CSRF::isTokenValid($_POST[CSRF::INPUT_NAME], self::LOGIN)) {
                    if (isset($_POST['email'], $_POST['password'])) {
                        $email = trim($_POST['email']);
                        $password = $_POST['password'];
                        //do login procces
                        if (LoginManager::loginProcess($email, $password)) {
                            $this->redirect();
                        }
                    }
                } else {
                    //pokud není token nebo nesedí
                    Logger::log()->warning(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] .' nemá platný CSRF TOKEN');
                    
                    //   FlashMessage::add((new Message())->setHeader('Přihlášení se nezdařilo')->setText('Zkuste to prosím znovu. Chyba ochraného prvku')->setType(Message::WARNING));
                }
                $this->renderData['CSRF_input_name'] = CSRF::INPUT_NAME;
                $this->renderData['CSRF_token'] = CSRF::getNewToken(self::LOGIN);
                $this->view = 'Login/index';
            } else {
                if ($urlParameters[0] == 'out' && SessionManager::isLogin()) {
                    SessionManager::logOut();
                    FlashMessage::add((new Message())->setHeader('Byl jste úspěšně odhlášen')->setText('Byl jste úspěšně odhlášen')->setType(Message::SUCCESS));
                }
                $this->redirect();
            }
        }
    }
}