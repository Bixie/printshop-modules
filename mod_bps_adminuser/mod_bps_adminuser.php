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

$app = JFactory::getApplication();
$document = JFactory::getDocument();
$document->addScript(str_replace(JPATH_ROOT.DS,'',dirname(__FILE__)).DS.'assets/adminuser.js');
//reset cart on switch
if (JRequest::getVar('setadminuser','') != '') {
	BixTools::getCartClass()->resetCart();
}
$actualUser = JFactory::getUser();
$adminUser = $app->getUserstateFromRequest('com_bixprintshop.adminUser','adminUser',-1,'int');
$id = uniqid();
$js = "window.addEvent('domready',function() {"
			."adminuser = new BixAdminuser('{$id}',{"
				."initValue: ".(int)$adminUser.""
			."});"
		."});";
$document->addScriptDeclaration($js);
$currentUser = '';
if ($adminUser > 0 && $actualUser->authorise('core.admin')) {
	$adminUserObj = JFactory::getUser($adminUser);
	$currentUser = $adminUserObj->name;
}

require JModuleHelper::getLayoutPath('mod_bps_adminuser', $params->get('layout', 'default'));
