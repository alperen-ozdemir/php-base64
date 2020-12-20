# PHP Base64 <img align="right" src="https://i.ibb.co/4Y5w7p6/cooltext369494488482539.gif" />

> PHP Base64 - Pure Base64 Algorithm Implementation

Implemented according to RFC4648, for documentation
and more information visit <https://tools.ietf.org/pdf/rfc4648.pdf>

## Installation

Click the `download` link above or `git clone git://github.com/alperen-ozdemir/php-base64.git`

## Usage

### Initialization

Simply require and initialize the `Base64` class like so:
```php
require_once 'Base64.php';
$base64 = new Base64();
```
### Examples
```php
$base64->base64Encode("This is going to be encoded in Base64";
$base64->base64EncodeUrl("https://github.com/alperen-ozdemir/php-base64";
$base64->base64EncodeUrl("SSBsb3ZlIGN1cmlvc2l0eS4=");
```

## Command Line Usage
It is available if you have PHP installed as a command line tool.
Locate diretory where /bin/phpbase64 and execute via command line.
```sh
$ phpbase64 --help

Usage:                                                                           
phpbase64 --encode <some text>                                                  
phpbase64 --encode-url <some text>                                               
phpbase64 --decode <some base64> 

```

## License
 
* The MIT License (MIT)
