<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$opt_array = [
  $cs_lang['profile'] => [
    'file' => 'profile',
    'icon' => 'personal',
    'name' => $cs_lang['profile'],
    'show' => ['users/settings' => 1],
  ],
  $cs_lang['picture'] => [
    'file' => 'picture',
    'icon' => 'camera_unmount',
    'name' => $cs_lang['picture'],
    'show' => ['users/settings' => 1],
  ],
  $cs_lang['password'] => [
    'file' => 'password',
    'icon' => 'password',
    'name' => $cs_lang['password'],
    'show' => ['users/settings' => 1],
  ],
  $cs_lang['setup'] => [
    'file' => 'setup',
    'icon' => 'looknfeel',
    'name' => $cs_lang['setup'],
    'show' => ['users/settings' => 1],
  ],
  $cs_lang['close'] => [
    'file' => 'close',
    'icon' => 'gpg',
    'name' => $cs_lang['close'],
    'show' => ['users/settings' => 1],
  ],
  $cs_lang['avatar'] => [
    'dir' => 'board',
    'file' => 'avatar',
    'icon' => 'babelfish',
    'name' => $cs_lang['avatar'],
    'show' => ['users/settings' => 1],
  ],
  $cs_lang['signature'] => [
    'dir' => 'board',
    'file' => 'signature',
    'icon' => 'colors',
    'name' => $cs_lang['signature'],
    'show' => ['users/settings' => 1],
  ], ];

$mod_array = cs_checkdirs('mods', 'users/settings');
$settings = array_merge($opt_array, $mod_array);
ksort($settings);

foreach($settings as $mod) {
  if(!array_key_exists('dir', $mod)) $mod['dir'] = 'users';
  if(!array_key_exists('file', $mod)) $mod['file'] = 'center';
  $acc_dir = 'access_' . $mod['dir'];
  
  if(array_key_exists($acc_dir, $account) AND $account[$acc_dir] >= $mod['show']['users/settings']) {
    echo cs_icon($mod['icon']);
    echo cs_link($mod['name'], $mod['dir'], $mod['file']);
    echo cs_html_br(1);
  }
}