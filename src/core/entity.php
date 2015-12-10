<?php

class Entity {

	private $select = "*";
	private $sorting = "id ASC";
	private $where = "1";
	private $pdo;
	private $name;

	function __construct() {
		$data = json_decode(file_get_contents(__DIR__."/../../app/config/parameters.json"));
		$this->pdo = new PDO(
    		'mysql:host='.$data->database_host.';dbname='.$data->database_name,
   			$data->database_user,
    		$data->database_pass
		);
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function select($params) {
		$i = 0;
		$this->select = "";
		foreach ($params as $key => $value) {
			if ($i > 0) $this->select .= ", ";
			$i++;
			$this->select .= $value;
		}
		if ($this->select == "") $this->select = "*";
	}

	public function where($params) {
		$i = 0;
		$this->where = "";
		foreach ($params as $key => $value) {
			if ($i > 0) $this->where .= " AND ";
			$i++;
			$this->where .= $value;
		}
		if ($this->where == "") $this->where = "1";
	}

	public function orderBy($param, $type = 'ASC') {
		$this->sorting = "$param $type";
	}

	public function find() {
		echo "SELECT $this->select FROM $this->name WHERE $this->where ORDER BY $this->sorting;";
		$sth = $this->pdo->prepare("SELECT $this->select FROM $this->name WHERE $this->where ORDER BY $this->sorting;");
		$sth->execute();
		return $sth->fetchAll();
		$this->sorting = "id ASC";
		$this->where = [];
	}

	public function findAll() {
		$sth = $this->pdo->prepare("SELECT * FROM $this->name;");
		$sth->execute();
		return $sth->fetchAll();
	}
}