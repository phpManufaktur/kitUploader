<?php

/**
 * kitUploader
 *
 * @author Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @link http://phpmanufaktur.de
 * @copyright 2011 - 2012
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {
  if (defined('LEPTON_VERSION')) include (WB_PATH . '/framework/class.secure.php');
}
else {
  $oneback = "../";
  $root = $oneback;
  $level = 1;
  while (($level < 10) && (!file_exists($root . '/framework/class.secure.php'))) {
    $root .= $oneback;
    $level += 1;
  }
  if (file_exists($root . '/framework/class.secure.php')) {
    include ($root . '/framework/class.secure.php');
  }
  else {
    trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
  }
}
// end include class.secure.php

$module_directory     = 'kit_uploader';
$module_name          = 'kitUploader';
$module_function      = (defined('LEPTON_VERSION')) ? 'library' : 'snippet';
$module_version       = '0.11';
$module_status        = 'Stable';
$module_platform      = '2.8';
$lepton_platform      = '1.x';
$module_author        = 'Ralf Hertsch, Berlin (Germany)';
$module_license       = 'MIT License (MIT)';
$module_description   = 'Upload progress for KIT extensions';
$module_home          = 'http://phpmanufaktur.de';
$module_guid          = '33A39E3B-79D1-48EF-9ADD-6D028B5E9DB4';

?>