<?php
$session = JFactory::getSession();
$session->set('id', JFactory::getApplication()->input->getInt('id', 0));
?>
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-container">
			<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
				<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('JGLOBAL_FIELDSET_GENERAL', true)); ?>
					<?php echo $this->loadTemplate('general'); ?>
				<?php echo JHtml::_('bootstrap.endTab'); ?>
				<?php if($session->get('id')){ ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'description', JText::_('JGLOBAL_FIELDSET_DESCRIPTION', true)); ?>
						<?php echo $this->loadTemplate('description'); ?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'gallery', JText::_('JGLOBAL_FIELDSET_GALLERY', true)); ?>
						<?php echo $this->loadTemplate('gallery'); ?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'features', JText::_('JGLOBAL_FIELDSET_FEATURES', true)); ?>
						<?php echo $this->loadTemplate('feature'); ?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'prices', JText::_('JGLOBAL_FIELDSET_PRICES', true)); ?>
						<?php echo $this->loadTemplate('price'); ?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'stock', JText::_('JGLOBAL_FIELDSET_STOCK', true)); ?>
						<?php echo $this->loadTemplate('stock'); ?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
				<?php } ?>
			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		</div>
	</div>
</div>
