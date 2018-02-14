<?php

class LoginManager
{
    private $name;
    private $password;
    
    public static function loginProcess($email, $password)
    {
        $user = (new UserService())->getByEmail($email);
        if ($user !== false) {
            //user se nalezl
            if ($user->verifyPassword($password)) {
                return true;
                
                
            }
        }
        return false;
    }
    
}