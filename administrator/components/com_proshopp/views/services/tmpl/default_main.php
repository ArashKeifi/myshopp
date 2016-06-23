<?php
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$types = JFormHelper::loadFieldType('ProductType', false);
$typesOptions=$types->getOptions()
?>
<form
    action="<?php echo JRoute::_('index.php?option=com_proshopp&view=services'); ?>"
    method="post" name="adminForm" id="adminForm">
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
        <div id="filter-bar" class="btn-toolbar">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="order_id">Stock name</label>
                        <input type="text" id="filter_search" name="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" placeholder="<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_TITLE'); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <?php echo JHTML::_('select.genericlist',JHtml::_('jgrid.publishedOptions', array('All' => '*')) , 'filter_state', 'class="form-control m-b" onchange="this.form.submit()"', 'value', 'text', $this -> state -> get('filter.state'),'filter_state',true );  ?>
                </div>
                <div class="col-lg-2">
                    <select name="filter_type" class="form-control m-b" onchange="this.form.submit()">
                        <option value="0"> - Select Type - </option>
                        <?php echo JHtml::_('select.options', $typesOptions, 'value', 'text', $this->state->get('filter.type'));?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="btn-group">
                        <button type="submit" class="btn-primary btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                        <button type="button" class="btn-white btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';document.getElementById('filter_state').selectedIndex =5;this.form.submit();"><i class="icon-remove"></i></button>
                    </div>
                </div>
                <div class="col-sm-1 pull-right hidden-phone">
                    <div class="btn-group">
                        <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                </div>
            </div>


        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="modal inmodal fade in" id="modal_order" tabindex="-1" role="dialog" aria-hidden="true">

                        </div>
                        <table class="footable table table-stripped toggle-arrow-tiny default footable-loaded" data-page-size="15">
                            <thead>
                            <?php echo $this->loadTemplate('head');?>
                            </thead>
                            <tbody>
                            <?php echo $this->loadTemplate('body');?>
                            </tbody>
                            <tfoot>
                            <?php echo $this->loadTemplate('foot');?>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>