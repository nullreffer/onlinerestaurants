<?php 
namespace ThirdLabs\Services;

class ModelDefinition {

    private $name;
    private $default_write_level = "owner";
    private $default_read_level = "owner";
    private $validator;
    private $attributes = array();

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function __set($property, $value) {
        if ($value === null) return;
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}

class AttributeDefinition {

    private $name;
    private $type;
    private $values;

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function __set($property, $value) {
        if ($value === null) return;
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}