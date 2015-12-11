<?php

class Users extends Entity {
   protected $id;
   protected $pseudo;
   protected $password;
   protected $age;
   protected $gender;

   function __construct() {
      parent::__construct();
   }

   public function getId() {
      return $this->id;
   }

   public function setId($id) {
      $this->id = $id;
   }

   public function getPseudo() {
      return $this->pseudo;
   }

   public function setPseudo($pseudo) {
      $this->pseudo = $pseudo;
   }

   public function getPassword() {
      return $this->password;
   }

   public function setPassword($password) {
      $this->password = $password;
   }

   public function getAge() {
      return $this->age;
   }

   public function setAge($age) {
      $this->age = $age;
   }

   public function getGender() {
      return $this->gender;
   }

   public function setGender($gender) {
      $this->gender = $gender;
   }

}
