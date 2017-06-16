<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["VALUE"] as $res)
{

	if($arParams["arUserField"]["SETTINGS"]["ROWS"] < 2):
		?><input type="text" id="main_<?=$arParams["arUserField"]["FIELD_NAME"]?>" name="<?=$arParams["arUserField"]["FIELD_NAME"]?>" value="<?=$res?>"<?
		
		if (intVal($arParams["arUserField"]["SETTINGS"]["SIZE"]) > 0)
		{
			?> size="<?=$arParams["arUserField"]["SETTINGS"]["SIZE"]?>"<?
		}
		
		if (intVal($arParams["arUserField"]["SETTINGS"]["MAX_LENGTH"]) > 0)
		{
			?> maxlength="<?=$arParams["arUserField"]["SETTINGS"]["MAX_LENGTH"]?>"<?
			?> maxlength="<?=$arParams["arUserField"]["SETTINGS"]["MAX_LENGTH"]?>"<?
		}
		
		if ($arParams["arUserField"]["EDIT_IN_LIST"]!="Y")
		{
			?> disabled="disabled"<?
		}
		
		echo '>';

	else:
		?><textarea class="fields string" name="<?=$arParams["arUserField"]["FIELD_NAME"]?>"<?
			?> cols="<?=$arParams["arUserField"]["SETTINGS"]["SIZE"]?>"<?
			?> rows="<?=$arParams["arUserField"]["SETTINGS"]["ROWS"]?>" <?
			if (intVal($arParams["arUserField"]["SETTINGS"]["MAX_LENGTH"]) > 0):
				?> maxlength="<?=$arParams["arUserField"]["SETTINGS"]["MAX_LENGTH"]?>"<?
			endif;
			if ($arParams["arUserField"]["EDIT_IN_LIST"]!="Y"):
				?> disabled="disabled"<?
			endif;
		?>><?=$res?></textarea><?
	endif;
}
?>

<?if ($arParams["arUserField"]["MULTIPLE"] == "Y" && $arParams["SHOW_BUTTON"] != "N"):?>
<input type="button" value="<?=GetMessage("USER_TYPE_PROP_ADD")?>" onClick="addElement('<?=$arParams["arUserField"]["FIELD_NAME"]?>', this)">
<?endif;?>