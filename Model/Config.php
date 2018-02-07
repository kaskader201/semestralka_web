<?php

Class Config
{
    private static $config = [
        'seo' => [
            'title'=>'Semestralni projekt',
            'keywords' => 'semstralni projekt, ČVUT, FEL',
            'description' =>'Stráka semestrálního projetku'
        ],
        'dbSetting' => [
            'dev' => [
                'login' => 'root',
                'password' => '',
                'dbName' => 'semestralka',
                'dbAddress' => 'localhost',
            ],
            'production' => [
                'login' => 'root',
                'password' => '',
                'dbName' => 'semestralka',
                'dbAddress' => 'localhost',
            ],
        
        ]
    ];
    public static function getFullConfig(){
        return self::$config;
    }
    public static function getDbSettingDevel(){
        return (object) self::$config['dbSetting']['dev'];
    }
    public static function getDbSettingProduction(){
        return self::$config['dbSetting']['production'];
    }
    public static function getSeo(){
        return (object) self::$config['seo'];
    }

}


