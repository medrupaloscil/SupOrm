<?php

class Entity {

	public $filter;
	private $pdo;
	private $name;

	function __construct() {
		$data = json_decode(file_get_contents(__DIR__."/../../app/config/parameters.json"));
		$this->pdo = new PDO(
    		'mysql:host='.$data->database_host.';dbname='.$data->database_name,
   			$data->database_user,
    		$data->database_pass
		);
		echo __DIR__."/../../app/config/parameters.json";
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function filterBy() {

	}

	public function find() {

	}

	public function findAll() {
		/*$sth = $this->pdo->prepare('SELECT * FROM'.$this->name.';');
		$sth->execute();
		return $sth->fetchAll();*/
	}
}