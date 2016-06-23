<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHTML::_('behavior.modal');
?>
<?php foreach($this->items as $i => $item): ?>
<tr class="row<?php echo $i % 2; ?>">
	<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?>
	</td>
	<td class="center"><a
		href="<?php echo JRoute::_('index.php?option=com_proshopp&task=stock.edit&id=' . $item->id); ?>">
			<?php echo $item->id; ?>
	</a>
	</td>
	<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'stocks.',true); ?>
	</td>

	<td class="left">
		<span style="color: rgba(123, 123, 123, 0.61)">@</span> <?php echo $item->name; ?>
	</td>
	<td class="center"><?php echo $item->low_count; ?></td>
	<td class="center"><?php echo $item->critical_count; ?></td>
</tr>
<?php endforeach; ?>