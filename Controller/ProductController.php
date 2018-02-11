<?php
/**
 * Created by PhpStorm.
 * User: expan
 * Date: 11.02.2018
 * Time: 23:57
 */

class ProductController extends Controller
{
    public function controlProcess(array $urlParameters)
    {
        $this->setAdditionallyJS(['dataTable.js']);
        $this->setAdditionallyCSS(['jquery.dataTables.min.css']);

        if(isset($urlParameters[0]) && $urlParameters[0] === "new"){
            $this->view = 'product/new';
        }
        elseif(isset($urlParameters[1]) && $urlParameters[1] === "delete"){
            $this->view = 'product/delete';
        }
        elseif(isset($urlParameters[2]) && $urlParameters[2] === "change"){
            $this->view = 'product/change';
        }
        else{
            $this->view = 'product/index';
        }

    }

}