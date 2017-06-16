<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

//форма обратной связи с директором
global $APPLICATION;
$FEEDBACK_CAPTCHA_CODE = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
?>
<h1><span class="h_write">Написать директору</span></h1>
<div id="formwriteme">
	<div class="message">
		
	</div>
		
	<form method="get" action="login.php" id="director_feedback">
		
		<p>
			<label for="username">ФИО</label>
			<input type="text" name="FEEDBACK[NAME]" id="username">
		</p>
		<p>
			<label for="emal">Электронная почта</label>
			<input type="text" name="FEEDBACK[EMAIL]" id="emal">
		</p>
		<p>
			<label for="phone">Контактный телефон</label>
			<input type="text" name="FEEDBACK[PHONE]" id="phone">
		</p>
		<p>
			<label for="comments">Текст сообщения</label>
			<textarea name="FEEDBACK[COMMENTS]" cols="36" rows="5" id="comments"></textarea>
		</p>
			
			
		<p>
			<label for="director_feedback_captcha_word">Код с картинки</label>
			<input type="text" name="FEEDBACK[captcha_word]" maxlength="50" id="director_feedback_captcha_word" value=""/>
		</p>
		<p>
			<input type="hidden" name="FEEDBACK[captcha_sid]" value="<?=$FEEDBACK_CAPTCHA_CODE?>" />
			<img class="capcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=$FEEDBACK_CAPTCHA_CODE?>" width="180" height="40" alt="CAPTCHA"/>
		</p>
		<p>
			<input type="submit" name="button" id="button_send" value="Отправить">
		</p>
	</form>
	<a class="cansel_order" style="display: none; margin: 10px 0px 0px 30px;" href="#">Закрыть</a>
</div>


<script>

$(document).ready(function(){

	$('.writeme').find('.cansel_order').bind('click', function(){
		$('.writeme').find('.close_button').click();
		$('.writeme').find('.contaner').html('');
		return false;
		});
		
	$('#director_feedback').validate({
		errorElement: "span",
		wrapper: "em",
		errorPlacement: function(error, element) {
			element.parent().append(error);
			},
		rules: {
			'FEEDBACK[NAME]': {
				required: true,
				minlength: 2
				},
			'FEEDBACK[EMAIL]': {
				//required: true,
				email: true
				},
			'FEEDBACK[PHONE]': {
				required: true,
				minlength: 5
				},

			'FEEDBACK[COMMENTS]': {
				required: true,
				minlength: 10
				},
			'FEEDBACK[captcha_word]': {
				required: true,
				minlength: 5,
				maxlength: 5
				}
			},
		messages: {
			'FEEDBACK[NAME]': {
				required: "Обязательно поле",
				minlength: "Ошибка"
				},
			'FEEDBACK[EMAIL]': {
				required: "Обязательно поле",
				email: "Ошибка"
				},
			'FEEDBACK[PHONE]': {
				required: "Обязательно поле",
				minlength: "Ошибка"
				},

			'FEEDBACK[COMMENTS]': {
				required: "Обязательно поле",
				minlength: "Ошибка"
				},
			'FEEDBACK[captcha_word]': {
				required: "Обязательно поле",
				minlength: "Ошибка",
				maxlength: "Ошибка"
				}
			},
		 submitHandler: function(form) {
			
			var form_data = $(form).serialize(); //данные формы
			var form_mess = $(form).parent().find('.message'); //вывод сообщения
			
			form_mess.html('');
			form_mess.hide();
			form_mess.removeClass('ok');
			form_mess.removeClass('error');

			//block button
			$(form).find('button').attr('disabled', 'disabled');
			
			$.ajax({
				url: '/bitrix/tools/kolorit/director_callback.php',
				type: 'POST',
				dataType : "json", 
				data: form_data,
				cache:false,
				success: function (data, textStatus) {
					
					if(data != 'null'){

						if(data['ERROR']){
							form_mess.addClass('error');
							}	
						else{
                            ga('send', 'event', 'direktor', 'sent');
                            form_mess.addClass('ok');
							$(form).parent().find('.cansel_order').show();
							//$(form).find("input[type!=submit]").val('');
							//$(form).find("textarea").val('');
							$(form).remove();
							}	

						form_mess.show();					
						form_mess.html(data['MESSAGE']);
						}
						
					//update capcha
					$(form).find("input[name='FEEDBACK[captcha_word]']").val('');
					$(form).find("input[name='FEEDBACK[captcha_sid]']").val(data['CAPTCHA_CODE']);
					$(form).find("img.capcha").attr('src', data['CAPTCHA_IMG']);
					
					$(form).find('button').removeAttr('disabled');
					
					},
				error: function () {

					form_mess.addClass('error');
					form_mess.show();						
					$(form).find('button').removeAttr('disabled');
					}
			});
			return false;
			}
		});
		

	});
	</script>