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

BixTools::loadCss();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
if ($params->get('layout', 'default') == '_:messages') {
	$bixPlugin	= new BixPlugin(array('bixprintshop_betaal','bixprintshop_mail','bixprintshop'));
	$result = $bixPlugin->trigger('BPSshowJsDebug',array());
	if ($bixPlugin->getError()) {
		echo $bixPlugin->getError();
	}
}
require JModuleHelper::getLayoutPath('mod_bps_debug', $params->get('layout', 'default'));