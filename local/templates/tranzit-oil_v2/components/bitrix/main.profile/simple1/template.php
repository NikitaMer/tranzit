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

	<h2>Данные об организации</h2>

	<?//=GetMessage('LOGIN')?>
	<input type="hidden" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />

	<div class="field-hidden">
		<label>Наименование предприятия<?//=GetMessage('SECOND_NAME')?></font></label>
		<div class="value-block">
			<input type="text" name="WORK_COMPANY" maxlength="50" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" />
			<div class="value"><?=$arResult["arUser"]["WORK_COMPANY"]?></div>
			<a class="edit" data-action="edit_field">Изменить</a>
		</div>
		<div class="line"></div>
	</div>


	<div class="field-hidden">
		<label>Организационно-правовая форма<?//=GetMessage('NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_OPF" name="UF_OPF" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_OPF']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_OPF']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>

	<div class="field-hidden">
		<label>Юридический адрес<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_ADR_UR" name="UF_ADR_UR" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_ADR_UR']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_ADR_UR']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>
	<div class="field-hidden">
		<label>Фактический адрес<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_ADR_FACT" name="UF_ADR_FACT" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_ADR_FACT']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_ADR_FACT']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>
	
	<div class="field-hidden">
		<label>Почтовый адрес<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_ADR_POST" name="UF_ADR_POST" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_ADR_POST']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_ADR_POST']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>
	<div class="field-hidden">
		<label>Банковские реквизиты<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<textarea style="width:380px;height:50px;" id="main_UF_REKV" name="UF_REKV"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_REKV']['VALUE']?></textarea>
		
			
		</div>
		<div class="line"></div>
	</div>
	<div class="field-hidden">
		<label>ИНН<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_INN" name="UF_INN" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_INN']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_INN']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>
	<div class="field-hidden">
		<label>ОГРН<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_OGRN" name="UF_OGRN" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_OGRN']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_OGRN']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>
	<div class="field-hidden">
		<label>Руководитель предприятия<?//=GetMessage('LAST_NAME')?></font></label>
		<div class="value-block">
			<input type="text" id="main_UF_RUKOVODITEL" name="UF_RUKOVODITEL" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_RUKOVODITEL']['VALUE']?>" size="20">
		
			<div class="value"><?=$arResult["USER_PROPERTIES"]["DATA"]['UF_RUKOVODITEL']['VALUE']?></div>
			<a class="edit">Изменить</a>
		</div>
		<div class="line"></div>
	</div>
	<div class="field-hidden">
		<label>Телефон/факс<?//=GetMessage('SECOND_NAME')?></font></label>
		<div class="value-block">
			<input type="text" name="WORK_PHONE" maxlength="50" value="<?=$arResult["arUser"]["WORK_PHONE"]?>" />
			<div class="value"><?=$arResult["arUser"]["WORK_PHONE"]?></div>
			<a class="edit" data-action="edit_field">Изменить</a>
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
	<!--by ko-->
	<script>
	function delete_tr(id, id2){
		$('#'+id).remove();
		$('#DOC_FILE'+id2).show();
		$('#DOC_FILE_'+id2).val('');
	}
	function change_doc(id, id2){
		$('#'+id).remove();
		$('#DOC_FILE'+id2).show();
		$('#DOC_FILE_'+id2).val('');
		$('#DOC_FILE'+id2).click();
	}
	</script>
	<div class="field-hidden userphoto">
		<label>Прикрепите копии ИНН и ОГРН</label>
		<div class="value-block">
				<?if($arResult["arUser"]["UF_DOC_FILES"]){
				?><table style="width: 100%;"><?
				if(isset($arResult["arUser"]["UF_DOC_FILES"][0])){
				$doc_file = CFile::GetByID($arResult["arUser"]["UF_DOC_FILES"][0]);
				$doc_file = $doc_file->Fetch();
				?><tr id="<?echo 'tr_'.$arResult["arUser"]["UF_DOC_FILES"][0];?>"><td><a href="<?=CFile::GetPath($arResult["arUser"]["UF_DOC_FILES"][0])?>" target="new" download><?=$doc_file['FILE_NAME']?></a></td><td><span style="cursor:pointer;" onclick="delete_tr('<?echo 'tr_'.$arResult["arUser"]["UF_DOC_FILES"][0];?>', 1);">Удалить</span></td><td><span style="cursor:pointer;" onclick="change_doc('<?echo 'tr_'.$arResult["arUser"]["UF_DOC_FILES"][0];?>', 1);">Изменить</span></td></tr><?
				} 
				if(isset($arResult["arUser"]["UF_DOC_FILES"][1])){
				$doc_file = CFile::GetByID($arResult["arUser"]["UF_DOC_FILES"][1]);
				$doc_file = $doc_file->Fetch();
				?><tr id="<?echo 'tr_'.$arResult["arUser"]["UF_DOC_FILES"][1];?>"><td><a href="<?=CFile::GetPath($arResult["arUser"]["UF_DOC_FILES"][1])?>" target="new" download><?=$doc_file['FILE_NAME']?></a></td><td><span style="cursor:pointer;" onclick="delete_tr('<?echo 'tr_'.$arResult["arUser"]["UF_DOC_FILES"][1];?>', 2);">Удалить</span></td><td><span style="cursor:pointer;" onclick="change_doc('<?echo 'tr_'.$arResult["arUser"]["UF_DOC_FILES"][1];?>', 1);">Изменить</span></td></tr><?
				}
				?>
				</table>
				<input name="DOC_FILE1"  id="DOC_FILE1" class="typefile" size="20" type="file" style="<?if(!isset($arResult["arUser"]["UF_DOC_FILES"][0])){?>display:block;<?}?>">
				<input name="DOC_FILE2"  id="DOC_FILE2" class="typefile" size="20" type="file" style="<?if(!isset($arResult["arUser"]["UF_DOC_FILES"][1])){?>display:block;<?}?>">
				<input name="DOC_FILE_1" id="DOC_FILE_1" size="20" value="<?=$arResult["arUser"]["UF_DOC_FILES"][0]?>" type="hidden">
				<input name="DOC_FILE_2" id="DOC_FILE_2" size="20" value="<?=$arResult["arUser"]["UF_DOC_FILES"][1]?>" type="hidden">
				<?}else{?>
				<input name="DOC_FILE1" class="typefile" size="20" style="display:block;" type="file">
				<input name="DOC_FILE2" class="typefile" size="20" style="display:block;" type="file">
				<?}?>

		</div>
		<div class="line"></div>
	</div>
	<!--by ko-->
	

	

	

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