<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!is_array($arResult['FORM_ERRORS']))
    $arResult['FORM_ERRORS'] = array();

$has_error = !empty($arResult['FORM_ERRORS']);

#if ($arResult["isFormErrors"] == "Y")
#    echo $arResult["FORM_ERRORS_TEXT"];?>

<?/*if($arResult["FORM_NOTE"]):?>
    <div class="ajax_form_result"><span><?=$arResult["FORM_NOTE"]?></span></div>
<?endif;*/?>


<?if ($arResult["isFormNote"] != "Y")
{
    $arResult["FORM_HEADER"] = str_replace('<form','<form class="mForm form_get_price ajax"',$arResult["FORM_HEADER"]);

    echo $arResult["FORM_HEADER"];

    if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
    {
        /***********************************************************************************
                            form header
        ***********************************************************************************/
        if ($arResult["isFormTitle"])
        {
        ?>
            <h3><?=$arResult["FORM_TITLE"]?></h3>
        <?
        } //endif ;

        if ($arResult["isFormImage"] == "Y")
        {
        ?>
        <a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>">
            <img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" />
        </a>

        <?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
        <?
        } //endif

        #echo $arResult["FORM_DESCRIPTION"];

    } // endif

    /***********************************************************************************
                            form questions
    ***********************************************************************************/

	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        //$arQuestion['FIELD_TYPE']
        #if($FIELD_SID == 'MESSAGE')
        #    echo '<pre>'.print_r($arQuestion).'</pre>';
	?>
        <div class="field <?=mb_strtolower($FIELD_SID)?><?if(array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?> error<?endif;?>">
            <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
            <span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
            <?endif;?>

            <?//=$arQuestion["CAPTION"]?>
            <?if ($arQuestion["REQUIRED"] == "Y"):?><?//=$arResult["REQUIRED_SIGN"];?><?endif;?>
            <?//=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>

            <?
            $arQuestion["HTML_CODE"] = str_replace('<input','<input placeholder="'.$arQuestion["CAPTION"].'" ',$arQuestion["HTML_CODE"]);
            $arQuestion["HTML_CODE"] = str_replace('<textarea','<textarea placeholder="'.$arQuestion["CAPTION"].'" ',$arQuestion["HTML_CODE"]);
			
            echo $arQuestion["HTML_CODE"]
            ?>
		</div>
	<?
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
    <p class="requered_info">* Все поля обязательны для заполнения</p>
    <label style="display: none;">
        <input type="text" name="YOUR_EMAIL_ADRES" value="" placeholder="box@examle.ru"> Ваш email
    </label>

    <?if($has_error):?>
    <p class="error_text">

        <?if(count($arResult['FORM_ERRORS'])> 0 ):?>
            <?=$arResult["FORM_ERRORS_TEXT"]?>
        <?else:?>
        Не все поля заполенны верно
        <?endif;?>
    </p>
    <?endif;?>


    <div class="buttons">
        <button class="<?if($arParams['WEB_FORM_ID'] == 2):?>yellow<?else:?>red<?endif;?>" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Y">
            Отправить<?//=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>
        </button>
        <?/*if ($arResult["F_RIGHT"] >= 15):?>
        &nbsp;<input type="hidden" name="web_form_apply" value="Y" /><input type="submit" name="web_form_apply" value="<?=GetMessage("FORM_APPLY")?>" />
        <?endif;*/?>
    </div>

    <?//=$arResult["REQUIRED_SIGN"];?> <?//=GetMessage("FORM_REQUIRED_FIELDS")?>

    <?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)

$APPLICATION->set_cookie("FORM_OPENED_".$arResult['arForm']['ID'], time());
?>
<?//if(!isset($_REQUEST['ajax'])):?>
    <script>
        $('form[name=<?=$arResult['arForm']['SID']?>]').submit(function(){
            var div = $(this).parents('div.fancybox-inner'),
                data = $(this).serialize(),
                url = $(this).attr('action');

            $(this).find('input, textarea').attr('disabled', 'disabled');

            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                data: data + "&web_form_submit=Y&ajax=Y",
                success: function(html){
                    div.html(html);
                    }
                });

            return false;
            });
    </script>
<?//endif;?>