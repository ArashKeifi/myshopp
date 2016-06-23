<?php
/**
 * @module        myshopp
 * @author-name   Arash Kifi
 * @copyright     Copyright (C) 2015 Arash Kifi
 * @license       GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppControllerService extends JControllerForm
{
    function save($key = null, $urlVar = null)
    {
        $data  = $this->input->post->get('jform', array(), 'array');
        $type = $data['type'];
        if (!isset($type))
        {
            $type = "";
            $data['type'] = $type;
        }
        else
        {
            $data['type'] = implode(",",  $data['type']);
        }
        $this->input->post->set('jform', $data);
        parent::save('id', $urlVar);

    }
}