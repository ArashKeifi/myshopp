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

class ProshoppModelOrderview extends JModelLegacy
{
    public $order_id;
    public $status_id;
    public $db ;
    public $statusType ;
    public $smsGetaway;
    public $emailGetaway;
    public function view()
    {
        $this->order_id = JRequest::getInt('id', '0');
        $cacheParams = JFactory::getCache();
        $this->statusType = $cacheParams->call( array( 'ProshoppHelper', 'getStatus' ));
        $this->db = JFactory::getDbo();
        $query = $this->db->getQuery(true);
        $query->select('a.id,a.total,a.create_datetime,a.coupon_code,a.comment,a.paid_data,a.tax,a.payment_type,a.order_type,a.shipping,b.email,b.name,c.name AS address_name,c.tell_cod,c.tell,c.state_id,c.city_id,c.quarter_id,c.address,c.zip_cod');
        $query->from($this->db->quoteName('#__shopp_order') . ' AS a');
        $query->join('INNER', $this->db->quoteName('#__users', 'b') . ' ON (' . $this->db->quoteName('a.user_id') . ' = ' . $this->db->quoteName('b.id') . ')');
        $query->join('INNER', $this->db->quoteName('#__shopp_user_address', 'c') . ' ON (' . $this->db->quoteName('a.contact_id') . ' = ' . $this->db->quoteName('c.id') . ')');
        $query->where('a.id = ' . (int)$this->order_id);
        $query->order('a.id ASC');
        $this->db->setQuery($query);
        if($general=$this->db->loadObject()){
            $general->create_datetime = JHtml::date($general->create_datetime , 'D F n, Y g:i a');
            $returns = '{"general":'.json_encode( $general );
            $availableStatus='';
            if($StatusHistory=$this->statusHistory()) {
                foreach ($this->statusType as $val => $option) {
                    foreach ($StatusHistory AS $StatusHistoryItem) {
                        if($StatusHistoryItem->action == $option->id){
                            unset($this->statusType[$val]);
                            $StatusHistoryItem->action = $option->status_name;
                            break;
                        }
                    }
                }
                $returns .= ',"statusHistory":'.json_encode($StatusHistory).'';
            }
            foreach ($this->statusType as $option) {
                $availableStatus .= '<option value="'.$option->id.'">'.$option->status_name.'</option>';
            }
            $returns .= ',"statusTypes":'.json_encode($availableStatus).'';
            $returns .= '}';
            echo $returns;
        }else{
            echo "false";
        }

    }
    public function statusHistory(){
        $query = $this->db->getQuery(true);
        $query->select('a.id,a.action,a.datetime,a.params');
        $query->from($this->db->quoteName('#__shopp_order_log') . ' AS a');
        $query->where('a.order_id = ' . (int)$this->order_id);
        $query->order('a.datetime ASC');
        $this->db->setQuery($query);
        //echo $query;
        return $this->db->loadObjectList();
    }

    public function changestatus(){
        $this->order_id = JRequest::getInt('id', '0');
        $this->status_id = JRequest::getInt('status_id', '0');
        $dbParameter='';
        // SMS getaway config
        if($smsMessageID=ProshoppHelper::searchInStatus($this->status_id,'sms_message') and $this->smsGetaway = JComponentHelper::getParams('com_proshopp')->get('smsplugin')) {
            JPluginHelper::importPlugin('proshopp-sms', $this->smsGetaway);
            $dispatcher = JDispatcher::getInstance();
            $handler = 'plgProshoppsms' . $this->smsGetaway;
            $dispatcher->register('onOrderStatusChange', $handler);
            $parameters = (object)array('messageID'=>$smsMessageID, 'orderID'=>$this->order_id);
            $dbParameter .= $dispatcher->trigger('onOrderStatusChange',$parameters)[0];
        }

        // Email getaway config
        if($emailMessageID=ProshoppHelper::searchInStatus($this->status_id,'email_message') and $this->emailGetaway = JComponentHelper::getParams('com_proshopp')->get('emailplugin')) {
            JPluginHelper::importPlugin('proshopp-email', $this->emailGetaway);
            $dispatcher = JDispatcher::getInstance();
            $handler = 'plgProshoppemail' . $this->emailGetaway;
            $dispatcher->register('onOrderStatusChange', $handler);
            $parameters = (object)array('messageID'=>$emailMessageID, 'orderID'=>$this->order_id);
            $dbParameter .= $dispatcher->trigger('onOrderStatusChange',$parameters)[0];
        }

        // Insert new status in order history
        $this->db = JFactory::getDbo();
        $query = $this->db->getQuery(true);
        $columns = array('id', 'order_id', 'action', 'datetime', 'params');
        $values = array('0', $this->db->quote($this->order_id), $this->db->quote($this->status_id), 'CURRENT_TIMESTAMP', "'".$dbParameter."'");
        $query
            ->insert($this->db->quoteName('#__shopp_order_log'))
            ->columns($this->db->quoteName($columns))
            ->values(implode(',', $values));
        $this->db->setQuery($query);
        if($this->db->execute()){
            $query->clear();
            $fields = array(
                $this->db->quoteName('status') . ' = ' . $this->db->quote($this->status_id)
            );
            $conditions = array(
                $this->db->quoteName('id') . ' = '.$this->order_id
            );
            $query->update($this->db->quoteName('#__shopp_order'))->set($fields)->where($conditions);
            $this->db->setQuery($query);
            $this->db->execute();

            //Stock action
            if($stockStatus=ProshoppHelper::searchInStatus($this->status_id,'stock') ){
                $this->updateStock();
            }
            echo $dbParameter;
        }else{
            echo "false";
        }
    }

    private function updateStock(){
    }
    

}
