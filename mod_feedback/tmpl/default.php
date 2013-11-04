<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_feed
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

?>
<strong><a href="<? echo $link; ?>" target="_blank" rel="nofollow"><? echo $title; ?> (<? echo $reviews; ?>)</a></strong><br/>
<div class="star star-<? echo number_format(modFeedbackHelper::round_to_half($score),1,'',''); ?>"></div> <? echo "<strong>".$score."/".$scoremax."</strong>"; ?>
<div class="feedbacklogo"><a href="<? echo $link; ?>" target="_blank" rel="nofollow"><img src="/modules/mod_feedback/assets/feedbackcompany.png" /></a></div>