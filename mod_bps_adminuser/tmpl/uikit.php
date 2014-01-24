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
<form action="<?php echo JURI::current(); ?>" method="post" class="uk-form">
	<div class="uk-grid">
		<div class="uk-width-medium-1-3 uk-width-large-1-4">
			<input type="text" name="" id="<?php echo $id; ?>" value="<?php echo $currentUser; ?>" autocomplete="off" class="bixajax uk-form-large" size="20" placeholder="<?php echo JText::_('BIX_ZOEK_GEBR'); ?>"/>
		</div>
		<div class="uk-width-medium-2-3 uk-width-large-1-2 selectholder">
			<select name="adminUser" id="select<?php echo $id; ?>" class="uk-width-1-1 inputbox" size="4"></select>
		</div>
		<div class="uk-width-medium-1-1 uk-width-large-1-4 buttons">
			<button class="inputbox uk-button uk-button-expand uk-float-right" ><?php echo JText::_('BIX_ACTIVEER_GEBR'); ?></button>
			<button id="reset<?php echo $id; ?>" type="button" class="uk-button uk-button-expand uk-float-right"><?php echo JText::_('BIX_RESET_GEBR'); ?></button>
		</div>
	</div>
</form>

