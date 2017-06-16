<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!is_array($arParams["~AUTH_RESULT"]))
	$arParams["~AUTH_RESULT"] = array();
?>
<!--
<? //print_r($arParams["~AUTH_RESULT"]);?>
-->
<?
if($arParams["~AUTH_RESULT"]['TYPE'] == 'OK')
{
	$arParams["~AUTH_RESULT"]['MESSAGE'] = str_replace('были ','',$arParams["~AUTH_RESULT"]['MESSAGE']);
	?>
	<div class="sucess-message"><?ShowMessage($arParams["~AUTH_RESULT"]);?></div>
	<?
}
else
{
	ShowMessage($arParams["~AUTH_RESULT"]);
}
?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
	<p><?echo GetMessage("AUTH_EMAIL_SENT")?></p>
<?else:?>

	<noindex>
	<form class="style2 order-auth registration" method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" id="bform">
	
		<?/*if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
		<p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
		<?endif*/?>

		<?if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif;?>
		
		<?if ($arResult["USE_EMAIL_CONFIRMATION"] == 'Y'):?>
			<input type="hidden" name="EMAIL_CONFIRMATION" value="Y" />
		<?endif;?>
		
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />

        <div class="field">
            <label for="USER_LOGIN"><?=GetMessage("AUTH_LOGIN_MIN")?></label>
            <input class="form-border" type="text" name="USER_LOGIN" id="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" style="width: 160px;" />
        </div>

		<div class="field">
			<label for="USER_EMAIL"><?=GetMessage("AUTH_EMAIL")?></label>
			<input class="form-border" type="text" name="USER_EMAIL" id="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" style="width: 160px;" />
		</div>
		<div class="field">
			<label for="USER_PASSWORD"><?=GetMessage("AUTH_PASSWORD_REQ")?></label>
			<input class="form-border"  type="password" name="USER_PASSWORD" id="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" style="width: 160px;"/>
			
			<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
				<script type="text/javascript">
				document.getElementById('bx_auth_secure').style.display = 'inline-block';
				</script>
			<?endif?>
		</div>
		<div class="field">
			<label for="USER_CONFIRM_PASSWORD"><?=GetMessage("AUTH_CONFIRM")?></label>
			<input class="form-border"  type="password" name="USER_CONFIRM_PASSWORD" id="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" style="width: 160px;" />
		</div>
		
			
		<?// ********************* User properties ***************************************************?>
		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
			<div class="field">
				<?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>
			</div>

			<div class="field">
				<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
				<?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?>
					<?=$arUserField["EDIT_FORM_LABEL"]?>:</td><td>
						<?$APPLICATION->IncludeComponent(
							"bitrix:system.field.edit",
							$arUserField["USER_TYPE"]["USER_TYPE_ID"],
							array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
				<?endforeach;?>
			</div>
		<?endif;?>
		<?// ******************** /User properties ***************************************************?>

		
		<?	/* CAPTCHA */ ?>
		<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
			<div class="field">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				
				<label for="captcha_word"><?=GetMessage("CAPTCHA_REGF_PROMT")?></label>
				<input class="form-border" type="text" name="captcha_word" maxlength="50" value="" id="captcha_word" style="width: 160px;"/>
			</div>
			<div class="field">
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" style="margin: 5px 0 10px 146px;"/>
			</div>
		<?endif;?>
		<?/* CAPTCHA */?>

		<div class="filed-button">
			<button class="yellow round" name="Register" type="submit"><?=GetMessage("AUTH_REGISTER")?></button>
			<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
				<noindex>
					<a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?//=GetMessage("AUTH_FORGOT_PASSWORD_2")?>Авторизация</a>
				</noindex>
			<?endif?>
		</div>

	</form>
	</noindex>

	<script>
		document.bform.USER_EMAIL.focus();
	</script>

<?endif?>

<?/*
<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
<a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a>
*/?>