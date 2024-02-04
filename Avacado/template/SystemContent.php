<?php
if(file_exists("System/" . strtolower($SystemPage) . ".php")){
    require "System/" . strtolower($SystemPage) . ".php";
}else if(file_exists("System/" . $SystemPage . ".php")){
    require "System/" . $SystemPage . ".php";
}
?>
