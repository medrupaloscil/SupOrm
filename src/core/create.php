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
		  		$this->createTable(ucfirst($value['name']);
		  		$className = ucfirst($value['name'];
		  		$fields = [];
		  		foreach ($value as $ky => $val) {
		  			array_push($fields, $val['name']);
		  			$this->addColumn(ucfirst($value['name'], $val['name'], $val['type']);
		  		}
		  		$this->generateFiles($className, $fields);
		  	}
		}
	}

	private function isDatabaseOrCreate($databaseName) {
		$sth = $this->pdo->prepare("CREATE DATABASE IF NOT EXISTS $databaseName;");
		$sth->execute();
	}

	private function createTable($tableName) {
		$sth = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS $tableName (id INTEGER);");
		$sth->execute();
		$sth = $this->pdo->prepare("ALTER TABLE $tableName ADD PRIMARY KEY(`id`);");
		$sth->execute();
		$sth = $this->pdo->prepare("ALTER TABLE $tableName MODIFY COLUMN id INT auto_increment;");
		$sth->execute();
	}

	private function addColumn($tableName, $columnName, $columnType) {
		$sth = $this->pdo->prepare("ALTER TABLE $tableName ADD $columnName $columnType;");
		$sth->execute();
	}

	public function generateTableByName($name) {
		foreach(glob(__DIR__.'/../xml/*.xml') as $file) {
		  	$xml = simplexml_load_file($file) or die("Error: Cannot create object");
		  	foreach ($xml as $key => $value) {
		  		if ($value['name'] == $name) {
		  			$this->createTable($value['name']);
		  			$className = $value['name'];
			  		$fields = [];
			  		foreach ($value as $ky => $val) {
			  			array_push($fields, $val['name']);
			  			$this->addColumn($value['name'], $val['name'], $val['type']);
			  		}
			  		$this->generateFiles($className, $fields);
			  		return "Table $name successfully generated\n";
		  		}
		  	}
		}

		return "Error 84971573: Table $name not found, please create it in xml file\n";
	}

	private function generateFiles($className, $fields) {
		$tabs = 1;
		$code = "<?php\n\n";
		$code .= "class ".ucfirst($className)." extends Entity {\n";
		foreach ($fields as $field) {
			$code .= $this->do_tabs($tabs) . 'protected $'.$field.";\n";
		}
		$code .= "\n";
		$code .= $this->do_tabs($tabs) . "function __construct() {\n";
		$code .= $this->do_tabs($tabs) . $this->do_tabs($tabs) . "parent::__construct();\n";
		$code .= $this->do_tabs($tabs) . "}\n\n";

		foreach ($fields as $field) {
			$code .= $this->do_tabs($tabs) . 'public function get'.ucfirst($field)."() {\n";
			$code .= $this->do_tabs($tabs) . $this->do_tabs($tabs) . 'return $this->'.$field.";\n";
			$code .= $this->do_tabs($tabs) . "}\n\n";
			$code .= $this->do_tabs($tabs) . 'public function set'.ucfirst($field).'($'.$field.") {\n";
			$code .= $this->do_tabs($tabs) . $this->do_tabs($tabs) . '$this->'.$field.' = $'.$field.";\n";
			$code .= $this->do_tabs($tabs) . "}\n\n";
		}
		$code .= "}\n";
		file_put_contents(__DIR__."/../model/".ucfirst($className).".php", $code);
	}

	private function do_tabs($tabs) {
		$ret = '';
		for ($i=0; $i < $tabs; $i++) {
			$ret = '   ';
			return $ret;
		}
	}
}