<?php
/**
 * @module        com_Proshopp
 * @script        type.php
 * @author-name arash
 * @copyright    Copyright (C) 2015 arash
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ProshoppModelLocation extends JModelAdmin
{
    public function getTable($type = 'Location', $prefix = 'ProshoppTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_proshopp.location', 'location', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_proshopp.edit.location.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }

    protected function populateState()
    {
        $app = JFactory::getApplication('administrator');

        $parentId = $app->input->getInt('parent_id');
        $this->setState('category.parent_id', $parentId);

        // Load the User state.
        $pk = $app->input->getInt('id');
        $this->setState($this->getName() . '.id', $pk);

    }
    public function save($data)
    {
        $dispatcher = JEventDispatcher::getInstance();
        $table      = $this->getTable();
        $input      = JFactory::getApplication()->input;
        $pk         = (!empty($data['id'])) ? $data['id'] : (int) $this->getState($this->getName() . '.id');
        $isNew      = true;
        $context    = $this->option . '.' . $this->name;
        if(empty ($data['alias'])){
            $data['alias'] = JFilterOutput::stringURLSafe($data['title']);
        }

        // Include the plugins for the save events.
        JPluginHelper::importPlugin($this->events_map['save']);

        // Load the row if saving an existing category.
        if ($pk > 0)
        {
            $table->load($pk);
            $isNew = false;
        }

        // Set the new parent id if parent id not matched OR while New/Save as Copy .
        if ($table->parent_id != $data['parent_id'] || $data['id'] == 0)
        {
            $table->setLocation($data['parent_id'], 'last-child');
        }

        // Alter the title for save as copy
        if ($input->get('task') == 'save2copy')
        {
            $origTable = clone $this->getTable();
            $origTable->load($input->getInt('id'));

            if ($data['title'] == $origTable->title)
            {
                list($title, $alias) = $this->generateNewTitle($data['parent_id'], $data['alias'], $data['title']);
                $data['title'] = $title;
                $data['alias'] = $alias;
            }
            else
            {
                if ($data['alias'] == $origTable->alias)
                {
                    $data['alias'] = '';
                }
            }

            $data['published'] = 0;
        }

        // Bind the data.
        if (!$table->bind($data))
        {
            $this->setError($table->getError());

            return false;
        }

        // Bind the rules.
        if (isset($data['rules']))
        {
            $rules = new JAccessRules($data['rules']);
            $table->setRules($rules);
        }

        // Check the data.
        if (!$table->check())
        {
            $this->setError($table->getError());

            return false;
        }

        // Trigger the before save event.
        $result = $dispatcher->trigger($this->event_before_save, array($context, &$table, $isNew));

        if (in_array(false, $result, true))
        {
            $this->setError($table->getError());

            return false;
        }

        // Store the data.
        if (!$table->store())
        {
            $this->setError($table->getError());

            return false;
        }

        // Trigger the after save event.
        $dispatcher->trigger($this->event_after_save, array($context, &$table, $isNew));

        // Rebuild the path for the category:
        if (!$table->rebuildPath($table->id))
        {
            $this->setError($table->getError());

            return false;
        }

        // Rebuild the paths of the category's children:
        if (!$table->rebuild($table->id, $table->lft, $table->level, $table->path))
        {
            $this->setError($table->getError());

            return false;
        }

        $this->setState($this->getName() . '.id', $table->id);

        // Clear the cache
        $this->cleanCache();

        return true;
    }

    protected function generateNewTitle($parent_id, $alias, $title)
    {
        // Alter the title & alias
        $table = $this->getTable();

        while ($table->load(array('alias' => $alias, 'parent_id' => $parent_id)))
        {
            $title = JString::increment($title);
            $alias = JString::increment($alias, 'dash');
        }

        return array($title, $alias);
    }
}