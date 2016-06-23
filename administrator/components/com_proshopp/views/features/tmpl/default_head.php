<?php
    defined('_JEXEC') or die('Restricted Access');
$listOrder = $this->escape($this->sortColumn);
$listDirn  = $this->escape($this->sortDirection);
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_proshopp&task=features.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'itemList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<script language="javascript" type="text/javascript">
    function tableOrdering( order, dir, task )
    {
        var form = document.adminForm;

        form.filter_order.value = order;
        form.filter_order_Dir.value = dir;
        document.adminForm.submit( task );
    }
</script>
<tr class="sortable">
    <th width="1%" class="nowrap center hidden-phone">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $this->sortDirection, $this->sortColumn, null, 'asc', 'icon-menu-2'); ?>
    </th>
		<th class="nowrap center" width="20">
            <?php echo JHtml::_('grid.checkall'); ?>
        </th>
        <th class="nowrap center" width="50">
            <?php echo JText::_('COM_PROSHOPP_STATE'); ?>
        </th>
        <th class="nowrap left">
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_NAME'); ?>
        </th>
    <th class="nowrap center">
        <?php echo JHTML::_( 'grid.sort', 'COM_PROSHOPP_SUBMENU_TYPES', 'a.type', $this->sortDirection, $this->sortColumn); ?>
    </th>
        
</tr>