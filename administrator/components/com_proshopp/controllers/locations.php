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

class ProshoppControllerLocations extends JControllerAdmin
{
    public function getModel($name = 'Location', $prefix= 'ProshoppModel', $config = array())
    {
        return parent::getModel($name , $prefix , array('ignore_request' => true));
    }
}