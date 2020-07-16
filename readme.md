# PHP Base64 <img align="right" src="http://r73.cooltext.com/rendered/cooltext-357164423794928.gif" />

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
$base = new Base64();
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
phpbase64 --decode <some text> 

```

### Command Line Example

<p align="center">
<img src="https://camo.githubusercontent.com/29b7009076fa2d81b6dc293793dfdfc1039c9196/687474703a2f2f7777772e696d67696d2e636f6d2f383830696e63696e393933343131332e676966" />
</p>

## License
 
* The MIT License (MIT)
