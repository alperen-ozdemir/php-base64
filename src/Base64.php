<?php

/**
* PHP Base64 - Pure Base64 Implementation
*
* Implemented according to RFC4648 for documentation
* and more information <https://tools.ietf.org/pdf/rfc4648.pdf>
* 
* @package  base64
* @author   Alperen Özdemir <https://github.com/alperen-ozdemir>
* @version  1.0
*/
    
class Base64 {

    /**
    * Input variable to be base64 encoded.
    * 
    * @var string
    */
    private string $data;

    /**
    * Base64 encoded varible.
    * 
    * @var string
    */
    private string $encoded;

    /**
    * Decoded variable, same as the input after decoding.
    * 
    * @var string
    */
    private string $decoded;

    /**
    * A flag to check if encoding must be in "URL Safe".
    * 
    * @var bool
    */
    private bool $isURL;

    /**
    * Class constructor to set properties and default values.
    * 
    */
    public function __construct() {
        $this->data    = '';
        $this->encoded = '';
        $this->decoded = '';
        $this->isURL   = false;
    }

    /**
    * Table that translates 6-bit positive integer index
    * values into their "Base64 Alphabet" equivalents as
    * specified in RFC 4648.
    * 
    * @var array
    */
    private array $toBase64URL = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
        'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
        'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '+', '/'
    ];

    /**
    * It is the table for "URL and Filename safe Base64" as specified
    * in RFC 4648, with the '+' and '/' changed to '-' and
    * '_'. This table is used when isURL set true.
    */
    private array $toBase64URL = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
        'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
        'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '_'
    ];
        
    /**
    * Standard Base64 encoding function that visible when the object
    * is created. It sets data property and isURL flag false, this settings
    * affects rest of the process such as decoding and findIndex. Calls private
    * main encoding function and returns the related string in Base64 format.
    * 
    * @param data takes plaintext input to be converted.
    * 
    * @return string
    */
    public function base64Encode(string $data): string {
        $this->data  = $data;
        $this->isURL = false;

        return $this->encode();
    }

    /**
    * Base64 "URL Safe" encoding function that visible when the object
    * is created. It sets property data and isURL flag as TRUE. Calls
    * private main encoding function and returns the related string in
    * Base64 format.
    * 
    * @param data takes plaintext input to be converted.
    * 
    * @return string
    */
    public function base64EncodeUrl(string $data): string {
        $this->data  = $data;
        $this->isURL = true;

        return $this->encode($data);
    }

    /**
    * Visible decode function to convert Base64 format string to
    * original plaintext. It calls main decode function and returns
    * plaintext as a string, also sets encoded property with given
    * string parameter.
    * 
    * @param data Base64 encoded string.
    * 
    * @return string
    */
    public function base64Decode(string $data): string {
        $this->encoded = $data;
        return $this->decode();
    }
        
    /**
    * The main encode function takes plaintext data propery
    * and encodes it in Base64 format.
    * 
    * @return string 
    */
    private function encode(): string {
        $tempval = 0;
        $counted = 0;
        $encoded = '';

        $base64Table = $this->isURL ? $this->toBase64URL : $this->toBase64;
        
        while (strlen($this->data) > ($counted + 3)) {
            // Reads three bytes, i.e 24 bits.
            $tempval  = (ord($this->data[$counted++]) & 0xff) << 16;
            $tempval |= (ord($this->data[$counted++]) & 0xff) << 8;
            $tempval |= (ord($this->data[$counted++]) & 0xff);
            
            // Turns the 24 bits into 4 chunks of 6 bits, and then 
            // appends the matching character to encoeded output.
            $encoded .= $base64Table[($tempval & 0x00fc0000) >> 18];
            $encoded .= $base64Table[($tempval & 0x0003f000) >> 12];
            $encoded .= $base64Table[($tempval & 0x00000fc0) >> 6];
            $encoded .= $base64Table[($tempval & 0x0000003f)];
        }
        
        // Adds padding char "=" if necessary.
        if (strlen($this->data) % $counted == 2) {
            $tempval  = (ord($this->data[$counted++]) & 0xff) << 16;
            $tempval |= (ord($this->data[$counted++]) & 0xff) << 8;
                    
            $encoded .= $base64Table[($tempval & 0x00fc0000) >> 18];
            $encoded .= $base64Table[($tempval & 0x0003f000) >> 12];
            $encoded .= ((($tempval & 0x00000fc0) >> 6) == 0x00)   ? '=' : $base64Table[($tempval & 0x00000fc0) >> 6];
            $encoded .= (($tempval & 0x0000003f) == 0x00)          ? '=' : $base64Table[($tempval & 0x0000003f)];
        }   
        else if (strlen($this->data) % $counted == 1) {
            $tempval = (ord($this->data[$counted++]) & 0xff) << 16;
                    
            $encoded .= $base64Table[($tempval & 0x00fc0000) >> 18];
            $encoded .= $base64Table[($tempval & 0x0003f000) >> 12];
            $encoded .= ((($tempval & 0x00000fc0) >> 6) == 0x00)   ? '=' : $base64Table[($tempval & 0x00000fc0) >> 6];
            $encoded .= (($tempval & 0x0000003f) == 0x00)          ? '=' : $base64Table[($tempval & 0x0000003f)];
        }
        
        $this->encoded = $encoded;
        return $encoded;
    }
        
    /**
    * Main decode function. It takes encoded property and
    * reverses encode operations to create plaintext as original
    * format before encoding.
    * 
    * @return string
    */
    private function decode(): string {
        $tempval = 0;
        $decoded = '';
                
        for ($counted = 0; $counted < strlen($this->encoded); $counted += 4) {
            $tempval  = ($this->findIndex($this->encoded[$counted])     & 0xff) << 18;
            $tempval |= ($this->findIndex($this->encoded[$counted + 1]) & 0xff) << 12;
            $tempval |= ($this->findIndex($this->encoded[$counted + 2]) & 0xff) << 6;
            $tempval |= ($this->findIndex($this->encoded[$counted + 3]) & 0xff);
                    
            $decoded .= chr(($tempval & 0x00ff0000) >> 16);
            $decoded .= chr(($tempval & 0x0000ff00) >> 8);
            $decoded .= chr($tempval & 0x000000ff);
        }
                
        if (ord($this->encoded[strlen($this->encoded) - 2]) == 0x3d) {
            $decoded = substr($decoded, 0, strlen($decoded) - 2);
        }
        else if (ord($this->encoded[strlen($this->encoded) - 1]) == 0x3d) {
            $decoded = substr($decoded, 0, strlen($decoded) - 1);
        }
        
        $this->decoded = $decoded;
        return $decoded;
    }
        
    /**
    * Function that detects character position in related
    * Base64 alphabet tables.
    * 
    * @param chr string to find it's index
    * 
    * @return int position, in case of failure returns -1
    */
    private function findIndex(string $chr): int {
        $index = -1;
        $base64Table = $this->isURL ? $this->toBase64URL : $this->toBase64;

        //$counted = 64 stands to break for loop when if condition returns true
        for ($counted = 0; $counted < 64; $counted++) {
            if ($chr === $base64Table[$counted]) {
                $index = $counted;
                $counted = 64;
            }
        }
        
        return $index;
    }
}