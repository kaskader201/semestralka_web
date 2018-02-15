<?php

namespace Semestralka {
    /**
     * Class CSRFToken
     * @package Semestralka
     */
    class CSRFToken
    {
        public $token;
        public $expiration;
        public $action;
        
        public function __construct($action)
        {
            $this->setToken($this->generateRandomString(50));
            $this->setExpiration((new DateTime())->modify('+60 minutes')->format('d.m.Y H:m:s'));
            $this->setAction($action);
        }
        
        /**
         * @return mixed
         */
        public function getAction()
        {
            return $this->action;
        }
        
        /**
         * @return mixed
         */
        public function getExpiration()
        {
            return $this->expiration;
        }
        
        /**
         * @return mixed
         */
        public function getToken()
        {
            return $this->token;
        }
        
        /**
         * @param mixed $expiration
         */
        public function setExpiration($expiration)
        {
            $this->expiration = $expiration;
        }
        
        /**
         * @param mixed $token
         */
        public function setToken($token)
        {
            $this->token = $token;
        }
        
        public function generateRandomString($length = 50)
        {
            if (function_exists('random_bytes')) {
                return substr(bin2hex(random_bytes($length)), 1, $length);
            } elseif (function_exists('openssl_random_pseudo_bytes')) {
                return substr(bin2hex(openssl_random_pseudo_bytes($length)), 1, $length);
            }
        }
        
        /**
         * @param mixed $action
         */
        public function setAction($action)
        {
            $this->action = $action;
        }
    }
}