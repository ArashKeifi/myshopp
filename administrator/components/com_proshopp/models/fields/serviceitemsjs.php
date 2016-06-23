<script type="text/javascript">
jQuery( document ).ready(function() {
    Joomla.submitbutton = function(task)
    {
        if (task != "feature.cancel")
        {

            Joomla.submitform(task);
        }else{
            Joomla.submitform(task);
        }
    };
    var newItem = 1;
    jQuery('#addNewRow').click(function(){
        moreOption();
    });

    jQuery("#removeRow").on("click", function() {
       var skuID = jQuery(this).parent().parent().find('input:hidden').val();
       var SelectedRow=jQuery(this).parent().parent();
        if(skuID != 0){
            jQuery.post( "index.php?option=com_proshopp&task=ajax&format=raw", { id: skuID, table: "shopp_service_items" })
                .done(function(data) {
                    if(data=="true"){
                        SelectedRow.remove();
                    }else{
                        alert("عملیات به درستی انجام نشد");
                    }
                });
        }else{
            SelectedRow.remove();
        }
    });
    function moreOption(){
            jQuery('tbody').append('<tr><td><input type="hidden" name="items[new'+newItem+'][id]" value="0" ><input class="form-control" type="text" name="items[new'+newItem+'][name]" value="" size="20"></td><td><input class="form-control" type="text" name="items[new'+newItem+'][price]" value="" size="20"></td><td><select id="items1currency" name="items[new'+newItem+'][currency]" class="form-control"><option value="add" selected="selected">Fixed price</option><option value="peresent">%</option></select></td><td><a id="removeRow" class="fa fa-trash  pull-right"></a></td></tr>');
    newItem++;
    }

});
</script>