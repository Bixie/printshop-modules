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
<?php
if ($aBestanden && count($aBestanden)) : ?>
<?php foreach ($aBestanden as $bestand) :
		$result = $bixPlugin->trigger('preflight4cloudGetFileInfo',array($bestand['fileID']));
		$controleInfo = $result[0];
		$controleInfo['resultLink'] = JRoute::_('index.php?Itemid='.BixTools::config('plugins.Orderpreflight4cloud.resultItemid',285));
		$controleData = $controleInfo['controleData'];
		$infotmpl = '_short';
	?>
	<?php include BIX_PATH_PLUGIN_ORDER.'/preflight4cloud/tmpl/orderuploaditem_upload.php'; ?>
<?php endforeach; ?>
<?php endif; ?> 
</ul>
<div class="bixUploader" id="<?php echo $uploadParams->get('uploadID'); ?>" data-orderid="<?php echo $orderID; ?>"></div>
<div class="uk-clearfix">
	<div class="bixdropbox bixdropbox-module uk-vertical-align uk-hidden"  id="dropbox-<?php echo $uploadParams->get('uploadID'); ?>">
		<div class="uk-vertical-align-middle"><?php echo JText::_('MOD_BPS_PREFLIGHT4CLOUD_DROPFILES'); ?></div>
	</div>
</div>