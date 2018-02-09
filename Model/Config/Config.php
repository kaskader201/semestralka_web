<?php

Class Config implements iConfig
{
    private static $config = [
        'urlAdrress'=>[
            self::DEV => 'http://localhost/',
            self::PRODUCTION =>'http://wa.toad.cz/~jelinda6/'
        ],
        'seo' => [
            'title'=>'Semestralni projekt',
            'keywords' => 'semstralni projekt, ČVUT, FEL',
            'description' =>'Stráka semestrálního projetku'
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
    public static function getFullConfig(){
        return self::$config;
    }
    public static function getDbSettingDevel(){
        return (object) self::$config['dbSetting'][self::DEV];
    }
    public static function getDbSettingProduction(){
        return (object) self::$config['dbSetting'][self::PRODUCTION];
    }
    public static function getSeo(){
        return (object) self::$config['seo'];
    }

}


