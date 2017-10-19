<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

$app = \Bitrix\Main\HttpApplication::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

$theme = $request->getQuery('theme');

//_print_r($arResult);

#EMAIL_REQUIRED
?>

<?if($USER->IsAuthorized()):?>

	<div class="ajax_form_result mini">
		<span>Вы успешно зарегистрированны
		<br><br><br>
		<a class="button yellow" href="">Перейти на сайт</a>
		</span>

	</div>

<?else:?>

    <div class="auth_form_registr <?=$theme?>">
        <form class="mForm ajax" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" id="ajax_reg_form" enctype="multipart/form-data">
            <h3><?=GetMessage("AUTH_REGISTER")?></h3>
			<?if(!$arResult['SUCCESS']):?>
            <?if($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif;?>

            <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" value="mypass" autocomplete="off">

			<?/*if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
			<p><?=GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
			<?endif;*/?>

        <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
		<?
		//echo '<pre>'; print_r($FIELD); echo '</pre>';
		?>

            <?if($FIELD == "CONFIRM_PASSWORD") continue;?>

            <?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>

                <div class="field email">
                    <?echo GetMessage("main_profile_time_zones_auto")?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>

                    <select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
                        <option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
                        <option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
                        <option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
                    </select>


                    <?echo GetMessage("main_profile_time_zones_zones")?></td>
                    <select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"'?>>
                        <?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
                            <option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
                        <?endforeach?>
                    </select>
                </div>

            <?else:?>
				<?if($FIELD!='WORK_COMPANY' && $FIELD!='PROPERTY_UF_INN' && $FIELD!='PROPERTY_UF_CONTRAGENT'):?>
                <div class="field <?=strtolower($FIELD)?>">

                    <?/*if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif*/?>
                    <?
                    switch ($FIELD)
                    {
                        case "PASSWORD":
                            ?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" />

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
                            <?
                            break;

                        case "CONFIRM_PASSWORD":

                            ?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" /><?
                            break;

                        case "PERSONAL_GENDER":
                            ?><select name="REGISTER[<?=$FIELD?>]">
                                <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                                <option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                                <option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                            </select><?
                            break;

                        case "PERSONAL_COUNTRY":
                        case "WORK_COUNTRY":
                            ?><select name="REGISTER[<?=$FIELD?>]"><?
                            foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
                            {
                                ?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
                            <?
                            }
                            ?></select><?
                            break;

                        case "PERSONAL_PHOTO":
                        case "WORK_LOGO":
                            ?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>"/><?
                            break;

                        case "PERSONAL_NOTES":
                        case "WORK_NOTES":
                            ?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>"><?=$arResult["VALUES"][$FIELD]?></textarea><?
                            break;

                        default:
                            if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
                            ?><input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>"/><?
                                if ($FIELD == "PERSONAL_BIRTHDAY")
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:main.calendar',
                                        '',
                                        array(
                                            'SHOW_INPUT' => 'N',
                                            'FORM_NAME' => 'regform',
                                            'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                            'SHOW_TIME' => 'N'
                                        ),
                                        null,
                                        array("HIDE_ICONS"=>"Y")
                                    );

                        }?>
                </div><?endif?>
            <?endif?>
        <?endforeach?>
            <?// ********************* User properties ***************************************************?>
            <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>

                <div class="field captcha">
                    <?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>
                    <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                        <?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:system.field.edit",
                                $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
                    <?endforeach;?>
                </div>
            <?endif;?>
			<input size="30" type="text" id="mail" name="mail" value="">
			<input type="radio" name="REGISTER[PROPERTY_UF_CONTRAGENT]" value="4" <?if($arResult["VALUES"]['PROPERTY_UF_CONTRAGENT']==4) echo 'checked'?> <?if($arResult["VALUES"]['PROPERTY_UF_CONTRAGENT']=='') echo 'checked'?>> Физическое лицо<br>
			<input type="radio" name="REGISTER[PROPERTY_UF_CONTRAGENT]" value="5" <?if($arResult["VALUES"]['PROPERTY_UF_CONTRAGENT']==5) echo 'checked'?>> Юридическое лицо<br><br>
			<div id="ur_block" <?if($arResult["VALUES"]['PROPERTY_UF_CONTRAGENT']!=5) echo 'style="display:none;"'?>>
				<div class="field login">
					<input size="30" type="text" name="REGISTER[WORK_COMPANY]" value="<?=$arResult["VALUES"]['WORK_COMPANY']?>" placeholder="Название организации/ИП">
				</div>
				<div class="field login">
					<input size="30" type="text" name="REGISTER[PROPERTY_UF_INN]" value="<?=$arResult["VALUES"]['PROPERTY_UF_INN']?>" placeholder="ИНН">
				</div>
				<div class="files">
					<span>Прикрепите копии ИНН и ОГРН</span>
					<input type="file" name="REGISTER[PROPERTY_UF_DOC_FILES[]]" value="<?=$arResult["VALUES"]['PROPERTY_UF_FILE']?>">
					<input type="file" name="REGISTER[PROPERTY_UF_DOC_FILES[]]" value="<?=$arResult["VALUES"]['PROPERTY_UF_FILE']?>">
				</div>
				<p>*Учетная запись будет активирована после проверки данных модератором</p>

			</div>
            <?
            // ******************** /User properties ***************************************************

            /* CAPTCHA */
            if ($arResult["USE_CAPTCHA"] == "Y")
            {
                // GetMessage("REGISTER_CAPTCHA_TITLE")
                ?>

                <div class="field_captcha_img">
                    <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                </div>

                <div class="field">
                    <input type="text" name="captcha_word" maxlength="50" value="" placeholder="<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>" />
                </div>
                <?
            }
            /* !CAPTCHA */
			if (count($arResult["ERRORS"]) > 0)
			{
            ?>
	            <div class="error_text">
	                <?
	                    foreach ($arResult["ERRORS"] as $key => $error)
	                        if (intval($key) == 0 && $key !== 0)
	                            $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	                    ShowError(implode("<br />", $arResult["ERRORS"]));
	                ?>
	            </div>
			<?}?>

			<div >
				<p style="text-align:justify;font-size: 10px;line-height: 12px;">	Нажимая кнопку «<?=GetMessage("AUTH_REGISTER")?>», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», <a href="/documents/agreement_.pdf" target="_blank">на условиях и для целей, определенных в Согласии на обработку персональных данных</a></p>
			</div>
            <div class="buttons">
                <button class="yellow" type="submit" name="register_submit_button" value="Y"><?=GetMessage("AUTH_REGISTER")?></button>
            </div>

            <?//echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
            <?//=GetMessage("AUTH_REQ")?>
		<?else:?>
			<h3>Заявка на регистрацию юридического лица успешно отправлена на проверку.</h3>
			<p style="text-align:justify;">После того, как ваша организация будет проверена службой безопасности, вам придет уведомление на e-mail об активации вашего профиля.</p>
		<?endif?>
        </form>
    </div>

    <script type="text/javascript">
		$("#mail").hide();
		$("input:radio").click(function(){
			if($( "input:checked" ).val()==5)
				$('#ur_block').show();
			else
				$('#ur_block').hide();
		});
        $('#ajax_reg_form').submit(function(){

            var div = $(this).parents('div.auth_form_registr'),
                data = $(this).serialize(),
                url = $(this).attr('action');

            $(this).find('input, textarea').attr('disabled', 'disabled');

            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                data: data + "&register_submit_button=Y&ajax=Y",
                success: function(html){
                    div.html(html);
                }
            });

            return false;
        });
    </script>
<?endif?>
