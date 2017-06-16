<?IncludeModuleLangFile(__FILE__);?>

<?
if($GLOBALS["errors"])
    echo CAdminMessage::ShowMessage($GLOBALS["errors"]);
?>

<form action="<?=$APPLICATION->GetCurPage()?>" name="form1">
	<?=bitrix_sessid_post()?>
	
	<input type="hidden" name="id" value="wsm.import1c">
	<input type="hidden" name="install" value="Y">
	<input type="hidden" name="step" value="2">
	<input type="hidden" name="lang" value="<?echo LANG?>">
	
	<p><?=GetMessage("MOD_INSTALL_ERR_1")?></p>
    <br/>
    <br/>
	<input type="submit" name="submit" value="<?echo GetMessage("MOD_INSTALL")?>">
</form>