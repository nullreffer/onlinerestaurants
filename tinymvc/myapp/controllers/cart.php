<?php

class Cart_Controller extends TinyMVC_Controller
{
    function index($params = array())
    {
        $this->get($params);
    }

    function get($params = array()) {
        if (empty($this->session->cartid))
            _createCart();
    }

    private function _createCart() {
        $this->session->isLoggedIn = false;
    }

    function add($params = array()) {
       
        // a call to /add/12 would mean add menu item to the cart
        // menu item ids will be unique across all restaurants, but we should probably add some validations
 
    }
}

?>
