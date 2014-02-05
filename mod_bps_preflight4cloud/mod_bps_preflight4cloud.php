<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2012 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;

if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php')) {
	require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';
} else {
	echo 'Installeer de Bixie Printshop!';
	return;
}
//init vars
$orderID = 0;
$uploadID = uniqid('u');
$endpoint = 'index.php?option=com_bixprintshop&format=raw&task=plugin.triggerevent&plugin=preflight4cloud&action=preflight4cloud.handleUpload';
$deleteUrl = 'index.php?option=com_bixprintshop&format=raw&task=plugin.triggerevent&plugin=preflight4cloud&action=preflight4cloud.deleteFile';
//set params
$uploadParams = new JRegistry();
$uploadParams->set('uploader.showFiles',false);
$uploadParams->set('bixOptions.loadUploader',true);
$uploadParams->set('uploadType','preflight4cloud');
$uploadParams->set('uploadID',$uploadID);
$uploadParams->set('endpoint',$endpoint);
$uploadParams->set('deleteUrl',$deleteUrl);

//load js
BixTools::BixAlert();
BixUpload::loadJS($uploadParams);
//plugin js na upload js
$doc = JFactory::getDocument();
$doc->addStyleSheet(BIX_PLUGIN_ORDER.'/preflight4cloud/assets/preflight4cloud.css');
$doc->addScript(BIX_PLUGIN_ORDER.'/preflight4cloud/js/preflight4cloud.js');

//show
require JModuleHelper::getLayoutPath('mod_bps_preflight4cloud', $params->get('layout', 'default'));
