<?php

class SocketConnectionErrorException extends Exception {
  
    public function __construct() {
      $this->error_number = socket_last_error();
      $this->error_message = socket_strerror($this->error_number);
    }

    public function getSocketError() {
      return sprintf("%d - %s", $this->error_number, $this->error_message);
    }
}
