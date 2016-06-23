<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');


class JFormFieldIconSelect extends JFormField {

    //The field class must know its own type through the variable $type.
    protected $type = 'IconSelect';


    public function getInput() {
        // code that returns HTML that will be shown as the form field
        $document = JFactory::getDocument();
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/elusive-icons-2.0.0/css/elusive-icons.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/font-awesome-4.2.0/css/font-awesome.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/ionicons-1.5.2/css/ionicons.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/map-icons-2.1.0/css/map-icons.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/material-design-1.1.1/css/material-design-iconic-font.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/octicons-2.1.2/css/octicons.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/typicons-2.0.6/css/typicons.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/icon-fonts/weather-icons-1.2.0/css/weather-icons.min.css');
        $document->addStyleSheet('components/com_proshopp/assets/icon_picker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css');
        $document->addStyleSheet('../media/jui/css/bootstrap.css');
        $document->addScript('components/com_proshopp/assets/icon_picker/bootstrap-iconpicker/js/bootstrap-iconpicker.js');
        $document->addScript('components/com_proshopp/assets/icon_picker/bootstrap-iconpicker/js/iconset/iconset-all.min.js');
        $document->addScriptDeclaration('
    jQuery(document).ready(function() {
        jQuery("#jform_icon").iconpicker();
    });
');
       return '<div id="'.$this->id.'" name="'.$this->name.'" data-rows="3" data-cols="6" role="iconpicker"></div>';
    }


}
