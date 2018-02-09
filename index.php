<?php
//bezpečnostní prvky
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', true);
ini_set('session.name', 'ASPSESSIONID');
ini_set('expose_php', 'off');
session_start();

function autoload($file)
{
    if (preg_match('/Controller$/', $file) && file_exists("Controller/" . $file . ".php")) {
        require("Controller/" . $file . ".php");
    } elseif (preg_match('/$/', $file) && file_exists("Model/" . $file . ".php")) {
        require("Model/" . $file . ".php");
    } else {
        Logger::log()->error('nenalezen soubor: '.$file);
    }
}

spl_autoload_register("autoload");


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
require_once __DIR__ . '/vendor/autoload.php';

// Připojení k databázi

if ($_SERVER['SERVER_ADDR'] === '::1' || $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === 'localhost') {
    $dataForDb = Config::getDbSettingDevel();
    if(class_exists(Tracy\Debugger::DEBUG)) {
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

