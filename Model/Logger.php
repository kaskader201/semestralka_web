<?php

namespace Semestralka {
    /**
     * Class Logger
     * @package Semestralka
     */
    class Logger
    {
        private static $logger;
        // nápověda
        const EMERGENCY = 'emergency';
        const ALERT = 'alert';
        const CRITICAL = 'critical';
        const ERROR = 'error';
        const WARNING = 'warning';
        const NOTICE = 'notice';
        const INFO = 'info';
        const DEBUG = 'debug';
        
        public static function log()
        {
            if (!isset(self::$logger) && !is_object(self::$logger)) {
                self::$logger = new \Katzgrau\KLogger\Logger('logs');
                if (($_SERVER['SERVER_ADDR'] == '::1' || $_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == 'localhost')) {
                    $level = self::DEBUG;
                } else {
                    $level = self::NOTICE;
                }
                self::$logger->setLogLevelThreshold($level);
            }
            return self::$logger;
            
        }
    }
}