<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!is_array($arParams["~AUTH_RESULT"]))
	$arParams["~AUTH_RESULT"] = array();

if($arParams["~AUTH_RESULT"]["TYPE"] == 'OK')
	$arParams["~AUTH_RESULT"]['MESSAGE'] = 'Информация для смены пароля отправлена на вашу электронную почту.';
?> 

<p><?ShowMessage($arParams["~AUTH_RESULT"]);?></p>


<?if($arParams["~AUTH_RESULT"]["TYPE"] != 'OK'):?> 

	<form class="style2 order-auth forgotpassw" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif;?>

		<input type="hidden" name="AUTH_FORM" value="Y"/>
		<input type="hidden" name="TYPE" value="SEND_PWD"/>
		<input type="hidden" name="send_account_info" value="Y"/>

		<p><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>

		<div class="field">
			<label for="phones"><?=GetMessage("AUTH_EMAIL")?></label>
			<input class="form-border"  type="text" name="USER_EMAIL" id="USER_EMAIL" maxlength="255"/>
		</div>

		<div class="filed-button">
			<button class="yellow round" name="Login" type="submit"><?=GetMessage("AUTH_SEND")?></button>
			<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
				<noindex>
					<a href="<?=$arResult["LAST_LOGIN"]?>" rel="nofollow"><?//=GetMessage("AUTH_FORGOT_PASSWORD_2")?>Авторизация</a>
				</noindex>
			<?endif?>
		</div>
	</form>

	<script type="text/javascript">
	document.bform.USER_EMAIL.focus();
	</script>

<?endif;?>

<?
global $APPLICATION;
$APPLICATION->SetTitle("Смена пароля");
$APPLICATION->SetDirProperty("title", "Смена пароля");
?>
