<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancies.
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';
require_once dirname(__FILE__).'/helper.php';

$list = modBPSstatsHelper::getList($params);
require JModuleHelper::getLayoutPath('mod_bps_stats', $params->get('layout', 'default'));
