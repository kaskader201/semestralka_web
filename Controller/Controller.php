<?php


abstract class Controller
{
    //nasetovaná data pro render
    protected $renderData = array();
    //nasetováné View
    protected $view = '';
    //nemámá probehnout render ?
    public $dontRender = false;
    //seo
    protected $seoHeader = array('title' => '', 'keywords' => '', 'description' => '');
    
    // provadí ošetření všech vstupních proměnných
    private function escapeString($item = null)
    {
        if ($item === null) {
            return null;
        }
        
        if (is_string($item)) {
            return htmlspecialchars($item, ENT_QUOTES);
        }
        
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->escapeString($value);
            }
            return $item;
        }
        return $item;
        
    }
    
    abstract public function controlProcess($urlParameters);
    
    public function renderView()
    {
        if (!$this->dontRender) {
            if ($this->view !== '') {
                extract($this->escapeString($this->renderData), EXTR_OVERWRITE);
                extract($this->renderData, EXTR_PREFIX_ALL, '');
                require 'View/' . $this->view . '.phtml';
            }
        }
    }
    
    // Přesměruje na dané URL
    public function redirect($url = '', $code = 301)
    {
        header('Location: /' . $url, true, $code);
        header('Connection: close');
        exit;
    }
}