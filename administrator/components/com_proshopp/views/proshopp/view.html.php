<?php
/**
 * @module        com_Proshopp
 * @script        view.html.php
 * @author-name   arash
 * @copyright     Copyright (C) 2015 arash
 * @license       GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppViewProshopp extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $canDo;
    public function display($tpl = null)
    {
        //$this->state = $this -> get('State');
        //$this->items = $this-> get('Items');
        //$this->pagination = $this->get('Pagination');
        $this-> canDo = JHelperContent::getActions('com_proshopp');
        ProshoppHelper::addSubmenu('Controls');
        if(count($errors = $this-> get ('Errors'))){
            JError::raiseError(500,implode('<br/>', $errors));
        }

        $this->sidebar = JHtmlSidebar::render();
        return parent::display($tpl);
    }

}