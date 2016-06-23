<?php
$session = JFactory::getSession();
jimport('joomla.filesystem.folder');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_proshopp/assets/upload/css/jquery.filer.css');
$document->addStyleSheet('components/com_proshopp/assets/upload/css/themes/jquery.filer-dragdropbox-theme.css');
$document->addScript('components/com_proshopp/assets/upload/jquery.filer.min.js');
$document->addScript('components/com_proshopp/assets/upload/custom.js');
$existFiles='[];';
if(JFolder::exists('../images/product/'.$session->get('id').'/')) {
    if ($files = JFolder::files('../images/product/' .$session->get('id').'/')) {
        //include_once(DS.'..'.DS.'..'.DS.'..'.DS.'models'.DS.'fields'.DS.'mime_content.php');
        $existFiles= '[';
        foreach ($files as $filename) {
            $existFiles .= '{name: "' . $filename . '" ,size: "' . filesize('../images/product/'.$session->get('id').'/'.$filename) . '",type: "' . ProshoppHelper::mime_content_type(JFile::getExt($filename)) . '",file: "../images/product/'.$session->get('id').'/'.$filename.'"}';
            if ($filename !== end($files)) $existFiles .= ',';
        }
        $existFiles.= '];';
    }
}
$document->addScriptDeclaration('files= new Array();files["img"] ='.$existFiles);
print('<script>
jQuery(document).ready(function(){
jqupload("#jform_product_image","../../../../../../images/product/'.$session->get('id').'/","img",fileDone,fileRemove);
    function fileDone(fileName){
    var filerKit = jQuery("#jform_product_image").prop("jFiler");
        jQuery.each(filerKit.files, function( index, value ) {
            files["img"].push({name: value.name ,size: "",type: "",file: ""});
            jQuery(".product_image").append("<option>"+value.name+"</option>");
        });
    };
    function fileRemove(fileName){
    files["img"] = jQuery.grep(files["img"], function(el, idx) {return el.name == fileName}, true);
    jQuery(".product_image option[value=\'"+fileName+"\']").remove();
    } 
})</script>');

?>
<div class="panel-body" >
    <input type="file" name="files[]" id="jform_product_image" multiple="multiple">
</div>