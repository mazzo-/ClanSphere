<?php
// ClanSphere 2009 - www.clansphere.net
// $Id$

function cs_error($file, $message, $log_only = 0) {

  global $cs_logs;
  if(!empty($cs_logs['save_errors'])) {
    $log = $file . "\n" . $message . "\n";
    $log .= isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] . "\n" : "unknown\n";
    $log .= isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] . "\n" : "unknown\n";
    $log .= isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] . "\n" : "unknown\n";
    $log .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] . "\n" : "unknown\n";
    cs_log('errors',$log);
  }
  if(empty($log_only))
    $cs_logs['errors'] .= 'Error: ' . $file . ' -> ' . $message . "\n";
}

function cs_error_internal($error = 0, $report = 0) {

  global $account, $com_lang, $cs_db, $cs_main, $cs_micro;

  $cs_main['error_internal'] = $error;
  $cs_main['error_reported'] = $report;
  $cs_main['def_title'] = 'ClanSphere';
  $cs_main['def_lang'] = empty($cs_main['def_lang']) ? 'English' : $cs_main['def_lang'];
  $cs_main['def_tpl'] = 'install';
  $cs_main['mod'] = 'errors';
  $cs_main['action'] = '500';
  $cs_main['show'] = 'mods/errors/500.php';
  $cs_main['public'] = 1;
  $cs_main['def_theme'] = 'base';
  $cs_main['cellspacing'] = 1;
  $cs_main['def_width'] = '100%';

  if(empty($account['users_lang']))
    $account = array('users_id' => 0, 'access_clansphere' => 0, 'access_errors' => 0, 'users_lang' => $cs_main['def_lang']);

  if(!empty($cs_main['init_mod'])) {
    chdir('../../');
    $cs_main['php_self']['dirname'] .= '../../';
  }

  echo cs_template($cs_micro, 'error.htm');
}

function cs_error_sql($cs_file,$part,$message,$stop = 0) {

  global $cs_db;
  if(empty($message)) {
    $message = 'Database connection error';
  }
  $cs_db['last_error'] = $part . ' - ' . $message;
  cs_error($cs_file,$cs_db['last_error']);

  if(!empty($stop)) {
    die(cs_error_internal('sql', $message));
  }
}

function cs_init($predefined) {

  $phpversion = phpversion();
  if(version_compare($phpversion, '5.0', '>=') && version_compare($phpversion, '6.0', '<'))
    @error_reporting(E_ALL | E_STRICT);
  else
    @error_reporting(E_ALL);

  @set_error_handler("php_error");

  @ini_set('short_open_tag','off');
  @ini_set('arg_separator.output','&amp;');
  @ini_set('session.use_trans_sid','0');
  @ini_set('session.use_cookies','1');
  @ini_set('session.use_only_cookies','1');
  @ini_set('display_errors','on');
  @ini_set('magic_quotes_runtime','off');

  if(version_compare($phpversion, '5.1', '>='))
    @date_default_timezone_set('Europe/Berlin');

  global $account, $com_lang, $cs_db, $cs_logs, $cs_main, $cs_micro;

  $cs_micro = explode(' ', microtime()); # starting parsetime
  $cs_logs = array('php_errors' => '', 'errors' => '', 'sql' => '', 'queries' => 0, 'warnings' => 1, 'dir' => 'uploads/logs');

  require_once 'system/core/servervars.php';
  require_once 'system/core/tools.php';
  require_once 'system/core/abcode.php';
  require_once 'system/core/cachegen.php';
  require_once 'system/core/templates.php';
  require_once 'system/core/gd.php';

  if ($cs_main['php_self']['basename'] != 'install.php')
    file_exists('setup.php') ? require_once 'setup.php' : die(cs_error_internal('setup', '<a href="install.php">Installation</a>'));

  if(empty($cs_main['charset'])) {
    $cs_main['charset'] = 'UTF-8';
    die(cs_error_internal(0,'No charset information found in setup.php'));
  }

  require_once 'system/output/xhtml_10.php';
  if(!empty($cs_main['xhtml_old']))
    require_once 'system/output/xhtml_10_old.php';

  if(!empty($predefined['init_sql'])) {

    require_once 'system/database/' . $cs_db['type'] . '.php';

    $cs_db['con'] = cs_sql_connect($cs_db);
    unset($cs_db['pwd'], $cs_db['user']);

    $cs_options = cs_sql_option(__FILE__,'clansphere');
    
    $cs_options['unicode'] = extension_loaded('unicode') ? 1 : 0;
    if(!isset($cs_options['cache_unicode']) OR $cs_options['cache_unicode'] != $cs_options['unicode'])
      cs_cache_clear();
  }
  else
    $cs_options = array();

  $cs_main = array_merge($cs_main, $cs_options, $predefined);

  if(empty($cs_main['def_path']))
    $cs_main['def_path'] = getcwd();

  $cs_main['template'] = empty($cs_main['def_tpl']) ? 'clansphere' : $cs_main['def_tpl'];
  if(!empty($_GET['template']) AND preg_match("=^[_a-z0-9-]+$=i",$_GET['template']))
    $cs_main['template'] = $_GET['template'];

  if(!empty($_GET['mod'])) {
    $cs_main['mod'] = $_GET['mod'];
    $cs_main['action'] = empty($_GET['action']) ? 'list' : $_GET['action'];  
  }
  else {
    $cs_main['mod'] = $cs_main['def_mod'];
    $cs_main['action'] = $cs_main['def_action'];

    $parameters_split = empty($cs_main['def_parameters']) ? array() : explode('&', $cs_main['def_parameters']);

    foreach($parameters_split AS $parameter) {
      if(empty($parameter))
        break;
      $par_array = explode('=',$parameter);
      $_GET[$par_array[0]] = empty($_GET[$par_array[0]]) ? $par_array[1] : $_GET[$par_array[0]];
    }
  }

  if(!preg_match("=^[_a-z0-9-]+$=i",$cs_main['mod']) OR !preg_match("=^[_a-z0-9-]+$=i",$cs_main['action'])) {
    $cs_main['mod'] = 'errors';
    $cs_main['action'] = '404';
  }

  $cs_main['show'] = 'mods/' . $cs_main['mod'] . '/' . $cs_main['action'] . '.php';

  if(!empty($predefined['init_sql'])) {

    require_once 'system/core/account.php';

    # load startup files
    $startup = cs_cache_load('startup');
    if(is_array($startup)) {
      foreach($startup AS $sup) {
        $file = $cs_main['def_path'] . '/mods/' . $sup . '/startup.php';
        file_exists($file) ? include_once $file : cs_error($file, 'cs_init - Startup file not found');
      }
    }
  }

  if(!empty($predefined['init_tpl']))
    echo cs_template($cs_micro, $predefined['tpl_file']);
}

// Array walking with referenced altering
function cs_int_walk(&$item, $key) {
    $item = (int)$item;
}
  
function cs_log($target,$content) {

  global $cs_logs, $cs_main;
  $full_path = $cs_logs['dir'] . '/' . $target;
  if(is_writeable($full_path . '/')) {
    $log = "-------- \n" . date('H:i:s') . "\n" . $content;
    $log_file = $full_path . '/' . date('Y-m-d') . '.log';
    $save_error = fopen($log_file,'a');
    # set stream encoding if possible to avoid converting issues
    if(function_exists('stream_encoding'))
      stream_encoding($save_error, $cs_main['charset']);
    fwrite($save_error,$log);
    fclose($save_error);
    chmod($log_file,0644);
  }
  else {
    $msg = 'cs_log - Unable to write into directory -> ' . $full_path;
    $cs_logs['errors'] .= $msg . "\n";
  }
}

function cs_log_sql($file, $sql, $action = 0) {

  global $cs_logs, $account;
  $cs_logs['queries']++;
  $new = $cs_logs['queries'] . ') ' . $sql . "\n";
  $cs_logs['sql'][$file] = isset($cs_logs['sql'][$file]) ? $cs_logs['sql'][$file] . $new : $new;

  if(!empty($action) AND !empty($cs_logs['save_actions'])) {
    $log = 'USERS_ID ' . $account['users_id'] . "\n" . $sql . "\n";
    cs_log('actions',$log);
  }
}

function cs_warning($message) {

  global $cs_logs;
  static $last_warning = array();
  if(!empty($cs_logs['warnings']) AND !isset($last_warning[$message])) {
    $cs_logs['errors'] .= 'Warning: ' . $message . "\n";
    $last_warning[$message] = 1;
  }
}

function cs_parsetime($micro, $precision = 3) {

  $new_time = explode(' ', microtime());
  $getparse = $new_time[1] + $new_time[0] - $micro[0] - $micro[1];
  $getparse = round($getparse,$precision) * 1000;
  return $getparse;
}

function cs_time() {

  $time = time() - date('Z');
  return $time;
}

function cs_getip () {

  if (getenv('HTTP_CLIENT_IP'))
    $ip = getenv('HTTP_CLIENT_IP');
  elseif (getenv('HTTP_X_FORWARDED_FOR'))
    $ip = getenv('HTTP_X_FORWARDED_FOR');
  elseif (getenv('HTTP_X_FORWARDED'))
    $ip = getenv('HTTP_X_FORWARDED');
  elseif (getenv('HTTP_FORWARDED_FOR'))
    $ip = getenv('HTTP_FORWARDED_FOR');
  elseif (getenv('HTTP_FORWARDED'))
    $ip = getenv('HTTP_FORWARDED');
  else
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
  return $ip;
}

// Log_error
function php_error($errno, $errmsg, $filename, $linenum) {
 
  global $cs_logs, $cs_main;
 
  $errortype = Array(
    E_ERROR    => 'Error',
    E_WARNING   => 'Warning',
    E_PARSE    => 'Parsing Error',
    E_NOTICE   => 'Notice',
    E_CORE_ERROR  => 'Core Error',
    E_CORE_WARNING  => 'Core Warning',
    E_COMPILE_ERROR  => 'Compile Error',
    E_COMPILE_WARNING => 'Compile Warning',
    E_USER_ERROR  => 'User Error',
    E_USER_WARNING  => 'User Warning',
    E_USER_NOTICE  => 'User Notice',
  );

  // Added E_Strict for PHP 5 Version
  if(substr(phpversion(), 0, 3) >= '5.0')
    $errortype['2048'] = 'Strict Notice/Error';
  
  // Added E_RECOVERABLE_ERROR for PHP 5.2.0 Version
  if (substr(phpversion(), 0, 3) >= '5.2')
    $errortype['4096'] = 'Recoverable Error';
    
  // Added E_DEPRECATED & E_USER_DEPRECATED for PHP 5.3.0 Version
  if (substr(phpversion(), 0, 3) >= '5.3') {
    $errortype['8192'] = 'Deprecate Notice';
    $errortype['16384'] = 'User Deprecated Warning';
  }

  $error = $errortype[$errno] . ": " . $errmsg . " in " . $filename . " on line " . $linenum . "\r\n";
  $cs_logs['php_errors'] = empty($cs_logs['php_errors']) ? '' : $cs_logs['php_errors'];
  $cs_logs['php_errors'] .= '<strong>PHP-Warning:</strong> ' . $error . "<br />";
  cs_error($filename, 'PHP ' . $errortype[$errno] . ' on line ' . $linenum . ' -> ' . trim($errmsg), 1);
}