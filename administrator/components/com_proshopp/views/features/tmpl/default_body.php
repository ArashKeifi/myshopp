<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHTML::_('behavior.modal');
$listOrder = $this->escape($this->sortColumn);
$listDirn  = $this->escape($this->sortDirection);
$saveOrder = $listOrder == 'a.ordering';
?>
<?php foreach($this->items as $i => $item):
	$item->max_ordering = 0;
	$ordering   = ($listOrder == 'a.ordering');
	;?>
<tr class="row<?php echo $i % 2; ?>">
	<td class="order nowrap center hidden-phone">
		<?php
		$iconClass = '';
		if (!$saveOrder)
			{
			$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
			};
		?>
		<span class="sortable-handler <?php echo $iconClass ?>">
								<span class="icon-menu"></span>
							</span>
			<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />

	</td>
	<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?>
	</td>
	<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'features.',true); ?>
	</td>
	<td class="left">
		<a href="<?php echo JRoute::_('index.php?option=com_proshopp&task=feature.edit&id=' . $item->id); ?>">
			<?php echo $item->name; ?>
		</a>
	</td>
	<td class="center">
		<?php echo $item->types; ?>
	</td>
</tr>
<?php endforeach; ?>