<?php
require_once dirname(__FILE__) . "/../models/generic_model.php";

class Api_Controller extends TinyMVC_Controller
{

    function index($params = array())
    {
        if (empty($params)) {
            $this->view->display('api/doc');
            return;
        }

        $gm = new Generic_Model();

        $arr = array();
        for ($c = 1; $c < count($params); $c += 2) {
            $arr[$params[$c-1]] = $params[$c];
        }

        $this->view->assign('gen', $gm->get('test', $arr));

        $this->view->display('api/auto');
        return;
    }
}

