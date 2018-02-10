<?php


class IndexController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        $this->setAdditionallyJS(['dataTable.js']);
        $this->setAdditionallyCSS(['jquery.dataTables.min.css']);
        $this->view = 'index';
    }
    
}
