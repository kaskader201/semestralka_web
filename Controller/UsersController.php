<?php

class UsersController extends Controller
{
    const EDIT_USER = 'edit_user';
    const CREATE_NEW_USER = 'new_user';
    /**
     * @var UserService
     */
    private $userService;
    private $allowSave = ['edit', 'new'];
    
    public function __construct()
    {
        $this->userService = new UserService();
    }
    
    
    public function controlProcess(array $urlParameters)
    {
        
        $this->setAdditionallyJS(['dataTable/jquery.dataTable.js','dataTable/dataTables.rowReorder.min.js','dataTable/dataTables.responsive.min.js','dataTable/dataTable.js', 'users.js']);
        $this->setAdditionallyCSS(['dataTable/jquery.dataTables.min.css','dataTable/responsive.dataTables.min.css','dataTable/rowReorder.dataTables.min.css', 'jquery-confirm.css']);
        switch (count($urlParameters)) {
            case 0:
                $this->showAllUsers();
                break;
            case 1:
                if ($urlParameters[0] === 'new') {
                    $this->showCreateNewUser();
                } elseif ($urlParameters[0] === 'delete') {
                    die('delete');
                } else {
                    $this->redirect('users');
                }
                break;
            case 2:
                if ($urlParameters[0] === 'edit' && is_numeric($urlParameters[1])) {
                    $this->showEditUser((int) $urlParameters[1]);
                } elseif ($urlParameters[0] === 'save' && $urlParameters[1] == $this->allowSave[1]) { //uložení novéhu uživatele
                    //byl odeslán formulář postem exituje v něm prvek (csrf token) a současně je csrf token pro povolené akce validní
                    if (isset($_POST[CSRF::INPUT_NAME]) && (CSRF::isTokenValid($_POST[CSRF::INPUT_NAME], self::EDIT_USER) || CSRF::isTokenValid($_POST[CSRF::INPUT_NAME], self::CREATE_NEW_USER))) {
                        $this->saveUser($_POST, $urlParameters[1]);
                    } else {
                        $this->redirect('users');
                    }
                } else {
                    $this->redirect('users');
                }
                break;
            case 3:
                if ($urlParameters[0] === 'save' && $urlParameters[1] == $this->allowSave[0] && is_numeric($urlParameters[2])) {
                    //byl odeslán formulář postem exituje v něm prvek (csrf token) a současně je csrf token pro povolené akce validní
                    if (isset($_POST[CSRF::INPUT_NAME]) && (CSRF::isTokenValid($_POST[CSRF::INPUT_NAME], self::EDIT_USER) || CSRF::isTokenValid($_POST[CSRF::INPUT_NAME], self::CREATE_NEW_USER))) {
                        $this->saveUser($_POST, $urlParameters[1], $urlParameters[2]);
                    } else {
                        $this->redirect('users');
                    }
                }
                break;
            default:
                $this->redirect('users');
        }
        
    }
    
    /**
     * proces ukládání nového uživatele či změn na něm
     * @param $data
     */
    private function saveUser($data, $typ, $idUser = null)
    {
        unset($data[CSRF::INPUT_NAME]);
        //todo: vracení pozměněných dat
        $this->validData($data);
        $userService = new UserService();
        
        
        switch ($typ) {
            case $this->allowSave[0]://edit
                $userOriginal = $userService->getById($idUser);
                $user = clone $userOriginal;
                foreach ($user as $key => $value) {
                    if (isset($data[$key]) && $data[$key] !== $value) {
                        $user->$key = $data[$key];
                    }
                    
                }
                if (!isset($data['active'])) {
                    $user->active = false;
                }
                if (!isset($data['verified'])) {
                    $user->verified = false;
                }
                if ($user != $userOriginal) {
                    if ($user->save()) {
                        FlashMessage::add((new Message())->setHeader('Úspěšně byl editován uživatel')->setText('Byl editován uživatel s ID: ' . $user->id)->setType(Message::SUCCESS));
                    } else {
                        FlashMessage::add((new Message())->setHeader('Nebyl editován uživatel')->setText('Došlo k chybě, bohužel nedošlo k editci uživatele s ID: ' . $user->id)->setType(Message::DANGER));
                    }
                } else {
                    FlashMessage::add((new Message())->setHeader('Nebyl editován uživatel')->setText('Data se shodují s již uloženými daty. Nedošlo k editaci uživatele s ID: ' . $user->id)->setType(Message::INFO));
                }
                break;
            case $this->allowSave[1]://vytvoření nového
                $user = new User();
                $user->setActive((!isset($data['active']) ? false : true))
                    ->setVerified((!isset($data['verified']) ? false : true))
                    ->setTel($data['tel'])
                    ->setPassword($data['password'])
                    ->setLastname($data['lastname'])
                    ->setFirstname($data['firstname'])
                    ->setEmail($data['email'])
                    ->setToken(uniqid('s', true))
                    ->setPermission($data['permission']);
                if ($user->save()) {
                    FlashMessage::add((new Message())->setHeader('Úspěšně byl vytvořen uživatel uživatel')->setText('Byl vytvořen uživatel.')->setType(Message::SUCCESS));
                } else {
                    FlashMessage::add((new Message())->setHeader('Nebyl editován uživatel')->setText('Došlo k chybě, bohužel nedošlo k editci uživatele s ID: ' . $user->id)->setType(Message::DANGER));
                }
                break;
        }
        $this->redirect('users');
    }
    
    private function validData($data)
    {
    
    }
    
    /**
     * zobraz všechny uživatele
     */
    private function showAllUsers()
    {
        $this->renderData['users'] = $this->userService->getAllUsers();
        $this->view = 'Users/index';
    }
    
    /**
     * zobraz editaci konkrétniho uživatele
     * @param int $idUser
     */
    private function showEditUser(int $idUser)
    {
        $result = $this->userService->getById($idUser);
        if (!$result) {
            $this->redirect('users');
        }
        $this->renderData['permissions'] = Permissions::getAllPermision();
        $this->renderData['CSRF_token'] = CSRF::getNewToken(self::EDIT_USER);
        $this->renderData['CSRF_input_name'] = CSRF::INPUT_NAME;
        //$this->renderData['token'] = substr(bin2hex(random_bytes(20)), 1, 20);
        $this->renderData['user'] = $result;
        $this->view = 'Users/edit';
    }
    
    private function showCreateNewUser()
    {
        $this->renderData['permissions'] = Permissions::getAllPermision();
        $this->renderData['CSRF_token'] = CSRF::getNewToken(self::CREATE_NEW_USER);
        $this->renderData['CSRF_input_name'] = CSRF::INPUT_NAME;
        
        $this->view = 'Users/new';
    }
}