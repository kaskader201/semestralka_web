<?php

namespace Semestralka {
    /**
     * Class ItemDAO
     * @package Semestralka
     */
    class ItemDAO implements iItem
    {
        public function delete(Item $item)
        {
            // TODO: Implement delete() method.
        }
        
        public function save(Item $item)
        {
            if ($item->getId() === null) {
                $this->create($item);
            } else {
                $this->update($item);
            }
        }
        
        protected function update(Item $item)
        {
        
        }
        
        protected function create(Item $item)
        {
            
            //  Db::insert('')
        }
    }
}