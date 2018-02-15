<?php
namespace Semestralka {
    /**
     * Chybová stránka
     * Class Error404Controller
     * @package Semestralka
     */
    class Error404Controller extends Controller
    {
        public function controlProcess(array $urlParameters)
        {
            $this->renderData['x'] = '';
            $this->view = 'chyba';
            
        }
    }
}