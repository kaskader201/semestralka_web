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
                        return true;
                        
                    }
                    $message->setText('Bylo zadáno špatné uživatelské jmeno nebo heslo.');
                    
                } else {
                    $message->setText('Bohužel nemáte aktivní účet.');
                }
            } else {
                $message->setText('Bohužel vaše emailová adresa nebyla doposud ověřena. Zkuste to prosím později.');
            }
        }
        FlashMessage::add($message);
        return false;
    }
    
}