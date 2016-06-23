<?php /**
 * @module		com_Proshopp
 * @script		Proshopp.php
 * @author-name Arash Kifi
 * @copyright	Copyright (C) 2012 Arash Kifi
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
?>

<div id="slider-range"></div>
<form class="form-validate" action="<?php echo JRoute::_('index.php?option=com_proshopp&layout=edit&id=' . (int)$this -> item -> id); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
		<div class="control-group">
			<div class="controls">
				<?php echo $this -> form -> getInput('id'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this -> form -> getLabel('published'); ?>
			</div>
			<div class="controls">
				<?php echo $this -> form -> getInput('published'); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this -> form -> getLabel('name'); ?>
			</div>
			<div class="controls">
				<?php echo $this -> form -> getInput('name'); ?>
			</div>
		</div>
	</fieldset>
	<div>
		<input type="hidden" name="task" value="type.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>