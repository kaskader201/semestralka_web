<?php

namespace Semestralka {
//bezpečnostní prvky
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', true);
    ini_set('session.name', 'ASPSESSIONID');
    ini_set('expose_php', 'off');
    
    if (!file_exists('temp') && !mkdir('temp', 0777, true) && !is_dir('temp')) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', 'temp'));
    }
    
    require_once __DIR__ . '/vendor/autoload.php';
    
    if (class_exists(\Nette\Loaders\RobotLoader::class)) {
        $loader = new \Nette\Loaders\RobotLoader;

// Add directories for RobotLoader to index
        $loader->addDirectory(__DIR__ . '/Controller');
        $loader->addDirectory(__DIR__ . '/Model');

// And set caching to the 'temp' directory
        $loader->setTempDirectory(__DIR__ . '/temp');
        $loader->register(); // Run the RobotLoader
    } else {
        throw new Exception('Need RobotLoader do Composer update');
    }
    session_start();
//treba dat do httpd.conf nebo apache.conf :
    ini_set('TraceEnable', 'off');
    ini_set('ServerSignature', 'off');
    ini_set('ServerTokens', 'Prod');
    
    header_remove('X-Powered-By');//pokud je expose_php On
    header("Strict-Transport-Security:max-age=63072000");
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');


// Nastavení interního kódování pro funkce pro práci s řetězci
    mb_internal_encoding("UTF-8");
//setlocale(LC_ALL,'czech');
    setlocale(LC_ALL, "cs_CZ.UTF-8");
    
    date_default_timezone_set('Europe/Prague');


// Připojení k databázi
    
    if ($_SERVER['SERVER_ADDR'] === '::1' || $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === 'localhost') {
        $dataForDb = Config::getDbSettingDevel();
        if (class_exists(Tracy\Debugger::class)) {
            Tracy\Debugger::enable();
            Tracy\Debugger::$strictMode = true;
        }
    } else {
        $dataForDb = Config::getDbSettingProduction();
    }
    
    Db::connect($dataForDb->dbAddress, $dataForDb->login, $dataForDb->password, $dataForDb->dbName);


//route
    $router = new RouterController();
    $router->controlProcess(array($_SERVER['REQUEST_URI']));

// Vyrenderování šablony
    $router->renderView();
}

