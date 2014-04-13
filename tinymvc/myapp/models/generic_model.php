<?php

class Generic_Model extends TinyMVC_Model
{
    function getAll($modelName) {
        if (!ctype_alpha($modelName)) {
            return array();
        }

        $r = array();
        
        $this->db->query("select * from " . $modelName);
        while ($row = $this->db->next()) {
            $r[] = (object) array_map(__FUNCTION__, $row); 
        }

        return $r;
    }

    function get($modelName, $params){
        if (!ctype_alpha($modelName) || empty($params)) {
            return array();
        }

        $r = array();

        $q = "";
        foreach ($params as $k => $v) {
            if (!preg_match("/^[A-Za-z0-9_]+$/", $k)) continue;
            $q .= !empty($q) ? " and " : " ";
            $q .= $k . " = '" . mysql_real_escape_string($v) . "' ";
        }
        if (empty($q)) return array();

        $this->db->query("select * from " . $modelName . " where " . $q );
        while ($row = $this->db->next()) {
            $r[] = (object) array_map(__FUNCTION__, $row); 
        }

        return $r;
    }

    function create($modelName, $obj) {

        $oa = get_object_vars($obj);
        if (empty($oa)) return -1;

        $a = array_map(__FUNCTION__, $oa);
        $this->db->query("insert into " . $modelName . "(" . implode(",", $oa) .") values(" . "?" . str_repeat(",?", count($oa) - 1) . ") ", array_values($a));

        return $this->db->last_insert_id();
    }

    function remove($modelName, $params) {
        // todo
    }

    function update($modelName, $params, $updates) {
        // todo
    }
}

