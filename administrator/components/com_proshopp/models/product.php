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

class ProshoppModelProduct extends JModelAdmin
{
    public $typeAlias = 'com_proshopp.product';


    public function getTable($type = 'Product', $prefix = 'ProshoppTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        JForm::addFieldPath('JPATH_ADMINISTRATOR/components/com_proshopp/models/fields');
        // Get the form.
        $form = $this->loadForm('com_proshopp.product', 'product', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    public function getItem($pk = null){
        $item = parent::getItem($pk);
        // Load item tags
        if (!empty($item->id))
        {
            $item->tags = new JHelperTags;
            $item->tags->getTagIds($item->id, 'com_proshopp.product');
        }

        return $item;
    }

     protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_proshopp.edit.product.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        $this->preprocessData('com_proshopp.product', $data);
        return $data;
    }

    public function save($data)
    {
            $feature = JFactory::getApplication()->input->get('feature', array(), 'array');
            if ($feature) {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query->select($db->quoteName(array('id', 'feature_id', 'feature_value')));
                $query->from($db->quoteName('#__shopp_product_feature'));
                $query->where($db->quoteName('product_id') . '=' . $data['id']);
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                foreach ($feature AS $id => $value) {
                    foreach ($rows AS $row) {
                        ($row->feature_id == $id) ? $newData['id'] = $row->id : '';
                    }
                    $newData['product_id'] = $data['id'];
                    $newData['feature_id'] = $id;
                    $value = is_array($value) ? implode(",", $value) : $value;
                    $newData['feature_value'] = $value;
                    try {
                        $table_feature_value = $this->getTable($type = 'Productfeature', $prefix = 'ProshoppTable', $config = array());
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
                    unset($newData);
                }

            }
            $skus = JFactory::getApplication()->input->get('skus', array(), 'array');
            if ($skus) {
                foreach ($skus AS $id => $sku) {
                    (strpos($sku['id'], 'new'))?$newData['id'] ='': $newData['id']=$sku['id'];
                    $newData['pattern'] = $sku['pattern'];
                    $newData['product_id'] = $data['id'];
                    $newData['sku'] = $sku['skuid'];
                    $newData['name'] = $sku['name'];
                    $newData['image'] = $sku['image'];
                    $newData['off_price'] = $sku['off_price'];
                    $newData['compare_price'] = $sku['compare_price'];
                    $newData['published'] = $sku['published'];
                    $newData['weight'] = $sku['weight'];
                    try {
                        $table_feature_value = $this->getTable($type = 'Skus', $prefix = 'ProshoppTable', $config = array());
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
                    $session = JFactory::getSession();
                    $newPrice['id']='';
                    $newPrice['skuID']= $sku['skuid'];
                    $newPrice['productID']=$data['id'];
                    $newPrice['date']=date("Y-m-d H:i:s");
                    $newPrice['price']=$sku['price'];

                    if(empty($session->get($sku['skuid'])) || $session->get($sku['skuid']) != $sku['price']){
                        $this->insertNewPrice($newPrice);
                    }
                    unset($newPrice);
                }
            }
            $services = JFactory::getApplication()->input->get('service', array(), 'array');
            if ($services) {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query->select($db->quoteName(array('id', 'service_id', 'service_value')));
                $query->from($db->quoteName('#__shopp_product_service'));
                $query->where($db->quoteName('product_id') . '=' . $data['id']);
                $db->setQuery($query);
                $rows = $db->loadObjectList();
                foreach ($services AS $id => $service) {
                    foreach ($rows AS $row) {
                        ($row->service_id == $id) ? $newData['id'] = $row->id : '';
                    }
                    $newData['product_id'] = $data['id'];
                    $newData['service_id'] = $id;
                    $newData['service_value'] = implode(",",$service);
                    try {
                        $table_feature_value = $this->getTable($type = 'productservice', $prefix = 'ProshoppTable', $config = array());
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
                    unset($newData);
                }

            }
        $allStocks = JFactory::getApplication()->input->get('stock', array(), 'array');
        foreach ($allStocks AS $index => $stocks) {
            foreach ($stocks AS $id => $stock) {
                if (!empty($stock[1])) {
                    $stock['id'] = '';
                    $stock['stockID'] = $id;
                    $stock['product_id'] = $data['id'];
                    $stock['skuID'] = $index;
                    $stock['befor_count'] = $stock[0];
                    if($stock['befor_count'] != '∞'){
                        $stock['after_count']= $stock['befor_count']+$stock[1];
                    }else{
                        $stock['after_count'] = $stock[1];
                    }
                    $stock['datetime'] = date("Y-m-d H:i:s");
                    $stock['order_id'] = '';
                    try {
                        $table_feature_value = $this->getTable($type = 'Stocklog', $prefix = 'ProshoppTable', $config = array());
                        if (!$table_feature_value->bind($stock)) {
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
                    unset($stock);
                }
            }
        }
        
        return parent::save($data);

    }
    public function insertNewPrice($newPrice){
        try {
            $table_feature_value = $this->getTable($type = 'Skuprice', $prefix = 'ProshoppTable', $config = array());
            if (!$table_feature_value->bind($newPrice)) {
                $this->setError($table->getError());
                return false;
            }
            if (!$table_feature_value->store($newPrice)) {
                $this->setError($user->getError());
                return false;
            }
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }
    
}