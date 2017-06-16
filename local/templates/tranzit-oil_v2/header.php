<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

IncludeTemplateLangFile(__FILE__);

$CSiteController = SiteController::getEntity();
#echo 'isMainPage='.$CSiteController->isMainPage();
$theme_class = $CSiteController->getTheme();
$theme_class = $theme_class ? ' '.$theme_class : '';

$home_page = SITE_DIR;
$path = $GLOBALS['APPLICATION']->GetCurPage(false);
$is_shop_main = $path == '/shop/';
						
switch($CSiteController->getSiteSection())
{
	case $CSiteController::SECT_SINCENTER:
		$home_page = SITE_DIR.'gruzoviye-shiny/';
		break;

	case $CSiteController::SECT_RETAIL:
		$home_page = SITE_DIR.'retail-network/';
		break;

	case $CSiteController::SECT_SHOP:
		$home_page = SITE_DIR.'shop/';
		break;
}

#подключение избранного
if(Bitrix\Main\Loader::includeModule('wsm.favorites'))
{
    Wsm\Favorites::ScriptInc();
    //CWSMFavorites::ScriptInc();
}
$APPLICATION->SetPageProperty("description",  'Интернет-магазин автотоваров Tranzit-shop.ru с доставкой по Казани и Наб. Челнам'); 
?><!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
    <head>
        <title><?$APPLICATION->ShowTitle()?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="robots" content="index, follow" />


		<link href="<?=SITE_TEMPLATE_PATH?>/font/styles.min.css" type="text/css"  rel="stylesheet" />
		<link type="image/x-icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.ico" rel="shortcut icon">

	    <?/* <meta name="viewport" content="width=device-width, initial-scale=1.0">
		*/?>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/jquery.easing.1.3.min.js')?>"></script>
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/fancyapp/jquery.fancybox.pack.js')?>"></script>
		<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/fancyapp/jquery.fancybox.css?v=2.1.5" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/by_ko_styles.css" />
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/jquery.sudoSlider.min.js')?>"></script>
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/mail.js')?>"></script>
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/add2compare.js')?>"></script>
		<script src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/script.js')?>"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
		<?$APPLICATION->ShowHead();?>
	</head> 
	<body>

        <?$APPLICATION->ShowPanel();?>

        <!-- start container -->
		<div class="container<?=$theme_class?><?if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?> bottom-line<?endif;?>">

				
		
			<div class="top-menu">
				<div class="wrapper center-block">

					<?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top",
                        array(
                            "ROOT_MENU_TYPE" => "top",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => "2",
                            "CHILD_MENU_TYPE" => "left",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N"
                        ),
                        false
                    );?>
					
					<!-- Соц. кнопки -->
					<div class="soc" style="display:none;">
					    <a href="https://vk.com/tranzitshop" target="_blank"><img src="/local/templates/tranzit-oil_v2/img/vk.png"></a>
						<a href="https://www.facebook.com/Интернет-магазин-Tranzit-shopru-1188521421197537​" target="_blank"><img src="/local/templates/tranzit-oil_v2/img/facebook.png"></a>
						<a href="https://www.instagram.com/tranzitshop.ru" target="_blank"><img src="/local/templates/tranzit-oil_v2/img/instagram.png"></a>
					</div>

                    <?/*$APPLICATION->IncludeComponent("bitrix:search.title", "mini", Array(
                            "NUM_CATEGORIES" => "1",	// Количество категорий поиска
                            "TOP_COUNT" => "5",	// Количество результатов в каждой категории
                            "ORDER" => "date",	// Сортировка результатов
                            "USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
                            "CHECK_DATES" => "Y",	// Искать только в активных по дате документах
                            "SHOW_OTHERS" => "Y",	// Показывать категорию "прочее"
                            "PAGE" => "#SITE_DIR#search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                            "CATEGORY_0_TITLE" => "",	// Название категории
                            "CATEGORY_0" => array(	// Ограничение области поиска
                                0 => "no",
                            ),
                            "SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
                            "INPUT_ID" => "title-search-input",	// ID строки ввода поискового запроса
                            "CONTAINER_ID" => "title-search",	// ID контейнера, по ширине которого будут выводиться результаты
                        ),
                        false
                    );*/?>
						
                    <!--<script>
                        /*$(function(){
                            var inp = $('.top-menu .search-line input[type=text]');
                            inp.focus(function(){
                                $(this).parents('.search-line').addClass('active');
                                });
                            inp.blur(function(){
                                if(this.value.trim() == ''){
                                    this.value = '';
                                    $(this).parents('.search-line').removeClass('active');
                                    }

                                });
                        })*/
                    </script>-->

					
				</div>
			</div>
			
			<header>
				<div class="wrapper center-block">
					<?if($CSiteController->isMainPage()):?>
					<div class="logo">
					<?else:?>
						<a class="logo" href="<?=$home_page?>">
					<?endif;?>

                        <?if($CSiteController->getSiteSection() == $CSiteController::SECT_SINCENTER):?>
							<img src="<?=SITE_TEMPLATE_PATH?>/img/logo-shincenter.png" alt="Шинный центр"/>
						<?elseif($CSiteController->getSiteSection() == $CSiteController::SECT_RETAIL):?>
							<img src="<?=SITE_TEMPLATE_PATH?>/img/logo-retail.png" alt=""/>
                        <?elseif($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?>
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/logo-shop_2.png" alt=""/>
						<?else:?>
							<img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" alt="Транзит Ойл"/>
						<?endif;?>

					<?if($CSiteController->isMainPage()):?>
					</div>
					<?else:?>
					</a>
					<?endif;?>

                    <!-- top icon blocks -->
					<div class="icon-blocks">

                        <?if($CSiteController->getSiteSection() === $CSiteController::SECT_SHOP):?>

                            <?$APPLICATION->IncludeComponent(
                                "bitrix:sale.basket.basket.small",
                                "icon_block",
                                array(
                                    "PATH_TO_BASKET" => "/shop/cart/",
                                    "PATH_TO_ORDER" => "/shop/cart/order.php",
                                    "SHOW_DELAY" => "N",
                                    "SHOW_NOTAVAIL" => "N",
                                    "SHOW_SUBSCRIBE" => "N"
                                ),
                                false
                            );?>

                        <?else:?>
                            <!-- get price -->
                            <a href="/local/ajax/getprice.php" target="_blank" class="block getprice open_ajax">
                                <div class="ico"><span></span></div>
                                <div class="desc"><span>Запросить<br>прайс лист</span></div>
                            </a>
                            <!-- end get price -->
                        <?endif;?>

                        <!-- phone icon-->
                        <?if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?>

                            <? # для интернет магазина ?>

                            <div class="block phone">
                                <div class="ico phone"><span></span></div>
                                <div class="desc">
                                    <span class="phone">222-90-14</span><span>- </span>Казань<br>
                                    <span class="phone">999-862</span><span>- </span><div>Наб. Челны</div>
                                </div>
                            </div>

                        <?else:?>

                            <div class="block phone">
                                <div class="ico phone"><span></span></div>
                                <div class="desc">
                                    <span class="phone">222-85-90</span><span> - </span>офис<br>
                                    <span class="phone">222-90-14</span><span> - </span><div>интернет-магазин</div>
                                </div>
                            </div>

                        <?endif;?>
                        <!-- end phone icon-->

                        <!-- personal icon-->
						<div class="block personal" id="auth-container">
							<div class="ico user"><span></span></div>
							<div class="desc">
                                <?
                                $personal_template = $CSiteController->getSiteSection() == $CSiteController::SECT_SHOP ? 'top_shop' : 'top';
                                $APPLICATION->IncludeComponent(
                                    "bitrix:system.auth.form",
                                    $personal_template,
                                    array(
                                        "REGISTER_URL" => "",
                                        "FORGOT_PASSWORD_URL" => "/shop/personal/orders/?forgot_password=yes",
                                        "PROFILE_URL" => "/shop/personal/",
                                        "SHOW_ERRORS" => "N"
                                    ),
                                    false
                                );?>

							</div>
						</div>
                        <!-- end personal icon-->
					
					</div>
                    <!-- end top icon blocks -->
				</div>
			</header>

            <!-- main slider -->
			<?
            #==================================================================
            # подключение основного слайдера
            #==================================================================

            global $USER;
            $arUGroup = $USER->GetUserGroupArray();

            $slider_postfix = in_array(9, $arUGroup) ? '_optovik' : '';

            if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP)
                include(dirname(__FILE__).'/sliders/slider_shop'.$slider_postfix.'.php');
            elseif(file_exists(dirname(__FILE__).'/sliders/slider_main'.$slider_postfix.'.php'))
                include(dirname(__FILE__).'/sliders/slider_main'.$slider_postfix.'.php');
            ?>
            <!-- end main slider -->

			<?if($CSiteController->getSiteSection() == $CSiteController::SECT_SHOP):?>

                <?$APPLICATION->IncludeComponent(
                    "bitrix:search.form",
                    "top_line",
                    array(
                        "PAGE" => "#SITE_DIR#shop/search/",
                        "USE_SUGGEST" => "N"
                    ),
                    false
                );?>

			<?endif;?>

            <!-- section content -->
			<section class="content">
                <!-- wrapper -->
				<div class="wrapper center-block">

                <?if($CSiteController->needColumn()):?>

                    <!-- columns -->
					<div class="columns">

                        <!-- left column -->
						<div class="col main_left">
							<?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "columns",
                                array(
                                    "AREA_FILE_SHOW" => "sect",
                                    "AREA_FILE_SUFFIX" => "left",
                                    "EDIT_TEMPLATE" => "",
                                    "AREA_FILE_RECURSIVE" => "Y"
                                ),
                                false
                            );?>


                            <?

                            if($CSiteController->isShop())
                                include($_SERVER["DOCUMENT_ROOT"].'/local/templates/tranzit-oil_v2/banner/shop_left.php');
                            else
                                include(dirname(__FILE__).'/banner/left_banners.php');
                            ?>

                            
						</div>
                        <!-- END left column -->

                        <!-- right column -->
						<div class="col main_right">



                            <?if(!$CSiteController->isMainPage() && !$CSiteController->is404()):?>

                                <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array(
                                        "START_FROM" => "",
                                        "PATH" => "",
                                        "SITE_ID" => "",
                                    ),
                                    false
                                    );?>

                            <?endif;?>

                            <?if($CSiteController->checkPath('/news/') && !$CSiteController->is404()):?>
                                <div class="page_title">
                                    <h1 class="mr80"><?$APPLICATION->ShowTitle('h1');?></h1>
                                    <?$R = $APPLICATION->ShowViewContent('h1_info'); echo $R;?>
                                </div>
                            <?elseif(!$CSiteController->is404()):?>
                                <h1 class="mr80"><?$APPLICATION->ShowTitle('h1');?></h1>
                            <?endif;?>

                <?else:?>

                    <?if(strpos($CSiteController->getPath(), '/shop/personal/') === 0 && !$CSiteController->is404()):?>

                        <? if (1==1) { $APPLICATION->IncludeComponent("conf:form_wide"); } ?>

                        <h1 class="mr80"><?$APPLICATION->ShowTitle('h1');?></h1>

                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "tab",
                            array(
                                "ROOT_MENU_TYPE" => "left",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N"
                            ),
                            false
                        );?>

                        <div class="tabs personal">
                            <div class="tab">

                    <?endif;?>

                <?endif;?>