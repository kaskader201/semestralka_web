<?php
/**
 * Class ProductService
 */

class ProductService
{
    /**
     * @var ProductDAO
     */
    protected $productDAO;
    
    public function __construct()
    {
        $this->productDAO= new ProductDAO();
    }
    
    /**
     * @param Product $product
     */
    public function delete(Product $product)
    {
        $this->productDAO->delete($product);
    }
    
    /**
     * @param Product $product
     * @return int|mixed
     */
    public function save(Product $product)
    {
        return $this->productDAO->save($product);
    }
    public function getAllProducts()
    {
        $products = [];
        $resultProduct= $this->productDAO->getAllProducts();
        foreach ($resultProduct as $dbProduct) {
            $product = $this->setProductData($dbProduct);
            $products[] = $product;
            
        }
        
        return $products;
    }
    private function setProductData(array $dbProduct)
    {
        return (new Product())
            ->setId($dbProduct['id'])
            ->setName($dbProduct['name'])
            ->setPrice($dbProduct['price']);
            
    }
}