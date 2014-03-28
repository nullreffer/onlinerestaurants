<?php

class Default_Controller extends TinyMVC_Controller
{
  function index($params = array())
  {
    $this->view->display('index_view');
  }
}

?>
