<?php
/**
 * @module        myshopp
 * @script        products.php
 * @author-name   Arash Kifi
 * @copyright     Copyright (C) 2015 Arash Kifi
 * @license       GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
class ProshoppControllerProduct extends JControllerForm
{
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$task = $this->getTask();

		$item = $model->getItem(); 
		$id = $item->get('id');
		$tags = $validData['tags'];

		// Store the tag data if the weblink data was saved.
		if ($tags )
		{
			//$tagsHelper = new JHelperTags;
			//$tagsHelper->tagItem($id, 'com_proshopp.product', $tags);
		}

	}


}