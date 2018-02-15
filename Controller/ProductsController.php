<?php
namespace Semestralka {
    /**
     * Stará se ostránku s produkty
     * Class ProductsController
     * @package Semestralka
     */
    class ProductsController extends Controller
    {
        const SAVE_NEW = 'saveNewProduct';
        /**
         * @var ProductService
         */
        protected $productService;
        
        public function __construct()
        {
            $this->productService = new ProductService();
        }
        
        public function controlProcess(array $urlParameters)
        {
            $this->setAdditionallyJS(['dataTable/jquery.dataTable.js', 'dataTable/dataTables.rowReorder.min.js', 'dataTable/dataTables.responsive.min.js', 'dataTable/dataTable.js', 'products.js']);
            $this->setAdditionallyCSS(['dataTable/jquery.dataTables.min.css', 'dataTable/responsive.dataTables.min.css', 'dataTable/rowReorder.dataTables.min.css', 'jquery-confirm.css']);
            //ochrana protí menším prácum než editor
            if (count($urlParameters) > 0 && !Permissions::checkPermission(Permissions::getPermission(3), SessionManager::getUserPermisson())) {
                FlashMessage::add((new Message())->setHeader('Nemáte oprávnění na tuto akci.')->setText('Bohužel na tuto akci nemáte oprávnění')->setType(Message::DANGER));
                Logger::log()->warning(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] . ' se snaži o nepovolenou akci:  ' . print_r($urlParameters, true) . ' a jeho opravneni je: ' . SessionManager::getUserPermisson());
                $this->redirect('products');
            }
            switch (count($urlParameters)) {
                case 0:
                    $this->showProducts();
                    break;
                case 1:
                    if ($urlParameters[0] === 'new') {
                        $this->showNewProduct();
                    } else {
                        $this->redirect('products');
                    }
                    break;
                case 2:
                    if (is_numeric($urlParameters[1]) && $urlParameters[0] === 'delete') {
                        $this->deleteProduct($urlParameters[1]);
                    } elseif (is_numeric($urlParameters[1]) && $urlParameters[0] === 'edit') {
                        $this->editProduct($urlParameters[1]);
                    } elseif ($urlParameters[1] === 'new' && $urlParameters[0] === 'save') {
                        if (isset($_POST[CSRF::INPUT_NAME]) && CSRF::isTokenValid($_POST[CSRF::INPUT_NAME], self::SAVE_NEW)) {
                            $this->saveNewProduct($_POST);
                        } else {
                            $this->redirect('products');
                        }
                        
                    } else {
                        $this->redirect('products');
                    }
                    break;
                default:
                    $this->redirect('products');
            }
            
            
        }
        
        private function showProducts()
        {
            $this->renderData['products'] = $this->productService->getAllProducts();
            $this->view = 'Product/index';
        }
        
        private function showNewProduct()
        {
            $this->renderData['CSRF_token'] = CSRF::getNewToken(self::SAVE_NEW);
            $this->renderData['CSRF_input_name'] = CSRF::INPUT_NAME;
            $this->view = 'Product/new';
        }
        
        private function saveNewProduct(array $data)
        {
            unset($data[CSRF::INPUT_NAME]);
            if (!$this->validData($data, 'new')) {
                $this->redirect('products/new');
            }
            
            $product = new Product();
            $product->setPrice($data['price'])->setName($data['name']);
            if ($product->save()) {
                FlashMessage::add((new Message())->setHeader('Úspěšně byl vytvořen nový produkt')->setText('Byl vytvořen produkt.')->setType(Message::SUCCESS));
            } else {
                FlashMessage::add((new Message())->setHeader('Chyba pri vytváření produktu')->setText('Došlo k chybě, bohužel nedošlo k vytvoření produktu')->setType(Message::DANGER));
            }
            $this->redirect('products');
        }
        
        private function editProduct(int $idProduct)
        {
            $this->view = 'Product/change';
        }
        
        private function deleteProduct(int $idProduct)
        {
            $this->view = 'Product/delete';
        }
        
        private function validData(&$data)
        {
            $req = ['name', 'price'];
            $valid = true;
            foreach ($req as $key) {
                if (!isset($data[$key])) {
                    $valid = false;
                } elseif (empty($data[$key])) {
                    $valid = false;
                } else {
                    if (strtolower($key) == $req[1] && (!is_numeric($data[$key]) || (float) ($data[$key]) > 999.99 || (float) ($data[$key]) < 0)) {
                        $valid = false;
                    } else {
                        SessionManager::setErrorForm($key, $data[$key]);
                        if (strtolower($key) == $req[1]) {
                            $data[$key] = (float) $data[$key];
                        }
                        $data[$key] = htmlspecialchars(trim($data[$key]));
                    }
                    
                }
            }
            if (!$valid) {
                return false;
            }
            
            return true;
            
        }
    }
}