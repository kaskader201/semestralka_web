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
                $latte->setTempDirectory('temp/');
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