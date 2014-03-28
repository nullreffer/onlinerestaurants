<?php

class Generic_Model extends TinyMVC_Model
{
    function getAll($modelName) {
        // sample
        $arr[0] = new StdClass();
        $arr[1] = new StdClass();

        $arr[0]->id = 1;
        $arr[1]->id = 2;

        $arr[0]->name = "jay";
        $arr[1]->name = "notjay";

        return $arr;
    }

    function get($modelName, $params){
        // sample
        $o = new StdClass();
        $o->id = 1;
        $o->name = "jay";

        if (isset($params["name"]) && $params["name"] == "who") {
            // sample where clause
            $o->name = "cookie";
        }
        
        return $o;
    }

    function create($modelName) {
        // sample
        $n = new StdClass();
        $n->id = 423;
        $n->name = "What";

        return $n;
    }
}

?>
