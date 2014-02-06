<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2013 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;
if (isset(self::$bixCart) && !$bixCart) {
	$bixCart = $this->bixCart;
}
$cartItemid = BixTools::config('algemeen.cartItemid',0)?'&Itemid='.BixTools::config('algemeen.cartItemid',0):'';
$cartLink = JRoute::_('index.php?option=com_bixprintshop&view=cart'.$cartItemid);
?>
<div class="uk-grid">
	<div class="uk-width-custom" style="width: 50px;">
		<a class="uk-button uk-button-mini" href="<?php echo $cartLink;?>" title="<?php echo JText::_('COM_BIXPRINTSHOP_TO_CART'); ?>">
			<i class="uk-icon-shopping-cart"></i>
		</a>
	</div>
	<div class="uk-width-custom" style="width: 160px;">
		<span class="text">
		<?php 
		if ($bixCart->get('nrOrders',0) == 1 ) : echo JText::sprintf('MOD_BPS_CART_ONE_ITEM_SPR',$bixCart->get('nrOrders',0)); else:
			 echo JText::sprintf('MOD_BPS_CART_MORE_ITEMS_SPR',$bixCart->get('nrOrders',0));
		endif;	 
		?>
		</span>
		<?php echo BixHtml::formatPrice($bixCart->get('totaalNetto',0)); ?>
	</div>
</div>
