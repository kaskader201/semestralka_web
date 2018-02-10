<?php
/**
 * Created by PhpStorm.
 * User: Jelin
 * Date: 10.02.2018
 * Time: 3:12
 */

class AjaxController extends Controller
{
    const AJAX_DELETE_USER = 'deleteUser';
    public function controlProcess(array $urlParameters)
    {
        $this->dontRender = true;
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            switch ($urlParameters) {
                case self::AJAX_DELETE_USER:
                    //todo: má na to práva ???
                    $idUser = ($_POST['id'] ?? 'aa');
                    if (is_numeric($idUser)) {
                        //todo: vyhodnocení jestli se provedlo smazani
                        (new UserService())->deleteById($idUser);
                    } else {
                    //todo: není číslo vrat chybu
                    }
                    break;
                default:
                    $this->redirect();
            }
        } else {
            //pokud se nejedná o AJAX
            $this->redirect();
        }
        

    }
}