<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?if($arResult["FORM_TYPE"] == "login"):?>

    <div class="auth_form_login">


        <form class="mForm ajax" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

            <h3>Вход в личный кабинет</h3>

            <?if($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>

            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>

            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />

            <div class="field login">
                <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" placeholder="<?=GetMessage("AUTH_LOGIN")?>"/>
            </div>

            <div class="field password">
                <input type="password" name="USER_PASSWORD" maxlength="50" size="17" placeholder="<?=GetMessage("AUTH_PASSWORD")?>"/>
            </div>

            <?if($arResult["SECURE_AUTH"]):?>
                <span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                    <div class="bx-auth-secure-icon"></div>
                </span>
                <noscript>
                <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                    <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                </span>
                </noscript>
                <script ty  pe="text/javascript">
                    document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
                </script>
            <?endif?>

            <?if ($arResult["CAPTCHA_CODE"]):?>

                <div class="field_captcha_img">
                    <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                </div>

                <div class="field captcha">
                    <input type="text" name="captcha_word" maxlength="50" value="" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" />
                </div>

            <?endif?>

            <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
                <div class="field_checkbox">
                    <input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /></td>
                    <label for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>"><?echo GetMessage("AUTH_REMEMBER_SHORT")?></label>
                </div>
            <?endif?>

            <div class="error_text">
                <?
                if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
                    ShowMessage($arResult['ERROR_MESSAGE']);
                ?>
            </div>

            <div class="links">
                <!--noindex-->
                <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                <!--/noindex-->
            </div>

            <div class="buttons">
                <button class="yellow" type="submit" name="Login" value="Y"><?=GetMessage("AUTH_LOGIN_BUTTON")?></button>
            </div>



        </form>
    </div>

    <script>
        $('form[name=system_auth_form<?=$arResult["RND"]?>]').submit(function(){

            var div = $(this).parents('div.auth_form_login'),
                data = $(this).serialize(),
                url = $(this).attr('action');

            $(this).find('input, textarea').attr('disabled', 'disabled');

            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                data: data + "&Login=Y&ajax=Y",
                success: function(html){
                    div.html(html);
                    }
                });

                return false;
            });
    </script>

<?else:?>
	<div class="ajax_form_result mini">
		<span>Вы авторизованы
		<br>
		<br>
		<a class="button yellow" href="">Перейти на сайт</a>
		</span>
		
	</div>
<?endif?>