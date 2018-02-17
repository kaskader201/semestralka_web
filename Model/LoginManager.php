<?php

/**
 * Class LoginManager
 * Stará se proces přihlášení a možných variant
 */
class LoginManager
{
    
    public static function loginProcess($email, $password)
    {
        $user = (new UserService())->getByEmail($email);
        $message = (new Message())->setHeader('Přihlášení se nezdařilo')->setType(Message::DANGER);
        if ($user !== false) {
            //user se nalezl
            if ($user->isVerified()) {
                if ($user->isActive()) {
                    if ($user->verifyPassword($password)) {
                        $user->setToken(uniqid('x', true));
                        $user->save();
                        SessionManager::setAfterLogin($user);
                        Logger::log()->notice(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] ." Úspěšně se prihlásil na email: ".$email);
                        return true;
                        
                    }
                    $message->setText('Bylo zadáno špatné uživatelské jmeno nebo heslo.');
                    Logger::log()->notice(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] ." Neúspěšně se chce prihlásil na email: ".$email);
                    
                } else {
                    $message->setText('Bohužel nemáte aktivní účet.');
                    Logger::log()->notice(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] ." Neaktivní účet email: ".$email);
                }
            } else {
                $message->setText('Bohužel vaše emailová adresa nebyla doposud ověřena. Zkuste to prosím později.');
                Logger::log()->notice(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] ." Neověřený účet email: ".$email);
            }
        }
        FlashMessage::add($message);
        return false;
    }
    
}