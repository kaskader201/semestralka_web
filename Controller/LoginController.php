<?php


class LoginController extends Controller
{
    public function controlProcess(array $urlParameters)
    {

        $this->view = 'Login/index';
    }
}