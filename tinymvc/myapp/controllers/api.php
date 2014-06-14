<?php
require_once dirname(__FILE__) . "/../../../build/ModelDefinitions.php";
require_once dirname(__FILE__) . "/../../../build/ModelDefinitionsHelper.php";

use ThirdLabs\Services\ModelDefinitionsHelper;

class Api_Controller extends TinyMVC_Controller
{
    private $modelDefinitionsHelper;

    function __construct() {
        parent::__construct();
        $modelDefinitions = unserialize(file_get_contents(dirname(__FILE__) . "/../../../build/mdata.txt"));
        $this->modelDefinitionsHelper = new ModelDefinitionsHelper($modelDefinitions, $this->load->database()->pdo);
    }

    function index($params = array())
    {
        header('Content-type: text/json');

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (method_exists($this, $method)) {
            echo $this->$method($params);
            return;
        }

        if (count($params) == 0) {
            echo "Model needed";
            return;
        }

        echo "Method $method not supported";
        return;
    }

    private function get($params) {
        $modelName = $params[0];
        $params = array_slice($params, 1);
        $filters = array('id' => $params[0]);
        if (count($params) > 1) {
            $filters = array();
            for ($i = 0; $i < count($params); $i += 2) { 
                $filters[$params[$i]] = $params[$i + 1];
            }
        }

        $models = $this->modelDefinitionsHelper->GetModels($modelName, $filters);

        return json_encode($models);
    }

    private function post($params) {
        $modelName = $params[0];

        $object = file_get_contents('php://input');
        $object = json_decode($object);
        if ($object == null) {
            echo "Post made without parameters";
            return;
        }

        return json_encode($this->modelDefinitionsHelper->CreateModel($modelName, $object));
    }

    private function put($params) {
        $modelName = $params[0];

        $object = file_get_contents('php://input');
        $object = json_decode($object);
        if ($object == null) {
            echo "Put made without parameters";
            return;
        }

        $this->modelDefinitionsHelper->UpdateModel($modelName, $object);
    }

    private function delete($params) {
        $modelName = $params[0];
        $modelId = $params[1];
        if (empty($modelId)) {
            echo "Delete made without model id";
            return;
        }

        $this->modelDefinitionsHelper->DeleteModel($modelName, $object);
    }
}

