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
<div class="grid-block width100 aanbiedingtekst">
	<div class="bg width100" style="background:url('/<?php echo $image; ?>') no-repeat scroll 100% 0 transparent;min-height:<?php echo $height; ?>px;">
		<div class="tekst ">
			<?php echo $tekst; ?>
		</div>
	</div>
</div>
<div class="grid-block width100 modfooter">
	<a href="<?php echo $sLink; ?>" class="button"><span class="buttontext"><?php echo JText::_('MOD_BPS_AANBIEDING_PRIJSINFO'); ?></span></a>
</div>