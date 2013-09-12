<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2012 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;
if (isset(self::$bixCart) && !$bixCart) {
	$bixCart = $this->bixCart;
}
?>
<span class="text">
<?php 
if ($bixCart->get('nrOrders',0) == 1 ) : echo JText::sprintf('MOD_BPS_CART_ONE_ITEM_SPR',$bixCart->get('nrOrders',0)); else:
	 echo JText::sprintf('MOD_BPS_CART_MORE_ITEMS_SPR',$bixCart->get('nrOrders',0));
endif;	 
?>
</span>
<?php echo BixHtml::formatPrice($bixCart->get('totaalNetto',0)); ?>
