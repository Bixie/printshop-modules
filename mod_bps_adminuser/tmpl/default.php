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
<div class="grid-block width100">
	<form action="<?php echo JURI::current(); ?>" method="post" class="style">
		<div class="grid-box width25 inputholder">
			<input type="text" name="" id="<?php echo $id; ?>" value="<?php echo $currentUser; ?>" autocomplete="off" class="bixajax" size="20" placeholder="<?php echo JText::_('BIX_ZOEK_GEBR'); ?>"/>
		</div>
		<div class="grid-box width50 selectholder">
			<select name="adminUser" id="select<?php echo $id; ?>" class="width100 inputbox" size="4"></select>
		</div>
		<div class="grid-box width25 inputholder">
			<input type="submit" class="inputbox button float-right" name="setadminuser" value="<?php echo JText::_('BIX_ACTIVEER_GEBR'); ?>"/>	
			<button id="reset<?php echo $id; ?>" type="button" class="button-default float-right"><?php echo JText::_('BIX_RESET_GEBR'); ?></button>
		</div>
	</form>
</div>

