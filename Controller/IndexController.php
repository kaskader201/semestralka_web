<?php


class IndexController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        $this->setAdditionallyJS(['dataTable.js']);
        $this->renderData['s'] = 'ahoj';
        $this->view = 'index';
    }
    
}
