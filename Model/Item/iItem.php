<?php

namespace Semestralka {
    /**
     * Interface iItem
     * @package Semestralka
     */
    interface iItem
    {
        public function save(Item $item);
        
        //   public function update();
        public function delete(Item $item);
    }
}