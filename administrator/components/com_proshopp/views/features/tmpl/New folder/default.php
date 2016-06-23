<?php
/**
 * @module		com_Proshopp
 * @script		Proshopp.php
 * @author-name Arash Kifi
 * @copyright	Copyright (C) 2012 Arash Kifi
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.multiselect');

// load tooltip behavior
JHtml::_('behavior.tooltip');
$searchterms = $this->state->get('filter.search');
if (strlen($searchterms)>1) JHtml::_('behavior.highlighter', explode(' ',$searchterms));
?>

<form class="table table-striped"
	action="<?php echo JRoute::_('index.php?option=com_proshopp&view=features'); ?>"
	method="post" name="adminForm" id="adminForm">
    <?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_WEBLINKS_SEARCH_IN_TITLE');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="جستجو" />
			</div>
			<div class="btn-group pull-left">
				<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			
		</div>
		<div class="clearfix"> </div>
	<table class="table table-striped">
		<thead>
			<?php echo $this->loadTemplate('head');?>
		</thead>
		<tfoot>
			<?php echo $this->loadTemplate('foot');?>
		</tfoot>
		<tbody>
			<?php echo $this->loadTemplate('body');?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" /> 
        <input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
