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
JFactory::getDocument()->addStylesheet(str_replace(JPATH_ROOT,'',dirname(__FILE__)).'/assets/headerimage.css');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

//init vars
$sTekstregel1 = false;
$sTekstregel2 = false;
$sImagepath = false;
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
		$sTekstregel1 = $bixProduct->get('tekstregel1','-','params',true);
		$sTekstregel2 = $bixProduct->get('tekstregel2','-','params',true);
		$sImagepath = $bixProduct->get('image','','params',true);
	}
}
//contentcategorie?
if ($option == 'com_content' && $view == 'article') {
	$iArticleID = JRequest::getInt('id',0);
	if ($iArticleID) {
		$db = JFactory::getDbo();
		$db->setQuery("SELECT images FROM #__content WHERE id = $iArticleID");
		$sImages = $db->loadResult();
		if ($sImages) {
			$rImages = new JRegistry;
			$rImages->loadString($sImages);
			if ($rImages->get('image_intro',false)) {
				$sImagepath = $rImages->get('image_intro','');
			}
			if ($rImages->get('image_intro_alt',false)) {
				$sTekstregel1 = $rImages->get('image_intro_alt','-');
			}
			if ($rImages->get('image_intro_caption',false)) {
				$sTekstregel2 = $rImages->get('image_intro_caption','-');
			}
		}
	}
}
//dan uit module
if ($sImagepath == false || !file_exists(JPATH_ROOT.DS.$sImagepath)) { 
	$sImagepath = $params->get('image', '');
}
if (!$sTekstregel1 || $sTekstregel1 == '-' ) { 
	$sTekstregel1 = $params->get('tekstregel1','');
}
if (!$sTekstregel2 || $sTekstregel2 == '-' ) { 
	$sTekstregel2 = $params->get('tekstregel2','');
}
if (file_exists(JPATH_ROOT.DS.$sImagepath)) {
	$aImageSize = getimagesize(JPATH_ROOT.DS.$sImagepath);
	$iWidth    = $aImageSize[0];
	$iHeight   = $aImageSize[1];
}

require JModuleHelper::getLayoutPath('mod_bps_headerimage', $params->get('layout', 'default'));
