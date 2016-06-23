<?php
/**
 * @module        com_Proshopp
 * @author-name arash
 * @copyright    Copyright (C) 2015 arash
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppModelFeature extends JModelAdmin
{

    public function getTable($type = 'Feature', $prefix = 'ProshoppTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_proshopp.feature', 'feature', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_proshopp.edit.feature.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }

    public function save($data)
    {
        $fieldType=JFactory::getApplication()->input->get('fieldType','text');
        $values = JFactory::getApplication()->input->get('option_value', array(), 'array');
        $texts  = JFactory::getApplication()->input->get('option_text', array(), 'array');
        if(!empty($texts)){
            $first=false;
            for($i=0, $l = count($texts); $i < $l ;$i++){
                if($texts[$i] != '' && $values[$i] != '') {
                    ($first) ? $items[] = ',' : $first = true;
                    $items[] = '{"text":"' . $texts[$i] . '","value":"' . $values[$i] . '"}';
                }
            }
        }
        $data['field_type_option']='{"field_type":"'.$fieldType.'","items":['.implode($items).']}';
        return parent::save($data);
    }
}