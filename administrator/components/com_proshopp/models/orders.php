<?php
/**
 * @module        myshopp
 * @script        types.php
 * @author-name Arash Kifi
 * @copyright    Copyright (C)2015 Arash Kifi
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppModelOrders extends JModelList
{
    protected $searchInFields = array('b.name');

    public function __construct($config = array())
    {
        $config['filter_fields'] = $this->searchInFields;
        parent::__construct($config);
    }


    protected function getListQuery()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.create_datetime,a.status,a.total,b.name');
        $query->from($db->quoteName('#__shopp_order') . ' AS a');
        $query->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.user_id') . ' = ' . $db->quoteName('b.id') . ')');
        $order_id = $this->getState('filter.order_id');
        if (is_numeric($order_id)) {
            $query->where('a.id = ' . (int)$order_id);
        } 
        $date = $this->getState('filter.date');
        if (!empty($date)) {
            $query->where('a.create_datetime = ' . (int)$date);
        } 
        $regex = str_replace(' ', '|', $this->getState('filter.customer'));
        if (!empty($regex)) {
            $regex = ' REGEXP ' . $db->quote($regex);
            $query->where('(' . implode($regex . ' OR ', $this->searchInFields) . $regex . ')');
        }

        $published = $this->getState('filter.state');
        if (is_numeric($published) && !empty($published)) {
            $query->where('a.status = "'.(string)$published.'"');
        } 
        $query->order('a.id ASC');
        return $query;
    }

    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context . '.filter.customer', 'filter_customer');
        $this->setState('filter.customer', preg_replace('/\s+/', ' ', $search));

        $published = $this->getUserStateFromRequest($this->context . 'filter.state', 'filter_state', '', 'String');
        $this->setState('filter.state', $published);

        $order_id = $this->getUserStateFromRequest($this->context . 'filter.order_id', 'filter_order_id', '', 'String');
        $this->setState('filter.order_id', $order_id);

        $date = $this->getUserStateFromRequest($this->context . 'filter.date', 'filter_date', '', 'String');
        $this->setState('filter.date', $date);
    }

    protected function getStoreId($id = '')
    {
        $id .= ':' . $this->getState('filter.customer');
        $id .= ':' . $this->getState('filter.status');
        $id .= ':' . $this->getState('filter.date');
        $id .= ':' . $this->getState('filter.order_id');
        return parent::getStoreId($id);

    }
}