<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.helper');
$statusType = json_decode(JComponentHelper::getParams('com_proshopp')->get('status_type'));
function geStatus($statusValue,$statusTypes){
	if (false !== $key = array_search($statusValue,$statusTypes->id)) {
		echo '<span class="label" style="color:#fff;background-color: '.$statusTypes->color[$key].'">'.ucfirst($statusTypes->status_name[$key]).'</span>';
	} else {
		echo '<span class="label" style="color:#fff;">'.ucfirst($statusTypes->status_name[$key]).'</span>';
	}
}
?>
<!-- Ladda -->
<script src="components/com_proshopp/assets/theme/js/plugins/ladda/spin.min.js"></script>
<script src="components/com_proshopp/assets/theme/js/plugins/ladda/ladda.min.js"></script>
<script src="components/com_proshopp/assets/theme/js/plugins/ladda/ladda.jquery.min.js"></script>

<!-- numeraljs.com -->
<script src="components/com_proshopp/assets/theme/js/plugins/numeral/numeral.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function (){
	numeral.language('fr', {
		delimiters: {
			thousands: ',',
			decimal: '.'
		},
		abbreviations: {
			thousand: 'k',
			million: 'm',
			billion: 'b',
			trillion: 't'
		},
		ordinal : function (number) {
			return number === 1 ? 'er' : 'ème';
		},
		currency: {
			symbol: 'تومان'
		}
	});

// switch between languages
	numeral.language('fr');
	jQuery('.numeral').each(function( index, value ) {
		jQuery(this).text(numeral(jQuery(this).text()).format('0,0 $'));
	});
l = jQuery( '.ladda-button' ).ladda();
    });
function changeOrderStatus(){
	if(jQuery('#add_status').val() != 0){
	jQuery.post( "index.php?option=com_proshopp&task=orderview&type=changestatus&format=raw", { id: jQuery('#add_status').attr('order_id') , status_id:jQuery('#add_status').val()})
		.done(function(data) {
			if(data != 'false'){
				jQuery('#order_status').append('<li><span href="#" class="check-link"><i class="fa fa-check-square"></i></span> <span class="m-l-xs todo-completed">'+jQuery("#add_status :selected").text()+'</span> <small class="label label-primary"><i class="fa fa-clock-o"></i>   <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SOME_SECOND_AGO') ?></small><ul class="tag-list pull-right">'+data+'</ul></li>');
				jQuery('#add_status :selected').remove();
			}else{
				toastr['error']('<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_STATUS_ERROR') ?>','<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ALERT_ERROR') ?>');
			}
		});
	}else{
		toastr['error']('<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_SELECT_STATUS') ?>','<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ALERT_ERROR') ?>');
	}
}
	function orderview(id){
		l.ladda( 'start' );
		jQuery('#modal_order div').remove();
		jQuery.post( "index.php?option=com_proshopp&task=orderview&format=raw", { id: id})
			.done(function(data) {
				console.log(order = jQuery.parseJSON( data ));
				if(order.statusHistory){
					var history='' ;
					jQuery.each(order.statusHistory, function( index, value ) {
						var date = new Date(new Date().getTime() - new Date(value.datetime).getTime());
						var spdate = '   ';
						if(date.getUTCDate()-1){spdate += date.getUTCDate()-1 + " <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_DAYS') ?>, "};
						if(date.getUTCHours()){spdate += date.getUTCHours() + "':"};
							if(date.getUTCDate()-1==0 && date.getUTCHours()==0){
								console.log(date.getUTCMinutes());
								if(date.getUTCMinutes()==0){
									spdate += "<?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SOME_SECOND_AGO') ?>";
								}else{
									spdate += date.getUTCMinutes() + " <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_AGO').' '.JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_MINS'); ?>";
								}
							}else{
								spdate += date.getUTCMinutes() + "\" <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_AGO') ?>";
							}
						if(value.params){
							var pluginTags = '<ul class="tag-list pull-right">'+value.params+'</ul>';
						}
						history += '<li><span href="#" class="check-link"><i class="fa fa-check-square"></i></span> <span class="m-l-xs todo-completed">'+value.action+'</span> <small class="label label-primary"><i class="fa fa-clock-o"></i>'+spdate+'</small>'+pluginTags+'</li>';
					});
				}else{
					history='';
				}

				jQuery('#modal_order').append(
					'<div class="modal-dialog modal-lg">' +
						'<div class="modal-content">' +
							'<div class="modal-header">' +
								'<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
								'<h4 class="modal-title pull-left"><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_NUMBER') ?> : '+order.general.id+'</h4>' +
						'<div class="pull-right m-r"> <button class="btn btn-white btn-xs" type="button">Print Order</button> <button class="btn btn-white btn-xs" type="button">Print Address</button></div>'+
							'</div>' +
							'<div class="modal-body">' +
						'<div class="row"><div class="col-lg-4"> <div class="widget style1 navy-bg"> <div class="row"> <div class="col-xs-4"> <i class="fa fa-dollar fa-5x"></i> </div> <div class="col-xs-8 text-right"> <span> <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_TOTAL') ?> </span> <h3 class="font-bold numeral">'+order.general.total+'</h3> </div> </div> </div> </div> <div class="col-lg-4"> <div class="widget style1 lazur-bg"> <div class="row"> <div class="col-xs-4"> <i class="fa fa-calendar-o fa-5x"></i> </div> <div class="col-xs-8 text-right"> <span> <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_DATE_ADD') ?> </span> <h4 class="font-bold">'+order.general.create_datetime+'</h4> </div> </div> </div> </div> <div class="col-lg-4"> <div class="widget style1 yellow-bg"> <div class="row"> <div class="col-xs-4"> <i class="fa fa-shopping-bag fa-5x"></i> </div> <div class="col-xs-8 text-right"> <span><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_NUMBER') ?></span><h2 class="font-bold">12</h2> </div> </div> </div> </div> </div>'+
								'<div class="row">' +
									'<div class="col-lg-8">' +
										'<div>'+
											'<div class="ibox float-e-margins">' +
												'<div class="ibox-title"><h5 class="text-success"><i class="fa fa-flag" aria-hidden="true"></i> <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_STATUS_HISTORY') ?> </h5></div>'+
												'<div class="ibox-content">'+
													'<ul id="order_status" class="todo-list m-t small-list ui-sortable">'+ history +'</ul>' +
													'<div class="hr-line-dashed"></div>' +
														'<div class="input-group"><select order_id="'+order.general.id+'" class="form-control m-b" id="add_status"><option value="0"><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_SELECT_STATUS') ?></option>'+order.statusTypes+'</select>'+
														'<span class="input-group-btn"> <button onclick="changeOrderStatus()" type="button" class="btn btn-primary"> <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_CHANGE_STATUS') ?> </button></span></div>'+
												'</div>' +
											'</div>'+
										'</div>' +
										'<div class="ibox-title"><h5 class="text-success"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT') ?> </h5><small class="m-l"><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_HISTORY');?></small></div>'+
										'<div class="ibox-content m-b">'+
											'<table class="table table-striped">'+
												'<thead>'+
													'<tr>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_DATE') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_METHOD') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_TRANSACTION_ID') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_AMOUNT') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ACTION') ?></th>'+
													'</tr>'+
												'</thead>'+
												'<tbody>'+
													'<tr>'+
														'<td><?php echo JHtml::date('2016-03-10 20:00:10' , 'Y-m-d H:i:s', true)?></td>'+
														'<td>Melat bank</td>'+
														'<td>1259482</td>'+
														'<td class="numeral">109000</td>'+
														'<td></td>'+
													'</tr>'+
												'</tbody>'+
											'</table>'+
										'</div>'+
										'<div class="tabs-container">'+
											'<ul class="nav nav-tabs">'+
												'<li class="active"><a data-toggle="tab" href="#shipping" aria-expanded="false"><i class="fa fa-truck"></i><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_SHIPPING')?></a></li>'+
												'<li ><a data-toggle="tab" href="#returned" aria-expanded="false"><i class="fa fa-undo"></i><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_RETURNED')?></a></li>'+
											'</ul>'+
											'<div class="tab-content">'+
												'<div id="shipping" class="tab-pane active">'+
													'<div class="panel-body">'+
														'<table class="table table-striped">'+
														'<thead>'+
														'<tr>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_DATE') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SHIPP_TYPE') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SHIPP_TRACK_ID') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_PAYMENT_AMOUNT') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SHIPP_STOCK') ?></th>'+
														'</tr>'+
														'</thead>'+
														'<tbody>'+
														'<tr>'+
														'<td><?php echo JHtml::date('2016-03-10 20:00:10' , 'Y-m-d H:i:s', true)?></td>'+
														'<td>Melat bank</td>'+
														'<td>1259482</td>'+
														'<td class="numeral">109000</td>'+
														'<td></td>'+
														'</tr>'+
														'</tbody>'+
														'</table>'+
					'<hr><div class="row m-t"><div class="col-lg-4"><select class="form-control m-b" name="stockname"> <option value="0">Select Stock</option> <option>option 2</option> <option>option 3</option> <option>option 4</option> </select></div><div class="col-lg-4"><input type="text" placeholder="Track ID" class="form-control" ></div><div class="col-lg-4"><button class="btn btn-primary" type="submit">Save</button></div></div>'+
													'</div>'+
												'</div>'+
												'<div id="returned" class="tab-pane">'+
													'<div class="panel-body">'+
														'<table class="table table-striped">'+
														'<thead>'+
														'<tr>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_DATE') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SHIPP_TRACK_ID') ?></th>'+
														'<th><?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_ORDER_SHIPP_STOCK') ?></th>'+
														'</tr>'+
														'</thead>'+
														'<tbody>'+
														'<tr>'+
														'<td><?php echo JHtml::date('2016-03-10 20:00:10' , 'Y-m-d H:i:s', true)?></td>'+
														'<td>125548</td>'+
														'<td>Tehran</td>'+
														'</tr>'+
														'</tbody>'+
														'</table>'+
														'<hr><div class="row m-t"><div class="col-lg-4"><select class="form-control m-b" name="stockname"> <option value="0">Select Stock</option> <option>option 2</option> <option>option 3</option> <option>option 4</option> </select></div><div class="col-lg-4"><input type="text" placeholder="Track ID" class="form-control" ></div><div class="col-lg-4"><button class="btn btn-primary" type="submit">Save</button></div></div>'+
													'</div>'+
												'</div>'+
											'</div>'+
										'</div>'+
									'</div>' +
									'<div class="col-lg-4">' +
										'<div class="ibox">' +
											'<div class="widget-head-color-box navy-bg p-lg text-center">' +
												'<div class="m-b-md">' +
													'<h2 class="font-bold no-margins"> '+order.general.name+' </h2>' +
												'</div> <img src="img/a4.jpg" class="img-circle circle-border m-b-md" alt="profile">' +
											'</div>' +
											'<div class="widget-text-box">' +
												'<h4 class="media-heading">Email</h4>' +
												'<p>'+order.general.email+'</p>' +
											'</div>' +
										'</div>'+
										'<div>' +
											'<div class="ibox float-e-margins">' +
												'<div class="ibox-title">' +
													'<h5><i class="fa fa-map-marker"></i> <?php echo JText::_('COM_PROSHOPP_ADMIN_MANAGER_SHIPPING_ADDRESS'); ?></h5>'+
												'</div>' +
												'<div class="ibox-content">' +
													'<address>' +
														'<h3 class="text-center"><i class="fa fa-phone m-r"></i>'+order.general.tell_cod+'-'+order.general.tell+'</h3>'+
														'<strong>'+order.general.address_name+'</strong><br><a href="mailto:#">first.last@example.com</a>' +
													'</address>' +
													'<address>' +
														'<strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107' +
													'</address>' +
												'</div>' +
											'</div>' +
										'</div>' +
					         		'</div>'+
								'</div>' +
					'<div class="row m-t">'+
						'<div class="col-lg-12">'+
							'<div class="ibox float-e-margins">'+
								'<div class="ibox-title">'+
								'<h2 class="text-success"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Selected Items</h2>'+
								'</div>'+
								'<div class="ibox-content">'+
									'<table class="table table-hover">'+
										'<thead>'+
											'<tr>'+
												'<th></th>'+
												'<th>Product</th>'+
												'<th>Unit Price</th>'+
												'<th>Qty</th>'+
												'<th>Total</th>'+
												'<th>Action</th>'+
											'</tr>'+
										'</thead>'+
										'<tbody>'+
											'<tr>'+
												'<td>1</td>'+
												'<td></td>'+
												'<td>Samantha</td>'+
												'<td></td>'+
												'<th>Total</th>'+
												'<th>Unit Price</th>'+
											'</tr>'+
										'</tbody>'+
									'</table>'+
								'</div>'+
							'</div>'+
					'</div><div class="col-lg-8"><div class="btn-group"> <button class="btn btn-white" type="button"><i class="fa fa-cubes m-r" aria-hidden="true"></i>Add Product</button> <button class="btn btn-primary" type="button"><i class="fa fa-ticket m-r" aria-hidden="true"></i>Add discount</button></div></div><div class="col-lg-4">' +
					'<div class="ibox">'+
					'<div class="ibox-title">'+
					'<h5>Summary</h5>'+
					'</div>'+
					'<div class="ibox-content">'+

					'<div class="ibox-content no-padding">'+
					'<ul class="list-group">'+
					'<li class="list-group-item"><span class="badge  badge-info">16000</span>Products</li>'+
					'<li class="list-group-item "><span class="badge numeral">1200</span>Shipping</li>'+
					'<li class="list-group-item"><span class="badge numeral">100</span>Taxes</li>'+
					'<li class="list-group-item"><span class="badge numeral">0</span>Discount</li>'+
					'<li class="list-group-item"><span class="badge badge-primary font-bold numeral">700000</span>Total</li>'+
					'</ul>'+
					'</div>'+
					'</div>'+
					'</div>'+
					'</div>'+
				'</div>'+
							'</div>' +
							'<div class="modal-footer">' +
								'<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>' +
							'</div>' +
						'</div>' +
					'</div>');
				 window.l.ladda('stop');
				jQuery('.numeral').each(function( index ) {
					jQuery(this).text(numeral(jQuery(this).text()).format('0,0 $'));
				});
				jQuery(document.body).addClass('modal-open');
				jQuery('#modal_order').modal("show");
			});

	}
</script>
<?php foreach($this->items as $i => $item): ?>
<tr class="<?php  echo($i % 2 ?  'footable-even' : 'footable-odd' ); ?>">
	<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?>
	</td>
	<td class="footable-visible footable-first-column"><a
		href="<?php echo JRoute::_('index.php?option=com_proshopp&task=order.edit&id=' . $item->id); ?>">
			<?php echo $item->id; ?>
	</a>
	</td>
	<td class="footable-visible"><?php geStatus($item->status,$statusType); ?></td>

	<td class="footable-visible"><?php echo $item->name; ?>
	</td>
	<td class="footable-visible"><?php echo JHtml::date($item->create_datetime , 'D F n, Y g:i a'); ?></td>
	<td class="footable-visible numeral"><?php echo $item->total; ?></td>
	<td class="text-right footable-visible footable-last-column">
                                        <div class="btn-group">
											<a class="ladda-button btn btn-info btn-xs" data-style="zoom-out" onclick="orderview('<?php echo $item->id; ?>');" ><i class="fa fa-search-plus"></i> <span class="bold"><?php echo JText::_('COM_PROSHOPP_GENERAL_VIEW') ?></span></a>
                                        </div>
                                    </td>
</tr>
<?php endforeach; ?>

