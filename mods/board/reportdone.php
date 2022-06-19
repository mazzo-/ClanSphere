<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('board');

$report_id = $_GET['id'];

$report_cells = ['boardreport_done'];
$report_save = [1];
cs_sql_update(__FILE__, 'boardreport', $report_cells, $report_save, $report_id);

cs_cache_delete('count_boardreport');

cs_redirect($cs_lang['done_true'], 'board', 'reportlist');