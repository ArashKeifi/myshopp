<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JFormHelper::loadFieldClass('list');
class JFormFieldProducttag extends JFormFieldList  {

    protected $type = 'Producttag';

    public function getOptions() {
        $options = explode("\r\n", JComponentHelper::getParams('com_proshopp')->get('producttags', '0'));
        foreach ($options AS $option){
            $newoption[]= array('text'=>$option,'value'=>$option);
        }
        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $newoption);
        return $options;
    }
}