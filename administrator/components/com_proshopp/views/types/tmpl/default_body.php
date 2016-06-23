<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHTML::_('behavior.modal');
?>
<?php foreach($this->items as $i => $item): ?>
<tr class="row<?php echo $i % 2; ?>">
	<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?>
	</td>
	<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'types.',true); ?>
	</td>

	<td ><a
			href="<?php echo JRoute::_('index.php?option=com_proshopp&task=type.edit&id=' . $item->id); ?>">
			<?php echo $item->name; ?>
		</a>
	</td>
	<td class="center"><img height="25px" src="<?php echo JURI::root( true ).'/'.$item->icon; ?>"/></td>
</tr>
<?php endforeach; ?>