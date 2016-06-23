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

class ProshoppModelAjax extends JModelLegacy
{

    public function delete()
    {
        $id = JRequest::getCmd('id', '0');
        $table = JRequest::getCmd('table', '');
        $skuid = JRequest::getCmd('sku', '0');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        if($skuid){
            $subquery = $db->getQuery(true);
            $conditionsku = array(
                $db->quoteName('skuID') . ' = '.$skuid
            );
            $subquery->delete($db->quoteName('#__shopp_sku_price'));
            $subquery->where($conditionsku);
            $db->setQuery($subquery);
            $db->execute();
        }
        $conditions = array(
            $db->quoteName('id') . ' = '.$id
        );
        $query->delete($db->quoteName('#__'.$table));
        $query->where($conditions);
        $db->setQuery($query);
        if($db->execute() && $table !=''){
            echo "true";
        }else{
            echo "false";
        }

    }
}