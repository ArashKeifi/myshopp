<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
class JFormFieldProductService extends JFormField  {

    protected $type = 'ProductService';
    protected $services;
    protected $service_value;
    protected $id;

    public function setup(SimpleXMLElement $element, $value, $group = null){
        $return = parent::setup($element, $value, $group);
        $this->id = JFactory::getApplication()->input->get('id');

        $db= JFactory::getDbo();
        $query = $db->getQuery(true);
        $subQuery = $db->getQuery(true);

        $subQuery->select('params');
        $subQuery->from('#__categories');
        $subQuery->where('id =' . $this->form->getValue('category_id'));
        $db->setQuery($subQuery);
        $count = $db->loadResult();

        $query->select('a.id,a.name AS service_name ,b.id AS subServiceId,b.service_id,b.name');
        $query->from($db->quoteName('#__shopp_service', 'a'));
        $query->join('INNER', $db->quoteName('#__shopp_service_items', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.service_id') . ')');
        $query->where('published = 1');
        $query .= " AND FIND_IN_SET(" . json_decode($count)->category_type[0] . ",a.type)";
        $db->setQuery($query);
        $this->services = $db->loadObjectList();

        $query='';
        $query = $db->getQuery(true);
        $query->select('a.service_value,a.service_id');
        $query->from($db->quoteName('#__shopp_product_service', 'a'));
        $query->where('a.product_id = '.$this->id);
        $db->setQuery($query);
        $this->services_value = $db->loadObjectList();
        return $return;
    }
    protected function getInput(){
        $proshoppParams = JComponentHelper::getParams('com_proshopp');
        $optionLang = $proshoppParams -> get('multilang', '0');
        $serviceItem = array();
        foreach($this->services as $service ){
            $service->service_value =  '';
            foreach($this->services_value as $value){
                if($service->id == $value->service_id) {
                    $service->service_value = $value->service_value;
                }
            }
            if (!in_array($service->id, $serviceItem)){
                array_push($serviceItem,$service->id);
                $html[]='<div class="form-group"><label>';
                $html[]= JText::_( ($optionLang) ? 'COM_PROSHOPP_PRODUCT_FEATURES_FIELD_'.strtoupper(str_replace(' ', '_', $service->service_name)) : $service->service_name);
                $html[]='</label><br>';
                foreach($this->services as $item ){
                    if($item->id == $service->id){
                        (in_array((string) $item->subServiceId, explode(',',$service->service_value) ) ? $checked ='checked="checked"' : $checked ='');
                        $html[]='<div class="checkbox checkbox-success checkbox-inline"> <input feature-id="'.$service->id.'" '.$checked.' type="checkbox" id="service_'.strtolower(str_replace(' ', '_', $service->name)).'" name="service['.$service->id.'][]" value="'.$item->subServiceId.'"><label for="inlineCheckbox1">'.$item->name.'</label></div>';
                    }
                }
                $html[]='</div><div class="hr-line-dashed"></div>';
            }
        }
        if(!empty($html)){
            return implode($html);
        }else{
            return '<div class="alert alert-info">'.JText::_('COM_PROSHOPP_PRODUCT_NO_FEATURE').'</div>';
        }
        
    }


}