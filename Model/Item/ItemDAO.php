<?php

/**
 * Created by PhpStorm.
 * User: Jelin
 * Date: 22.12.2017
 * Time: 14:16
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