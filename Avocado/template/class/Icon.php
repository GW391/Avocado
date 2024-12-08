
<?php

class Icon
{

public $Icon;

       public function __construct($file)
    {
        $this->Icon="images/icons/" . $file;
        if(file_exists($this->Icon . ".svg")){
            include $this->Icon . ".svg";
        }elseif(file_exists($this->Icon . ".png")){
            $file = ucfirst($file);
            echo '<img src="' . $this->Icon . '.png" alt="' . $file . '" name="' . $file . '" title="' . $file . '">';
        }
            else {
                echo ucfirst($file);
            }
    }
/*        public function __toString()
    {
                include $this->Icon;
        return $this->Icon;

    }*/
}




