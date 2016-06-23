<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
class JFormFieldProductPrice extends JFormField  {

    protected $type = 'ProductPrice';
    protected $features;
    protected $features_value;
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

        $query->select('a.field_type_option,a.id,a.name');
        $query->from($db->quoteName('#__shopp_feature', 'a'));
        $query->where('published = 1');
        $query .= " AND FIND_IN_SET(" . json_decode($count)->category_type[0] . ",a.type)";
        $db->setQuery($query);
        $this->features = $db->loadObjectList();
        $query='';
        $query = $db->getQuery(true);
        $query->select('a.feature_value,a.feature_id');
        $query->from($db->quoteName('#__shopp_product_price', 'a'));
        $query->where('a.product_id = '.$this->id);
        $db->setQuery($query);
        $this->features_value = $db->loadObjectList();
        return $return;

    }
    protected function getInput(){
        $proshoppParams = JComponentHelper::getParams('com_proshopp');
        $optionLang = $proshoppParams -> get('multilang', '0');
        if(!empty($this->features)) {
            foreach ($this->features as $feature) {
                if (!empty($feature->field_type_option)) {
                    $field_option = ProshoppHelper::featureFieldValue(str_replace("'", '"', $feature->field_type_option));
                } else {
                    $field_option = (object)array("type" => 'default', "items" => '');
                }
                $parametr = array('active' => 'pricetb_'.$feature->id);
                (empty($html) AND ($field_option->type == 'color' OR $field_option->type=='list' ) ) ? $html[] = JHtml::_('bootstrap.startTabSet', 'productPrice',$parametr  ) : '';
                $feature->feature_value = '';
                foreach ($this->features_value as $value) {
                    if ($feature->id == $value->feature_id) {
                        $feature->feature_value = $value->feature_value;
                    }
                }
                switch ($field_option->type) {
                    case 'color':
                        $html[] = JHtml::_('bootstrap.addTab', 'productPrice', 'pricetb_'.$feature->id , JText::_(($optionLang) ? 'COM_PROSHOPP_PRODUCT_FEATURES_FIELD_' . strtoupper(str_replace(' ', '_', $feature->name)) : $feature->name, true) . '<span style=" float: right; ">' . count($field_option->items) . '</span>');
                        $html[] = '<fieldset class="checkboxes">';
                        $html[] = '<ul style=" list-style-type: none; ">';
                        foreach ($field_option->items as $item) {
                            (in_array((string)$item->value, explode(',', $feature->feature_value)) ? $checked = 'checked="checked"' : $checked = '');
                            $html[] = '<li><div class="checkbox"><input feature-id="' . $feature->id . '" ' . $checked . ' type="checkbox" id="price_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" name="feature[' . $feature->id . '][]" value="' . $item->text . '"><label><span style="background: ' . $item->value . '" class="label">' . $item->text . '</span></label></div></li>';
                            //$html[]='<li><span class="feature_color" style="background: '.$item->value.'"></span><label for="jform_toppings0">'.$item->text.'</label></li>';
                        }
                        $html[] = '</ul>';
                        $html[] = '</fieldset>';
                        $html[] = JHtml::_('bootstrap.endTab');

                        break;
                    case 'list':
                        $html[] = JHtml::_('bootstrap.addTab', 'productPrice','pricetb_'.$feature->id , JText::_(($optionLang) ? 'COM_PROSHOPP_PRODUCT_FEATURES_FIELD_' . strtoupper(str_replace(' ', '_', $feature->name)) : $feature->name, true) . '<span style=" float: right; ">' . count($field_option->items) . '</span>');
                        $html[] = '<fieldset class="checkboxes">';
                        $html[] = '<ul style=" list-style-type: none; ">';
                        foreach ($field_option->items as $item) {
                            ($feature->feature_value == $item->value) ? $checked = 'checked="checked"' : $checked = '';
                            $html[] = '<li><div class="checkbox"><input feature-id="' . $feature->id . '" ' . $checked . ' type="checkbox" id="price_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" name="feature[' . $feature->id . '][]" value="' . $item->value . '"><label for="checkbox1">' . $item->text . '</label></div></li>';
                            //$html[]='<li><input  /><label for="jform_toppings0">'.$item->text.'</label></li>';
                        }
                        $html[] = '</ul>';
                        $html[] = '</fieldset>';
                        $html[] = JHtml::_('bootstrap.endTab');
                        //var_dump($html);
                        break;
                }

            }
            $html[] = JHtml::_('bootstrap.endTabSet');
        }else{
            return '<div class="alert alert-warning">'.JText::_('COM_PROSHOPP_ADMIN_ALERT_NO_FEATURE').'</div>';
        }
        return implode($html);
    }


}