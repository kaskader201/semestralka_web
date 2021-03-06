<?php

/**
 * Class AjaxController
 * Stará se o příjmání ajaxů
 */

class AjaxController extends Controller
{
    const AJAX_DELETE_USER = 'deleteUser';
    
    /**
     * @param array $urlParameters
     */
    public function controlProcess(array $urlParameters)
    {
        
        $this->dontRender = true;
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            
            switch ($urlParameters[0]) {
                case self::AJAX_DELETE_USER:
                    //todo: má na to práva ???
                    $idUser = ($_POST['id'] ?? 'aa');
                    if (is_numeric($idUser)) {
                        //todo: vyhodnocení jestli se provedlo smazani
                        (new UserService())->deleteById($idUser);
                        echo json_encode(['sucess' => true]);
                    } else {
                        echo json_encode(['sucess' => false]);
                        //todo: není číslo vrat chybu
                    }
                    break;
                default:
                    echo json_encode(['sucess' => false]);
                // $this->redirect();
            }
            exit;
        } else {
            //pokud se nejedná o AJAX
            
            $this->redirect();
        }
        
        
    }
}
