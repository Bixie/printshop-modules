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

JFactory::getDocument()->addStyleSheet('modules/mod_bps_aanbieding/assets/bps_aanbieding.css');
$titel = $params->get('titel');
$aantal = number_format($params->get('aantal'),0,'','.');
$tekst = nl2br($params->get('tekst', ''));
$prijs = $params->get('prijs', '');
$image = $params->get('image', '');
$imageinfo = getimagesize(JPATH_ROOT.DS.$image);
$width    = $imageinfo[0];
$height   = $imageinfo[1];
$productID = $params->get('productID', 0);
if ($productID) {
	$item = BixTools::getItem('product',$productID);
	if ($item->params['itemId'] > 0) {
		$item->prodLink = JRoute::_('index.php?Itemid='.$item->params['itemId']);
	} else {
		$item->prodLink = JRoute::_('index.php?option=com_bixprintshop&view=productdetails&catid='.$item->catid.'&productID='.$item->productID);
	}
}

require JModuleHelper::getLayoutPath('mod_bps_aanbieding', $params->get('layout', 'default'));
