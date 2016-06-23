<?php
/**
 * Created by PhpStorm.
 * User: Arash
 * Date: 12/7/2015
 * Time: 4:15 PM
 */

/**
 * Products Model
 */
defined('_JEXEC') or die('Restricted access');

class ProshoppModelProducts extends JModelList{
    protected $searchInFields = array('a.id','a.name',);
    public function __construct($config=array()){
        $config[ 'filter_fields' ]= $this->searchInFields ;
        parent::__construct($config);
    }


    protected function getListQuery(){
        $db= JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,b.title,a.published,a.badge,a.default_pic,a.summary');
        $query->from($db->quoteName('#__shopp_product'). ' AS a');
        $query->leftJoin('#__categories AS b on b.id= a.category_id');
        $regex = str_replace(' ','|', $this->getState('filter.search'));
        if(!empty($regex)){
            $regex = ' REGEXP '.$db->quote($regex);
            $query->where('(' . implode($regex. ' OR ', $this-> searchInFields ) . $regex . ')');
        }

        $published = $this -> getState('filter.state');
        if(is_numeric($published)){
            $query->where('a.published = '. (int)$published);
        }elseif(empty($published)){
            $query->where('(a.published IN (0,1))');
        }
        $category= $this->getState('filter.category');
        if(is_numeric($category)){
            $query->where('a.category_id = '. (int)$category);
        }
        $badge= $this->getState('filter.badge');
        if(is_numeric($badge)){
            $query->where('a.badge='. (int)$badge);
        }
        $query -> order('a.id DESC');
        return $query;

    }
    protected function populateState($ordering = null, $direction = null){
        $search= $this->getUserStateFromRequest($this->context . '.filter.search','filter_search');
        $this->setState('filter.search', preg_replace('/\s+/', ' ', $search));

        $published = $this->getUserStateFromRequest($this->context.'filter.state','filter_state', '', 'String');
        $this -> setState('filter.state', $published);

        $category = $this->getUserStateFromRequest($this->context.'filter.category','filter_category', '', 'int');
        $this -> setState('filter.category', $category);

        $badge = $this->getUserStateFromRequest($this->context.'filter.badge','filter_badge', '', 'int');
        $this -> setState('filter.badge', $badge);
    }

    protected function getStoreId($id=''){

        $id .= ':' . $this -> getState('filter.search');
        $id .= ':' . $this -> getState('filter.state');
        $id .= ':' . $this -> getState('filter.category');
        $id .= ':' . $this -> getState('filter.badge');
        return parent::getStoreId($id);

    }
}