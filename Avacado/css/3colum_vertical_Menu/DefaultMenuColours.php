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
/*large screen */
@media only screen and (min-width: 1025px) {
#Menucontainer {
  color: #F7F9FB;
  background-color: #F7F9FB;
}

#menu {
    background-image: linear-gradient(to bottom, #F7F9FB 0%, #F7F9FB 100%);
}

#menu ul {
}

#menu a, #menu h2 {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    border-color: #5085A5;
    background-image: linear-gradient(to bottom, #F7F9FB 0%, #F7F9FB 100%);
}

#menu h2 {
    color: #F7F9FB;
    background: #F7F9FB;
}

#menu a {
    color: #31708E;
    background-image: linear-gradient(to bottom, #F7F9FB 0%, #F7F9FB 100%);
}

#menu a:hover {
    color: #F7F9FB;
    background-image: linear-gradient(to bottom, #31708E 0%, #31708E 100%);
}
#menu #selected a {
    color: #F7F9FB;
    background-image: linear-gradient(to bottom, #687864 0%, #687864 100%);
}

#menu ul ul a {
    background-image: linear-gradient(to bottom, #8FC1E3 0%, #8FC1E3 100%);
}

#menu ul ul a:hover {
    color: #F7F9FB;
    background-image: linear-gradient(to bottom, #31708E 0%, #31708E 100%);
}

#menu ul ul ul {
    background-image: linear-gradient(to bottom, #6941E0 0%, #41B9E0 100%);
}

/* hiding the Hovers */

div#menu ul ul,
div#menu ul li:hover ul ul,
div#menu ul ul li:hover ul ul
{background-image: linear-gradient(to bottom, #F7F9FB 0%, #F7F9FB 100%);}

div#menu ul li:hover ul,
div#menu ul ul li:hover ul,
div#menu ul ul ul li:hover ul
{background-image: linear-gradient(to bottom, #F7F9FB 0%, #F7F9FB 100%);}

}

/*Small screen */

@media only screen and (max-device-width: 1024px) and (orientation: landscape), (max-width: 1025px){
    
h1 {
  font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
  color: #000000; /*#06D85F;*/
}

.box {
  background: #8FC1E3; /*rgba(105,65,224,1);*/
  border-color: #5085A5;
}

.menuicon_container {
}
.menuicon_menu-Line {
  background-color: #F7F9FB;
 }

.menuicon_container:hover {
}

.menucloseicon_container {
}
.menucloseicon_menu-Line1 {
  background-color: #F7F9FB;
 }

 .menucloseicon_menu-Line2 {
  background-color: #F7F9FB;
 }

.button {
  color: #F7F9FB;
  border-color: #5085A5;
}
.button:hover {
  color: #31708E;
}

.Menucontainer {
  background: #F7F9FB; /*rgba(0, 0, 0, 0.8);*/
}
.Menucontainer:target {
}

#menu {
  background: #F7F9FB;
}

.menu ul a:hover {
    color: #F7F9FB;
    background-color: #31708E;
}
.collapsibleList label:hover {
  color: #F7F9FB;
}


@media only screen and (max-device-width: 700px), (max-width: 700px){
  .box{

  }
  .Menucontainer {
  }
}

@media only screen and (max-device-width:900px) and (min-device-width: 700px), (max-width: 900px) and (min-width: 700px){
  .box{
  }
  #menu{
  }
  .Menucontainer {
  }
}

#menu ul a {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #31708E;
}

#menu ul{
  background: #8FC1E3;
}

#menu li{
  background: #8FC1E3;
  color: #31708E;
}

#menu li:hover ~a {
 background-color: #31708E;
 color: #F7F9FB;
}

#menu li li{
  background: #8FC1E3;
  color: #31708E;
}

#menu ul li li a {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: #31708E;
}
#menu ul li li a:hover {
    color: #F7F9FB;
}

#menu h2 {
  color: #F7F9FB;
  font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

#menu .close {
  color: #F7F9FB;
  background-color: #8FC1E3;
}
#menu .close:hover {
  color: #F7F9FB;
}
#menu .content {
}

.collapsibleList li > input + * {
}

.collapsibleList li:hover ~a ~ul a {
 color: #F7F9FB;
}
.collapsibleList li > input:checked + * {
}

.collapsibleList li > input {
}

.collapsibleList label {
  color: #F7F9FB;
}
.collapsibleList label:hover a{
    color: #F7F9FB
}
.collapsibleList a:hover {
    color: #F7F9FB;
}

.collapsibleList li li> input + * {
}
 
.collapsibleList li li> input:checked + * {
}

.collapsibleList li li> input {
}

}
</style>
