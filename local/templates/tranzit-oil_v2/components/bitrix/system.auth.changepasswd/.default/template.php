<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if($arParams["~AUTH_RESULT"]['TYPE'] == 'ERROR')
{
	if($arParams["~AUTH_RESULT"]['FIELD'] == 'CHECKWORD')
		$arParams["~AUTH_RESULT"]['MESSAGE'] = 'Для востановления паролья необходимо повторно запросить информацию на email.';
}
?>

<?if($arParams["~AUTH_RESULT"]["TYPE"] != 'OK'):?> 
	
	<?
	ShowMessage($arParams["~AUTH_RESULT"]);
	?> 

	<form class="style2 order-auth form-changepassword authorization" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
		<?if (strlen($arResult["BACKURL"]) > 0): ?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<? endif ?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="CHANGE_PWD">
		<input type="hidden" name="change_pwd" value="Y"/>
		<input type="hidden" name="USER_CHECKWORD" value="<?=$arResult["USER_CHECKWORD"]?>"/>
		
		<?/*

		<p style="margin: 0;">
			<label for="phones" style="width: 130px;line-height: 29px;"><?=GetMessage("AUTH_CHECKWORD")?></label>
			<input type="text" name="USER_CHECKWORD" id="phones" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" style="width: 160px;"/>
		</p>
		*/?>
		
		<?if($arResult["LAST_LOGIN"] == ''):?>
			<div class="field">
				<label for="login"><?=GetMessage("AUTH_LOGIN")?></label>
				<input type="text" name="USER_LOGIN" id="login" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>"/>
			</div>
		<?else:?>
			<input type="hidden" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>"/>
		<?endif;?>

		<div class="field">
			<label for="passw"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></label>
			<input class="form-border"  type="password" name="USER_PASSWORD" id="passw" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>"/>
		</div>

		<div class="field">
			<label for="passw_conf" ><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?></label>
			<input class="form-border"  type="password" name="USER_CONFIRM_PASSWORD" id="passw_conf" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"/>
		</div>
		
		<?//=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>

		<div class="filed-button">
			<button class="yellow round" name="change" type="submit"><?=GetMessage("AUTH_CHANGE")?></button>
		</div>
		
	</form>

	<script type="text/javascript">
	document.bform.USER_LOGIN.focus();
	</script>
<?else:?>
	<?
	$arParams["~AUTH_RESULT"] = array('TYPE' => 'OK', 'MESSAGE' => 'Пароль успешно сменен.');
	ShowMessage($arParams["~AUTH_RESULT"]);
	?>
	<br/><a style="padding-left:0px;" href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
<?endif;?>