<?php

/**
 * Class Product
 * Reprezentace Produktu
 */
class Product
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $price;
    /**
     * @var ProductService
     */
    protected $productService;
    
    public function __construct()
    {
        $this->productService = new ProductService();
    }
    
    
    public function delete()
    {
        $product = $this;
        $this->productService->delete($product);
    }
    
    /**
     * @return int
     */
    public function save()
    {
        $product = $this;
        return $this->productService->save($product);
    }
    
    /** Retur name of Product
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }
    
    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->name;
    }
    
    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return float
     */
    public function getPrice(): float
    {
        return (float) $this->price;
    }
    
    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }
    
}