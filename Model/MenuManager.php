<?php

class MenuManager
{
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
        $categories = Db::queryAll('SELECT * FROM MENU ORDER BY parent_menu_id, order_no, text');
        return $this->formatTree($categories, null);
    }
    
    public function renderMenu($categories, $parentUrl = '', $isMainCategory = true)
    {
        $menu = "";
        if (!$isMainCategory) {
            $menu = '<ul class="nav flex-column">';
            $menu .= ' <li class="nav-item"><a href="" class="nav-link text-white"><span class="fa fa-home"></span>
                        Navigace</a></li>';
        }
        
        
        foreach ($categories as $index => $category) {
            $url = ($parentUrl === '' ? $category['url'] : $parentUrl . '/' . $category['url']);
            if ($category['subcategories']) {
                $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '"><h5 class="text-white">' . $category['text'] . '</h5></a>';
                $menu .= $this->renderMenu($category['subcategories'], $url, true);
                $menu .= '</li>';
            } else {
                if (count($category['parent_menu_id']) == null) {
                    $menu .= '<li class="nav-item"><a class="nav-link" href="' . $url . '"><h5 class="text-white">' . $category['text'] . '</h5></a>';
                    
                } else {
                    $menu .= '<li class="nav-item pl-2"><a href="' . $url . '" class="nav-link" data-path="' . $url . '">' . $category['text'] . '</a></li>';
                }
                
            }
            
        }
        if (!$isMainCategory) {
            $menu .= '</ul>';
        }
        return $menu;
    }
    
    
}