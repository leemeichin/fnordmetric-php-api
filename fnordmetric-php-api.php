<?php
  class FnordmetricApi {
    
    protected $socket;
    public    $host,
              $port;

    public function __construct($host = '0.0.0.0', $port = 1337) {
      $this->host = $host;
      $this->port = $port;
    }

    public function __destruct() {
      $this->closeSocket();
    }

    public function event($name, Array $data = array()) {
      $this->openSocket();
      $this->write($data);
    }

    public function formatData($name, $data = array()) {
      $data['_type'] = $name;
      return json_encode($data);
    }

    public function openSocket() {
      $this->socket = socket_create(IF_ANET, SOCK_STREAM, SOL_TCP);
      if ($this->socket === false) throw new SocketConnectionErrorException;

      // add client connection to socket (ie. us)
      $client = socket_bind($this->socket, '127.0.0.1');
      if ($client === false) throw new SocketConnectionErrorException;

      $server = socket_connect($this->socket, $this->host, $this->port);
      if ($server === false) throw new SocketConnectionErrorException;
    }

    public function write($data) {
      if (!$this->socketIsOpen()) $this->openSocket();

      $length = strlen($data);
      $offset = 0;

      while ($offset < $length) {
        $sent_data = socket_write($this->socket, substr($data, $offset), $length - $offset);
        if ($sent_data === false) throw new SocketConnectionErrorException;

        $offset += $sent_data;
      }
      return true; // if something went wrong, there'd be an exception thrown
    }

    public function socketIsOpen() {
      return (bool) $this->socket && is_resource($this->socket);
    }

    public function closeSocket() {
      if ($this->socketIsOpen()) {
        @socket_shutdown($this->socket, 2);
        socket_close($this->socket);
      }
    }
