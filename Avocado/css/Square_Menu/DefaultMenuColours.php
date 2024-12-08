<?php
/*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
/*
    Created on : 08-Feb-2020
    Author     : Gregor
*/
?>
<style>

  <?php $MenuBackgroundColour = validate(parameters('MenuBackgroundColour'),'hd'); ?>
  <?php $MenuItemTextColour = validate(parameters('MenuItemTextColour'),'hd'); ?>
  <?php $MenuBorderColour = validate(parameters('MenuBorderColour'),'hd'); ?>
  <?php $MenuItemBackgroundColour = validate(parameters('MenuItemBackgroundColour'),'hd'); ?>
  <?php $MenuItemBorderColour = validate(parameters('MenuItemBorderColour'),'hd'); ?>
  <?php $MenuItemBackgroundColourHover = validate(parameters('MenuItemBackgroundColourHover'),'hd'); ?>
  <?php $MenuItemTextColourHover = validate(parameters('MenuItemTextColourHover'),'hd'); ?>
  <?php $MenuItemBackgroundColourSelected= validate(parameters('MenuItemBackgroundColourSelected'),'hd'); ?>
  <?php $MenuItemTextColourSelected = validate(parameters('MenuItemTextColourSelected'),'hd'); ?>

/*large screen */
@media only screen and (min-width: 1025px) {
#Menucontainer {
 /* color: #333333;
  background-color: #000000;*/
}

#menu {

    background-image: linear-gradient(to bottom,  <?php echo $MenuBackgroundColour ?> 0%, <?php echo $MenuBackgroundColour ?> 100%);
    border-color: <?php echo $MenuBorderColour; ?>;
}

#menu ul {
}

#menu a, #menu h2 {

    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    border-color: <?php echo $MenuItemBorderColour; ?>;
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColour ?> 0%, <?php echo $MenuItemBackgroundColour ?> 100%);
}

#menu h2 {
    color: <?php echo $MenuItemTextColour ?>;
    background: <?php echo $MenuItemBackgroundColour ?>;
}

#menu a {
    color: <?php echo $MenuItemTextColour ?>;
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColour ?> 0%, <?php echo $MenuItemBackgroundColour ?> 100%);
}

#menu a:hover {
    color: <?php echo $MenuItemTextColourHover ?>;
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColourHover ?> 0%, <?php echo $MenuItemBackgroundColourHover ?> 100%);
}
#menu #selected a {
    color: <?php echo $MenuItemTextColourSelected ?>;;
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColourSelected ?> 0%, <?php echo $MenuItemBackgroundColourSelected ?> 100%);
}

#menu ul ul a {
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColour ?> 0%, <?php echo $MenuItemBackgroundColour ?> 100%);
}

#menu ul ul a:hover {
    color: <?php echo $MenuItemTextColourHover ?>;
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColourHover ?> 0%, <?php echo $MenuItemBackgroundColourHover ?> 100%);
}

#menu ul ul ul {
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColour ?> 0%, <?php echo $MenuItemBackgroundColour ?> 100%);
}

/* hiding the Hovers */

div#menu ul ul,
div#menu ul li:hover ul ul,
div#menu ul ul li:hover ul ul
{background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColourHover ?> 0%, <?php echo $MenuItemBackgroundColourHover ?> 100%);}

div#menu ul li:hover ul,
div#menu ul ul li:hover ul,
div#menu ul ul ul li:hover ul
{background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColourHover ?> 0%, <?php echo $MenuItemBackgroundColourHover ?> 100%);}

}

/*Small screen */

@media only screen and (max-device-width: 1024px) and (orientation: landscape), (max-width: 1025px){
  #menu #selected a {
    color: <?php echo $MenuItemTextColourSelected ?>;;
    background-image: linear-gradient(to bottom, <?php echo $MenuItemBackgroundColourSelected ?> 0%, <?php echo $MenuItemBackgroundColourSelected ?> 100%);
}

h1 {
  font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
  color: <?php echo $MenuItemTextColour ?>;
}

.box {
  background:  <?php echo $MenuBackgroundColour ?>;
  border-color:  <?php echo $MenuBorderColour; ?>;
}

.menuicon_container {
}
.menuicon_menu-Line {
  background-color: <?php echo $MenuItemTextColour ?>;
 }

.menuicon_container:hover {
}

.menucloseicon_container {
}
.menucloseicon_menu-Line1 {
  background-color: <?php echo $MenuItemTextColour ?> ;
 }

 .menucloseicon_menu-Line2 {
  background-color: <?php echo $MenuItemTextColour ?> ;
 }

.button {
  color: <?php echo $MenuItemTextColour ?>;
    border-style: solid;
    border-width: 2px;
    white-space: nowrap;
    border-radius: 50px 0px 0px 50px;
  border-color: <?php echo $MenuBorderColour; ?>;
}
.button:hover {
  color: <?php echo $MenuItemTextColourHover ?>; /*#31708E;*/
}

.Menucontainer {
  background: <?php echo $MenuBackgroundColour ?> ; /*rgba(0, 0, 0, 0.8);*/
}
.Menucontainer:target {
}

#menu {
  background: <?php echo $MenuBackgroundColour ?> ;
}

#menu ul a:hover {
    color: <?php echo $MenuItemTextColourHover ?>;
    background-color: <?php echo $MenuItemBackgroundColourHover ?> ;
}
.collapsibleList label:hover {
  color: <?php echo $MenuItemTextColourHover ?>;
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
    color: <?php echo $MenuItemTextColour ?>;
}

#menu ul{
  background: <?php echo $MenuBackgroundColour ?> ;
}

#menu li{
  background: <?php echo $MenuBackgroundColour ?> ;
  color: <?php echo $MenuItemTextColour ?>;
}

#menu li:hover ~a {
 background-color: <?php echo $MenuItemBackgroundColourHover ?> ;
 color: <?php echo $MenuItemTextColourHover ?>;
}

#menu li li{
  background: <?php echo $MenuBackgroundColour ?> ;
  color: <?php echo $MenuItemTextColour ?>;
}

#menu ul li li a {
    font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
    color: <?php echo $MenuItemTextColour ?>;
}
#menu ul li li a:hover {
    color: <?php echo $MenuItemTextColourHover ?>;
}

#menu h2 {
  color: <?php echo $MenuItemTextColour ?>;
  font-family: <?php echo validate(parameters('MainFont'),'hd'); ?>;
}

#menu .close {
  color: <?php echo $MenuItemTextColour ?>;
  background-color: <?php echo $MenuItemBackgroundColour ?><?php //echo $MenuBackgroundColour ?> ;
}
#menu .close:hover {
  color: <?php echo $MenuItemTextColourHover ?>;
}
#menu .content {
}

.collapsibleList li > input + * {
}

.collapsibleList li:hover ~a ~ul a {
 color: <?php echo $MenuItemTextColourHover ?>;
}
.collapsibleList li > input:checked + * {
}

.collapsibleList li > input {
}

.collapsibleList label {
  color: <?php echo $MenuItemTextColour ?>;
}
.collapsibleList label:hover a{
    color: <?php echo $MenuItemTextColourHover ?>
}
.collapsibleList a:hover {
    color: <?php echo $MenuItemTextColourHover ?>;
}

.collapsibleList li li> input + * {
}

.collapsibleList li li> input:checked + * {
}

.collapsibleList li li> input {
}

}
</style>
