﻿<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

header('Content-type: application/javascript');

session_start();

$lang = empty($_SESSION['ckeditor_lang']) ? 'en' : $_SESSION['ckeditor_lang'];
$skin = empty($_SESSION['ckeditor_skin']) ? 'kama' : $_SESSION['ckeditor_skin'];
$height = empty($_SESSION['ckeditor_height']) ? '300' : $_SESSION['ckeditor_height'];
$path = empty($_SESSION['ckeditor_path']) ? '' : $_SESSION['ckeditor_path'];

?>
$(function() {
  
  var options = { language : '<?php echo $lang; ?>', skin : '<?php echo $skin; ?>', height : '<?php echo $height; ?>', baseHref : '<?php echo $path; ?>/', basePath : '<?php echo $path; ?>/mods/ckeditor/' }
  
  $('#content').bind('csAjaxLoad', function() { 
  
    $(this).find('textarea.rte_html').each(function() {
      var instance = CKEDITOR.instances[this.id];
      if(instance) {
          CKEDITOR.remove(instance);
      } 
    }).ckeditor(null, options); 
    
  });
  
  $( 'textarea.rte_html' ).ckeditor(null, options);

});