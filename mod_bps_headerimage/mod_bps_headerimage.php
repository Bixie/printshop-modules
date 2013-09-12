<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2012 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$tekstregel1 = $params->get('tekstregel1');
$tekstregel2 = $params->get('tekstregel2');
$image = $params->get('image', '');
$imageinfo = getimagesize(JPATH_ROOT.DS.$image);
$width    = $imageinfo[0];
$height   = $imageinfo[1];

require JModuleHelper::getLayoutPath('mod_bps_headerimage', $params->get('layout', 'default'));
