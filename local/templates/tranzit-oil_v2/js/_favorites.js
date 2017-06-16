
BX.ready(function(){

	if(!BX.ORGMFavorites)
		return false;
		
	BX.ORGMFavorites({
		'link': 'addToFavorite',
		'check_status': true,
		'started': function(link, ID){
			
			if($(link).hasClass('isFavList')){
				if(!confirm('Вы действительно хотите удалить товар из избранного?'))
					return false;
				}

			},
		'success': function(link, cheched, ID, count, count_total){
			
			$('.user_faforites').html(count_total);
			
			if(cheched){
				link.innerHTML = 'В избранном';
				$(link).addClass('active');
				ShowNoticeFLine('fav');
				}
			else {
				
				link.innerHTML = 'В избранное';
				$(link).removeClass('active');

				if($(link).hasClass('isFavList'))
					$(link).parents('.tovar').remove();
				}
			},
		'error': function(link, error){
		
			if(error == 'need_auth')
				alert('Для добавления в избранное необходимо авторизоваться');
				
			},
		'checked': function(data, count, count_total){

			$('.user_faforites').html(count_total);

			for (i in data) {

				if(data[i]['infav']) {
					data[i]['element'].innerHTML = 'В избранном';
					$(data[i]['element']).addClass('active');
					}
				else{
					data[i]['element'].innerHTML = 'В избранное';
					$(data[i]['element']).removeClass('active');
					}
				}
			}
		});
	});