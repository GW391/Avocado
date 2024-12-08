<?php

class junkCheck
{

public $output;
public $JunkCheck;
public $Tolerance;
public $count = 0;



public function junkCheck($Check){
    //$count = 0;
    $this->JunkCheck = strtolower(parameters('Junk_Check'));
    $this->Tolerance = strtolower(parameters('Junk_Check_Tolerance'));
    //$JunkCheck = strtolower(parameters('Junk_Check'));
    $JunkCheckArray = explode(PHP_EOL, trim($this->JunkCheck));
    str_replace($JunkCheckArray, ' ', strtolower($Check), $this->count);

    if ($count >= $this->Tolerance){
        $this->output = TRUE;
    }else{
        $this->output = FALSE;
    }
    }
}
