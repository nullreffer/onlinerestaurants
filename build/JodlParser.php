<?php 
namespace ThirdLabs\Services;

require_once "ModelDefinitions.php";

class JodlParser {

    private $options;

    public static function Instance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new JodlParser();
        }
        return $instance;
    }

    private function __construct() {
        $this->options = array(
            "TablePrefix" => "i",
            "LogLevel" => "verbose"
        ); 
    }

    public function LoadFile($filename) {
        $jodl = file_get_contents($filename);
        return $this->LoadString($jodl);
    }

    /*
     * Takes in jodl and returns an array of model definitions
     * See ModelDefinition.php for more information
     */
    public function LoadString($jodl) {
        
        // TODO: write json schema validator
        $modelArray = json_decode($jodl);
        // echo "<pre>" . print_r($modelArray, true) . "</pre>";

        $modelDefinitions = array();
        foreach ($modelArray as $m) {
            
            $modelDef = new ModelDefinition();
            $modelDef->name = $m->name;
            $modelDef->default_write_level = $m->default_write_level;
            $modelDef->default_read_level = $m->default_read_level;
            $modelDef->validator = $m->validator;

            $attributes = array();
            foreach ($m->attributes as $a) {
                $attribDef = new AttributeDefinition();
                $attribDef->name = $a->name;
                $attribDef->type = $a->type;
                $attribDef->values = $a->values;
                $attributes[$attribDef->name] = $attribDef;
            }
            $modelDef->attributes = $attributes;

            $modelDefinitions[$m->name] = $modelDef;
        }
    
        return $modelDefinitions;   
    }
}