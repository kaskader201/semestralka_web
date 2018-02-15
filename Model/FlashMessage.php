<?php

namespace Semestralka {
    /**
     * Class FlashMessage
     * @package Semestralka
     */
    class FlashMessage
    {
        const SESSION_KEY = 'flashMessage';
        
        public static function add(Message $message)
        {
            $_SESSION[self::SESSION_KEY][] = serialize($message);
        }
        
        public static function exist(): bool
        {
            return (isset($_SESSION[self::SESSION_KEY]) && count($_SESSION[self::SESSION_KEY]) > 0 ? true : false);
        }
        
        public static function get(): array
        {
            $messages = [];
            foreach ($_SESSION[self::SESSION_KEY] as $key => $item) {
                $messages[] = unserialize($item, ['allowed_classes' => true]);
            }
            self::delete();
            return $messages;
        }
        
        
        private static function delete()
        {
            $_SESSION[self::SESSION_KEY] = [];
            unset($_SESSION[self::SESSION_KEY]);
        }
    }
}