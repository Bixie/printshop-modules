<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancies.
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';
require_once dirname(__FILE__).'/helper.php';

$list = modBPSordersHelper::getList($params);
require JModuleHelper::getLayoutPath('mod_bps_orders', $params->get('layout', 'default'));
