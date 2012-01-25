# [Fnordmetric](https://github.com/paulasmuth/fnordmetric) PHP API

### Send new events to Fnordmetric without relying on cURL

Fnordmetric PHP API uses TCP sockets to write new events to Fnordmetric. You don't need cURL installed, and you don't need a PHP Redis lib.

## Usage

```php
# Instantiate the class with your Fnordmetric instance's TCP IP and port (defaults to 0.0.0.0:1337)
$fnord = new FnordmetricApi('0.0.0.0', 1337);

# Send a basic increment event
$fnord->event('unicorn_seen');

# Send a less basic event with extra data
$data = array(
    'colour' => 'rainbow',
    'name' => 'Luna'
);

$fnord->event('rare_unicorn_seen', $data);

# If you'd rather not rely on the destructor to close the socket
$fnord->close(); 
```    

