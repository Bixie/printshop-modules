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
<div style="float: left; width: 60%; padding-right: 10px;">
<p style="margin-top: 5px;">Uitstekende service, daar staan we voor. Laat je daarom overtuigen door de <strong><? echo $reviews; ?></strong> klanten die je voor zijn gegaan.</p>
</div>
<div style="float: right; text-align: center;">
<!--<div class="fb-title large">Reviews (<? echo $reviews; ?>)</div>-->
	<span class="fb-rating large"><? echo $score; ?></span> / <span class="fb-scale large"><? echo $scoremax; ?></span><br/>
	<div class="rstar rstar-<? echo number_format(modFeedbackHelper::round_to_half($score),1,'',''); ?>"></div>
	<!--<br/><span class="fb-count"><? echo $reviews; ?></span> reviews-->
	<br/><a href="<? echo $link; ?>" target="_blank" rel="nofollow" class="button-default button-blue" style="margin-top: 10px;">Lees reviews</a>
</div>