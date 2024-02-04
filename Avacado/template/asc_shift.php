<?php

// To detect if functions are availble to page
$shiftloaded = True;

function getCipher(){
//old $ciphering BF-ECB
   if (!isset($ciphering)){
      $ciphering = "AES-256-CTR";
   }
   return $ciphering;
}

// Encrypt Data for saving
function encrypt($value){
   if(!$value){return false;}
      // Store the cipher method
$ciphering = getCipher();
   global $DataKey;
   $key = $DataKey;
   $text = $value;
   //OPENSSL -- New encryption
   $blockSize = 8;
    $len = strlen($value);
    $paddingLen = intval(($len + $blockSize - 1) / $blockSize) * $blockSize - $len;
    $padding = str_repeat("\0", $paddingLen);
    $text = $value . $padding;
    // old encryption - no longer used for any encryption
   // $crypttext = openssl_encrypt($text, 'BF-ECB', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);

    // new encryption
    $iv = openssl_random_pseudo_bytes(16);
   $crypttext = openssl_encrypt($text, $ciphering, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
   //TODO: Get '00' below from paramters for key to use
   return trim(base64_encode(date('y') . '00' .$iv . $crypttext)); //encode for cookie
}

// Decrypt Saved Data
function decrypt($value){
   if(!$value){return false;}
      // Store the cipher method
$ciphering = getCipher();
   global $DataKey;
   $key = $DataKey;
   $crypttext = base64_decode($value); //decode cookie
   //OpenSSL -- New Decryption
   if(intval(substr($crypttext,0,2) < 23)){
      // 23 or above not found, use old encryption
   global $DataKey;
   $key = $DataKey;
   $decrypttext = openssl_decrypt($crypttext, 'BF-ECB', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
   }else{
      // which key has been used in the encryption
      // 0 = the orignial key, has no number.
      if(intval(substr($crypttext,2,2)) == 0){
            global $DataKey;
            $key = $DataKey;
      }else{
         global ${'DataKey' . intval(substr($crypttext,2,2))};
         $key =  ${'DataKey' . intval(substr($crypttext,2,2))};
      }}
   $iv = substr($crypttext,4,16);
   $crypttext = substr($crypttext,20);
   $decrypttext = openssl_decrypt($crypttext, $ciphering, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
   return trim($decrypttext);
}

//Encrypt data for passing front end data
function encryptfe($value){

   // Store the cipher method
$ciphering = getCipher();

   if(!$value){return false;}
   global $PostKey;
   $key = $PostKey;
   $text = $value;
   $iv = openssl_random_pseudo_bytes(16);
   $blockSize = 8;
   $paddingLen= 0;
   // echo $value;
   $len = strlen($value);
   $paddingLen = intval(($len + $blockSize - 1) / $blockSize) * $blockSize - $len;
   $padding = str_repeat("\0", $paddingLen);
 //   echo $padding;
   $data = $value . $padding;
//    echo $data;
   $crypttext = openssl_encrypt($data, $ciphering, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
   return trim(base64_encode($iv . $crypttext)); //encode for cookie
}

//Decrypt data passed in font end
function decryptfe($value){
   if(!$value){return false;}
   $ciphering = getCipher();

   global $PostKey;
   $key = $PostKey;
   $crypttext = base64_decode($value); //decode cookie
   $iv = substr($crypttext,0,16);
   $crypttext = substr($crypttext,16);
   $decrypttext = openssl_decrypt($crypttext, $ciphering, $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
   return trim($decrypttext);
}
?>
