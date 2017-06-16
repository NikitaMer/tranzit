var compareElements = [];


function removeFromCompareComplate(id)
{
	$('.element_'+id).remove();

	if($('.compare-list .element_item').length == 1)
		$("a.removeCategory").click();
}

function setCompareTitle(){

	for(i in compareElements){

		var pos_y = 0;
		pos_y = $(compareElements[i].row).position().top;
		$(compareElements[i].title).css('top', pos_y + 'px').appendTo('.compare-control')

	}

}

function checkNavElements()
{
	var elements = $('.compare-list .div-tr .element_item');
	elements.each(function(k, el){
		var nav_prev = $(el).find('.nav.prev'),
			nav_next = $(el).find('.nav.next');
			
		if(k == 0)
			nav_prev.hide();
		else
			nav_prev.show();
		
		if(k == elements.length - 1)
			nav_next.hide();
		else
			nav_next.show();
		
		});
}
$(function(){

	checkNavElements();

	$('.compare-list .element_item .nav').click(function(){
		var next = $(this).hasClass('next'),
			parent = $(this).parents('.compare-list .element_item'),
			index = $('.compare-list .element_item').index(parent);
			console.log('index',index, 'next', next);
			
			$('.compare-list .div-tr').each(function(k, row){
				
				var div = $(row).find('div.block'),
					current = div.eq(index).detach();
					
				//console.log(index, row);
				
				if(next){
					var next_element = div.eq(index + 1);
					$(next_element).after(current);
					}
				else {
					var prev_element = div.eq(index -1);
					$(prev_element).before(current);
					}
					
				});

		if($('.compare-list .div-tr').length < 4)
			$('.compare-list .div-tr').css('overflow-x','hide');
		
		checkNavElements();
		
		return false;
		});

	$('.compare-list div.left-title').each(function(index, element) {

		var elem = {
			row: $(element).parents('.div-tr').eq(0),
			title: this
		};

		compareElements.push(elem);
	});

	setCompareTitle();

	$('.compare-control input[name=different]').change(function(){
		var type = $(this).val(),
			props = $('.compare-list .property'),
			labels = $('.compare-control .left-title');

		if(type == 'different'){
			props.filter('.equal').hide();
			labels.filter('.equal').hide();
		}
		else {
			props.show();
			labels.show();
		}

		setCompareTitle();
	});
});