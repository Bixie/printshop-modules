<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancies.
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bixprintshop'.DS.'classes'.DS.'bixtools.php';
require_once dirname(__FILE__).'/helper.php';

JFactory::getDocument()->addScript('modules/mod_bps_stats/assets/bps_stats.js');
$app = JFactory::getApplication();

$list = modbps_statsHelper::getList($params);
$currentPeriode = $app->getUserState('com_bixprintshop.mod_bps_stats.periode','week');
$perodeOptions = array(
	JHtml::_('select.option', 'week', JText::_('MOD_BPS_STATS_PWEEK')),
	JHtml::_('select.option', 'maand', JText::_('MOD_BPS_STATS_PMAAND')),
	JHtml::_('select.option', 'kwart', JText::_('MOD_BPS_STATS_PKWART')),
	JHtml::_('select.option', 'jaar', JText::_('MOD_BPS_STATS_PJAAR'))
);



require JModuleHelper::getLayoutPath('mod_bps_stats', $params->get('layout', 'default'));
