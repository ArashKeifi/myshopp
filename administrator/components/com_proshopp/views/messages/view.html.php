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

class ProshoppViewMessages extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $canDo;
    
    public function display($tpl = null)
    {
        $this->state = $this -> get('State');
        $this->items = $this-> get('Items');
        $this->pagination = $this->get('Pagination');
        $this-> canDo = JHelperContent::getActions('com_proshopp');
        ProshoppHelper::addSubmenu('Messages');
        if(count($errors = $this-> get ('Errors'))){
            JError::raiseError(500,implode('<br/>', $errors));
        }
        $this-> addToolBar();
        $this->sidebar = JHtmlSidebar::render();
        return parent::display($tpl);
    }

    protected function addToolBar(){
        $state = $this->get('State');
        $bar = JToolbar::getInstance('toolbar');
        JToolbarHelper::title(JText::_('COM_PROSHOPP_SUBMENU_MESSAGES'));

        if(JFactory::getUser()->authorise('core.admin','com_proshopp')){
            JToolbarHelper::preferences('com_proshopp');
        }
        if ($this -> canDo -> get('core.create')) {
            JToolBarHelper::addNew('message.add');
        }
        if ($this -> canDo -> get('core.edit')) {
            JToolBarHelper::editList('message.edit');
        }
        if ($this -> canDo -> get('core.edit.state')) {
            JToolBarHelper::publishList('messages.publish');
            JToolBarHelper::unpublishList('messages.unpublish');
        }
        if ($this -> canDo -> get('core.delete')) {
            if ($this -> state -> get('message.state') == -2) {
                JToolbarHelper::deleteList('', 'messages.delete', 'JTOOLBAR_EMPTY_TRASH');
            } else {
                JToolbarHelper::trash('messages.trash');
            }
        }

    }

}