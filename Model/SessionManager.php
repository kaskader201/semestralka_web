<?php

class SessionManager
{   const USER = 'user';
    const USER_ID_NAME = 'own_user_id';
    const  PERMISSON = 'permission';

    
    public static function getUserId()
    {
        if (isset($_SESSION[self::USER_ID_NAME]) && $_SESSION[self::USER_ID_NAME] != null) {
            $result = (int) $_SESSION[self::USER_ID_NAME];
        } else {
            if (!isset($_SESSION['token'])) {
                
            }
            $result = $_SESSION['token'];
        }
        return $result;
    }
    public static function getUserPermisson(){
        return ($_SESSION[self::USER][self::PERMISSON] ?? 1);
    }
    public static function setUserId($id)
    {
        $id = (int) $id;
        $_SESSION[self::USER_ID_NAME] = $id;
        
    }
    public static function destroyUserId(){
        unset($_SESSION[self::USER_ID_NAME]);
    }
    
    public static function isLogin(){
        return (bool)$_SESSION['login'];
    }

    
    
}