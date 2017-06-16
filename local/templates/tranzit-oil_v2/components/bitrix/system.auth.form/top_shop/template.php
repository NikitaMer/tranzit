<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="top-auth-form">
<?
$CSiteController = SiteController::getEntity();
$theme_class = $CSiteController->getTheme();

$frame = $this->createFrame("top-auth-form", false)->begin();
?>
<?if($arResult["FORM_TYPE"] == "login"):?>

    <a class="personal" href="javascript:void(0);"><span>Личный кабинет</span></a>
	
		<a class="open_ajax login" href="/local/ajax/auth.php?theme=<?=$theme_class?>">Вход</a>

    <div class="sep"></div>
    <a class="open_ajax registr" href="/local/ajax/reg.php?theme=<?=$theme_class?>">Регистрация</a>

<?else: //if($arResult["FORM_TYPE"] == "login")?>

    <form  class="" action="<?=$arResult["AUTH_URL"]?>" id="top_auth_form">

        <?foreach ($arResult["GET"] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>
 
        <div class="personal">
			<span><?=TruncateText($arResult["USER_NAME"], 15)?><div class="menu-down"></div></span>
			
			<ul class="profile-menu">
				<li><a href="<?=$arParams["PROFILE_URL"]?>orders/">Мои заказы</a></li>
				<li><a href="<?=$arParams["PROFILE_URL"]?>profile/">Настройки</a></li>
				<li><a href="?logout=yes">Выход</a></li>
			<ul>
		</div>

        <?/*
        <a class="login">Ваш бонус: 23 руб</a>
        */?>

        <script>
            $(function(){
                $('#top_auth_form a.logout').click(function(){
                    $(this).parents('form').submit();
                    });
                });


            var file;
            function searchFileDoc(){
                var file = $("[name='ORDER_PROP_10[0]']");
                file.click();

                file.unbind('change');

                file.change(function(e){
                    var val = $(this).val();
                    $("[name='ORDER_PROP_S_10[0]']").val(val);
                    });

                return false;
            }

        </script>
    </form>

<?endif?>
<?
$frame->beginStub();

$frame->end();
?>
</div>