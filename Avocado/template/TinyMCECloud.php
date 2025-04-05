<?php

/* 
 * Copyright (C) 2022 Gregor
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/<?PHP /* get key from parameters */ echo parameters('TinyMCEKey')?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    
   // settings: {plugins:"charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview",
   //     toolbar1:"formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_add_media,wp_adv",
   //     toolbar2:"strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
   //     toolbar3:"",
   //     toolbar4:"",
   //     external_plugins:[],
   //     classic_block_editor:true},
tinymce.init({
  selector: 'textarea',
  //height: 500,
  menubar: true,
  //{plugins:"charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,
  //wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview",
  //toolbar1:"formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,
  //wp_more,spellchecker,wp_add_media,wp_adv",toolbar2:"strikethrough,hr,forecolor,pastetext,removeformat,
  //charmap,outdent,indent,undo,redo,wp_help",toolbar3:"",toolbar4:"",external_plugins:[],
  //classic_block_editor:true
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount',
    'code imagetools',
    'charmap colorpicker hr lists media paste tabfocus textcolor fullscreen'
  ],
  //plugins: [],
  toolbar1: "wp_add_media insertfile undo redo | styleselect | strikethrough bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image link,unlink,spellchecker'",
      //toolbar: ['formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,spellchecker'],
        toolbar2: "strikethrough hr forecolor pastetext removeformat charmap fullscreen",
        <?php
        // get fonts from the parameters
        $AvailableFonts = parameters('AvailableFonts');
        $order   = array("\r\n", "\n", "\r");
        $replace = '; ';
        $font_formats = str_replace($order, $replace, $AvailableFonts);
        ?>                 
   font_formats: "<?php echo $font_formats; ?>",
        content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tiny.cloud/css/codepen.min.css'
  ],
  classic_block_editor:true,
    image_list: [
      <?php

$dir = "images/";

// Sort in ascending order - this is default
$files = array_diff(scandir($dir), array('.', '..'));

// Sort in descending order
$b = scandir($dir,1);

// populate the image list
foreach ($files as $key => $value) {
    echo "{title: '" .$value . "', value: 'images/" . $value . "'},\r\n";
}

?>
  
    //{title: 'CrossLarge', value: 'images/CrossLarge.png'},
    //{title: 'My image 2', value: 'http://www.moxiecode.com/my2.gif'}
  ],
   image_uploadtab: true
});
</script>
<!-- /TinyMCE -->
