<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JFormHelper::loadFieldClass('list');

// The class name must always be the same as the filename (in camel case)
class JFormFieldLocationParent extends JFormFieldList {

	//The field class must know its own type through the variable $type.
	protected $type = 'LocationParent';

	protected function getOptions() {
		// Initialise variables.
		$options = array();
		$name = (string)$this -> element['name'];

		// Let's get the id for the current item, either category or content item.
		$jinput = JFactory::getApplication() -> input;
		// For categories the old category is the category id 0 for new category.
		
		$db = JFactory::getDbo();
		$query = $db -> getQuery(true) -> select('a.id AS value, a.title AS text, a.level') -> from('#__shopp_location AS a') -> join('LEFT', $db -> quoteName('#__shopp_location') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt');
		// Filter by the type
		if ($this -> element['parent']) {
			// Prevent parenting to children of this item.
			if ($id = $this -> form -> getValue('id')) {
				$query -> join('LEFT', $db -> quoteName('#__shopp_location') . ' AS p ON p.id = ' . (int)$id) -> where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');

				$rowQuery = $db -> getQuery(true);
				$rowQuery -> select('a.id AS value, a.title AS text, a.level, a.parent_id') -> from('#__shopp_location AS a') -> where('a.id = ' . (int)$id);
				$db -> setQuery($rowQuery);
				$row = $db -> loadObject();
			}
		}
		$query -> where('a.published IN (0,1)') -> group('a.id, a.title, a.level, a.lft, a.rgt, a.parent_id') -> order('a.lft ASC');

		// Get the options.
		$db -> setQuery($query);

		try {
			$options = $db -> loadObjectList();
		} catch (RuntimeException $e) {
			JError::raiseWarning(500, $e -> getMessage());
		}

		// Pad the option text with spaces using depth level as a multiplier.
		for ($i = 0, $n = count($options); $i < $n; $i++) {
			// Translate ROOT
			if ($options[$i] -> level == 0) {
				$options[$i] -> text = JText::_('JGLOBAL_ROOT_PARENT');
			}elseif($options[$i] -> level != 1){
				$options[$i] -> text = str_repeat('&nbsp;&nbsp;', $options[$i] -> level-1) ."'-". $options[$i] -> text;
			}
		}
		// Get the current user object.
		

		if (isset($row) && !isset($options[0])) {
			if ($row -> parent_id == '1') {
				$parent = new stdClass;
				$parent -> text = JText::_('JGLOBAL_ROOT_PARENT');
				array_unshift($options, $parent);
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}

}
