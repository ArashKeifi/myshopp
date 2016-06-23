<?php
/**
 * @module        myshopp
 * @script        proshopp.php
 * @author-name Arash Kifi
 * @copyright    Copyright (C)2015 Arash Kifi
 * @license        GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

abstract class ProshoppHelper extends JHtml{
    public static function addSubmenu($vName= 'products'){
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_CONTROLPANEL'), 'index.php?option=com_proshopp', $vName == 'Controls');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_ORDERS'), 'index.php?option=com_proshopp&view=orders', $vName == 'Orders');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_PRODUCTS'), 'index.php?option=com_proshopp&view=products', $vName == 'Products');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_CATEGORIES'), 'index.php?option=com_categories&extension=com_proshopp', $vName == 'categories');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_TYPES'), 'index.php?option=com_proshopp&view=types', $vName == 'Types');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_STOCKS'), 'index.php?option=com_proshopp&view=stocks', $vName == 'Stocks');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_FEATURE'), 'index.php?option=com_proshopp&view=features', $vName == 'Features');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_SERVICE'), 'index.php?option=com_proshopp&view=services', $vName == 'Services');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_LOCATIONS'), 'index.php?option=com_proshopp&view=locations', $vName == 'Locations');
        JHtmlSidebar::addEntry(JText::_('COM_PROSHOPP_SUBMENU_MESSAGES'), 'index.php?option=com_proshopp&view=messages', $vName == 'Messages');

    }
    public function getStatus(){
        $options = json_decode(JComponentHelper::getParams('com_proshopp')->get('status_type', '0'));
        foreach ($options->id as $key => $value) {
            $statusParam[]= (object)array("id"=>$value,"color"=>$options->color[$key],"status_name"=>$options->status_name[$key],"show_user"=>$options->show_user[$key],"show_user"=>$options->show_user[$key],"stock"=>$options->stock[$key],"user_alert"=>$options->user_alert[$key],"sms_message"=>$options->sms_message[$key],"email_message"=>$options->email_message[$key]);
        }
        return $statusParam ;
    }

    public function getStatusOptions($filterValue){
        $cacheParams = JFactory::getCache();
        $options = $cacheParams->call( array( 'ProshoppHelper', 'getStatus' ));
        $selectOptions='';
        foreach ($options as $option) {
            $selected = ($option->id == $filterValue ?'selected':'');
            $selectOptions .= '<option '.$selected.' value="'.$option->id.'">'.$option->status_name.'</option>';
        }
        return $selectOptions;
    }
    public function searchInStatus($statusID,$itemName){
        $cacheParams = JFactory::getCache();
        $statuses = $cacheParams->call( array( 'ProshoppHelper', 'getStatus' ));
        foreach($statuses as $status){
            if($status->id == $statusID){
                return $status->$itemName;
                break;
            }
        }

    }
    public function splitString($string,$position){
        $string = strip_tags($string);
        if(strlen($string) > $position) {
            if ($pos =strpos($string, ' ', $position)) {
                return substr($string, 0, $pos) . ' ...';
            } else {
                return substr($string, 0, $position) . ' ...';
            }
        }else {
            return $string;
        }


    }

    public function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
    public function featureFieldValue($value){
        $jsonValue = json_decode($value);
        $type=$jsonValue->field_type;
        if(isset($jsonValue->items)){
            $items=$jsonValue->items;
        }else{
            $items='';
        }
        return (object)array("type"=>$type,"items"=>$items);
    }

    public static function calendar($value, $name, $id, $format = '%Y-%m-%d', $placeholder='Date', $attribs = null)
    {
        static $done;

        if ($done === null)
        {
            $done = array();
        }

        $readonly = isset($attribs['readonly']) && $attribs['readonly'] == 'readonly';
        $disabled = isset($attribs['disabled']) && $attribs['disabled'] == 'disabled';

        if (is_array($attribs))
        {
            $attribs['class'] = isset($attribs['class']) ? $attribs['class'] : 'input-medium';
            $attribs['class'] = trim($attribs['class'] . ' hasTooltip');

            $attribs = JArrayHelper::toString($attribs);
        }

        static::_('bootstrap.tooltip');

        // Format value when not nulldate ('0000-00-00 00:00:00'), otherwise blank it as it would result in 1970-01-01.
        if ($value && $value != JFactory::getDbo()->getNullDate())
        {
            $tz = date_default_timezone_get();
            date_default_timezone_set('UTC');
            $inputvalue = strftime($format, strtotime($value));
            date_default_timezone_set($tz);
        }
        else
        {
            $inputvalue = '';
        }

        // Load the calendar behavior
        static::_('behavior.calendar');

        // Only display the triggers once for each control.
        if (!in_array($id, $done))
        {
            $document = JFactory::getDocument();
            $document
                ->addScriptDeclaration(
                    'jQuery(document).ready(function($) {Calendar.setup({
			// Id of the input field
			inputField: "' . $id . '",
			// Format of the input field
			ifFormat: "' . $format . '",
			// Trigger for the calendar (button ID)
			button: "' . $id . '_img",
			// Alignment (defaults to "Bl")
			align: "Tl",
			singleClick: true,
			firstDay: ' . JFactory::getLanguage()->getFirstDay() . '
			});});'
                );
            $done[] = $id;
        }

        // Hide button using inline styles for readonly/disabled fields
        $btn_style = ($readonly || $disabled) ? ' style="display:none;"' : '';
        $div_class = (!$readonly && !$disabled) ? ' class="input-append input-group date"' : '';
        return '<div' . $div_class . '>'
        . '<span id="' . $id . '_img" class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" title="' . ($inputvalue ? static::_('date', $value, null, null) : '')
        . '" name="' . $name . '" class="form-control" placeholder="'.$placeholder.'" id="' . $id . '" value="' . htmlspecialchars($inputvalue, ENT_COMPAT, 'UTF-8') . '" ' . $attribs . ' />'
        . '</div>';
    }
}