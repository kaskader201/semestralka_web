<?php

namespace Semestralka {
    /**
     * Class ProductDAO
     * @package Semestralka
     */
    class ProductDAO
    {
        
        public function delete(Product $product)
        {
            if ($product->getId() !== null) {
                $this->deleteById($product->getId());
            }
            return false;
            
        }
        
        public function deleteById(int $id)
        {
            return Db::query('DELETE FROM PRODUCTS WHERE id = ? ', array($id));
        }
        
        public function save(Product $product)
        {
            if ($product->getId() == null) {
                return $this->create($product);
            }
            return $this->update($product);
            
        }
        
        protected function update(Product $product)
        {
            $arrayProduct = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            
            ];
            return Db::update('PRODUCTS', $arrayProduct, ' WHERE id = ' . $product->getId());
        }
        
        /**
         * Vytvoří zboží
         * @param Product $product
         * @return int
         */
        protected function create(Product $product)
        {
            $arrayProduct = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
            return Db::insert('PRODUCTS', $arrayProduct);
        }
        
        /**
         * Vrat zbozi dle ID
         * @param int $productId
         * @return mixed
         */
        public function getById(int $productId)
        {
            return Db::queryOne('SELECT * FROM PRODUCTS WHERE id = ?', array($productId));
            
        }
        
        /**
         * Vrrcí zboží dle názvu
         * @param string $productName
         * @return mixed
         */
        public function getByName(string $productName)
        {
            return Db::queryOne('SELECT * FROM PRODUCTS WHERE name = ?', array($productName));
            
        }
        
        /**
         * Vrací všechno zboží
         * @return array
         */
        public function getAllProducts(): array
        {
            $result = Db::queryAll('SELECT * FROM PRODUCTS');
            if ($result) {
                return $result;
            }
            return [];
        }
        
    }
}