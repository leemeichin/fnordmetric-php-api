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

## License

Copyright (C) 2012 Lee Machin

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
