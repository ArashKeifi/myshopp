<?php
/**
 * @module		com_Proshopp
 * @script		Proshopp.php
 * @author-name Arash Kifi
 * @copyright	Copyright (C) 2015 Arash Kifi
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');


class ProshoppTableLocation extends JTableNested {
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__shopp_location', 'id', $db);
	}
	
	public function delete($pk = null, $children = false)
	{
		return parent::delete($pk, $children);
	}

}
