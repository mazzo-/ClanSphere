<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$head = ['mod' => 'ClanSphere', 'action' => $cs_lang['head_system'], 'topline' => $cs_lang['body_system']];

$sys_array = [
  $cs_lang['software'] => [
    'file' => 'software',
    'icon' => 'kpackage',
    'name' => $cs_lang['software'],
    'show' => ['clansphere/system' => 5],
  ],$cs_lang['languages'] => [
    'file' => 'lang_list',
    'icon' => 'locale',
    'name' => $cs_lang['languages'],
    'show' => ['clansphere/system' => 4],
  ], $cs_lang['templates'] => [
    'file' => 'temp_list',
    'icon' => 'style',
    'name' => $cs_lang['templates'],
    'show' => ['clansphere/system' => 4],
  ], $cs_lang['themes'] => [
    'file' => 'themes_list',
    'icon' => 'kllckety',
    'name' => $cs_lang['themes'],
    'show' => ['clansphere/system' => 5],
  ], $cs_lang['storage'] => [
    'file' => 'storage',
    'icon' => 'hdd_unmount',
    'name' => $cs_lang['storage'],
    'show' => ['clansphere/system' => 5],
  ], $cs_lang['variables'] => [
    'file' => 'variables',
    'icon' => 'kdvi',
    'name' => $cs_lang['variables'],
    'show' => ['clansphere/system' => 5],
  ], $cs_lang['metatags'] => [
    'file' => 'metatags',
    'icon' => 'knetconfig',
    'name' => $cs_lang['metatags'],
    'show' => ['clansphere/system' => 5],
  ], $cs_lang['cache'] => [
    'file' => 'cache',
    'icon' => 'ark',
    'name' => $cs_lang['cache'],
    'show' => ['clansphere/system' => 4],
  ], $cs_lang['version'] => [
    'file' => 'version',
    'icon' => 'agt_update-product',
    'name' => $cs_lang['version'],
    'show' => ['clansphere/system' => 5],
  ], $cs_lang['support'] => [
    'file' => 'support',
    'icon' => 'krdc',
    'name' => $cs_lang['support'],
    'show' => ['clansphere/system' => 4],
  ], $cs_lang['charset'] => [
    'file' => 'charset',
    'icon' => 'txt',
    'name' => $cs_lang['charset'],
    'show' => ['clansphere/system' => 5],
  ],
];

require_once('mods/clansphere/functions.php');

echo cs_manage('clansphere', 'system', 'clansphere', 'roots', $sys_array, $head);