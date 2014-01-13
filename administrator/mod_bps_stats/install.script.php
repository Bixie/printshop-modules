<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2014 Matthijs Alles
 *	Bixie.org
 *
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class mod_Bps_statsInstallerScript {

	protected $_ext = 'mod_bps_stats';

	/**
	 * Called on installation
	 *
	 * @param   object  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	function install($parent)
	{
		// init vars
		$db = JFactory::getDBO();
		jimport('joomla.application.component.model');
		JModel::addIncludePath(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_modules'.DS.'models'.DS, 'ModulesModel');
		$model = JModel::getInstance('module', 'ModulesModel', array('name'=>'menu','ignore_request' => true));
		//get default
		$query = $db->setQuery($db->getQuery(true)
				->select('*')
				->from('#__modules')
				->where("module = '{$this->_ext}'"));
		$row = $db->loadObject();
		//set for bps panel
		if ($row) {
			$row->ordering = 1;
			$row->published = 1;
			$row->position = 'bps-cpanel';
			$row->params = '{"count":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","automatic_title":"1"}';
			if (!$model->save(JArrayHelper::fromObject($row))) {
				echo JText::sprintf('MOD_BPS_STATS_ERROR_CPANEL_SPR', $db->stderr());
			} else {
				echo JText::_('MOD_BPS_STATS_INSTALL_SUCCES');
			}
		}

	}

}