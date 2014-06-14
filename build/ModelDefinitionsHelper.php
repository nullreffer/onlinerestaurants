<?php 
namespace ThirdLabs\Services;

use Exception;
use PDO;

class ModelDefinitionsHelper {

    private $modelDefinitions;
    private $pdo;
    private $options;

    public function __construct($modelDefinitions, $pdo, $options = array("TablePrefix" => "i")) {
    	$this->modelDefinitions = $modelDefinitions;
    	$this->pdo = $pdo;
    	$this->options = $options;
    }

    public function GetModels($modelName, $filters = array()) {
    	if (!in_array($modelName, array_keys($this->modelDefinitions))) {
    		throw new Exception("Model $modelName not found", 1);
    	}

        // check to make sure all filters exist in model def
	    foreach ($filters as $fkey => $fval) {
	    	if ($fkey == 'id') continue;
	       	if (!in_array($fkey, array_keys($this->modelDefinitions[$modelName]->attributes))) {
	       		throw new Exception("Attribute $fkey not found", 1);
	       	}
	    }
    	
        $tableName = $this->options["TablePrefix"] . $modelName;
    	$stmt = "SELECT * from $tableName WHERE 1=1 ";
    	foreach ($filters as $fkey => $fval) {
    		$stmt .= " AND $fkey = ? ";
    	}

        $stmt = $this->pdo->prepare($stmt);
    	$stmt->execute(array_values($filters));
    	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    	return $rows;
    }

    public function UpdateModel($modelName, $newModel) {
    	// update only supported by id
    	if (!in_array($modelName, array_keys($this->modelDefinitions)) || empty($newModel->id)) {
    		throw new Exception("Model not found", 1);
    	}

	   	foreach (get_object_vars($newModel) as $attr => $attrVal) {
	   		if (!in_array($attr, array_keys($this->modelDefinitions[$modelName]->attributes))) {
	   			throw new Exception("Attribute $attr not part of $modelName", 1);
	   		}
	   	}

		$tableName = $this->options["TablePrefix"] . $modelName;
    	$stmt = "UPDATE $tableName SET ";
    	$vals = array();
    	$first = true;
    	foreach (get_object_vars($newModel) as $attr => $attrVal) {
    		if (!$first) {
    			$stmt .= " , ";
    		} 
    		$first = false;

    		$stmt .= " $attr = ? ";

    		if (strpos($this->modelDefinitions[$modelName]->attributes[$attr]->type, '[]')) {
    			$vals[] = json_encode($newModel->$attr);
    		} else {
    			$vals[] = $newModel-$attr;
    		}
    	}
    	$stmt .= " WHERE id = ? ";
        $vals[] = $newModel->id;

    	$stmt = $this->pdo->prepare($stmt);
    	$stmt->execute(array_values($vals));
    }

    public function CreateModel($modelName, $newModel) {
    	if (!in_array($modelName, array_keys($this->modelDefinitions))) {
    		throw new Exception("Model not found", 1);
    	}

    	foreach (get_object_vars($newModel) as $attr => $attrVal) {
    		if (!in_array($attr, array_keys($this->modelDefinitions[$modelName]->attributes))) {
    			throw new Exception("Attribute $attr not part of $modelName", 1);
    		}
    	}

		$tableName = $this->options["TablePrefix"] . $modelName;
    	$stmt = "INSERT INTO $tableName SET ";
    	$vals = array();
    	$first = true;
    	foreach (get_object_vars($newModel) as $attr => $attrVal) {
    		if (!$first) {
    			$stmt .= " , ";
    		} 
    		$first = false;
    		$stmt .= " $attr = ? ";

    		if (strpos($this->modelDefinitions[$modelName]->attributes[$attr]->type, '[]')) {
    			$vals[] = json_encode($newModel->$attr);
    		} else {
    			$vals[] = $newModel->$attr;
    		}
    	}

    	$stmt = $this->pdo->prepare($stmt);
    	$stmt->execute(array_values($vals));
    	$modelId = $this->pdo->lastInsertId();

    	return $this->GetModels($modelName, array("id" => $modelId));
    }

    public function DeleteModel($modelName, $id) {
		if (!in_array($modelName, array_keys($this->modelDefinitions))) {
    		throw new Exception("Model not found", 1);
    	}

    	$tableName = $this->options["TablePrefix"] . $modelName;
    	$stmt = "DELETE FROM $tableName WHERE id = ? ";

    	$stmt = $this->pdo->prepare($stmt);
    	$stmt->execute(array_values($id));
    }

    private function UserHasModelReadAccess($userModel, $model) {
    	$modelAccessLevel = $model->default_write_access;

        // TODO:

    	return true;
    }

    private function UserHasModelWriteAccess($userModel, $model) {
    	$modelAccessLevel = $model->default_write_access;

        // TODO:

    	return true;
    }

    public function CreateTables() {
    	$stmts = $this->createCreateQueries();

    	foreach ($stmts as $sql) {
    		$this->pdo->exec($sql);
    	}
    }

    private function createCreateQueries() {
    	$modelDefinitions = $this->modelDefinitions;

        $loadedTypes = array(
            "decimal",
            "money",
            "number",
            "text",
            "datetime",
            "option",
            "user"
        );

        // load user first
        $userModelDef = $modelDefinitions["user"];
        $stmt = array();
        if ($userModelDef != null) {
            $stmt[] = $this->createCreateStatement($userModelDef);
        }

        $c = count($modelDefinitions);
        while ($c > 0) { // user will always remain
            $newModelDefinitons = array();
            foreach ($modelDefinitions as $modelDef) {

                // check if model can be loaded i.e. all its dependencies are loaded
                // TODO: recursion will put this in an infinite loop
                $dependenciesLoaded = true;
                foreach ($modelDef->attributes as $attr) {
                    if (!in_array(str_replace("[]", "", $attr->type), $loadedTypes)) {
                        $dependenciesLoaded = false;
                        // echo "\nnot loaded: " . $modelDef->name . " because of " . $attr->type . "\n";
                        break;
                    }
                }
                if (!$dependenciesLoaded) {
                    $newModelDefinitons[$modelDef->name] = $modelDef;
                    continue;
                }

                if (!in_array($modelDef->name, $loadedTypes)) {
                    $stmt[] = $this->createCreateStatement($modelDef);
                    $loadedTypes[] = $modelDef->name;
                    // echo "\nloaded: " . $modelDef->name . "\n";
                }

                $c--;
            }
            $modelDefinitions = $newModelDefinitons;
        }
        return $stmt;
    }

    private function createCreateStatement($modelDef) {
        $stmt = "CREATE TABLE " . $this->options["TablePrefix"] . trim($modelDef->name) . "( ";
        $stmt .= " id INT(11) UNSIGNED AUTO_INCREMENT, ";
        $keys = array();
        foreach ($modelDef->attributes as $attr) {
            $stmt .= $attr->name . " ";
            $type = (strpos($a,'[]') !== false) ? "array" : $attr->type;
            switch ($attr->type) {
                case 'decimal':
                case 'money':
                    $stmt .= " DECIMAL(10, 2), ";
                    break;
                case 'option':
                    $stmt .= " ENUM('" . implode("','", $attr->values) . "'), ";
                    break;
                case 'number':
                    $stmt .= " INT(11), ";
                    break;
                case 'datetime':
                    $stmt .= " DATETIME, ";
                    break;
                case 'array':
                case 'text':
                    $stmt .= " VARCHAR(255), ";
                    break;
                default:
                    // assume foreign id
                    $stmt .= " INT(11) UNSIGNED, ";
                    $keys[] = $attr->name;
                    break;
            }
        }
        if ($modelDef->name != "user")
            $stmt .= " owner INT(11) UNSIGNED, ";
        $stmt .= " creation_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, "; 
        // $stmt .= " modified_time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ";

        $stmt .= " PRIMARY KEY (id) ";
        foreach ($keys as $key){
            $stmt .= ", INDEX (" . $key . ") ";
        }

        $stmt .= " ); ";

        return $stmt;
    }

}