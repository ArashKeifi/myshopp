<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
class JFormFieldServiceItems extends JFormField  {

    protected $type = 'ServiceItems';
    protected $items;
    protected $id;

    public function setup(SimpleXMLElement $element, $value, $group = null){
        include_once 'ServiceItemsJs.php';
        $return = parent::setup($element, $value, $group);
        $this->id = JFactory::getApplication()->input->get('id');
        if(!$this->id){
            return false;
        }

        $db= JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,a.price,a.currency');
        $query->from($db->quoteName('#__shopp_service_items', 'a'));
        $query->where('a.service_id = '.$this->id);
        $db->setQuery($query);
        $this->items = $db->loadObjectList();
        return $return;

    }
    protected function getInput(){
        $html[]='<table class="table table-striped"><thead><tr><th width="5">Name</th><th width="3">Price / %</th><th width="3">Currency Type</th><th width="3">Action</th></tr></thead><tbody>';
        $arr = array(
            JHTML::_('select.option', 'add', JText::_('Fixed price') ),
            JHTML::_('select.option', 'peresent', JText::_('%') )
        );
        foreach($this->items as $item ){
            $html[]='<tr>';
            $html[]='<td><input type="hidden" name="items['.$item->id.'][id]" value="'.$item->id.'" ><input class="form-control" type="text" name="items['.$item->id.'][name]" value="'.$item->name.'" size="20"></td>';
            $html[]='<td><input class="form-control" type="text" name="items['.$item->id.'][price]"  value="'.$item->price.'" size="20"></td>';
            //$html[]='<td><input class="uk-form-width-small uk-form-small" type="text" name="items['.$item->id.'][currency]"  value="'.$item->currency.'" size="20"></td>';
            $html[]='<td>'.JHTML::_('select.genericlist', $arr, 'items['.$item->id.'][currency]', 'class="form-control"', 'value', 'text', $item->currency).'</td>';
            $html[]='<td><a id="removeRow" class="fa fa-trash  pull-right"></a></td>';
            $html[]='</tr>';
        }
        $html[]='</tbody></table>';
        $html[]='<a id="addNewRow" class="btn btn-xs btn-primary"><i class="fa fa-list-ul"></i>   Add new Row</a>';
        return implode($html);
    }

}