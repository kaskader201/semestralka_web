<?php

class SessionManager
{   const USER = 'user';
    const USER_ID_NAME = 'own_user_id';
    const IS_ADMIN_NAME = 'own_user_id';

    
    public static function getUserId()
    {
        if (isset($_SESSION[self::USER_ID_NAME]) && $_SESSION[self::USER_ID_NAME] != null) {
            $result = (int) $_SESSION[self::USER_ID_NAME];
        } else {
            if (!isset($_SESSION['token'])) {
                (new Autorizace())->createSession();
            }
            $result = $_SESSION['token'];
        }
        return $result;
    }
    
    public static function setUserId($id)
    {
        $id = (int) $id;
        $_SESSION[self::USER_ID_NAME] = $id;
        
    }
    public static function destroyUserId(){
        unset($_SESSION[self::USER_ID_NAME]);
    }
    
    public static function isAdmin(){
        return (bool)$_SESSION['admin'];
    }
    public static function isLogin(){
        return (bool)$_SESSION['login'];
    }

    
    
}