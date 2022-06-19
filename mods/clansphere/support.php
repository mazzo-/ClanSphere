<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('clansphere');

$data = [];

$data['support'] = [
  0 => [
    'url' => 'board.clansphere.net',
    'name' => $cs_lang['name_board'],
    'text' => $cs_lang['text_board'],
  ],
  1 => [
    'url' => 'bugs.clansphere.net',
    'name' => $cs_lang['name_bugs'],
    'text' => $cs_lang['text_bugs'],
  ],
  2 => [
    'url' => 'contact.clansphere.net',
    'name' => $cs_lang['name_contact'],
    'text' => $cs_lang['text_contact'],
  ],
  3 => [
    'url' => 'design.clansphere.net',
    'name' => $cs_lang['name_design'],
    'text' => $cs_lang['text_design'],
  ],
  4 => [
    'url' => 'lang.clansphere.net',
    'name' => $cs_lang['name_lang'],
    'text' => $cs_lang['text_lang'],
  ],
  5 => [
    'url' => 'mods.clansphere.net',
    'name' => $cs_lang['name_mods'],
    'text' => $cs_lang['text_mods'],
  ],
  6 => [
    'url' => 'vcs.clansphere.net',
    'name' => $cs_lang['name_vcs'],
    'text' => $cs_lang['text_vcs'],
  ],
  7 => [
    'url' => 'wiki.clansphere.net',
    'name' => $cs_lang['name_wiki'],
    'text' => $cs_lang['text_wiki'],
  ],
];

echo cs_subtemplate(__FILE__, $data, 'clansphere', 'support');