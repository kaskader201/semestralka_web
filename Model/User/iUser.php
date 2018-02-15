<?php

namespace Semestralka {
    /**
     * Interface iUser
     * @package Semestralka
     */
    interface iUser
    {
        public function save();
        
        public function delete();
    }
}