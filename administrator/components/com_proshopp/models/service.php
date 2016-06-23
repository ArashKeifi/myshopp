<?php
/**
 * @module        com_Proshopp
 * @author-name arash
 * @copyright    Copyright (C) 2015 arash
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppModelService extends JModelAdmin
{

    public function getTable($type = 'Service', $prefix = 'ProshoppTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_proshopp.service', 'service', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_proshopp.edit.service.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }

    public function save($data)
    {
        if (parent::save($data)) {
            $items = JFactory::getApplication()->input->get('items', array(), 'array');
            if ($items) {
                foreach ($items AS $id => $value) {
                    (strpos($value['id'], 'new'))?$newData['id'] ='': $newData['id']=$value['id'];
                    $newData['service_id'] = $data['id'];
                    $newData['name'] = $value['name'];
                    $newData['price'] = $value['price'];
                    $newData['currency'] = $value['currency'];
                    try {
                        $table_feature_value = $this->getTable($type = 'Serviceitem', $prefix = 'ProshoppTable', $config = array());
                        if (!$table_feature_value->bind($newData)) {
                            $this->setError($table->getError());
                            return false;
                        }
                        if (!$table_feature_value->store($newData)) {
                            $this->setError($user->getError());
                            return false;
                        }
                    } catch (Exception $e) {
                        $this->setError($e->getMessage());

                        return false;
                    }

                }
            }
        }
        return true;

    }
}