<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2012 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;
?>
<div style="background:url('/<?php echo $image; ?>') 0px 10px no-repeat;">
	<div class="offer-details">
		<h3 class="module-title"><? echo $titel; ?></h3>	
		<p><?php echo $tekst; ?></p>
		<a href="<?php echo $item->prodLink; ?>" class="button-primary" style="float: right;">Bekijk</a>
	</div>
	<div class="offer-price">
		<div class="offer-amount"><span class="offer-amount-count"><? echo $aantal; ?></span> stuks</div>
		<div class="offer-newprice">&euro;<? echo $prijs; ?></div>
	</div>
</div>
