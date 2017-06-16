<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<form  class="style2 order-auth" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
	<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
	
	<?
	#$arResult['ERROR_MESSAGE'] = str_replace('логин','email', $arResult['ERROR_MESSAGE']['MESSAGE']);
	#if(is_array($arParams["~AUTH_RESULT"]))
	#	$arParams["~AUTH_RESULT"]['MESSAGE'] = str_replace('логин','email', $arParams["~AUTH_RESULT"]['MESSAGE']);
	
	ShowMessage($arParams["~AUTH_RESULT"]);
	ShowMessage($arResult['ERROR_MESSAGE']);
	?>
	<div class="field">
		<label for="USER_LOGIN"><?=GetMessage("AUTH_LOGIN")?></label>
		<input class="form-border" type="text" name="USER_LOGIN" id="phones" maxlength="255" id="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" />
	</div>

	<div class="field">
		<label for="USER_PASSWORD"><?=GetMessage("AUTH_PASSWORD")?></label>
		<input class="form-border" type="password" name="USER_PASSWORD" id="USER_PASSWORD" maxlength="50" />
	</div>

	<?if ($arResult["STORE_PASSWORD"] == "Y"):?>		  
		<input type="checkbox" name="USER_REMEMBER" id="USER_REMEMBER"  value="Y" style="margin-top: 2px; float: left; margin-left: 165px!important; margin-bottom: 14px;">
		<label for="USER_REMEMBER" class="art_aa" >&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label> 
	<?endif?>
	
	<?if($arResult["CAPTCHA_CODE"]):?>
		<div class="field">
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			
			<label for="captcha" style="width: 130px;line-height: 29px;"><?=GetMessage("AUTH_CAPTCHA_PROMT")?></label>
			<input class="form-border" type="text" name="captcha_word" maxlength="50" value="" id="captcha"/>
		</div>
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" style="margin: 5px 0 10px 146px;"/>
		<div class="clear_light"></div>
	<?endif;?>

	<div class="filed-button">
		<button class="yellow round" name="Login" type="submit"><?=GetMessage("AUTH_AUTHORIZE")?></button>
		<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
			<noindex>
			<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?//=GetMessage("AUTH_FORGOT_PASSWORD_2")?>Забыли пароль ?</a>
			</noindex>
		<?endif?>
	</div>


	<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
	<div class="filed-button">
		<noindex>
			<p>
				<br />
				<a class="open_ajax registr" href="/local/ajax/reg.php?theme=theme-yellow">Регистрация</a>
				<?//=GetMessage("AUTH_REGISTER")?></a>
				<?//=GetMessage("AUTH_FIRST_ONE")?>
			</p>
		</noindex>
	</div>
	<?endif?>
</form>

<script type="text/javascript">
	<?if (strlen($arResult["LAST_LOGIN"])>0):?>
	try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
	try{document.form_auth.USER_LOGIN.focus();}catch(e){}
	<?endif?>
</script>
