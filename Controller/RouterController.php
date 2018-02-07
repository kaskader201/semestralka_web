<?php


class RouterController extends Controller
{
    protected $instanceOfController;
    
    private function doCamelCase(string $text): string
    {
        $veta = str_replace('-', ' ', $text);
        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);
        return $veta;
    }
    
    // Naparsuje URL adresu podle lomítek a vrátí pole parametrů
    private function parsingURL(string $url): array
    {
        // Naparsuje jednotlivé části URL do pole
        $url = parse_url($url);
        // Odstranění počátečního lomítka
        $url['path'] = ltrim($url['path'], '/');
        // Odstranění bílých znaků kolem adresy
        $url['path'] = trim($url['path']);
        
        return explode('/', $url['path']);
    }
    
    public function controlProcess(array $urlParameters)
    {
        $url = $this->parsingURL($urlParameters[0]);
        if (empty($url[0])) {
            $url = ['index'];
        }
        $controller = $this->doCamelCase(array_shift($url)) . 'Controller';
        
        // kontroler je 1. parametr URL
        if (file_exists('Controller/' . $controller . '.php')) {
            $this->instanceOfController = new $controller;
        } else {
            Logger::log()->warning(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] . ' nenašel kontroler: ' . $controller);
            $this->redirect('error-404');
        }
        
        // Volání controlleru
        $this->instanceOfController->controlProcess($url);
        $this->renderData['baseURL'] = 'http://localhost/';
        $this->renderData['additionalyJs'] = $this->instanceOfController->getAdditionallyJS();
        $this->renderData['title'] = (!empty($this->instanceOfController->seoHeader['title']) ? $this->instanceOfController->seoHeader['title'] : Config::getSeo()->title);
        $this->renderData['keywords'] = (!empty($this->instanceOfController->seoHeader['keywords']) ? $this->instanceOfController->seoHeader['keywords'] : Config::getSeo()->keywords);
        $this->renderData['description'] = (!empty($this->instanceOfController->seoHeader['description']) ? $this->instanceOfController->seoHeader['description'] : Config::getSeo()->description);
        $this->view = 'layout';
    }
}