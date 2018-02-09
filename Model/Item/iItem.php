<?php
/**
 * Created by PhpStorm.
 * User: Jelin
 * Date: 09.02.2018
 * Time: 15:26
 */
interface iItem{
    public function save(Item $item);
 //   public function update();
    public function delete(Item $item);
}