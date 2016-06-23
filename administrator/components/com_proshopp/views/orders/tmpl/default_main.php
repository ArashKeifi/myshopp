<form
    action="<?php echo JRoute::_('index.php?option=com_proshopp&view=orders'); ?>"
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
                        <label class="control-label" for="order_id">Order ID</label>
                        <input type="text" id="filter_order_id" name="filter_order_id" value="<?php echo $this->escape($this->state->get('filter.order_id')); ?>" placeholder="<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_NUMBER'); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <select class="form-control m-b" id="filter_state" name="filter_state">
                        <option value="0"><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_STATUS'); ?></option>
                        <?php
                        echo ProshoppHelper::getStatusOptions($this->state->get('filter.state'));
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="customer">Customer</label>
                        <input type="text" id="filter_customer" name="filter_customer" value="<?php echo $this->escape($this->state->get('filter.customer')); ?>" placeholder="<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_CUSTOMER'); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date_added">Date added</label>
                        <?php
                        echo ProshoppHelper::calendar($this->escape($this->state->get('filter.date')),'filter_date', 'filter_date', '%Y-%m-%d',JText::_('COM_PROSHOPP_ADMIN_MANAGER_DATE_ADD'),array('size'=>'8','maxlength'=>'10','class'=>' validate[\'required\']',));
                        ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="btn-group">
                        <button type="submit" class="btn-primary btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                        <button type="button" class="btn-white btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_customer').value='';document.getElementById('filter_state').selectedIndex =0;document.getElementById('filter_date').value='';document.getElementById('filter_order_id').value='';this.form.submit();"><i class="icon-remove"></i></button>

                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="btn-group pull-right hidden-phone">
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