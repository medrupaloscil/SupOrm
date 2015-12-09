<?php

class Create {
	private $pdo;

	function __construct() {
		$data = json_decode(file_get_contents(__DIR__."/../../app/config/parameters.json"));
		$this->pdo = new PDO(
    		'mysql:host='.$data->database_host.';dbname='.$data->database_name,
   			$data->database_user,
    		$data->database_pass
		);
	}

	public function createDatabase() {
		foreach(glob(__DIR__.'/../xml/*.xml') as $file) {
		  	$xml = simplexml_load_file($file) or die("Error: Cannot create object");
		  	$this->isDatabaseOrCreate($xml['name']);
		  	foreach ($xml as $key => $value) {
		  		$this->createTable($value['name']);
		  		$className = $value['name'];
		  		$fields = [];
		  		foreach ($value as $ky => $val) {
		  			array_push($fields, $val['name']);
		  			//var_dump($val);
		  		}
		  		$this->generateFiles($className, $fields);
		  	}
		}
	}

	private function createTable($tableName) {
		echo "gros tas ";
		$sth = $this->pdo->prepare('CREATE TABLE IF NOT EXISTS :name (id INTEGER);');
		$sth->execute([':name' => $tableName]);
	}

	private function isDatabaseOrCreate($databaseName) {
		$sth = $this->pdo->prepare('CREATE DATABASE IF NOT EXISTS :name;');
		$sth->execute([':name' => $databaseName]);
	}

	private function generateFiles($className, $fields) {
		$tabs = 1;
		$code = "<?php\n\n";
		$code .= "class $className\n{\n";
		foreach ($fields as $field) {
			$code .= $this->do_tabs($tabs) . 'protected $'.$field.";\n";
		}
		$code .= "\n";

		foreach ($fields as $field) {
			$code .= $this->do_tabs($tabs) . 'public function get'.ucfirst($field)."() {\n";
			$code .= $this->do_tabs($tabs) . $this->do_tabs($tabs) . 'return $this->'.$field.";\n";
			$code .= $this->do_tabs($tabs) . "}\n\n";
			$code .= $this->do_tabs($tabs) . 'public function set'.ucfirst($field).'($'.$field.") {\n";
			$code .= $this->do_tabs($tabs) . "{\n";
			$code .= $this->do_tabs($tabs) . $this->do_tabs($tabs) . '$this->'.$field.' = $'.$field.";\n";
			$code .= $this->do_tabs($tabs) . "}\n\n";
		}
		$code .= "}\n";
		file_put_contents(__DIR__."/../model/".$className.".php", $code);
	}

	private function do_tabs($tabs) {
		$ret = '';
		for ($i=0; $i < $tabs; $i++) {
			$ret = '   ';
			return $ret;
		}
	}
}

