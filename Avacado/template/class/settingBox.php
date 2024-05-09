<?php

class settingBox
{

public $Select;
public $From;
public $die = "Sorry there is a problem on this page please, try again later";
public $where;
public $Group = null;
public $Limit = null;
public $sort = null;
public $SettingsBoxResult;
public $outputNumber;
public $result;

public function getData($Select, $From, $where)
{

    $this->SettingsBoxResult = SQL($this->Select, $this->From, $this->die, $this->where, $this->Limit, $this->Group, $this->sort);
  //  $outputNumber = num_rows($SettingsBoxResult);
    $this->result = mysqli_fetch_object($this->SettingsBoxResult);
    $this->outputNumber = $result->number;

}

       public function __construct($Select, $From, $where)
    {
        $this->getData($this->Select, $this->From, $this->where);
    }

}
