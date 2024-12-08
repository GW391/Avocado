<?php

// Decrypt Saved Data
class Decrypt{

    private $value;         // input text for Decryption
    private $key;           // encryption key, pulled from global data DataKey
    private $iv;
    private $text;
    private $cipherString;
    private $encryptedText;
    private $decryptedOutput;   // final decrypted data for output

    // Encrypt Data for saving
public function  __construct($value)
{
   if(!$value){return false;}
      // Store the cipher method
    $this->cipherString = new getCipher();
    $this->encryptedText = base64_decode($value); //decode string

   //OpenSSL -- New Decryption

    $isnew = intval(substr($this->encryptedText,0,2));
 //   echo $isnew;
//    are we using the new encryption method
   if($isnew < 23){
   echo "23 or above not found, use old encryption";
 //  global $DataKey;
 //  $this->key = $DataKey;
   $this->encryptedText = openssl_decrypt($this->encryptedText, 'BF-ECB', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
   }else{
      // which key has been used in the encryption
      // 0 = the orignial key, has no number.
      if(intval(substr($this->encryptedText,2,2)) == 0){
         // echo 'we have 0';
            global $DataKey;
            $this->key = $DataKey;
      }else{
         global ${'DataKey' . intval(substr($this->encryptedText,2,2))};
         $this->key = ${'DataKey' . intval(substr($this->encryptedText,2,2))};
      }
   $this->iv = substr($this->encryptedText,4,16);
   /*echo*/ $this->iv;
   /*echo*/ $this->encryptedText = trim(substr($this->encryptedText,20));
  /* echo */ $this->decryptedOutput = openssl_decrypt($this->encryptedText, $this->cipherString, $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
   }
}
       public function __toString()
    {
        return trim($this->decryptedOutput);
    }
}
