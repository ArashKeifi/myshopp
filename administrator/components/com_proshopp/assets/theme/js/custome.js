jQuery( document ).ready(function() {

	jQuery('div.pagination').addClass('dataTables_paginate paging_simple_numbers').removeClass('pagination pagination-toolbar');
	jQuery('ul.pagination-list').addClass('pagination pull-right').removeClass('pagination-list');

		var heights = jQuery(".equal-height > [class*='col-']  .product-desc").map(function() {
				return jQuery(this).height();
			}).get(),

			maxHeight = Math.max.apply(null, heights);
	jQuery(".equal-height > [class*='col-'] .product-desc").height(maxHeight);
	jQuery(".tabs-container .nav-tabs:first li").click(function(){
		jQuery(".tabs-container .nav-tabs:first li").map(function(){
			jQuery(this).removeClass();
		})

	})
	jQuery(".tab-content .nav-tabs li").click(function(){
		jQuery(".tab-content .nav-tabs li").map(function(){
			jQuery(this).removeClass();
		})

	})
	jQuery( ".picgallery .input-prepend" ).prepend(jQuery('a.modal.btn'));
	jQuery( "#custome-toolbar" ).append( jQuery('div#toolbar').html());
	jQuery("h2#page_title").text(jQuery(".page-title").text());
	jQuery("a#logout").attr("href", jQuery(".btn-group.logout a").attr("href"));
	jQuery("select#limit").addClass( "inputbox input-mini form-control m-b" );
	jQuery( "#side-menu" ).append( jQuery("#submenu").html() );
	jQuery('#sidebar .filter-select select').each(
		function(index){
			console.log(jQuery(this));
			jQuery( "#filter-bar .col-sm-2:last" ).before(jQuery(this));
		}
	);
	var alert_type = jQuery("#system-message-container div").attr('class');
	if(alert_type) {
		switch(alert_type) {
			case "alert alert-success":
				alert_type = "success"
				break;
			case "alert ":
				alert_type = "warning"
				break;
			case "alert alert-warning":
				alert_type = "warning"
				break;
			case "alert alert-error":
				alert_type = "error"
				break;
			default:
			alert_type = "info"
		}
			toastr[alert_type](jQuery("#system-message-container .alert").html());

		toastr.options = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": false,
			"progressBar": false,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
	}
});