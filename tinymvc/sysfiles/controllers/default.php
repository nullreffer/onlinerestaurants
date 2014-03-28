<?php

class Default_Controller extends TinyMVC_Controller
{
  function index()
  {
    $this->view->display('index_view');
  }
}

?>
