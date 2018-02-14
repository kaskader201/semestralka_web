<?php

class LoginManager
{
    
    public static function loginProcess($email, $password)
    {
        $user = (new UserService())->getByEmail($email);
        if ($user !== false) {
            //user se nalezl
            if ($user->verifyPassword($password)) {
                SessionManager::setAfterLogin($user);
                return true;
                
            }
        }
        return false;
    }
    
}