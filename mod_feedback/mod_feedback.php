<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_feedback
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
jimport('joomla.filesystem.folder');

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$cacheName = JPATH_ROOT.DS.'cache/feedback/fbc.xml.cache';
if (!JFolder::exists(JPATH_ROOT.DS.'cache/feedback')) {
	JFolder::create(JPATH_ROOT.DS.'cache/feedback');
}
$age = 1800;
$feedbackID = $params->get('feedbackID', '0');
$tekst = $params->get('tekst');
$title = $module->title;
$url = "http://beoordelingen.feedbackcompany.nl/samenvoordeel/scripts/flexreview/getreviewxml.cfm?ws=$feedbackID&publishIDs=1&nor=0&publishDetails=1&publishOnHold=0&sort=desc&emlpass=test";

if(!file_exists($cacheName) || filemtime($cacheName) > time() + $age) {
  $contents = file_get_contents($url);
  file_put_contents($cacheName, $contents);
}

$feedback = simplexml_load_file($cacheName);

if ($feedback) {
	// Onderdelen
	$score = (float)$feedback->score;
	$scoremax = $feedback->scoremax;
	$reviews = $feedback->noReviews;
	$link = $feedback->detailslink;
}


require JModuleHelper::getLayoutPath('mod_feedback', $params->get('layout', 'default'));
