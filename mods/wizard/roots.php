<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('wizard');

$cs_options = cs_sql_option(__FILE__, 'wizard');

$task_array = [
  0 => [
    'icon' => 'locale',
    'handler' => 'lang',
    'mod' => 'clansphere',
    'action' => 'lang_list',
  ],
  1 => [
    'icon' => 'style',
    'handler' => 'temp',
    'mod' => 'clansphere',
    'action' => 'temp_list',
  ],
  2 => [
    'icon' => 'package_system',
    'handler' => 'opts',
    'mod' => 'clansphere',
    'action' => 'options',
  ],
  3 => [
    'icon' => 'knetconfig',
    'handler' => 'meta',
    'mod' => 'clansphere',
    'action' => 'metatags',
  ],
  4 => [
    'icon' => 'looknfeel',
    'handler' => 'setp',
    'mod' => 'users',
    'action' => 'setup',
  ],
  5 => [
    'icon' => 'personal',
    'handler' => 'prfl',
    'mod' => 'users',
    'action' => 'profile',
  ],
  6 => [
    'icon' => 'kdmconfig',
    'handler' => 'clan',
    'mod' => 'clans',
    'action' => 'create',
  ],
  7 => [
    'icon' => 'kontact',
    'handler' => 'cont',
    'mod' => 'contact',
    'action' => 'imp_edit',
  ],
  8 => [
    'icon' => 'kcmdf',
    'handler' => 'mods',
    'mod' => 'modules',
    'action' => 'roots',
  ],
  9 => [
    'icon' => 'log',
    'handler' => 'logs',
    'mod' => 'logs',
    'action' => 'roots',
  ],
];

$handler = $_GET['handler'] ?? 0;
if(!empty($handler)) {
  foreach($task_array as $step) {

    if($step['handler'] == $handler) {
      
      require_once 'mods/clansphere/func_options.php';
      
      $save = [];
      $save['done_' . $handler] = $_GET['done'] ?? 0;
      
      cs_optionsave('wizard', $save);
      $cs_options['done_' . $handler . ''] = $save['done_' . $handler];
      break;
    }
  }
}

$run = 0;
$done = 0;
$next = 0;
$next_task = '-';
$data = ['head' => [],'wizard' => []];

foreach($task_array AS $step) {
  $data['wizard'][$run]['icon'] = cs_icon($step['icon'], 48);
  $data['wizard'][$run]['link'] = cs_link($cs_lang['' . $step['handler'] . '_name'], $step['mod'], $step['action']);
  $data['wizard'][$run]['text'] = $cs_lang['' . $step['handler'] . '_text'];
  if(empty($cs_options['done_' . $step['handler'] . ''])) {
    $next_task = empty($next) ? cs_link($cs_lang['' . $step['handler'] . '_name'], $step['mod'], $step['action']) : $next_task;
    $data['wizard'][$run]['next'] = empty($next) ? '&gt;&gt; ' . $cs_lang['next_step'] . ' &lt;&lt;' : '';
    $data['wizard'][$run]['done'] = cs_link(cs_icon('cancel'), 'wizard', 'roots', 'handler=' . $step['handler'] . '&amp;done=1');
    $data['wizard'][$run]['class'] = 'b';
    $next++;
  }
  else {
    $data['wizard'][$run]['next'] = '';
    $data['wizard'][$run]['done'] = cs_link(cs_icon('submit'), 'wizard', 'roots', 'handler=' . $step['handler'] . '&amp;done=0');
    $data['wizard'][$run]['class'] = 'c';
    $done++;
  }
  $run++;
}

$data['head']['next_task'] = $cs_lang['next_step'] . ': ' . $next_task;
$data['head']['parts_done'] = sprintf($cs_lang['parts_done'], $done, $run);

echo cs_subtemplate(__FILE__, $data, 'wizard', 'roots');