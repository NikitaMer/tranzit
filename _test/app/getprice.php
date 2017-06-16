
<form id="form_get_price ajax">
    <h3>Запросить прайс</h3>
	<div class="field name error">
		<label class="icon" for=""></label>
		<input type="text" value="" placeholder="Логин"/>
	</div>
	<div class="field company">
		<input type="password" placeholder="Организация"/>
	</div>
	
	
	<div class="field email">
		<input type="password" placeholder="Email"/>
	</div>
	
	<div class="field phone">
		<input type="text" placeholder="Телефон"/>
	</div>
	
	<div class="field mess"><textarea  placeholder="Сообщение"></textarea></div>
	
	<p class="error_text"></p>
    <div class="buttons">
	    <button class="btn" type="submit">Отправить</button>
    </div>
</form>
<script>
$('#form_get_price').submit(function(){
	$(this).find('.error_text').html('Сообщение об ошибке').show();
	return false;
	});
</script>