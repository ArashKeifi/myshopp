<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHTML::_('behavior.modal');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'messages.',true); ?>
		</td>
		<td class="left">
			<a href="<?php echo JRoute::_('index.php?option=com_proshopp&task=message.edit&id=' . $item->id); ?>">
				<?php echo $item->title; ?>
			</a>
		</td>
		<td class="center">
			<?php if($item->type == 1){echo "<small class=\"label label-primary\"><i class=\"fa fa-envelope-o\"></i> Email</small>";}elseif($item->type == 2){echo "<small class=\"label label-warning\"><i class=\"fa fa-phone-square\"></i> SMS</small>";}; ?>
		</td>
	</tr>
<?php endforeach; ?>