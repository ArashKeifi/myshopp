<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr >
		<th class="nowrap center" width="5">
                <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
        </th>                 
        <th class="nowrap center" >
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ID'); ?>
        </th>
        <th class="nowrap center" >
            <?php echo JText::_('COM_PROSHOPP_STATE'); ?>
        </th>
        <th class="nowrap center">
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_NAME'); ?>
        </th>
        <th class="nowrap center" >
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_LOW'); ?>
        </th>
        <th class="nowrap center" >
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_CRITICAL'); ?>
        </th>
        
</tr>