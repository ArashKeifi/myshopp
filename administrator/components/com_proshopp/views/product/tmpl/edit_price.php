<?php
$id  = JFactory::getApplication()->input->getInt('id', 0);
?>
<div class="panel-body" >
<style>.skuproduct i.fa-trash {
		color: #C34949;
		font-size: 15px;
		cursor: pointer;
	}
	.invalid {
		border-color: red !important;
	}
</style>

<script>
	jQuery( document ).ready(function() {
		var newItem = 1;
		var id =<?php echo $id; ?>;
		function numberCheck(input){
			var result='';
			jQuery(input.split(',')).each(function (index,values) {
				result +=values.split(':')[0];
			});
			return result;
		};
		function textCheck(input){
			var result='';
			jQuery(input.split(',')).each(function (index,values) {
				result +=values.split(':')[1]+' ';
			});
			return jQuery.trim(result);
		};
		// remove items
		jQuery("#prices table tbody i.fa-trash").on("click", function() {
			var skuID = jQuery(this).parent().parent().find("input[name*='[id]']").val();
			var skuVal = jQuery(this).parent().parent().find("input[name*='[skuid]']").val();
			var SelectedRow=jQuery(this).parent().parent();
			if(skuID != 0){
				jQuery.post( "index.php?option=com_proshopp&task=ajax&format=raw", { id: skuID, table: "shopp_product_sku" , sku: skuVal})
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

		var inputs =jQuery( "#productPriceContent input:checkbox" ).map(function() { return jQuery( this ).attr('name'); }).get();
		jQuery("#generate").click(function() {
			var listOption;
			for (i = 0; i < files["img"].length; i++) {
				listOption += '<option value="'+files["img"][i]['name']+'">'+files["img"][i]['name']+'</option>';
			}

			optionsin = new Array;
			var b = 0;
			jQuery.each(jQuery.unique(inputs), function (i, index) {
				optionin = new Array;
				jQuery("#productPriceContent input[name='" + index + "']:checked").each(function () {
					optionin.push(jQuery(this).attr("feature-id") + ':' + jQuery(this).val());
				});
				if (optionin.length) {
					optionsin[b] = optionin;
					b++;
				}

			});
			if (optionsin.length) {
			jQuery.post("index.php?option=com_proshopp&task=sku&format=raw", {options: optionsin})
				.done(function (data) {
					if (data) {
						resultObj = eval(data);
						var existSku = new Array();
						jQuery("#prices table tbody input[name*='[name]']").each(function (index, value) {
							existSku.push(jQuery(this).val());
						});
						jQuery.each(resultObj, function (index, value) {
							var rand = Math.floor((Math.random() * 800) + 100);
							if (jQuery.inArray('singleOption', existSku) == '0') {
								alert('لطفا مقادیر پیشین را حذف نمایید');
								return false;
							}
							if (jQuery.inArray(textCheck(value), existSku) == '-1') {
								jQuery('#prices table tbody').append(
									'<tr>' +
									'<td><input type="hidden" name="skus[new' + newItem + '][id]" value="0" >' +
									'<input readonly="readonly" type="hidden" name="skus[new' + newItem + '][pattern]" value="' + value + '" >' +
									'<input readonly="readonly" class="form-control input-sm" type="text" name="skus[new' + newItem + '][skuid]" value="' + id + numberCheck(value) + rand + '" size="20"></td>' +
									'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][name]"  value="' + textCheck(value) + '" size="20" ></td>' +
									'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][price]"  value="' + jQuery('#price').val() + '" size="20" ></td>' +
									'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][off_price]"  value="' + jQuery('#off_price').val() + '" size="20" ></td>' +
									'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][compare_price]"  value="' + jQuery('#compare').val() + '" size="20" ></td>' +
									'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][weight]"  value="' + jQuery('#weight').val() + '" size="20" ></td>' +
									'<td><select class="product_image form-control input-sm" name="skus[new' + newItem + '][image]" ><option value="-1">- None Selected -</option>'+listOption+'</select></td>'+
									'<td class="center"><select name="skus[new' + newItem + '][published]" class="form-control input-sm" size="1">' +
									'<option value="1" selected="selected">Published</option><option value="0" >Unpublished</option></select></td>' +
									'<td class="center"><i class="fa fa-trash"></i></td>' +
									'</tr>'
								);
								newItem++;
							}
						});
					} else {
						alert("error");
					}
				});
			}else{
				var existSku = new Array();
				jQuery("#prices table tbody input[name*='[name]']").each(function (index, value) {
					existSku.push(jQuery(this).val());
				});
				if (jQuery.inArray('singleOption', existSku) == '-1') {
					jQuery('#prices table tbody').append(
						'<tr>' +
						'<td><input type="hidden" name="skus[new' + newItem + '][id]" value="0" >' +
						'<input type="hidden" name="skus[new' + newItem + '][pattern]" value="single" >' +
						'<input readonly="readonly" class="form-control input-sm" type="text" name="skus[new' + newItem + '][skuid]" id="jform_feature_test_sample" value="' + id +  Math.floor((Math.random() * 800) + 100) + '" size="20"></td>' +
						'<td><input readonly="readonly" class="form-control input-sm" type="text" name="skus[new' + newItem + '][name]" id="jform_feature_test_sample" value="singleOption" size="20" ></td>' +
						'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][price]" id="jform_feature_test_sample" value="' + jQuery('#price').val() + '" size="20" ></td>' +
						'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][off_price]" id="jform_feature_test_sample" value="' + jQuery('#off_price').val() + '" size="20" ></td>' +
						'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][compare_price]" id="jform_feature_test_sample" value="' + jQuery('#compare').val() + '" size="20" ></td>' +
						'<td><input class="form-control input-sm" type="text" name="skus[new' + newItem + '][weight]" id="jform_feature_test_sample" value="' + jQuery('#weight').val() + '" size="20" ></td>' +
						'<td><select class="product_image form-control input-sm" name="skus[new' + newItem + '][image]" ><option value="-1">- None Selected -</option>'+listOption+'</select></td>'+
						'<td class="center"><select name="skus[new' + newItem + '][published]" class="form-control input-sm" size="1">' +
						'<option value="1" selected="selected">Published</option><option value="0" >Unpublished</option></select></td>' +
						'<td class="center"><i class="fa fa-trash"></i></td>' +
						'</tr>'
					);newItem++;
				}
			}
		});
	});

</script>
	<div class="row">
		<div class="col-sm-7 b-r"><h3 class="m-t-none m-b"><?php echo JText::_('JGLOBAL_FIELDSET_FEATURES'); ?></h3>
			<p><?php echo JText::_('COM_PROSHOPP_PRODUCT_PRICETAB_DESCRIPTION'); ?></p>
			<div class="hr-line-dashed"></div>
			<div class="tabbable tabs-left">
				<?php
				$document = JFactory::getDocument();
				$document->addStyleSheet('components/com_proshopp/models/fields/fieldtypeoption.css');
				?>
				<?php echo $this -> form -> getInput('price');?>
			</div>

		</div>
		<div class="col-sm-5">
			<div class="form-group mb-sm"><label class="col-lg-4 control-label">Price</label>
				<div class="col-lg-8">
					<input id="price" type="text" placeholder="Price" class="form-control input-sm m-b">
				</div>
			</div>
			<div class="form-group"><label class="col-lg-4 control-label">Purchase price</label>
				<div class="col-lg-8">
					<input id="off_price" type="text" placeholder="Purchase price" class="form-control input-sm m-b">
				</div>
			</div>
			<div class="form-group"><label class="col-lg-4 control-label">Compare</label>
				<div class="col-lg-8">
					<input id="compare" type="text" placeholder="Compare" class="form-control input-sm m-b">
				</div>
			</div>
			<div class="form-group"><label class="col-lg-4 control-label">Weight</label>
				<div class="col-lg-8">
					<input id="weight" type="text" placeholder="Weight" class="form-control input-sm m-b">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-8 col-md-offset-4">
					<a href="javascript:void(0)" id="generate" class="btn btn-primary m-b col-lg-12" >Generate</a>
				</div>
			</div>

		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 b-t">
			<h3 class="m-t-none m-b m-t">Product SKU</h3>
			<p>Deferent type of features</p>
			<?php echo $this -> form -> getInput('skus');?>
		</div>
	</div>
</div>



