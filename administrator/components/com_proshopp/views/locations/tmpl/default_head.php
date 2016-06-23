<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr >
    <th class="footable-visible footable-first-column center" width="40">
            <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
    </th>
    <th data-hide="phone" class="footable-visible center" width="100">
            <?php echo JText::_('COM_PROSHOPP_STATE'); ?>
    </th>
    <th data-hide="phone" class="footable-visible">
        <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_TITLE'); ?>
    </th>
    <th data-hide="phone" class="footable-visible">
        <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_PATH'); ?>
    </th>
</tr>