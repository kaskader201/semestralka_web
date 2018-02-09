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
    protected $seoHeader = ['title' => '', 'keywords' => '', 'description' => ''];
    
    protected $additionallyJS = [];
    
    // provadí ošetření všech vstupních proměnných
    
    /**
     * @param null $item
     * @return array|null|string
     */
    /*private function escapeString($item = null)
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
        
    }*/
    
    /**
     * @param array $urlParameters
     * @return void
     */
    abstract public function controlProcess(array $urlParameters);
    
    public function renderView()
    {
        if (!$this->dontRender) {
            if ($this->view !== '') {
                $latte = new Latte\Engine;
                $latte->setTempDirectory('tmp/');
/*                extract($this->escapeString($this->renderData), EXTR_OVERWRITE);
                extract($this->renderData, EXTR_PREFIX_ALL, '');*/
                $latte->render(dirname(__DIR__).'/View/'.$this->view.'.latte', $this->renderData);
               // require 'View/' . $this->view . '.phtml';
            }
        }
    }
    
    //
    
    /**
     * Přesměruje na dané URL
     * @param string $url
     * @param int $code
     * @return void
     */
    public function redirect(string $url = '', int $code = 301)
    {
        header('Location: /' . $url, true, $code);
        header('Connection: close');
        exit;
    }
    
    /**
     * Přidá na konec požadované JS scripty
     * @param array $js
     * @return void
     */
    public function setAdditionallyJS(array $js)
    {
        foreach ($js as $item){
            $this->additionallyJS[] = $item;
        }
    }
    
    /**
     * @return array
     */
    public function getAdditionallyJS(): array
    {
        return $this->additionallyJS;
    }
}