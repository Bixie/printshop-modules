<?php

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_content/models', 'ContentModel');

jimport('joomla.application.categories');

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_latest
 */
abstract class modBPSordersHelper
{
	/**
	 * Get a list of articles.
	 *
	 * @param	JObject		The module parameters.
	 *
	 * @return	mixed		An array of articles, or false on error.
	 */
	public static function getList($params)
	{
		// Initialise variables
		$user = JFactory::getuser();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select("o.orderID AS id, o.productNaam, o.orderNetto, o.created, o.checked_out, o.checked_out_time");
		// Join over the user
		$query->select("CONCAT(ou.name,' (',ou.username,')') AS userNaam");
		$query->from('#__bps_order AS o');
		$query->join('INNER', '#__users AS ou ON ou.id=o.userID');
		//orderstatus
		$query->select('os.statusName AS orderStatusName');
		$query->join('LEFT', '#__bps_orderstatus AS os ON os.statusCode = o.orderStatus');
		// Join over the users for the checked out user.
		$query->select('up.name AS editor');
		$query->join('LEFT', '#__users AS up ON up.id=o.checked_out');
	
		$query->where('o.bestelID > 0');
		$query->order('o.created DESC');
		
		$db->setQuery($query,0,$params->get('count', 5));
		$items = $db->loadObjectList();

		if ($error = $db->getError()) {
			JError::raiseError(500, $error);
			return false;
		}

		// Set the links
		foreach ($items as &$item) {
			if ($user->authorise('core.edit', 'com_bixprintshop.order.'.$item->id)){
				$item->link = JRoute::_('index.php?option=com_bixprintshop&task=order.edit&orderID='.$item->id);
			} else {
				$item->link = '';
			}
		}

		return $items;
	}

	/**
	 * Get the alternate title for the module
	 *
	 * @param	JObject	The module parameters.
	 * @return	string	The alternate title for the module.
	 */
	public static function getTitle($params)
	{
		$who = $params->get('user_id');
		$catid = (int)$params->get('catid');
		$type = $params->get('ordering') == 'c_dsc' ? '_CREATED' : '_MODIFIED';
		if ($catid)
		{
			$category = JCategories::getInstance('Content')->get($catid);
			if ($category) {
				$title = $category->title;
			}
			else {
				$title = JText::_('MOD_POPULAR_UNEXISTING');
			}
		}
		else
		{
			$title = '';
		}
		return JText::plural('MOD_LATEST_TITLE'.$type.($catid ? "_CATEGORY" : '').($who!='0' ? "_$who" : ''), (int)$params->get('count'), $title);
	}
}
