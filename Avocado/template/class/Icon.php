
<?php


// class to load icons
class Icon
{

public $Icon;

       public function __construct($file)
    {
        $this->Icon="images/icons/" . $file;
        // check to see if file is an svg file
        if(file_exists($this->Icon . ".svg")){
            // embed svg into page
            include $this->Icon . ".svg";
        }elseif(file_exists($this->Icon . ".png")){ // check if file is PNG
            $file = ucfirst($file);
            // add icon as an image in the page
            echo '<img src="' . $this->Icon . '.png" alt="' . $file . '" name="' . $file . '" title="' . $file . '">';
        }
            else {
                echo ucfirst($file);
            }
    }
 // TODO: update to check for jpg, gif, and other image formats
 // TODO: update to check for icon inside skin folder
}




