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

class ProshoppModelTypes extends JModelList
{
    protected $searchInFields = array('a.id', 'a.name');

    public function __construct($config = array())
    {
        $config['filter_fields'] = $this->searchInFields;
        parent::__construct($config);
    }


    protected function getListQuery()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,a.published,a.icon');
        $query->from($db->quoteName('#__shopp_type') . ' AS a');
        $regex = str_replace(' ', '|', $this->getState('filter.search'));
        if (!empty($regex)) {
            $regex = ' REGEXP ' . $db->quote($regex);
            $query->where('(' . implode($regex . ' OR ', $this->searchInFields) . $regex . ')');
        }

        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.published = ' . (int)$published);
        } elseif (empty($published)) {
            $query->where('(a.published IN (0,1))');
        }
        $query->order('a.id ASC');
        return $query;

    }

    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', preg_replace('/\s+/', ' ', $search));

        $published = $this->getUserStateFromRequest($this->context . 'filter.state', 'filter_state', '', 'String');
        $this->setState('filter.state', $published);
    }

    protected function getStoreId($id = '')
    {

        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');
        return parent::getStoreId($id);

    }
}