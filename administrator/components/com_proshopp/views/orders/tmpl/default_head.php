<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr >
		<th class="footable-visible footable-first-column" width="5">
                <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
        </th>                 
        <th data-hide="phone" class="footable-visible" >
                <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_NUMBER'); ?>
        </th>
        <th data-hide="phone" class="footable-visible" >
                <?php echo JText::_('COM_PROSHOPP_STATE'); ?>
        </th>
         <th data-hide="phone" class="footable-visible">
                <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_CUSTOMER'); ?>
        </th>
        <th data-hide="phone" class="footable-visible" >
                <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_DATE_ADD'); ?>
        </th>
        <th data-hide="phone" class="footable-visible" >
            <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_TOTAL'); ?>
        </th>
        <th class="text-right footable-visible footable-last-column">
        Action
        </th>
        
</tr>