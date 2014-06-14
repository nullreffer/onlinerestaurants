<?php

class Cart_Controller extends TinyMVC_Controller
{
    function index($params = array())
    {
        echo "Controller CART";
        echo $this->get($params);
    }

    function get($params = array()) {
        if (empty($this->session->cartid))
            _createCart();
        return $this->session->cartid;
    }

    private function _createCart() {
        $this->session->isLoggedIn = false;
        $this->session->cartid = 1;
    }

    function add($params = array()) {
       
        // a call to /add/12 would mean add menu item to the cart
        // menu item ids will be unique across all restaurants, but we should probably add some validations
 
    }
}

?>
