<?php


class IndexController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        //$this->setAdditionallyJS(['sss.js', 'cccc.js', 'sadasd.js']);
        $this->renderData['s'] = 'ahoj';
        $this->view = 'index';
    }
    
}
