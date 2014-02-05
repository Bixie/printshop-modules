<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2014 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;
?>
<ul class="uk-grid uk-filelist" id="list-<?php echo $uploadID; ?>" data-orderid="<?php echo $orderID; ?>">
</ul>
<div class="bixUploader" id="<?php echo $uploadParams->get('uploadID'); ?>" data-orderid="<?php echo $orderID; ?>"></div>
<div class="uk-clearfix">
	<div class="bixdropbox uk-hidden"  id="dropbox-<?php echo $uploadParams->get('uploadID'); ?>"><span><?php echo JText::_('COM_BIXPRINTSHOP_DROPBOX'); ?></span></div>
</div>