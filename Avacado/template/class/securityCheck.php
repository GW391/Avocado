<?php

class securityCheck
{

public $output;

public function securityCheck($required_security)
{
    if (isset($_SESSION['securty_array'])){
        // echo "required_security: " . $required_security;
        $security = array_map('strtolower', $_SESSION['securty_array']);
      //   print_r ($security);
        if (in_array(strtolower($required_security), $security, true)){
          //  echo $required_security . ' is in ' . $security;
            $this->output = TRUE;
        }else{
           // echo $required_security . ' is not in ' . $security;
            $this->output =  FALSE;
        }
    }else{
      //  echo 'Session array not set';
        $this->output =  FALSE;
    }
 //   return $this->output;
}
       public function __construct($required_security)
    {
        $this->output = null;
        $this->securityCheck($required_security);
    }
}
