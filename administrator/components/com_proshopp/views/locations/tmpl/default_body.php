<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHTML::_('behavior.modal');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'locations.',true); ?>
		</td>
		<td class="left">
			<a href="<?php echo JRoute::_('index.php?option=com_proshopp&task=location.edit&id=' . $item->id); ?>">
				<?php
				if ($item -> level == 0) {
					$item -> title = JText::_('JGLOBAL_ROOT_PARENT');
				}elseif($item -> level != 1){
					$item -> title = str_repeat('&nbsp;&nbsp;', $item -> level-1) ."'-". $item -> title;
				}
				echo $item->title; ?>
			</a>
		</td>
		<td><?php echo $item->path; ?></td>
	</tr>
<?php endforeach; ?>