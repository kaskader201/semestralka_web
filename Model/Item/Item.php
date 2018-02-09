<?php

/**
 * Objekt Zboží
 * User: Jelin
 * Date: 22.12.2017
 * Time: 14:09
 */

class Item implements iItem
{
    private $id;
    private $code;
    private $name;
    private $price;
    private $stock;
    private $new;
    private $producer;
    /**
     * @var ItemService
     */
    private $itemService;
    
    public function __construct()
    {
        $this->itemService = new ItemService();
    }
    
    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return mixed
     */
    public function getNew()
    {
        return $this->new;
    }
    
    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * @return mixed
     */
    public function getProducer()
    {
        return $this->producer;
    }
    
    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }
    
    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @param $name
     * @return Item
     */
    public function setName($name) :Item
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @param bool $new
     * @return Item
     */
    public function setIsNew(bool $new) : Item
    {
        $this->new = $new;
        return $this;
    }
    

    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }
    

    public function setProducer($producer)
    {
        $this->producer = $producer;
        return $this;
    }
    
   
    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }
    
    public function delete()
    {
        $this->itemService->delete($this);
    }
    
    public function save()
    {
        $this->itemService->save($this);
    }
    
    
}