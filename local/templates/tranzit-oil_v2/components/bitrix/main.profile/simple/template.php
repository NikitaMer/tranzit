<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
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

	<h2>Личные данные</h2>

	<?//=GetMessage('LOGIN')?>
	<input type="hidden" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />

	<div class="field-hidden">
		<label>Ваша фамилия<?//=GetMessage('SECOND_NAME')?></font></label>
		<div class="value-block">
			<input type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
			<div class="value"><?=$arResult["arUser"]["SECOND_NAME"]?></div>
			<a class="edit" data-action="edit_field">Изменить</a>
		</div>
		<div class="line"></div>
	</div>


	<div class="field-hidden">
		<label>Ваше имя<?//=GetMessage('NAME')?></font></label>
		<div class="value-block">
			<input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
			<div class="value"><?=$arResult["arUser"]["NAME"]?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>

	<div class="field-hidden">
		<label>Ваше отчество<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
			<div class="value"><?=$arResult["arUser"]["LAST_NAME"]?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>

	<div class="field-hidden">
		<label>Дата рождения<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" name="PERSONAL_BIRTHDAY" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_BIRTHDAY"]?>" />
			
			<div class="value"><?=$arResult["arUser"]["PERSONAL_BIRTHDAY"]?></div>
			<a class="edit">Изменить</a>
			
			<?/*
			$APPLICATION->IncludeComponent(
				'bitrix:main.calendar',
				'',
				array(
					'SHOW_INPUT' => 'Y',
					'FORM_NAME' => 'form1',
					'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
					'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
					'SHOW_TIME' => 'N'
				),
				null,
				array('HIDE_ICONS' => 'Y')
			);*/

			//=CalendarDate("PERSONAL_BIRTHDAY", $arResult["arUser"]["PERSONAL_BIRTHDAY"], "form1", "15")
			?>
			
		</div>
		<div class="line"></div>
	</div>


	<div class="field-hidden">
		<label>Электронная почта <?//if($arResult["EMAIL_REQUIRED"]):?><?//=GetMessage('SECOND_NAME')?></label>
		<div class="value-block">
			<input type="text" name="EMAIL" maxlength="50" value="<?=$arResult["arUser"]["EMAIL"]?>" />
			<div class="value"><?=$arResult["arUser"]["EMAIL"]?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>

	<div class="field-hidden">
		<label>Телефон<?//=GetMessage('USER_PHONE')?></font></label>
		<div class="value-block">
			<input type="text" name="PERSONAL_PHONE" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
			<div class="value"><?=$arResult["arUser"]["PERSONAL_PHONE"]?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>

	<div class="field-hidden userphoto">
		<label>Фото</label>
		<div class="value-block">

			<input name="PERSONAL_PHOTO" class="typefile" size="20" type="file">
		
			<?//=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"];?>
		
			<?if (strlen($arResult["arUser"]["PERSONAL_PHOTO"])>0):?>
				<?//= $arResult["arUser"]["PERSONAL_PHOTO_HTML"] ?>
			<?endif;?>

			<div class="value">
				<?if($arResult["arUser"]["PERSONAL_PHOTO"]):?>
				<?$img = CFile::ResizeImageGet($arResult['arUser']['PERSONAL_PHOTO'], array('width'=>110, 'height'=>110), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?>
				<div class="image" style="background-image: url(<?=$img['src']?>);"></div>
				
				<?/*
				<input type="checkbox" name="PERSONAL_PHOTO_del" value="Y" id="PERSONAL_PHOTO_del">
				<label for="PERSONAL_PHOTO_del">Удалить файл</label>
				*/?>
				
				<?endif;?>
			</div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>

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

<?/*
	<div class="sep"></div>
	<h2 class="pb5">Уведомления</h2>
	<div class="div-table notif">
		<div class="div-tr header">
			<div class="name"> </div>
			<div class="option">СМС</div>
			<div class="option">Электронная почта</div>
		</div>
		<div class="div-tr">
			<div class="name">О спецпредложениях</div>
			<div class="option"><input type="checkbox" name="" value="Y"></div>
			<div class="option"><input type="checkbox" name="" value="Y"></div>
		</div>
		<div class="div-tr">
			<div class="name">О создании заказа</div>
			<div class="option"><input type="checkbox" name="" value="Y" checked=""></div>
			<div class="option"><input type="checkbox" name="" value="Y"></div>
		</div>
		<div class="div-tr">
			<div class="name">О приходе заказов с центрального склада</div>
			<div class="option"><input type="checkbox" name="" value="Y"></div>
			<div class="option"><input type="checkbox" name="" value="Y" checked=""></div>
		</div>
		<div class="div-tr">
			<div class="name">О состоянии безналичных заказов</div>
			<div class="option"><input type="checkbox" name="" value="Y" checked=""></div>
			<div class="option"><input type="checkbox" name="" value="Y"></div>
		</div>
	</div>

	*/?>

	<div class="sep"></div>
	<h2 class="pb40">Информация об автомобиле</h2>

	<?// ********************* User properties ***************************************************?>
	<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>

		<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
		<div class="field w100p">
			<label>
				<?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?>
				<?=$arUserField["EDIT_FORM_LABEL"]?>
			</label>

			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				$arUserField["USER_TYPE"]["USER_TYPE_ID"]."_simple",
				array(
				"bVarsFromForm" => $arResult["bVarsFromForm"],
				"arUserField" => $arUserField
				),
				null,
				array("HIDE_ICONS"=>"Y")
				);
				?>
		</div>
		<?endforeach;?>

	<?endif;?>
	
	<?// ******************** /User properties ***************************************************?>

	<?/*if($arResult["IS_ADMIN"]):?>
	<div class="field w100p">
		<label><?=GetMessage("USER_ADMIN_NOTES")?>:</label>
		<textarea cols="30" rows="5" name="ADMIN_NOTES"><?=$arResult["arUser"]["ADMIN_NOTES"]?></textarea>
	</div>
	<?endif;*/?>

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