
//класс для добавления к сравнению
(function( $ ){

	$.fn.compareList = function( options ) {

		controller = this;

		var defaults = $.extend( {
			'url'			: '/local/ajax/add2compare.php',
			'list_name' 	: 'CATALOG_COMPARE_LIST',
			'iblock_id' 	: 1,
			'started'	 	: function(){},
			'checkStatus'   : function(){},
			'success'       : function(){},
			'errors'        : function(){}
			}, options);

		var arID = [],
			elements = null,
			compareList = this;

		var options = $.extend(defaults, options || {});

		 this.reload = function (){

			elements = $(compareList.selector);
			elements.each(function(index, element) {

				var ID = $(element).attr('data-id') - 0;

				if(ID == 0 || isNaN(ID))
					console.warn('not set ID in data-id property');

				if(ID > 0)
					arID.push(ID);

				$(element).unbind();

				$(element).bind('click', function(){
					var ID = $(this).attr('data-id'),
						result = options.started(this),
						_this = this;

					if(result === false)
						return false;




					$.ajax({
						type: "POST",
						dataType: 'json',
						cache: false,
						data: {
							'id': ID,
							'list_name': options.list_name,
							'iblock_id': options.iblock_id
							},
						url: options.url,
						success: function(data){

							if(data['ERRORS'].length > 0) {
								if(typeof options.success == 'function')
									options.errors(_this, data['ERRORS']);
								}
							else {

								if(typeof options.success == 'function')
									options.success(_this, data);
								}

							},
						error: function(){

							}
						});

					return false;
					});
				});


	
			$.ajax({
				method: 'POST',
				dataType: 'json',
				//async: true,
				url: options.url,
				data: {
					'action': 'check',
					'elements': arID,
					'list_name': options.list_name,
					'iblock_id': options.iblock_id
					},
				cache: false,
				success: function(data){
					var El = {};
					
					for(i in arID){
					
						var has = false;
						for(k in data['ELEMENTS']){
							if(data['ELEMENTS'][k]==arID[i]){
								has = true;
							}
						}
						
						El[arID[i]] = has;
						}

					if(typeof options.checkStatus == 'function')
						options.checkStatus(El, data['COUNT']);
					},
				error: function(err){
					console.error(err);
					}
				});
			}

		this.reload();

	return compareList;
			
	};
})( jQuery );


