<?php

// no direct access
defined('_JEXEC') or die;
?>
<table class="adminlist">
	<thead>
		<tr>
			<th>
				<?php echo JText::_('MOD_BPS_ORDERS_LATEST_ORDERS'); ?>
			</th>
			<th>
				<strong><?php echo JText::_('JSTATUS'); ?></strong>
			</th>
			<th>
				<strong><?php echo JText::_('MOD_BPS_ORDERS_CREATED'); ?></strong>
			</th>
			<th>
				<strong><?php echo JText::_('MOD_BPS_ORDERS_ORDERNETTO'); ?></strong>
			</th>
			<th>
				<strong><?php echo JText::_('MOD_BPS_ORDERS_USER');?></strong>
			</th>
		</tr>
	</thead>
<?php if (count($list)) : ?>
	<tbody>
	<?php foreach ($list as $i=>$item) : ?>
		<tr>
			<th scope="row">
				<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time); ?>
				<?php endif; ?>

				<?php if ($item->link) :?>
					<a href="<?php echo $item->link; ?>">
						<?php echo htmlspecialchars($item->id.' - '.$item->productNaam, ENT_QUOTES, 'UTF-8');?></a>
				<?php else :
					echo htmlspecialchars($item->id.' - '.$item->productNaam, ENT_QUOTES, 'UTF-8');
				endif; ?>
			</th>
			<td class="center">
				<?php echo $item->orderStatusName;?>
			</td>
			<td class="center">
				<?php echo JHtml::_('date', $item->created, 'BIX_DATE'); ?>
			</td>
			<td class="right">
				<?php echo BixHtml::formatPrice($item->orderNetto);?>
			</td>
			<td class="center">
				<?php echo $item->userNaam;?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
<?php else : ?>
	<tbody>
		<tr>
			<td colspan="5">
				<p class="noresults"><?php echo JText::_('MOD_BPS_ORDERS_NO_MATCHING_RESULTS');?></p>
			</td>
		</tr>
	</tbody>
<?php endif; ?>
</table>
