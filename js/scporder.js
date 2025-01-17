(function($){
	$('table.posts #the-list, table.pages #the-list').sortable({
		'items': 'tr',
		'axis': 'y',
		'helper': fixHelper,
		'update' : function(e, ui) {
			$.post( ajaxurl, {
				action: 'update-menu-order',
				order: $('#the-list').sortable('serialize'),
				nonce: scporder.nonce
			});
		}
	});  

	var fixHelper = function(e, ui) {
		ui.children().children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	
})(jQuery)