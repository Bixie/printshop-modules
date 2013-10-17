<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_feedback
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
class modFeedbackHelper
{
	public static function round_to_half($num)
	{
	  if($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25) return $ceil;
	  else if($num < $half - 0.25) return floor($num);
	  else return $half;
	}
}