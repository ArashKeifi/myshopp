<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
class JFormFieldSkusearch extends JFormField  {

    protected $type = 'SkuSearch';
    protected $features;
    protected $features_value;
    protected $id;

    public function setup(SimpleXMLElement $element, $value, $group = null){
        $return = parent::setup($element, $value, $group);
        return $return;
    }
    protected function getInput(){
        $proshoppParams = JComponentHelper::getParams('com_proshopp');
        $optionLang = $proshoppParams -> get('multilang', '0');
        $html[]='<div class="uk-form-icon">
    <i class="uk-icon-calendar"></i>
    <input type="text">
</div>';
        return implode($html);
    }
}