<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
<!--
function ChangeGenerate(val)
{
	if(val)
	{
		document.getElementById("sof_choose_login").style.display='none';
	}
	else
	{
		document.getElementById("sof_choose_login").style.display='block';
		document.getElementById("NEW_GENERATE_N").checked = true;
	}

	try{document.order_reg_form.NEW_LOGIN.focus();}catch(e){}
}
//-->
</script>

	<h1>Оформление заказа</h1>

	<?/*if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
		<b><?echo GetMessage("STOF_2REG")?></b>
	<?endif;*/?>

	<?/*if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
		<b><?echo GetMessage("STOF_2NEW")?></b>
	<?endif;*/?>

	<? //echo GetMessage("STOF_LOGIN_PROMT")?>

	<form class="style2 order-auth" method="post" action="" name="order_auth_form">
		<?=bitrix_sessid_post()?>

		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach;?>

		<div class="field">
			<label><?echo GetMessage("STOF_LOGIN")?></label>
			<input type="text" name="USER_LOGIN" maxlength="30"value="<?=$arResult["AUTH"]["USER_LOGIN"]?>">
			<!--<div class="info">Пароль должен содержать буквы латинского алфавита и цифры, не менее 8 символов</div>-->
		</div>

		<div class="field">
			<label><?echo GetMessage("STOF_PASSWORD")?></label>
			<input type="password" name="USER_PASSWORD" maxlength="30">
		</div>


		<div class="filed-button">
			<button class="yellow round" type="submit">Войти</button>
			<?/*
			<a href="<?=$arParams["PATH_TO_AUTH"]?>?forgot_password=yes&back_url=<?= urlencode($APPLICATION->GetCurPageParam()); ?>">Забыли пароль?<?//echo GetMessage("STOF_FORGET_PASSWORD")?></a></td>
			*/?>
		</div>

		<input type="hidden" name="do_authorize" value="Y">

	</form>


<h1>Если вы покупаете впервые</h1>


<div class="order-selector div-table">

	<div class="div-tr">
		<div class="bttn">
            <a class="button round yellow open_ajax registr" href="/local/ajax/reg.php?theme=<?=$theme_class?>">Зарегистрироваться</a>
		</div>
		<div class="info2">Получайте бонусы, экономьте деньги и время при сдедующих покупках. Регистрация займет всего пару минут.</div>
	</div>

	<div class="div-tr">
		<div class="bttn">
			<a class="button white round open_ajax" href="/local/ajax/buy_one_click.php">Купить без регистрации</a>
		</div>
		<div class="info2">Вы не сможете получать бонусы за покупку. При следующей покупке придется заново указывать контактныю информацию или адрес доставки.
		</div>

	</div>

</div>

<?/*if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
	<form class="style2 order-auth" method="post" action="" name="order_reg_form">
		<?=bitrix_sessid_post()?>
		<?
		foreach ($arResult["POST"] as $key => $value)
		{
		?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?
		}
		?>
		<div class="field">
			<label><?echo GetMessage("STOF_NAME")?> <span class="starrequired">*</span></label>
			<input type="text" name="NEW_NAME" size="40" value="<?=$arResult["AUTH"]["NEW_NAME"]?>">&nbsp;&nbsp;&nbsp;
		</div>
		<div class="field">
			<label><?echo GetMessage("STOF_LASTNAME")?> <span class="starrequired">*</span></label>
			<input type="text" name="NEW_LAST_NAME" size="40" value="<?=$arResult["AUTH"]["NEW_LAST_NAME"]?>">&nbsp;&nbsp;&nbsp;
		</div>
		<div class="field">
			<label>E-Mail <span class="starrequired">*</span></label>
			<input type="text" name="NEW_EMAIL" size="40" value="<?=$arResult["AUTH"]["NEW_EMAIL"]?>">&nbsp;&nbsp;&nbsp;
		</div>


		<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
		<div class="field">
			<input type="radio" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N" OnClick="ChangeGenerate(false)"<?if ($_POST["NEW_GENERATE"] == "N") echo " checked";?>>
			<label for="NEW_GENERATE_N"><?echo GetMessage("STOF_MY_PASSWORD")?></label>
		</div>
		<?endif;?>

		<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
		<div class="field">
			<label><?echo GetMessage("STOF_LOGIN")?> <span class="starrequired">*</span></label>
			<input type="text" name="NEW_LOGIN" size="30" value="<?=$arResult["AUTH"]["NEW_LOGIN"]?>">
		</div>
		<div class="field">
			<label><?echo GetMessage("STOF_PASSWORD")?> <span class="starrequired">*</span></label>
			<input type="password" name="NEW_PASSWORD" size="30">
		</div>
		<div class="field">
			<label><?echo GetMessage("STOF_RE_PASSWORD")?> <span class="starrequired">*</span></label>
			<input type="password" name="NEW_PASSWORD_CONFIRM" size="30">
		</div>

		<div class="field">
			<input type="radio" id="NEW_GENERATE_Y" name="NEW_GENERATE" value="Y" OnClick="ChangeGenerate(true)"<?if ($POST["NEW_GENERATE"] != "N") echo " checked";?>> <label for="NEW_GENERATE_Y"><?echo GetMessage("STOF_SYS_PASSWORD")?></label>
			<script language="JavaScript">
			<!--
			ChangeGenerate(<?= (($_POST["NEW_GENERATE"] != "N") ? "true" : "false") ?>);
			//-->
			</script>
		</div>

		<?endif;?>

		<?
		if($arResult["AUTH"]["captcha_registration"] == "Y") //CAPTCHA
		{
			?>
			<div class="field">
				<b><?=GetMessage("CAPTCHA_REGF_TITLE")?></b>
			</div>
			<div class="field">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["AUTH"]["capCode"]?>">
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA">
			</div>
			<div class="field">
				<span class="starrequired">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>:<br />
				<input type="text" name="captcha_word" size="30" maxlength="50" value="">
			</div>
			<?
		}
		?>
		<div class="filed-button">
			<button class="yellow" type="submit" value="Y"><?echo GetMessage("STOF_NEXT_STEP")?></button>
			<input type="hidden" name="do_register" value="Y">
		</div>
	</form>
<?endif;*/?>


<?//echo GetMessage("STOF_REQUIED_FIELDS_NOTE")?>
<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
	<?//echo GetMessage("STOF_EMAIL_NOTE")?>
<?endif;?>
<?//echo GetMessage("STOF_PRIVATE_NOTES")?>
