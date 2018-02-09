<?php

class UsersController extends Controller
{
    private $userService;
    public function controlProcess(array $urlParameters)
    {
        $this->userService = new UserService();
        $this->setAdditionallyJS(['dataTable.js']);
        $this->renderData['users'] = $this->userService->getAllUsers();
        $this->view = 'user';
    }
}