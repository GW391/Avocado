<?php
/*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
/*
    Created on : 08-Feb-2020, 21:44:50
    Author     : Gregor
*/
?>

  <?php $BackgroundColour = validate(parameters('BackgroundColour'),'hd'); //#F7F9FB;?>
  <?php $TextColour = validate(parameters('TextColour'),'hd'); ?>
  <?php $H1TextColour = validate(parameters('H1TextColour'),'hd'); //#000000 ?>
  <?php $AlertTopBackgroundColour = validate(parameters('AlertTopBackgroundColour'),'hd'); //#8FC1E3;?>
  <?php $AlertTopTextColour = validate(parameters('AlertTopTextColour'),'hd'); //#8FC1E3;?>

<style>

/*  set colours & Fonts */
body {
    background-color: <?php echo $BackgroundColour ?>;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

table {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

.header {
            background-color: <?php echo $BackgroundColour ?>;
}
.header h1 {
    font: bold <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: <?php echo $H1TextColour ?>;
}

div#breadcrumbs {
    background-color: RGBA(65, 105, 225, .8);
}

div#maincontent {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    background-color: <?php echo $BackgroundColour ?>;
}

div#footer {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    background-color: <?php echo $BackgroundColour ?>;
    color: <?php echo $TextColour ?>;
}

.loginbox table {
    background-color: <?php echo $BackgroundColour ?>;
    color: #8FC183;
}

div#loginbox {
    background: <?php echo $BackgroundColour ?>;
    border-color: #5085A5;
}

div#loginbox input {
    border-color: #5085A5;
}

div#loginbox input:focus {
  background-color: #8FC1E3;
}

div#editbox input {
border-color: #5085A5;
}
div#editbox option {
border-color: #5085A5;
}
div#editbox input:focus {
  background-color: #8FC1E3;
}
div#editbox input[type=submit]:hover {
  background-color: #8FC1E3;
}
div#editbox textarea {

}
div#edit a {
    border-color: #5085A5;
    background: <?php echo $BackgroundColour ?>;
}
div#edit a:hover {
   background: #8FC1E3;
   border-color: #5085A5;
}

div#editbox textarea:focus {
  background-color: <?php echo $BackgroundColour ?>;
}

p {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: <?php echo $TextColour ?>;
}

li {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: <?php echo $TextColour ?>;
}
ul {
font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
color: <?php echo $TextColour ?>;
}
a:hover span {
background: #5085A5;
color: <?php echo $BackgroundColour ?>;
border-color: #687864;
}
a.link {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #31708E;
}
a.visited {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #8FC1E3;
}
a.hover {
color: <?php echo $BackgroundColour ?>;
}

.small {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #283824;
}
div#small ul li{
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #283824;
}

a.small {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #8FC1E3;
}

p.small {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #283824;
}

h2 {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

div#alerts .txt {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    background-color: <?php echo $AlertTopBackgroundColour ?>;
    color: <?php echo $TextColour ?>;
    border-color: #5085A5;
}

.alerts .top {
    background: <?php echo $AlertTopBackgroundColour ?>;
    color: <?php echo $AlertTopTextColour ?>;
}
.alerts .top a {
    color: <?php echo $BackgroundColour ?>;
}

.alerts .top a:hover {
    color: <?php echo $BackgroundColour ?>;
}

#article{
    background-color: <?php echo $BackgroundColour ?>;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

#articlenarrow{
    background-color: <?php echo $BackgroundColour ?>;
    border-bottom-color: #687864;
}

div#inactive{
        float: left;
    	background-color: #eeeeee;
        color: #3C578C;
        font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
        border-bottom-color: #687864;
}

div#inactivenarrow{
        float: left;
    	background-color: #eeeeee;
        color: #3C578C;
        font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
        border-bottom-color: #687864;
}

#article p{
    background-color: <?php echo $BackgroundColour ?>;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

#article p{
    background-color: <?php echo $BackgroundColour ?>;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

.blur{
    background-color: #ccc;
    color: inherit;
}

.shadow{
	background-color: #777; /*shadow color*/
	color: inherit;
}

.content-lb{
	background-color: <?php echo $BackgroundColour ?>; /*background color of content*/
	color: <?php echo $TextColour ?>; /*text color of content*/
	border-color: #687864; /*border color*/
}
.content-db{
	background-color: <?php echo $BackgroundColour ?>; /*background color of content*/
	color: <?php echo $TextColour ?>; /*text color of content*/
	border-color: #687864; /*border color*/
}

#highlight tr:hover{
	background-color: <?php echo $AlertTopBackgroundColour ?>;
}

.custombutton {

}

img {

}

.container {
  color: <?php echo $BackgroundColour ?>;
  background-color: <?php echo $BackgroundColour ?>;
}

.centered {
  color: rgba(255,255,255,100);
  background: rgba(120,120,120,0.1);
}


        </style>
