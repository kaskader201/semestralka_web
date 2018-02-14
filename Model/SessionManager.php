<?php

class SessionManager
{
    const USER = 'user';
    const USER_ID_NAME = 'own_user_id';
    const  PERMISSON = 'permission';
    
    
    public static function getUserId()
    {
        if (isset($_SESSION[self::USER][self::USER_ID_NAME]) && $_SESSION[self::USER][self::USER_ID_NAME] != null) {
            $result = (int) $_SESSION[self::USER][self::USER_ID_NAME];
        } else {
            if (!isset($_SESSION[self::USER]['token'])) {
                
            }
            $result = $_SESSION[self::USER]['token'];
        }
        return $result;
    }
    
    public static function getUserPermisson()
    {
        return ($_SESSION[self::USER][self::PERMISSON] ?? 1);
    }
    
    public static function setUserId($id)
    {
        $id = (int) $id;
        $_SESSION[self::USER][self::USER_ID_NAME] = $id;
        
    }
    
    public static function destroyUserId()
    {
        unset($_SESSION[self::USER][self::USER_ID_NAME]);
    }
    
    public static function isLogin()
    {
        return (bool)(isset($_SESSION[self::USER]['login']) ?? false);
    }
    
    public static function setAfterLogin(User $user)
    {
        $_SESSION[self::USER]['login'] = true;
        $_SESSION[self::USER]['name'] = $user;
        $_SESSION[self::USER][self::PERMISSON] = Permissions::getPermission($user->getPermission());
    }
    
    /**
     * Vrací jmeno přihlášeneho uživatele nebo prázdný řetězec
     * @return string
     */
    public static function getUserName() :string
    {
        return (isset($_SESSION[self::USER]['name']) ?? '');
    }
    
    
}