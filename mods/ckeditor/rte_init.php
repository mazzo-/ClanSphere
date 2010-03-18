<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

global $account, $cs_main;

if(empty($account['access_ckeditor']))
  $cs_main['rte_html'] = '';
else {

  # set access for uploads
  $_SESSION['access_ckeditor'] = empty($account['access_ckeditor']) ? 0 : $account['access_ckeditor'];

  cs_scriptload('ckeditor', 'javascript', 'ckeditor.js');

  function cs_rte_html($name, $value = '') {

    # handle abcode html tag behavior
    $value = cs_abcode_inhtml($value, 'del');

    global $cs_main;
    $data = array('ckeditor');
    $data['ckeditor'] = cs_sql_option(__FILE__,'ckeditor');
    $data['ckeditor']['skin'] = empty($data['ckeditor']['skin']) ? 'kama' : $data['ckeditor']['skin'];
    $data['ckeditor']['height'] = empty($data['ckeditor']['height']) ? '300' : $data['ckeditor']['height'];
    $data['ckeditor']['path'] = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
    $data['ckeditor']['name'] = $name;
    $data['ckeditor']['value'] = htmlentities($value, ENT_QUOTES, $cs_main['charset']);

    return cs_subtemplate(__FILE__, $data, 'ckeditor', 'rte_html');
  }
}