<?php
    defined('_JEXEC') or die('Restricted Access');
?>
<tr >
		<th class="nowrap center" width="20">
                <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
        </th>                 
        <th class="nowrap center" width="10">
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ID'); ?>
        </th>
        <th class="nowrap center" width="50">
            <?php echo JText::_('COM_PROSHOPP_STATE'); ?>
        </th>
        <th class="nowrap left">
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_NAME'); ?>
        </th>
    <th class="nowrap center">
        <?php echo JText::_('COM_PROSHOPP_SUBMENU_TYPES'); ?>
    </th>
        
</tr>