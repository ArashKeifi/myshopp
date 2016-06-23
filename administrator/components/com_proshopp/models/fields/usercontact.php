<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
class JFormFieldUserContact extends JFormField  {

    protected $type = 'UserContact';

    public function setup(SimpleXMLElement $element, $value, $group = null){
        $return = parent::setup($element, $value, $group);
        $db= JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,a.tell_cod,a.tell,a.state_id,a.city_id,a.quarter_id,a.address,a.zip_cod');
        $query->from($db->quoteName('#__shopp_user_address', 'a'));
        $query->where('published = 1');
        $query->where('a.user_id = '.$this->form->getValue('user_id'));
        $db->setQuery($query);
        //$this->features = $db->loadObjectList();
        return $return;
    }
    protected function getInput(){
        $proshoppParams = JComponentHelper::getParams('com_proshopp');
        $optionLang = $proshoppParams -> get('multilang', '0');
        //$html[]=
        //return implode($html);
    }
}