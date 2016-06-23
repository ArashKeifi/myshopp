<script>
jQuery( document ).ready(function() {
    // Sortable list
    jQuery(".mycolor").colorpicker();
    jQuery('.sortable').sortable({handle: '.handle'});

    jQuery(".fa-trash").on('click', function(event) {
        jQuery(this).parent().parent().remove();
    });
    jQuery('a#addNewRow').click(function(){
        moreOption(jQuery("#jform_field_type_list").val());
    });

    function moreOption(value){
        if(value== 'color') {
            jQuery('ul.sortable.uk-list.uk-list-striped').append(
                '<li class="row" draggable="true"> <div class="col-lg-1"> <span class="handle"> <i class="fa fa-bars"></i> </span> </div> <div class="col-lg-6"> <input name="option_text[]" class="color_value form-control" placeholder="<?php echo JText::_('COM_PROSHOP_COLOR_NAME'); ?>" type="text"> </div> <div class="col-lg-3"> <input name="option_value[]" type="text" value="" class="mycolor form-control" readonly> </div> <div class="col-lg-2"><a class="fa fa-trash  pull-right"></a></div> </li>');
            jQuery(".mycolor").colorpicker();
        }else if(value== 'list' || value == 'multiple'){
            jQuery('ul.sortable.uk-list.uk-list-striped').append(
                '<li class="row" draggable="true"> <div class="col-lg-1"> <span class="handle"> <i class="fa fa-bars"></i> </span> </div> <div class="col-lg-5"> <input name="option_text[]" class="color_value form-control" placeholder="<?php echo JText::_('COM_PROSHOP_TEXT_NAME'); ?>" type="text"> </div> <div class="col-lg-5"> <input name="option_value[]" placeholder="<?php echo JText::_('COM_PROSHOP_VALUE_NAME') ?>" type="text" value="" class="text-t mycolor form-control"> </div> <div class="col-lg-1"><a class="fa fa-trash  pull-right"></a></div> </li>');
        }
    }

    function fieldTypeChange (value){
        switch(value){
            case 'value':
                jQuery("#fields_measurement").show();
                break;
            case 'color':
                moreOption(value);
                jQuery('#other_option li').remove();
                jQuery('#other_option').show();
                jQuery("#fields_measurement").hide();
                break;
            case 'list':
                moreOption(value);
                jQuery('#other_option li').remove();
                jQuery('#other_option').show();
                break;
            case 'multiple':
                moreOption(value);
                jQuery('#other_option li').remove();
                jQuery('#other_option').show();
                break;
            default:
                jQuery("#fields_measurement").hide();
                jQuery('#other_option').hide();
        }
    }

    //check field type selected
    jQuery("#jform_field_type_list").change(function(){
        jQuery("#fields_measurement").hide();
        jQuery('#other_option').hide();
        fieldTypeChange(jQuery("#jform_field_type_list").val());
    })  ;
});
</script>