<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JFormHelper::loadFieldClass('radio');
jimport('joomla.form.formfield');
class JFormFieldProductFeature extends JFormField  {

    protected $type = 'ProductFeature';
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
        $category = json_decode($db->loadResult());
        if(property_exists($category, 'category_type')){
        $category_type = $category->category_type[0];
        $query->select('a.required,a.field_type_option,a.id,a.name,a.measurement');
        $query->from($db->quoteName('#__shopp_feature', 'a'));
        $query->where('published = 1');
        $query .= " AND FIND_IN_SET(" . $category_type . ",a.type)";
        $db->setQuery($query);
        $this->features = $db->loadObjectList();
        $query='';
        $query = $db->getQuery(true);
        $query->select('a.feature_value,a.feature_id');
        $query->from($db->quoteName('#__shopp_product_feature', 'a'));
        $query->where('a.product_id = '.$this->id);
        $db->setQuery($query);
        $this->features_value = $db->loadObjectList();
        }
        return $return;
    }
    protected function getInput()
    {
        $proshoppParams = JComponentHelper::getParams('com_proshopp');
        $optionLang     = $proshoppParams->get('multilang', '0');
        $document       = JFactory::getDocument();
        $document->addStyleSheet('components/com_proshopp/assets/css/proshopp.css');
        $unit = array("length"    => array("m" => "m", "cm" => "cm", "mm" => "mm", "in" => "in", "ft" => "ft", "km" => "km"),
                      "weight"    => array("g" => "g", "kg" => "kg", "lbs" => "lbs", "oz" => "oz"),
                      "volume"    => array("l" => "l", "ml" => "ml", "cm3" => "cm³", "m3" => "m³", "cl" => "cl", "mm3" => "mm³"),
                      "frequency" => array("Hz" => "Hz", "KHz" => "KHz", "MHz" => "MHz", "GHz" => "GHZ"));
        if($this->features){
            foreach ($this->features as $feature)
            {
                $feature->feature_value = '';
                foreach ($this->features_value as $value)
                {
                    if ($feature->id == $value->feature_id)
                    {
                        $feature->feature_value = $value->feature_value;
                    }
                }
                if (!empty($feature->field_type_option)) {
                    $field_option = ProshoppHelper::featureFieldValue(str_replace("'", '"', $feature->field_type_option));
                } else {
                    $field_option = (object)array("type"=>'default',"items"=>'');
                }

                $required     = $feature->required ? ' required" ' : '"';
                $html[]       = '<div class="clearfix  form-group">';
                $html[]       = '<label class="col-sm-2 control-label' . $required . '">';
                $html[]       = JText::_(($optionLang) ? 'COM_PROSHOPP_PRODUCT_FEATURES_FIELD_' . strtoupper(str_replace(' ', '_', $feature->name)) : $feature->name);
                $html[]       = $feature->required ? '<span class="star">&nbsp;*</span>' : '';
                $html[]       = '</label>';

                $required     = $feature->required ? ' required" aria-required="true"' : '"';
                
                switch ($field_option->type)
                {
                    case 'color':
                        $html[] = '<div class="col-sm-10">';
                        $html[]= '<input type="hidden" value="0" name="feature[' . $feature->id . '][]"/>';
                        $html[] = '<ul style=" list-style-type: none; ">';
                        foreach ($field_option->items as $item)
                        {
                            (in_array((string) $item->value, explode(',', $feature->feature_value)) ? $checked = 'checked="checked"' : $checked = '');
                            $html[]='<li><div class="checkbox"><input class="'.$required.$checked.' type="checkbox" id="price_feature_'.strtolower(str_replace(' ', '_', $feature->name)).'" name="feature['.$feature->id.'][]" value="'.$item->value.'"><label><span style="background: '.$item->value.'" class="label">'.$item->text.'</span></label></div></li>';
                        }
                        $html[] = '</ul>';
                        $html[] = '</div>';
                        break;
                    case 'list':
                        $document->addStyleSheet('components/com_proshopp/assets/theme/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css', 'text/css');
                        foreach ($field_option->items as $item)
                        {
                            ($feature->feature_value == $item->value) ? $checked = 'checked="checked"' : $checked = '';
                            $html[]='<div class="checkbox checkbox-success checkbox-inline">
                                            <input '.$checked.' class="'.$required.' type="checkbox" id="jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" name="feature[' . $feature->id . '][]" value="' . $item->value . '">
                                            <label for="inlineCheckbox1">'.$item->text.'</label>
                                        </div>';

                        }
                        break;

                    case 'multiple':
                        $html[] = '<div class="col-sm-10">';
                        $html[] = '<select name="feature[' . $feature->id . ']" id="jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" class="form-control m-b ' . $field_option->type .$required. '>';
                        foreach ($field_option->items as $item)
                        {
                            ($item->value == $feature->feature_value) ? $selected = ' selected' : $selected = '';
                            $html[] = '<option ' . $selected . ' value="' . $item->value . '"' . '' . ' >' . $item->text . '</option>';
                        }
                        $html[] = '</select>';
                        $html[] = '</div>';
                        break;
                    case 'text':
                        $html[] = '<div class="col-sm-10">';
                        $html[] = '<input type="text"  class="form-control m-b '.$required.'  name="feature[' . $feature->id . ']" id="jform_feature_' . strtolower(str_replace(' ', '_', $feature->id)) . '" value="' . $feature->feature_value . '">';
                        $html[] = '</div>';
                        break;
                    case 'radio':
                        $html[] = '<div class="col-sm-10">';
                        $document->addStyleSheet('components/com_proshopp/assets/theme/css/plugins/switchery/switchery.css', 'text/css');
                        $document->addScript('components/com_proshopp/assets/theme/js/plugins/switchery/switchery.js', 'text/javascript');
                        $document->addScriptDeclaration('jQuery(document).ready(function() {var elem = document.querySelector(\'.js-switch\');var switchery = new Switchery(elem, { color: \'#1AB394\' });});');
                        $checked = $feature->feature_value ? ' checked ' : '"';
                        $html[]= '<input type="hidden" value="0" name="feature[' . $feature->id . ']"/>';
                        $html[] ='<input type="checkbox" class="js-switch'.$required.' name="feature[' . $feature->id . ']" id="jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" '.$checked.' />';
                        $html[] = '</div>';
                        break;
                    case 'editor':
                        $editor =& JFactory::getEditor();
                        $html[] = '<div class="col-sm-10">';
                        $html[] = $editor->display('feature[' . $feature->id . ']', $feature->feature_value, '300', '200', '10', '5', false, 'jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)));
                        $html[] = '</div>';
                        break;
                    case 'value':
                        $valInput = '<div class="row"><div class="col-md-2"><input type="text" class="form-control jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" value=""></div><label>*</label>' . '<div class="col-md-2"><input type="text" class="form-control jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" value="" ><label>*</label></div>' . '<input type="text" class="form-control jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" value=""></div>';
                        if ($feature->measurement)
                        {
                            $valInput .= '<select class="feature_val jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '_measur">';
                            foreach ($unit[$feature->measurement] as $value => $option)
                            {
                                //if ($value == $this->fieldType ){$selected = 'selected';}else{$selected = '';}
                                $selected = '';
                                $valInput .= '<option value="' . $value . '"' . $selected . ' >' . $option . '</option>';
                            }
                            $valInput .= '</select>';
                        }
                        $html[] = $valInput;
                        $html[]="</div>";
                        $html[] = '<input type="hidden" name="feature[' . $feature->id . ']" id="jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" value="" size="20">';

                        break;
                    case 'file':
                        jimport('joomla.filesystem.folder');
                        $document->addStyleSheet('components/com_proshopp/assets/upload/css/jquery.filer.css');
                        $document->addStyleSheet('components/com_proshopp/assets/upload/css/themes/jquery.filer-dragdropbox-theme.css');
                        $document->addScript('components/com_proshopp/assets/upload/jquery.filer.min.js');
                        $document->addScript('components/com_proshopp/assets/upload/custom.js');
                        $existFiles = 'null;';
                        if (JFolder::exists('../media/com_proshopp/images/' . $this->id . '/' . $feature->id))
                        {
                            if ($files = JFolder::files('../media/com_proshopp/images/' . $this->id . '/' . $feature->id))
                            {
                                include_once('mime_content.php');
                                $existFiles = '[';
                                foreach ($files as $filename)
                                {
                                    $existFiles .= '{name: "' . $filename . '" ,size: "' . filesize('../media/com_proshopp/images/' . $this->id . '/' . $feature->id . '/' . $filename) . '",type: "' . ProshoppHelper::mime_content_type(JFile::getExt($filename)) . '",file: "../media/com_proshopp/images/' . $this->id . '/' . $feature->id . '/' . $filename . '"}';
                                    if ($filename !== end($files)) $existFiles .= ',';
                                }
                                $existFiles .= '];';
                            }
                        }
                        $document->addScriptDeclaration('files[' . $feature->id . '] =' . $existFiles);
                        $html[] = '<div class="col-sm-10">';
                        $html[] = '<script>jQuery(document).ready(function() { jqupload("#jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '","../../../../../../media/com_proshopp/images/' . $this->id . '/' . $feature->id . '/","' . $feature->id . '");})</script>';
                        $html[] = '<input type="file" name="files[]" id="jform_feature_' . strtolower(str_replace(' ', '_', $feature->name)) . '" multiple="multiple">';
                        $html[] = '</div>';
                        break;
                }
                $html[]       = '</div><div class="hr-line-dashed"></div>';
                $field_option = json_decode(str_replace("'", '"', $feature->field_type_option));


            }
            return implode($html);
        }else{
                return '<div class="alert alert-warning">'.JText::_('COM_PROSHOPP_ADMIN_ALERT_NO_FEATURE').'</div>';
        }
    }
    protected function units($type){

        switch ($type){
            case'length':
                $options = array( "m"=>"m","cm"=>"cm","mm"=>"mm","in"=>"in","ft"=>"ft","km"=>"km");
                return $options;
                break;
            case'weight':
                $options = array( "g"=>"g","kg"=>"kg","lbs"=>"lbs","oz"=>"oz");
                return $options;
                break;
            case'volume':
                $options = array( "l"=>"l","ml"=>"ml","cm3"=>"cm³","m3"=>"m³","cl"=>"cl","mm3"=>"mm³");
                return $options;
                break;
            case'frequency':
                $options = array( "Hz"=>"Hz","KHz"=>"KHz","MHz"=>"MHz","GHz"=>"GHZ");
                return $options;
                break;
            case'power':
                $options = array( "W"=>"W","KW"=>"KW","MW"=>"MW","mW"=>"mW");
                return $options;
                break;
            case'time':
                $options = array( "sec"=>"sec","min"=>"min","hr"=>"hr","day"=>"days","week"=>"weeks","month"=>"months","year"=>"years");
                return $options;
                break;
        }
    }

}