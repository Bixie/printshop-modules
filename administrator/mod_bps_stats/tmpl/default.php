<?php

// no direct access
defined('_JEXEC') or die;



?>

<script>
	window.addEvent('domready', function(){	
		var BPSstats = new modBPSstats('graphForm',{elIds:{periode:'periode',graph:'graphs'}});
	});
</script>

<form id="graphForm">
	<div class="grid-block width100">
		<div id="controls">	
			<div class="grid-box width33">
				<?php echo JHtml::_('select.genericlist',$perodeOptions, 'data[periode]', 'class="inputbox" size="1" ', 'value', 'text', $currentPeriode, 'periode');?>
			</div>
			<div class="grid-box width33">
				producten/gebruiker/omzet
			</div>
			<div class="grid-box width33">
				x
			</div>
		</div>
	</div>
	<div class="grid-block width100">
		<div id="graphs">	
			graph
		</div>
	</div>
	<input type="hidden" name="data[rapportageDag]" value="<?php echo $params->get('rapportageDag',5); ?>">
</form>

