<?php
/**
 *	com_bix_printshop - Online-PrintStore for Joomla
 *  Copyright (C) 2010-2013 Matthijs Alles
 *	Bixie.nl
 *
 */

// no direct access
defined('_JEXEC') or die;
?>
<div id="headerimage" class="widthmax" style="background-image: url('<?php echo $sImagepath; ?>');max-width:<?php echo $iWidth; ?>px;max-height:<?php echo $iHeight; ?>px;">
	<div class="wrapper">
		<?php if ($sTekstregel1 != '') : ?>
			<div class="tekst tekstregel1"><?php echo $sTekstregel1; ?></div>
		<?php endif; ?>
		<?php if ($sTekstregel2 != '') : ?>
			<div class="tekst tekstregel2"><?php echo $sTekstregel2; ?></div>
		<?php endif; ?>
	</div>
</div>
