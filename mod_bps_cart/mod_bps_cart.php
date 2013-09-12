<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2013 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';
$document = JFactory::getDocument();

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$bixCart = BixTools::getCartClass();
$bixCart->loadJS();
$layoutRaw = str_replace('_:','',$params->get('layout', 'default')).'_raw';
$script = 
	"bixCart.addModule('bpsCartModule',{".
		"name:'mod_bps_cart',".
		"layout:'".$layoutRaw."',".
		"elementID:'bix-cart-default',".
		"floatHeightAdj:".$params->get('floatHeightAdj', 0).",".
		"floatMod:".$params->get('floatMod', 0).",".
		"linkEl:".$params->get('linkEl', 0)."".
	"});";
$document->addScriptDeclaration($script);
if ($params->get('floatMod', 0)) {
	//$document->addScript(BIX_JS.'/scrollspy/mootools-more-1.4.0.1.js');
	$document->addScript(BIX_JS.'/scrollspy/ScrollSpy.js');
}
require JModuleHelper::getLayoutPath('mod_bps_cart', $params->get('layout', 'default'));
