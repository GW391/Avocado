<?php

/*    function decryptbf($crypttext)
    {

    static $cypher = 'blowfish';
    static $mode   = 'ecb';
    global $DataKey;
   $key = $DataKey;


        $plaintext = "";
        $td        = mcrypt_module_open($cypher, '', $mode, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
        $iv        = 0;
        $crypttext = substr($crypttext, $ivsize);
        if ($iv)
        {
            mcrypt_generic_init($td, $key, $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return $plaintext;
}


//phpinfo();
*/
require 'config.php';
require 'asc_shift.php';
    global $DataKey;
   $key = $DataKey;


$dec = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, "9s7/VdGRYlE=" ,MCRYPT_MODE_ECB);

echo $dec;

//print_r (openssl_get_cipher_methods());
//echo openssl_get_cipher_methods()[61]; // 'bf-ecb'

//decryptbf('9s7/VdGRYlE=');



?>

