<?php

class Messages extends Entity {
   protected $id;
   protected $sender;
   protected $receiver;
   protected $content;

   function __construct() {
      parent::__construct();
   }

   public function getId() {
      return $this->id;
   }

   public function setId($id) {
      $this->id = $id;
   }

   public function getSender() {
      return $this->sender;
   }

   public function setSender($sender) {
      $this->sender = $sender;
   }

   public function getReceiver() {
      return $this->receiver;
   }

   public function setReceiver($receiver) {
      $this->receiver = $receiver;
   }

   public function getContent() {
      return $this->content;
   }

   public function setContent($content) {
      $this->content = $content;
   }

}
