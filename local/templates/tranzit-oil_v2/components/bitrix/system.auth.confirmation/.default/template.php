<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?//here you can place your own messages
	switch($arResult["MESSAGE_CODE"])
	{
	case "E01":
		?><? //When user not found
		break;
	case "E02":
		?><? //User was successfully authorized after confirmation
		break;
	case "E03":
		?><? //User already confirm his registration
		break;
	case "E04":
		?><? //Missed confirmation code
		break;
	case "E05":
		?><? //Confirmation code provided does not match stored one
		break;
	case "E06":
		?><? //Confirmation was successfull
		break;
	case "E07":
		?><? //Some error occured during confirmation
		break;
	}
?>

<?if($arResult["MESSAGE_TEXT"])
{
	if($arResult["MESSAGE_CODE"] != 'E06')
	{
		echo '<br/>';
		ShowMessage(array('MESSAGE' => $arResult["MESSAGE_TEXT"], 'TYPE' => 'ERROR'));
	}
	else
	{
		ShowMessage(array('MESSAGE' => $arResult["MESSAGE_TEXT"], 'TYPE' => 'OK'));
	}
	echo '<br/>';
}
?>


<?if($arResult["SHOW_FORM"]):?>
	<form class="style2 order-auth cofirmation" method="post" action="<?echo $arResult["FORM_ACTION"]?>" name="bconfirm">
	
		<input type="hidden" value="<?echo GetMessage("CT_BSAC_CONFIRM")?>" />
		<input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />

		<div class="field">
			<label for="LOGIN"><?=GetMessage("CT_BSAC_LOGIN")?></label>
			<input class="form-border" type="text" name="<?echo $arParams["LOGIN"]?>" id="LOGIN" maxlength="50" value="<?echo (strlen($arResult["LOGIN"]) > 0? $arResult["LOGIN"]: $arResult["USER"]["LOGIN"])?>" style="width: 160px;"/>
		</div>

		<div class="field">
			<label for="CONFIRM_CODE"><?=GetMessage("CT_BSAC_CONFIRM_CODE")?></label>
			<input class="form-border" type="text" name="<?echo $arParams["CONFIRM_CODE"]?>" id="CONFIRM_CODE" maxlength="255" value="<?=$arResult["CONFIRM_CODE"]?>" style="width: 160px;"/>
		</div>

		<div class="filed-button">
			<button class="yellow round" name="Login" type="submit"><?=GetMessage("CT_BSAC_CONFIRM")?></button>
		</div>
	</form>
	
<?elseif(!$USER->IsAuthorized()):?>
	<h2>Вход</h2>
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", array('HIDE_REG_LINK' => 'Y'));?>
<?endif?>