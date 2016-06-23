<?php
/**
 * @module        myshopp
 * @author-name Arash Kifi
 * @copyright    Copyright (C)2015 Arash Kifi
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppModelFeatures extends JModelList
{
    protected $orderingType = array('a.ordering','a.type');
    protected $searchInFields=array('a.name');
    public function __construct($config = array())
    {
        $config['filter_fields'] = $this->orderingType;
        parent::__construct($config);
    }


    protected function getListQuery()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id,a.name,a.published,GROUP_CONCAT(b.name) AS types,a.ordering');
        $query->from($db->quoteName('#__shopp_feature', 'a'));
        $query->join('LEFT', $db->quoteName('#__shopp_type', 'b').' ON FIND_IN_SET( b.id, a.type)');
        $regex = str_replace(' ', '|', $this->getState('filter.search'));
        if (!empty($regex)) {
            $regex = ' REGEXP ' . $db->quote($regex);
            $query->where('(' . implode($regex . ' OR ', $this->searchInFields) . $regex . ')');
        }

        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.published = ' . (int)$published);
        } elseif (empty($published) OR $published=='*') {
            $query->where('(a.published IN (0,1))');
        }

        $type = $this->getState('filter.type');
        if (is_numeric($type) && !empty($type)) {
            $query->where('b.id = ' . (int)$type);
        }
        $query->group($db->quoteName('a.id'));
        $query->order($db->escape($this->getState('list.ordering', 'a.id')).' '.
            $db->escape($this->getState('list.direction', 'ASC')));
        return $query;

    }

    protected function populateState($ordering = null, $direction = null)
    {
        parent::populateState('a.id', 'ASC');
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', preg_replace('/\s+/', ' ', $search));

        $published = $this->getUserStateFromRequest($this->context . 'filter.state', 'filter_state', '');
        $this->setState('filter.state', $published);

        $type = $this->getUserStateFromRequest($this->context . 'filter.type', 'filter_type', '', 'int');
        $this->setState('filter.type', $type);
    }

    protected function getStoreId($id = '')
    {

        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');
        $id .= ':' . $this->getState('filter.type');
        return parent::getStoreId($id);

    }
}