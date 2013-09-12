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

//init vars
$sTekstregel1 = '';
$sTekstregel2 = '';
$sImagepath = '';
$iWidth    = 0;
$iHeight   = 0;
//joomla request uitlezen
$option = JRequest::getCmd('option');
$view = JRequest::getCmd('view');
//productpagina?
if ($option == 'com_bixprintshop' && $view == 'productdetails') {
	$iProductID = JRequest::getInt('productID',0);
	if ($iProductID) {
		$bixProduct = BixTools::getproductClass($iProductID);
		$sTekstregel1 = $bixProduct->get('tekstregel1','','params',true);
		$sTekstregel2 = $bixProduct->get('tekstregel2','','params',true);
		$sImagepath = $bixProduct->get('image','','params',true);
	}
}
//contentcategorie?



if ($sImagepath == '' ) { //dan uit module
	$sTekstregel1 = $params->get('tekstregel1','');
	$sTekstregel2 = $params->get('tekstregel2','');
	$sImagepath = $params->get('image', '');
}
if (file_exists(JPATH_ROOT.DS.$sImagepath)) {
	$aImageSize = getimagesize(JPATH_ROOT.DS.$sImagepath);
	$iWidth    = $aImageSize[0];
	$iHeight   = $aImageSize[1];
}

require JModuleHelper::getLayoutPath('mod_bps_headerimage', $params->get('layout', 'default'));
