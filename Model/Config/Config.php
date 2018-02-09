<?php

Class Config implements iConfig
{
    private static $config = [
        'urlAdrress' => [
            self::DEV => 'http://localhost/',
            self::PRODUCTION => 'http://wa.toad.cz/~jelinda6/'
        ],
        'seo' => [
            'title' => 'Semestralni projekt',
            'keywords' => 'semstralni projekt, ČVUT, FEL',
            'description' => 'Stráka semestrálního projetku'
        ],
        'dbSetting' => [
            self::DEV => [
                'login' => 'root',
                'password' => '',
                'dbName' => 'semestralka',
                'dbAddress' => 'localhost',
            ],
            self::PRODUCTION => [
                'login' => 'jelinda6',
                'password' => 'webove aplikace',
                'dbName' => 'jelinda6',
                'dbAddress' => 'localhost',
            ],
        
        ]
    ];
    
    public static function getFullConfig()
    {
        return self::$config;
    }
    
    public static function getDbSettingDevel()
    {
        return (object) self::$config['dbSetting'][self::DEV];
    }
    
    public static function getDbSettingProduction()
    {
        return (object) self::$config['dbSetting'][self::PRODUCTION];
    }
    
    public static function getSeo()
    {
        return (object) self::$config['seo'];
    }
    
    public static function getBaseUrl()
    {
        if ($_SERVER['SERVER_ADDR'] === '::1' || $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === 'localhost') {
            if ((int) $_SERVER['SERVER_PORT'] === 80) {
                return self::$config['urlAdrress'][self::DEV];
            }
            return sprintf('http://localhost:%s/', $_SERVER['SERVER_PORT']);
            
        }
        return self::$config['urlAdrress'][self::PRODUCTION];
    }
    
}


