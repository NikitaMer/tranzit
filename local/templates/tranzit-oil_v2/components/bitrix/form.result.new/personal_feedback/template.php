<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!is_array($arResult['FORM_ERRORS']))
    $arResult['FORM_ERRORS'] = array();

//print_r($arResult['FORM_ERRORS']);

$has_error = count($arResult['FORM_ERRORS']) > 0;

#if ($arResult["isFormErrors"] == "Y")
#    echo $arResult["FORM_ERRORS_TEXT"];?>

<?/*if($arResult["FORM_NOTE"]):?>
    <div class="ajax_form_result"><span><?=$arResult["FORM_NOTE"]?></span></div>
<?endif;*/?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?if ($arResult["isFormNote"] != "Y")
{
    $arResult["FORM_HEADER"] = str_replace('<form','<form class="style2"',$arResult["FORM_HEADER"]);

    echo $arResult["FORM_HEADER"];

    if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
    {
        /***********************************************************************************
                            form header
        ***********************************************************************************/
        if ($arResult["isFormTitle"])
        {
        ?>
			<div class="title"><?=$arResult["FORM_TITLE"]?></div>
        <?
        } //endif ;

        #echo $arResult["FORM_DESCRIPTION"];

    } 

    /***********************************************************************************
                            form questions
    ***********************************************************************************/

	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{

        #if($FIELD_SID == 'MESSAGE')
        #    echo '<pre>'.print_r($arQuestion, true).'</pre>';
		
		if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'textarea')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
			?>
			<div class="field <?=mb_strtolower($FIELD_SID)?><?if(array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?> error<?endif;?>">
				<label><?echo $arQuestion["CAPTION"];?> <?=$arQuestion['FIELD_TYPE']?></label>
				<?echo $arQuestion["HTML_CODE"];?>
			</div>
		<?
		}
        unset($arResult['FORM_ERRORS'][$FIELD_SID]);
	} //endwhile
	?>

    <?
    if($arResult["isUseCaptcha"] == "Y")
    {
    ?>
        <div class="field capcha_image">
            <?//=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>
            <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
        </div>
        <div class="field capcha">
            <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
            <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
        </div>
    <?
    } // isUseCaptcha

    ?>

    <?if($has_error):?>
    <p class="error_text">

        <?if(count($arResult['FORM_ERRORS'])> 0 ):?>
            <?=$arResult["FORM_ERRORS_TEXT"]?>
        <?else:?>
        Не все поля заполенны верно
        <?endif;?>
    </p>
    <?endif;?>


    <div class="filed-button">
        <button class="<?if($arParams['WEB_FORM_ID'] == 2):?>yellow<?else:?>red<?endif;?>" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Y">
            Отправить<?//=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>
        </button>
    </div>

    <?=$arResult["FORM_FOOTER"]?>
<?
}

#$APPLICATION->set_cookie("FORM_OPENED_".$arResult['arForm']['ID'], time());
?>
