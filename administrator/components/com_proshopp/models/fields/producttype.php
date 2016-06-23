<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('checkboxes');

class JFormFieldProductType extends JFormFieldCheckboxes {

    //The field class must know its own type through the variable $type.
    protected $type = 'ProductType';
    public $checkedOptions;
    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        $return = parent::setup($element, $value, $group);
        if ($return)
        {
            $this->checkedOptions = $value;

        }

        return $return;
    }
    protected function getInput()
    {
        $required       = $this->required ? ' required aria-required="true"' : '';
        $options = $this->getOptions();


        // Start the checkbox field output.
        $htmlnew[]='<select " name="' . $this->name . '" id="' . $this->id . '" data-placeholder="'.JText::_('JGULOBUL_CHOOSE_TYPE').'" multiple class="chosen-select '. $required .'">';
        $htmlnew[]= JHtml::_('select.options', $options, 'value', 'text', $this->checkedOptions);
        $htmlnew[]='</select>';
        return implode($htmlnew);
    }

    public function getOptions(){
        // Initialise variables.
        $options = array();
        $db = JFactory::getDbo();
        $query = $db -> getQuery(true)
            -> select('a.id AS value, a.name AS text')
            -> from('#__shopp_type AS a')
            -> where('a.published IN (0,1)');

        // Get the options.
        $db -> setQuery($query);

        try {
            $options = $db -> loadObjectList();
        } catch (RuntimeException $e) {
            JError::raiseWarning(500, $e -> getMessage());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

}
