<?
IncludeModuleLangFile(__FILE__);
echo CAdminMessage::ShowNote(GetMessage("MOD_INST_OK"));
?>

<p><?=GetMessage("GO_TO_WSMART_SITE");?><a target="_blank" href="http://w-smart.ru/marketplace/wsm.import1c/?from=install">http://w-smart.ru/marketplace/wsm.import1c/</a></p>

<form action="<?echo $APPLICATION->GetCurPage()?>">
	<input type="hidden" name="lang" value="<?echo LANG?>">
	<input type="submit" name="" value="<?echo GetMessage("MOD_BACK")?>">
</form>
