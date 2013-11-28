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
<a href="<?php echo $item->prodLink; ?>" class="offer-link">
<div class="offer-wrapper" style="background-image:url('/<?php echo $image; ?>')">
	<div class="offer-details">
		<h3 class="module-title"><? echo $titel; ?></h3>	
		<p><?php echo $tekst; ?></p>
	</div>
	<div class="offer-price">
		<div class="offer-amount"><? if($percentage) { ?><span class="offer-amount-count">Korting!</span><? } else { ?><span class="offer-amount-count"><? echo $aantal; ?></span> stuks<? } ?></div>
		<div class="offer-newprice"><? if($percentage) { echo $percentage; } else { echo $prijs; } ?></div>
	</div>
</div>
</a>
