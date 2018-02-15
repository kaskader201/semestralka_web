<?php
namespace Semestralka {
    /**
     * Class MenuManager
     * @package Semestralka
     */
    class MenuManager
    {
        /**
         * Převede data z DB na stromovou strukturu
         * @param $items
         * @param $parentId
         * @return array
         */
        private function formatTree($items, $parentId)
        {
            // Vytvoříme prázdný strom
            $tree = array();
            // Pokusíme se najít položky, které patří do rodičovské kategorie ($parentId)
            foreach ($items as $item) {
                if ($item['parent_menu_id'] == $parentId) {
                    // Položku přidáme do nového stromu
                    $tree[$item['id']] = $item;
                    // A rekurzivně přidáme strom podpoložek
                    $tree[$item['id']]['subcategories'] = $this->formatTree($items, $item['id']);
                }
            }
            return $tree; // Vrátíme hotový strom
        }
        
        /**
         * Vrátí kategorie produktů v podobě stromu
         * @return array Kategorie produktů v podobě stromu
         */
        public function getMenuItems()
        {
            $categories = Db::queryAll('SELECT * FROM MENU WHERE visible = 1 ORDER BY parent_menu_id, order_no, text');
            return $this->formatTree($categories, null);
        }
        
        public function renderMenu($categories, $parentUrl = '', $isMainCategory = true)
        {
            $menu = "";
            if (!$isMainCategory) {
                $menu = '<ul class="nav flex-column">';
                if($parentUrl == '') {
                    $menu .= ' <li class="nav-item"><a href="" class="nav-link text-white"><h2><span class="fa fa-home"></span> Navigace</h2></a></li>';
                }
            }
            
            
            foreach ($categories as $index => $category) {
                
                if (Permissions::checkPermission($category['min_permisssion'], SessionManager::getUserPermisson())) {
                    $url = ($parentUrl === '' ? $category['url'] : $parentUrl . '/' . $category['url']);
                    
                    if ($category['subcategories']) {
                        $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '"><h3 class="text-white">' . $category['text'] . '</h3></a></li>'.PHP_EOL;
                        $menu .= $this->renderMenu($category['subcategories'], $url, true);
                        // $menu .= '</li>'.PHP_EOL;
                    } else {
                        if (count($category['parent_menu_id']) == null) {
                            if ($url == 'login' && SessionManager::isLogin()) {
                                $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '/out"><h3 class="text-white">Logout</h3></a></li>'.PHP_EOL;
                            } else {
                                $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '"><h3 class="text-white">' . $category['text'] . '</h3></a></li>'.PHP_EOL;
                            }
                        } else {
                            $menu .= '<li class="nav-item pl-2"><a href="' . $url . '" class="nav-link text-white" data-path="' . $url . '">' . $category['text'] . '</a></li>'.PHP_EOL;
                            
                        }
                        
                    }
                }
            }
            if (!$isMainCategory) {
                $menu .= '</ul>';
            }
            return $menu;
        }
        
        
    }
}