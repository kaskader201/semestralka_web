<?php

class CSRF
{
    const INPUT_NAME = 'CSRFToken';
    
    private static function getSession()
    {
        return ($_SESSION['csrf']['tokens'] ?? null);
    }
    
    private static function setSession($akce, $token)
    {
        $_SESSION['csrf']['tokens'][$akce][] = $token;
    }

    
    private static function unSetSession($akce, $key)
    {
        unset($_SESSION['csrf']['tokens'][$akce][$key]);
    }
    
    public static function getCSRFHTMLInput($token)
    {
        return sprintf('<input type="hidden" name="%s" value="%s">', self::INPUT_NAME, $token);
    }
    
    /**
     * @param string $akce
     * @return array
     */
    public static function getTokens($akce = 'default')
    {
        $session = self::getSession();
        $token = array();
        if ($session !== null && !empty($session) && array_key_exists($akce, $session)) {
            $token = $session[$akce];
        }
        return $token;
    }
    
    public static function getNewToken($akce = 'default')
    {
        foreach (self::getTokens($akce) as $key => $item) {
            if ($item->getExpiration() <= (new DateTime())->format('d.m.Y H:m:s')) {
                self::unSetSession($akce, $key);
            }
        }
        $token = new CSRFToken($akce);
        self::setSession($akce, $token);
        return $token->getToken();
    }
    
    /**
     * @param $token
     * @param $akce
     * @return bool
     */
    public static function isTokenValid($token, $akce)
    {
        $tokens = self::getTokens($akce);
        foreach ($tokens as $key => $item) {
            if ($item->getToken() === $token && $item->getExpiration() >= (new DateTime())->format('d.m.Y H:m:s') && $item->getAction() === $akce) {
                self::unSetSession($akce, $key);
                return true;
            }
        }
        return false;
        
        
    }
    
    
}