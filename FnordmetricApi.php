<?php

  class FnordmetricApi {
    
    protected $socket;
    public    $host,
              $port;

    public function __construct($host = '0.0.0.0', $port = 1337) {
      $this->host = $host;
      $this->port = $port;
    }
  
    /* close the socket connection when the class is no longer needed */
    public function __destruct() {
      $this->closeSocket();
    }

    /* send an event to the fnordmetric server */
    public function event($name, Array $data = array()) {
      $data = $this->formatData($name, $data);
      $this->write($data);
    }

    /* close the connection manually if necessary */
    public function close() {
      $this->closeSocket();
    }

    /* add the event name to the data array, and json encode the lot of it */
    private function formatData($name, $data = array()) {
      $data['_type'] = $name;
      return json_encode($data);
    }

    /* open up a socket connection */
    private function openSocket() {
      $this->socket = @socket_create(IF_ANET, SOCK_STREAM, SOL_TCP);
      if ($this->socket === false) throw new SocketErrorException;

      // add client connection to socket (ie. us)
      $client = @socket_bind($this->socket, '127.0.0.1');
      if ($client === false) throw new SocketErrorException;

      $server = @socket_connect($this->socket, $this->host, $this->port);
      if ($server === false) throw new SocketErrorException;
    }

    /* write the data to the socket */
    private function write($data) {
      if (!$this->socketIsOpen()) $this->openSocket();

      $length = strlen($data);
      $offset = 0;

      while ($offset < $length) {
        $sent_data = @socket_write($this->socket, substr($data, $offset), $length - $offset);
        if ($sent_data === false) throw new SocketErrorException;

        $offset += $sent_data;
      }
      return true; // if something went wrong, there'd be an exception thrown
    }

    /* check that the socket is open, but not necessarily connected  (if the var is true and is also a resource) */
    private function socketIsOpen() {
      return (bool) $this->socket && is_resource($this->socket);
    }

    /* close the socket connection and nullify it */
    private function closeSocket() {
      if ($this->socketIsOpen()) {
        @socket_shutdown($this->socket, 2);
        socket_close($this->socket);
      }
      $this->socket = null;
    }
}