<?php


class LoginController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        $this->setAdditionallyJS(['dataTable.js']);
        $this->setAdditionallyCSS(['jquery.dataTables.min.css']);
        $this->view = 'login/index';
    }
}