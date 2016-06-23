<?php

/**
 * @module        proshopp
 * @script        controller.php
 * @author-name   Arash Kifi
 * @copyright     Copyright (C)2015 Arash Kifi
 * @license       GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * General Controller of ProShopp component
 */
class ProshoppController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = array())
    {
        JRequest::setVar('view', JRequest::getCmd('view', 'Proshopp'));
        parent::display($cachable, $urlparams);
    }
    public function ajax($cachable = false, $urlparams = array())
    {
        $model = $this->getModel('ajax');
        $command=JRequest::getCmd('type', 'delete');
        $model->$command();
    }
    public function orderview($cachable = false, $urlparams = array())
    {
        $model = $this->getModel('orderview');
        $command=JRequest::getCmd('type', 'view');
        $model->$command();
    }
    public function sku($cachable = false, $urlparams = array())
    {
        $options=JRequest::getVar('options', '0');
        function possible_combos($groups, $prefix='') {
            $result = array();
            $group = array_shift($groups);
            foreach($group as $selected) {
                if($groups) {
                    $result = array_merge($result, possible_combos($groups, $prefix . $selected. ','));
                } else {
                    $result[] = $prefix . $selected;
                }
            }
            return $result;
        }
        echo json_encode(possible_combos($options));
    }
}