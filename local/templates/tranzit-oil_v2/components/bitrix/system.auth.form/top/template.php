<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="top-auth-form">
<?
$CSiteController = SiteController::getEntity();
$theme_class = $CSiteController->getTheme();

$frame = $this->createFrame("top-auth-form", false)->begin();
?>
<?if($arResult["FORM_TYPE"] == "login"):?>

    <a class="personal" href="javascript:void(0);"><span>Личный кабинет</span></a>
    <a class="open_ajax login" href="/local/ajax/auth.php?theme=theme-red">Вход</a>
    <div class="sep"></div>
    <a class="open_ajax registr" href="/local/ajax/reg.php?theme=theme-red">Регистрация</a>

<?else: //if($arResult["FORM_TYPE"] == "login")?>

    <form  class="" action="<?=$arResult["AUTH_URL"]?>" id="top_auth_form">

        <?foreach ($arResult["GET"] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>

        <a class="personal" href="/shop/personal/orders/"><span>Личный кабинет</span></a>
        <a class="login" href="<?=$arResult["PROFILE_URL"]?>">профиль<?//=TruncateText($arResult["USER_NAME"].'abcdefigh', 7)?></a>
        <div class="sep"></div><a class="registr logout" href="#"><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a>

        <?//=$arResult["USER_LOGIN"]?>

        <input type="hidden" name="logout" value="yes" />
        <input type="hidden" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />

        <script>
            $(function(){
                $('#top_auth_form a.logout').click(function(){
                    $(this).parents('form').submit();
                    });
                });
        </script>
    </form>

<?endif?>
<?
$frame->beginStub();

$frame->end();
?>
</div>