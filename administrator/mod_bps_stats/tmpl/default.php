<?php

// no direct access
defined('_JEXEC') or die;


//
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
	window.addEvent('domready', function(){	
		var BPSstats = new modBPSstats('graphForm',{
			elIds:{
				periode:'periode',
				dataType:'dataType',
				startDatum:'startDatum',
				graph:'graphs'
			},
			periodical: 300000
		});
		new bixSelectNav('startDatum');
	});
	//googl api
	google.load('visualization', '1', {packages: ['corechart']});
</script>

<form id="graphForm">
	<div class="grid-block width100">
		<div class="grid-block width100" id="controls">	
			<div class="grid-box width33">
				<?php echo JHtml::_('select.genericlist',$perodeOptions, 'data[periode]', 'class="inputbox" size="1" ', 'value', 'text', $currentPeriode, 'periode'); ?>
			</div>
			<div class="grid-box width33">
				<?php echo JHtml::_('select.genericlist',$datatypeOptions, 'data[dataType]', 'class="inputbox" size="1" ', 'value', 'text', $currentDataType, 'dataType'); ?>
			</div>
			<div class="grid-box width33">
				<?php echo JText::_('MOD_BPS_STATS_PERIODE');?>: 
				<span><?php echo JHtml::_('select.genericlist',$browseRanges, 'data[startDatum]', 'class="inputbox" size="1" ', 'value', 'text', $currentStartDatum, 'startDatum'); ?></span>
			</div>
		</div>
	</div>
	<div class="grid-block width100">
		<div id="graphs">	
		</div>
	</div>
	<input type="hidden" name="data[rapportageDag]" value="<?php echo $params->get('rapportageDag',5); ?>">
</form>

