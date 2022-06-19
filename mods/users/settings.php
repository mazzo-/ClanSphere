<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('users');

$head = ['mod' => $cs_lang['mod_name'], 'action' => $cs_lang['settings'], 'topline' => $cs_lang['settings_info'], 'message' => cs_getmsg()];

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

require_once('mods/clansphere/functions.php');
echo cs_manage('users', 'settings', 'users', 'center', $opt_array, $head);