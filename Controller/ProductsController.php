<?php
/**
 * Created by PhpStorm.
 * User: expan
 * Date: 11.02.2018
 * Time: 23:57
 */

class ProductsController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        $this->setAdditionallyJS(['dataTable/jquery.dataTable.js','dataTable/dataTables.rowReorder.min.js','dataTable/dataTables.responsive.min.js','dataTable/dataTable.js', 'users.js']);
        $this->setAdditionallyCSS(['dataTable/jquery.dataTables.min.css','dataTable/responsive.dataTables.min.css','dataTable/rowReorder.dataTables.min.css', 'jquery-confirm.css']);
        
        switch (count($urlParameters)) {
            case 0:
                $this->showProducts();
                break;
            case 1:
                if ($urlParameters[0] === 'new') {
                    $this->showNewProduct();
                } else {
                    $this->redirect('product');
                }
                break;
            case 2:
                if(is_numeric($urlParameters[1]) && $urlParameters[0] === "delete"){
                    $this->deleteProduct($urlParameters[1]);
                } elseif (is_numeric($urlParameters[1]) && $urlParameters[0] === "edit"){
                    $this->editProduct($urlParameters[1]);
                } else{
                    $this->redirect('product');
                }
                break;
            default:
                $this->redirect('product');
        }

        
    }
    
    private function showProducts()
    {
        $this->view = 'Product/index';
    }
    
    private function showNewProduct()
    {
        $this->view = 'Product/new';
    }
    private function editProduct(int $idProduct){
        $this->view = 'Product/change';
    }
    private function deleteProduct(int $idProduct){
        $this->view = 'Product/delete';
    }
}