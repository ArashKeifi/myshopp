<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldFieldTypeOption extends JFormField  {

    //The field class must know its own type through the variable $type.

    protected $type = 'FieldTypeOption';
    protected $jsonValue ;
    protected $noneJsonValue;
    protected $fieldType;
    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        include_once 'fieldtypeoptionjs.php';
        $return = parent::setup($element, $value, $group);
        //$this->value="{'field_type':'color','items':[{'text':'Garay','value':'#7f7f7f'},{'text':'Silver','value':'#bfbfbf'},{'text':'Rose Gold','value':'#fac08f'},{'text':'withe','value':'#ffffff'},{'text':'arash','value':'#c4bd97'},{'text':'ali','value':'#1f497d'}]}";
        //echo str_replace("'",'"',$this->value);
        //var_dump(json_decode('{"field_type":"radio"}'));


            if (!empty($this->value)) {
                $this->value = ProshoppHelper::featureFieldValue(str_replace("'", '"', $this->value));
            } else {
                $this->value = (object)array("type"=>'default',"items"=>'');
            }

        return $return;
    }

    protected function getInput(){
        if(!empty($this->value)) {
            JHtml::_('jquery.ui');
            $document = JFactory::getDocument();
            $document->addScript('components/com_proshopp/assets/sort/jquery.sortable.min.js');
            $document->addScript('components/com_proshopp/assets/color/js/evol.colorpicker.min.js');
            $document->addStyleSheet('components/com_proshopp/assets/color/css/evol.colorpicker.min.css');
            $document->addStyleSheet('components/com_proshopp/models/fields/fieldtypeoption.css');
            $html[] = $this->getOptions();
            switch ($this->value->type) {
                case 'color':
                    $html = array_merge($html, $this->getOptionsColor());
                    break;
                case 'list':
                    $html = array_merge($html, $this->getOptionsList());
                    break;
                case 'multiple':
                    $html = array_merge($html, $this->getOptionsList());
                    break;
                default:
                    $html[] = '<div id="other_option" style="display: none"><ul class="sortable uk-list uk-list-striped"></ul><a id="addNewRow" class="btn btn-xs btn-primary"><i class="fa fa-list-ul"></i>   Add new Row</a></div>';
            }
            return implode($html);
        }

    }

    protected function getOptionsColor(){
        $html[]='<div id="other_option">
                    <ul class="sortable uk-list uk-list-striped">';
        foreach($this->value->items as $options) {
            $html[]='<li class="row" draggable="true" >
                        <div class="col-lg-1"><span class="handle"><i class="fa fa-bars"></i></span></div>
                        <div class="col-lg-6"><input class="color_value form-control"  value="'.$options->text.'" placeholder="'.JText::_('COM_PROSHOP_COLOR_NAME').'" type="text"  /></div>
                        <div class="col-lg-3"><input type="text" value="'.$options->value.'" class="mycolor form-control" readonly/></div>
                        <div class="col-lg-2"><a class="fa fa-trash pull-right"></a></div>
                     </li>';
        };
        $html[]='</ul>
            <a id="addNewRow" class="btn btn-xs btn-primary"><i class="fa fa-list-ul"></i>   Add new Row</a>
		</div>';
        return $html;
    }

    protected function getOptionsList(){
        $html[]='<div id="other_option">
                    <ul class="sortable uk-list uk-list-striped">';
        foreach($this->value->items as $options) {
            $html[]='<li class="row" draggable="true"> <div class="col-lg-1"> <span class="handle"> <i class="fa fa-bars"></i> </span> </div> <div class="col-lg-5"> <input name="option_text[]" value="'.$options->text.'" class="color_value form-control" placeholder="'.JText::_("COM_PROSHOP_TEXT_NAME").'" type="text"> </div> <div class="col-lg-5"> <input value="'.$options->value.'" name="option_value[]" placeholder="'.JText::_("COM_PROSHOP_VALUE_NAME").'" type="text" value="" class="text-t form-control"> </div> <div class="col-lg-1"><a class="fa fa-trash  pull-right"></a></div> </li>';
        };
        $html[]='</ul>
            <a id="addNewRow" class="btn btn-xs btn-primary"><i class="fa fa-list-ul"></i>   Add new Row</a>
		</div>';
        return $html;
    }


    protected function getOptions(){
        $class          = !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $required       = $this->required ? ' required aria-required="true"' : '';
        $lists[] = '<select id="' . $this->id . '_list"' . $class . $required . 'name="'.substr($this->name, 0, -1) .'_list]"'. '>';
        $options = array(
            JHTML::_('select.option', 'text', JText::_('Text') ),
            JHTML::_('select.option', 'value', JText::_('Value') ),
            JHTML::_('select.option', 'editor', JText::_('Editor') ),
            JHTML::_('select.option', 'file', JText::_('File uploader') ),
            JHTML::_('select.option', 'color', JText::_('Color') ),
            JHTML::_('select.option', 'list', JText::_('Check list') ),
            JHTML::_('select.option', 'radio', JText::_('Yes/No') ),
            JHTML::_('select.option', 'multiple', JText::_('Multiple values') ),
            JHTML::_('select.option', 'line', JText::_('Spacer') )
           );

        return JHTML::_('select.genericlist', $options,'fieldType', $class . $required, 'value', 'text', $this->value->type,'jform_field_type_list');
    }

}