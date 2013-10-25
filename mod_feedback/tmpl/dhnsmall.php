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
<div class="fb-small" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
<!--<div class="fb-title">Reviews (<? echo $reviews; ?>)</div>-->
	<span class="hidden" itemprop="itemreviewed">Drukhetnu.nl</span>
	<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
		<span class="fb-rating" itemprop="average"><? echo $score; ?></span> / <span class="fb-scale" itemprop="best"><? echo $scoremax; ?></span><br/>
	</span>
	<div class="rstar rstar-<? echo number_format(modFeedbackHelper::round_to_half($score),1,'',''); ?>"></div>
	<br/><a href="<? echo $link; ?>" target="_blank" rel="nofollow"><span class="fb-count" itemprop="votes"><? echo $reviews; ?></span> reviews</a>
</div>

