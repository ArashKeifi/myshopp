<?php
/**
 * @module      com_RealState
 * @script      RealState.php
 * @author-name Arash Kifi
 * @copyright   Copyright (C) 2012 Arash Kifi
 * @license     GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if (!JFactory::getUser()->authorise('core.manage', 'com_proshopp'))
{
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

// require helper file
JLoader::register('ProshoppHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'proshopp.php');
 
jimport('joomla.application.component.controller');
 
$controller = JControllerLegacy::getInstance('Proshopp');
$controller->execute(JFactory::getApplication()->input->get('task'));

$controller->redirect();