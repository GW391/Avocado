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
<style>

/*  set colours & Fonts */
body {
    background-color: #F7F9FB;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

table {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

.header {
            background-color: #F7F9FB;
}
.header h1 {
    font: bold <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #31708E;
}

div#breadcrumbs {
    background-color: RGBA(65, 105, 225, .8);
}

div#maincontent {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    background-color: #F7F9FB;
}

div#footer {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    background-color: #F7F9FB;
    color: #000000;
}

.loginbox table {
    background-color: #F7F9FB;
    color: #8FC183;
}

div#loginbox {
    background: #F7F9FB;
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
    background: #F7F9FB;
}
div#edit a:hover {
   background: #8FC1E3;
   border-color: #5085A5;
}

div#editbox textarea:focus {
  background-color: #F7F9FB;
}

p {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #000000;
}

li {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #000000;
}
ul {
font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
color: #000000;
}
a:hover span {
background: #5085A5;
color: #F7F9FB;
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
color: #F7F9FB;
}

.small {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #687864;
}

a.small {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #8FC1E3;
}

p.small {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #687864;
}

h2 {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

div#alerts .txt {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    background-color: #8FC1E3;
    color: #000000;
    border-color: #5085A5;
}

.alerts .top {
    background: #8FC1E3;
    color: #000000;
}
.alerts .top a {
    color: #F7F9FB;
}

.alerts .top a:hover {
    color: #F7F9FB;
}

#article{
    background-color: #F7F9FB;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

#articlenarrow{
    background-color: #F7F9FB;
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
    background-color: #F7F9FB;
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

#article p{
    background-color: #F7F9FB;
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
	background-color: #F7F9FB; /*background color of content*/
	color: #000; /*text color of content*/
	border-color: #687864; /*border color*/
}
.content-db{
	background-color: #F7F9FB; /*background color of content*/
	color: #000; /*text color of content*/
	border-color: #687864; /*border color*/
}

#highlight tr:hover{
	background-color: #8FC1E3;
}

.custombutton {
    
}

img {
    
}

.container {
  color: #F7F9FB;
  background-color: #F7F9FB;
}

.centered {
  color: rgba(255,255,255,100);
  background: rgba(120,120,120,0.1);
}


        </style>
