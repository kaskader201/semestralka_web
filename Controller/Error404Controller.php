<?php

/**
 * Class Error404Controller
 * Stránka 404
 */
class Error404Controller extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        $this->renderData['x'] = '';
        $this->view = 'chyba';
    
    }
}