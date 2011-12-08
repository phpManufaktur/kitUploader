<?php

/**
 * kitDirList
 *
 * @author Ralf Hertsch (ralf.hertsch@phpmanufaktur.de)
 * @link http://phpmanufaktur.de
 * @copyright 2011
 * @license GNU GPL (http://www.gnu.org/licenses/gpl.html)
 * @version $Id$
 *
 * FOR VERSION- AND RELEASE NOTES PLEASE LOOK AT INFO.TXT!
 */

// Include config file

$config_path = '../../../../config.php';
if (!file_exists($config_path)) {
    die('Missing Configuration File...');
}
require_once($config_path);
require_once WB_PATH.'/framework/functions.php';

// if kitDirList is not installed use kitForm framework and create table if needed
global $dbKITdirList;
if (file_exists(WB_PATH.'/modules/kit_dirlist/class.link.php')) {
    require_once WB_PATH.'/modules/kit_dirlist/class.link.php';
}
else {
    require_once WB_PATH.'/modules/kit_form/framework/KIT/kit_dirlist/class.link.php';
}
if (!is_object($dbKITdirList)) {
    $dbKITdirList = new dbKITdirList();
    if (!$dbKITdirList->sqlTableExists()) $dbKITdirList->sqlCreateTable();
}
if (!$dbKITdirList->sqlFieldExists(dbKITdirList::field_reference)) {
    // add the additional field for references
    $dbKITdirList->sqlAlterTableAddField(dbKITdirList::field_reference, "VARCHAR(255) NOT NULL DEFAULT ''", dbKITdirList::field_id);
    $dbKITdirList->sqlAlterTableAddField(dbKITdirList::field_file_orgin, "VARCHAR(255) NOT NULL DEFAULT ''", dbKITdirList::field_id);
}


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = WB_PATH .'/'. $_REQUEST['folder'].'/';
	if (!file_exists($targetPath)) {
	    @mkdir($targetPath, 0755, true);
	}
	$md = media_filename($_FILES['Filedata']['name']);
	// check if this file already exists (avoid duplicate uploads)
	$where = array(
	        dbKITdirList::field_file => $md,
	        dbKITdirList::field_reference => $_POST['upload_id']
	        );
	$uploads = array();
	if (!$dbKITdirList->sqlSelectRecord($where, $uploads)) {
	    die($dbKITdirList->getError());
	}
	if (count($uploads) > 0) {
	    // the file already exists
	    @unlink($tempFile);
	    exit();
	}
	$targetFile =  str_replace('//','/',$targetPath) . $md ;
	if (move_uploaded_file($tempFile, $targetFile)) {
	    // file is in the temporay directory - create record
	    $data = array(
	            dbKITdirList::field_file => $md,
	            dbKITdirList::field_file_origin => $_FILES['Filedata']['name'],
	            dbKITdirList::field_date => date('Y-m-d H:i:s'),
	            dbKITdirList::field_count => 0,
	            dbKITdirList::field_path => $targetFile,
	            dbKITdirList::field_user => '',
	            dbKITdirList::field_reference => $_POST['upload_id']
	            );
	    $dbKITdirList->sqlInsertRecord($data);
	}
}

?>