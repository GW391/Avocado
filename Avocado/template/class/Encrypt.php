<?php
class Encrypt
{
    private $value;         // input text for encryption
    private $key;           // encryption key, pulled from global data DataKey
    private $blockSize = 8; // set block size of 8
    private $valueLength;   // hold legth of text for encryption
    private $encryptedOutput;   // final encrypted data for output
    private $padding;           //
    private $paddingLenth;
    private $iv;
    private $text;
    private $cipherString;
    private $encryptedText;

    // Encrypt Data for saving
public function  __construct($value){
   if(!$value){return false;}
    // Store the cipher method
    $this->cipherString = new getCipher();
    //TODO get key from papameters
    global $DataKey;
    $this->key = $DataKey;
    $this->iv = openssl_random_pseudo_bytes(16);
   // echo $this->iv;
   //OPENSSL -- New encryption
    $this->valueLength = strlen($value);
    $this->paddingLength = intval(($this->valueLength + $this->blockSize - 1) / $this->blockSize) * $this->blockSize - $this->valueLength;
    $this->padding = str_repeat("\0", $this->paddingLength);
    $this->text = trim($value); // . $this->padding;
    // old encryption - no longer used for any encryption
   // $crypttext = openssl_encrypt($text, 'BF-ECB', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);

    // new encryption
   $this->encryptedText = openssl_encrypt($this->text, $this->cipherString, $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
   //TODO: Get '00' below from paramters for key to use to enable key rotation
   $this->encryptedOutput = trim(base64_encode(date('y') . '00' . $this->iv . $this->encryptedText)); //encode for cookie
}

    public function __toString()
    {
        return trim($this->encryptedOutput);
    }
}
