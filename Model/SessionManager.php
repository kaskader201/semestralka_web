<?php

class SessionManager
{
    const USER = 'user';
    const USER_ID_NAME = 'own_user_id';
    const  PERMISSON = 'permission';
    
    
    public static function getUserId(): int
    {
        
        return (int) $_SESSION[self::USER][self::USER_ID_NAME];
        
    }
    
    /**
     * Vrací práva uživatele
     * @return int
     */
    public static function getUserPermisson(): int
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
    
    public static function isLogin(): bool
    {
        return (isset($_SESSION[self::USER]['login']) ?? false);
    }
    
    public static function logOut()
    {
        unset($_SESSION[self::USER]);
    }
    
    public static function setAfterLogin(User $user)
    {
        $_SESSION[self::USER]['login'] = true;
        $_SESSION[self::USER]['name'] = $user;
        self::setUserId($user->getId());
        $_SESSION[self::USER][self::PERMISSON] = Permissions::getPermission($user->getPermission());
    }
    
    /**
     * Vrací jmeno přihlášeneho uživatele nebo prázdný řetězec
     * @return string
     */
    public static function getUserName(): string
    {
        return (isset($_SESSION[self::USER]['name']) ?? '');
    }
    
    public static function setErrorForm($element, $data = '')
    {
        $_SESSION['form']['error'][$element] = ['value' => $data];
    }
    
    public static function getAllErrorForm()
    {
        $data = ($_SESSION['form']['error'] ?? false);
        unset($_SESSION['form']['error']);
        return $data;
    }
    
    public static function getErrorFormValue($element)
    {
        if (isset($_SESSION['form']['error'][$element])) {
            $data = $_SESSION['form']['error'][$element]['value'];
            unset($_SESSION['form']['error'][$element]);
        } else {
            $data = null;
        }
        
        
        return $data;
    }
    
}