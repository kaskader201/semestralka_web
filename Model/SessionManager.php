<?php

/**
 * Stará se o komunikaci se Session
 * Class SessionManager
 */
class SessionManager
{
    const USER = 'user';
    const USER_ID_NAME = 'own_user_id';
    const  PERMISSON = 'permission';
    
    /**
     * Vrat User ID
     * @return int
     */
    
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
    
    /**
     * Setuje user ID
     * @param int $id
     */
    public static function setUserId(int $id)
    {
        $_SESSION[self::USER][self::USER_ID_NAME] = $id;
        
    }
    
    /**
     * Smaž uložené User ID
     */
    public static function destroyUserId()
    {
        unset($_SESSION[self::USER][self::USER_ID_NAME]);
    }
    
    /**
     * Je uživatel přihlášen
     * @return bool
     */
    public static function isLogin(): bool
    {
        return (isset($_SESSION[self::USER]['login']) ?? false);
    }
    
    /**
     * Smaž data o uživately
     */
    public static function logOut()
    {
        unset($_SESSION[self::USER]);
    }
    
    /**
     * Setování dat po přihlášení
     * @param User $user
     */
    public static function setAfterLogin(User $user)
    {
        $_SESSION[self::USER]['login'] = true;
        
        $_SESSION[self::USER]['name'] = (string) $user->getFirstname() . ' ' . $user->getLastname();
        $_SESSION[self::USER]['email'] = $user->getEmail();
        self::setUserId($user->getId());
        $_SESSION[self::USER][self::PERMISSON] = Permissions::getPermission($user->getPermission());
    }
    
    /**
     * Vrací jmeno přihlášeneho uživatele nebo prázdný řetězec
     * @return string
     */
    public static function getUserName(): string
    {
        return (isset($_SESSION[self::USER]['name']) ? $_SESSION[self::USER]['name'] : '');
    }
    
    /**
     * Vrací email přihlášeného uživatele nebo prázdný řetezec
     * @return string
     */
    public static function getUserEmail(): string
    {
        return (isset($_SESSION[self::USER]['email']) ? $_SESSION[self::USER]['email'] : '');
    }
    
    /**
     * Setuje data při chybně vyplněném formuláři
     * @param string $element
     * @param string $data
     */
    public static function setErrorForm(string $element, string $data = '')
    {
        $_SESSION['form']['error'][$element] = ['value' => $data];
    }
    
    /**
     * vrátí všechny data chybně vyplněného formuláře a smaže je ze Session
     * @return array | false
     */
    public static function getAllErrorForm()
    {
        $data = ($_SESSION['form']['error'] ? $_SESSION['form']['error'] : false);
        unset($_SESSION['form']['error']);
        return $data;
    }
    
    /**
     * Smaže data o formuláři ze session
     */
    public static function deleteErrorForm()
    {
        unset($_SESSION['form']['error']);
    }
    
    /**
     * Vrátí value emlementu v chybně  odeslaném formuláři
     * @param $element
     * @return null|string
     */
    public static function getErrorFormValue($element)
    {
        if (isset($_SESSION['form']['error'][$element])) {
            $data = (string) $_SESSION['form']['error'][$element]['value'];
            unset($_SESSION['form']['error'][$element]);
        } else {
            $data = null;
        }
        
        return $data;
    }
    
}