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

<?php  require JModuleHelper::getLayoutPath('mod_bps_cart', 'default_raw'); ?>
	<?php if ($bixCart->get('nrOrders',0) > 0) :?>
	<div class="grid-block">
		<a class="tocartlink float-left" href="<?php echo JRoute::_('index.php?Itemid='.BixTools::config('algemeen.cartItemid'))?>"><?php echo JText::_('MOD_BPS_TOCARTLINK'); ?></a>
	</div>
	<?php endif; ?>
	<div id="productPriceHolder">
		<div class="prijshold totaalText"><?php echo JText::_('Totaal bedrag:'); ?></div>
		<div class="prijshold origHolder"><?php echo JText::_('Adviesprijs '); ?><div class="strike"><div class="origPrijs"></div></div></div>
		<div class="prijshold nettoHolder"><div class="orderNetto"></div></div>
		<div class="prijshold btwHolder"><div class="orderBtw"></div></div>
		<div class="prijshold brutoHolder">(<div class="orderBruto"></div> <?php echo JText::_('MOD_BPS_CART_INCLBTW'); ?>)</div>
	</div>
	<button type="button" class="button" id="orderButton"><?php echo JText::_('Bestellen'); ?></button>

	<ul id="cartInfoUL" class="rawlist"> 
	</ul>
