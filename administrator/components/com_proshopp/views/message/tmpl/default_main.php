<?php
jimport( 'joomla.html.html.jgrid' );
?>
<form role="form" class="form-validate" action="<?php echo JRoute::_('index.php?option=com_proshopp&layout=edit&id=' . (int)$this -> item -> id); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row  border-bottom white-bg dashboard-header">
        <h2 id="page_title"></h2><hr>
        <div class="btn-toolbar" id="toolbar">
            <div class="col-sm-12" id="custome-toolbar"></div>
        </div>
        <hr>
        <?php if (!empty( $this->sidebar)) : ?>
            <div id="j-sidebar-container">
                <?php echo $this->sidebar; ?>
            </div>
        <?php endif;?>
        <div class="clearfix"> </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <?php echo $this->loadTemplate('body');?>
    </div>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>