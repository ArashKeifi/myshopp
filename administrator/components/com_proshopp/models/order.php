<?php
/**
 * @module        com_Proshopp
 * @script        type.php
 * @author-name arash
 * @copyright    Copyright (C) 2015 arash
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppModelOrder extends JModelAdmin
{

    public function getTable($type = 'Order', $prefix = 'ProshoppTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_proshopp.order', 'order', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }



    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_proshopp.edit.order.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }
}