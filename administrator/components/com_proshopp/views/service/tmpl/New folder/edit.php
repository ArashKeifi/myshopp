<?php /**
 * @module		com_Proshopp
 * @author-name Arash Kifi
 * @copyright	Copyright (C) 2012 Arash Kifi
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
JHtml::_('jquery.ui');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_proshopp/models/fields/FieldTypeOption.css');
$document->addStyleSheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.css');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.24.3/css/uikit.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.24.3/js/uikit.min.js"></script>
<style>i.uk-icon-minus-square {
		color: #C34949;
		font-size: 20px;
		margin-top: 3px;
		cursor: pointer;
	}</style>
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
				<?php echo $this -> form -> getLabel('name'); ?>
			</div>
			<div class="controls">
				<?php echo $this -> form -> getInput('name'); ?>
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
				<?php echo $this -> form -> getLabel('type'); ?>
			</div>
			<div class="controls">
				<?php echo $this -> form -> getInput('type'); ?>
			</div>
		</div>
		<hr>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this -> form -> getLabel('items'); ?>
			</div>
			<div class="controls">
				<?php echo $this -> form -> getInput('items'); ?>
			</div>
		</div>

	</fieldset>
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>