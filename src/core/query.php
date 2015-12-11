<?php

class Query {

	private $pdo;
	private $select = "*";
	private $sorting = "id ASC";
	private $where = "1";
	private $limit = "0";

	function __construct() {
		$data = json_decode(file_get_contents(__DIR__."/../../app/config/parameters.json"));
		$this->pdo = new PDO(
    		'mysql:host='.$data->database_host.';dbname='.$data->database_name,
   			$data->database_user,
    		$data->database_pass
		);
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

	public function find($name) {
		$sth = $this->pdo->prepare("SELECT $this->select FROM $name WHERE $this->where ORDER BY $this->sorting;");
		$sth->execute();
		$result = [];
		foreach ($sth->fetchAll() as $key => $value) {
		 	array_push($result, $this->createEntity($name, $value));
		}
		$this->sorting = "id ASC";
		$this->where = "1";
		$this->select = "*";
		return $result;
	}

	public function findAll($name) {
		$sth = $this->pdo->prepare("SELECT * FROM $name;");
		$sth->execute();
		$result = [];
		foreach ($sth->fetchAll() as $key => $value) {
		 	array_push($result, $this->createEntity($name, $value));
		}
		return $result;
	}

	public function findOne($name) {
		$sth = $this->pdo->prepare("SELECT $this->select FROM $name WHERE $this->where ORDER BY $this->sorting LIMIT 1;");
		$sth->execute();
		$result = $this->createEntity($name, $sth->fetchAll()[0]);
		$this->sorting = "id ASC";
		$this->where = "1";
		$this->select = "*";
		return $result;
	}

	public function createEntity($name, $datas) {
		$newEntity = new $name();
		
		foreach ($datas as $key => $value) {
			if (gettype($key) != 'integer') $function = 'set'.$key;
			$newEntity->$function($value);
		}

		return $newEntity;
	}

	public function save($object) {
		$array = $object->getProperties();
		$table = strtolower(get_class($object));
		$set = "";
		$id = $object->getId();
		if ($id == null) {
			$sth = $this->pdo->prepare("INSERT INTO $table (id) VALUES (DEFAULT);");
			$sth->execute();
			$id = $this->pdo->lastInsertId();
		}
		$set = "";
		$i = 0;
		foreach ($array as $key => $value) {
			$key = str_replace("*", "", $key);
			if ($value != null) {
				if ($i > 0) $set .= ",";
				$set .= " $key = '$value'";
				$i++;
			}
		}
		$sth = $this->pdo->prepare("UPDATE $table SET $set WHERE id = '$id';");
		$sth->execute();
	}

	public function delete($object) {
		$id = $object->getId();
		$table = strtolower(get_class($object));
		$sth = $this->pdo->prepare("DELETE FROM $table WHERE id = $id");
		$sth->execute();
	}

}
