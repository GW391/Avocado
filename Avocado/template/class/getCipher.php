<?php
class getCipher
{
    private $cipherString;
    public function __construct()
    {
        //old $cipherString BF-ECB
        $this->cipherString = "AES-256-CTR";
        //   return $this.ciphering;
    }
    public function __toString()
    {
        return trim($this->cipherString);
    }
}
