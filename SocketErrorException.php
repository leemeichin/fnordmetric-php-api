<?php
/**
 * Handles errors caused by socket connections, using the procedural-tastic socket error functions to
 * find out what went wrong. Not really much else to it.
 */
class SocketErrorException extends Exception {
  
    public function __construct() {
      $this->error_number = socket_last_error();
      $this->error_message = socket_strerror($this->error_number);
    }

    public function getSocketError() {
      return sprintf("%d - %s", $this->error_number, $this->error_message);
    }
}
