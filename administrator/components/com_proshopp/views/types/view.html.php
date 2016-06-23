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

class ProshoppViewTypes extends JViewLegacy {

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
        ProshoppHelper::addSubmenu('Types');
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
        JToolbarHelper::title(JText::_('COM_PROSHOPP_ADMIN_MANAGER_TYPES'));

        if(JFactory::getUser()->authorise('core.admin','com_proshopp')){
            JToolbarHelper::preferences('com_proshopp');
        }
        if ($this -> canDo -> get('core.create')) {
            JToolBarHelper::addNew('type.add');
        }
        if ($this -> canDo -> get('core.edit')) {
            JToolBarHelper::editList('type.edit');
        }
        if ($this -> canDo -> get('core.edit.state')) {
            JToolBarHelper::publishList('types.publish');
            JToolBarHelper::unpublishList('types.unpublish');
        }
        if ($this -> canDo -> get('core.delete')) {
            if ($this -> state -> get('filter.state') == -2) {
                JToolbarHelper::deleteList('', 'types.delete', 'JTOOLBAR_EMPTY_TRASH');
            } else {
                JToolbarHelper::trash('types.trash');
            }
        }
        //JHtmlSidebar::addFilter(JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_state', JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this -> state -> get('filter.state'), true));
    }

}