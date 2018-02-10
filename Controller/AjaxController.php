<?php
/**
 * Created by PhpStorm.
 * User: Jelin
 * Date: 10.02.2018
 * Time: 3:12
 */

class AjaxController extends Controller
{
    const AJAX_DELETE_USER = '';
    public function controlProcess(array $urlParameters)
    {
        $this->dontRender = true;
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        
        } else {
            //pokud se nejedná o AJAX
            $this->redirect();
        }
        

    }
}