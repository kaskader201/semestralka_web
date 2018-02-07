<?php
namespace Semestralka;
/**
 * Objekt Zboží
 * User: Jelin
 * Date: 22.12.2017
 * Time: 14:09
 */

class Goods
{
    private $id;
    private $code;
    private $name;
    private $price;
    private $stock;
    private $new;
    private $producer;
    private $goodsService;
    
    public function __construct()
    {
    
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
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @param mixed $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }
    
    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * @param mixed $producer
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;
    }
    
    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }
    
    
    
}