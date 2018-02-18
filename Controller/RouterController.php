<?php
/**
 * Class RouterController
 * Základní routing a setování dat do šablon
 */

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
        
        $result = explode('/', $url['path']);

        return $result;
    }
    
    public function controlProcess(array $urlParameters)
    {
        $url = $this->parsingURL($urlParameters[0]);
        if (empty($url[0])) {
            $url = ['index'];
        }
        $urlOld = $url[0];
        $urlCamle = $this->doCamelCase(array_shift($url));

        $controller = $urlCamle . 'Controller';
        
        // kontroler je 1. parametr URL
        if (file_exists('Controller/' . $controller . '.php')) {
            //ověřuje jetli má uživatel práva na zobrazení dané kategorie
            if (!Permissions::checkPermission(Permissions::getPermissionForCategory($urlOld), SessionManager::getUserPermisson())) {
                FlashMessage::add((new Message())->setHeader('Nemáte oprávnění na tuto akci.')->setText('Bohužel na tuto akci nemáte oprávnění')->setType(Message::DANGER));
                Logger::log()->warning(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] . ' se snaži o nepovolenou akci:  ' . $urlOld . ' a jeho opravneni je: ' . SessionManager::getUserPermisson());
                $this->redirect('index');
            }
            $this->instanceOfController = new $controller;
        } else {
            Logger::log()->warning(__METHOD__ . ' IP:' . $_SERVER['REMOTE_ADDR'] . ' nenašel kontroler: ' . $controller);
            $this->redirect('error-404');
        }

    
        // Volání vykonání controlleru
        $this->instanceOfController->controlProcess($url);
        $this->dontRender = $this->instanceOfController->dontRender;
        if (!$this->dontRender) {
            $this->renderData['block'] = $this->instanceOfController->view . '.latte';
            foreach ($this->instanceOfController->renderData as $key => $value) {
                $this->renderData[$key] = $value;
            }
            $this->renderData['loginName'] = SessionManager::getUserName();
            $this->renderData['isLogIn'] = SessionManager::isLogin();
            $this->renderData['menu'] = (new MenuManager())->renderMenu((new MenuManager())->getMenuItems(), '', false);
            $this->renderData['baseURL'] = Config::getBaseUrl();
            $this->renderData['additionalyJs'] = $this->instanceOfController->getAdditionallyJS();
            $this->renderData['additionalyCSS'] = $this->instanceOfController->getAdditionallyCSS();
            $this->renderData['title'] = (!empty($this->instanceOfController->seoHeader['title']) ? $this->instanceOfController->seoHeader['title'] : Config::getSeo()->title);
            $this->renderData['keywords'] = (!empty($this->instanceOfController->seoHeader['keywords']) ? $this->instanceOfController->seoHeader['keywords'] : Config::getSeo()->keywords);
            $this->renderData['description'] = (!empty($this->instanceOfController->seoHeader['description']) ? $this->instanceOfController->seoHeader['description'] : Config::getSeo()->description);
            $this->view = 'layout';
        }
        
    }
}