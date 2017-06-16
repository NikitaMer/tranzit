<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * company_user_profile template
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<?ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
	ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<form class="style2" id="user-profile" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">

	<?=$arResult["BX_SESSION_CHECK"]?>
	<input type="hidden" name="lang" value="<?=LANG?>" />
	<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
	<input type="hidden" name="EMAIL" maxlength="50" value="<?=$arResult["arUser"]["EMAIL"]?>" />
	
	<input type="hidden" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />

	<h2>Данные об организации</h2>

	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
		<div class="field-hidden">
			<label><?=$arUserField["EDIT_FORM_LABEL"]?>	
			<?if ($arUserField["MANDATORY"]=="Y"):?>
				<span class="starrequired">*</span>
			<?endif;?>
			</label>
			<div class="value-block">
			
				<?$APPLICATION->IncludeComponent(
					"bitrix:system.field.edit",
					$arUserField["USER_TYPE"]["USER_TYPE_ID"],
						array("bVarsFromForm" => $arResult["bVarsFromForm"],
						"arUserField" => $arUserField),
						null,
						array("HIDE_ICONS"=>"Y")
				);?>
			
			</div>
			<a class="edit">Изменить</a>
		</div>
		
		<div class="line"></div>
	<?endforeach;?>

	
	<?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
	<div class="sep"></div>
	<h2>Сменить пароль</h2>

	<div class="field v2">
		<label>Старый пароль</label>
		<input type="password" name="LAST_PASSWORD">
	</div>

	<div class="field v2">
		<label>Новый пароль<?//=GetMessage('NEW_PASSWORD_REQ')?></label>
		<input type="password" name="NEW_PASSWORD"  maxlength="50" value="" autocomplete="off">
		<div class="info"><?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]?></div>

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

	<div class="field v2">
		<label>Повтор нового пароля<?//=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
		<input type="password" name="NEW_PASSWORD_CONFIRM"  maxlength="50" value="" autocomplete="off">
	</div>
	<?endif?>

	<div class="sep"></div>

	<div class="filed-button-v2">
		<button type="submit" class="yellow round" name="save" value="Y">Сохранить<?//=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?></button>
		<?/*<input type="reset" value="<?=GetMessage('MAIN_RESET');?>">*/?>
	</div>

</form>

<script>
	$(function(){
		
		$("#user-profile").find("a.edit").click(function(){
	
			var parent = $(this).parents('.field-hidden');

			$(this).hide();
			parent.find('.value').hide();

			parent.find('input').show();
			return false;
			});
		});
</script>