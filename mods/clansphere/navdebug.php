<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

$nav_array = array('----',
  'articles/navlist',
  'banners/navlist',
  'banners/navright',
  'banners/rotation',
  'board/navlist',
  'board/navtop',
  'buddys/navlist',
  'count/navall',
  'count/navday',
  'count/navmon',
  'count/navone',
  'count/navusr',
  'count/navyes',
  'cups/navlist',
  'events/navcal',
  'events/navnext',
  'gallery/navlist',
  'files/navlist',
  'files/navtop',
  'gallery/navlist',
  'members/navrand',
  'news/navlist',
  'search/navlist',
  'servers/navlist',
  'shoutbox/navlist',
  'users/navbirth',
  'users/navlast',
  'users/navonline',
  'votes/navlist',
  'wars/navlist',
  'wars/navlist2',
  'wars/navnext'
);

$cs_lang = cs_translate('clansphere');

if(isset($_REQUEST['debug_navfile']))
  $_SESSION['debug_navfile'] = (int) $_REQUEST['debug_navfile'];

if(empty($_SESSION['debug_navfile'])) {

  $data = array();

  foreach($nav_array AS $num => $value) {
    $data['navfiles'][$num]['value'] = $value;
    $data['navfiles'][$num]['num'] = $num;
  }

  echo cs_subtemplate(__FILE__,$data,'clansphere','navdebug');
}
else {

  $nav_file = $nav_array[$_SESSION['debug_navfile']];
  $remove = cs_link($cs_lang['remove'], $cs_main['def_mod'], $cs_main['def_action'], 'debug_navfile=0');
  echo $nav_file . ' [ ' . $remove . ' ]' . cs_html_br(2);
  include 'mods/' . $nav_file . '.php';
}