<?php
/**
 * @module		com_RealState
 * @author-name Arash Kifi
 * @copyright	Copyright (C) 2012 Arash Kifi
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Ola View
 */
class ProshoppViewStock extends JViewLegacy
{
	/**
	 * display method of RealState view
	 * @return void
	 */
    public function display($tpl = null)
    {
     // Initialiase variables.
     $this->form = $this->get('Form');
     $this->item = $this->get('Item');
     $this->state = $this->get('State');
     ProshoppHelper::addSubmenu('Stocks');
     // Check for errors.
     if (count($errors = $this->get('Errors'))) {
         JError::raiseError(500, implode("\n", $errors));

         return false;
     }

     $this->addToolbar();
     $this->sidebar = JHtmlSidebar::render();
     parent::display($tpl);
    }
        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
            JFactory::getApplication()->input->set('hidemainmenu', true);
        	$isNew = ($this->item->id == 0);
        	JToolBarHelper::title($isNew ? JText::_('COM_PROSHOPP_ADMIN_STOCK_NEW')
        	: JText::_('COM_PROSHOPP_ADMIN_STOCK_EDIT'), 'type');
        	JToolBarHelper::apply('stock.apply');
        	JToolBarHelper::save('stock.save');
        	JToolBarHelper::cancel('stock.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
        }

}
