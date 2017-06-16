<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;

#echo '<pre>'.print_r($arResult['DISPLAY_PROPERTIES'], true).'</pre>';
$delivery_file = $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/files/delivery.php';

$delivery_file_ex = false;
if(file_exists($delivery_file))
	$delivery_file_ex = true;

$BUY_WITH = $arResult['PROPERTIES']['BUY_WITH']['VALUE'];

global $arWithBuyFilter;
$arWithBuyFilter = array(
	'IBLOCK_ID' => $arParams["IBLOCK_ID"],
	'ID' => $BUY_WITH,
	);

#_print_r($arWithBuyFilter);
?><? $APPLICATION->AddHeadString('<link href="https://www.'.SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL'].'" rel="canonical" />',true); ?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/status_bayers.php'; ?>

<? if ($status_bayer != 'Юридическое лицо') { ?>

<!-- tabs block -->
	<div class="catalog-tab">
		<ul class="tab-control">
			<li class="active"><a href="#">Характеристики</a></li>
			<?if($delivery_file_ex):?>
			<li><a href="#">Оплата и доставка</a></li>
			<?endif;?>
			
		</ul>

		<div class="tabs">

            <!-- tab 1 -->
			<div class="tab">

				<?if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']):?>

					<h3>Общая информация</h3>

					<div class="prop-block" id="tovar-prop-block">
						<?foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp):?>
							<dl class="prop">
								<dt class="item"><? echo $arOneProp['NAME']; ?></dt>
								<dd class="item">
									<? echo (
									is_array($arOneProp['DISPLAY_VALUE'])
										? implode(' / ', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
									); ?>
								</dd>
							</dl>
						<?endforeach;?>
					</div>

					<script>
						var max_w = 0;
						$(function(){
							$('#tovar-prop-block dt').each(function(i, el){
								var w = $(el).width() - 0;
								if(w > max_w || max_w == 0)
									max_w = w;
							});
							max_w += 20;
							$('#tovar-prop-block dd').css('marginLeft', max_w + 'px');

						});
					</script>

				<?endif;?>

			</div>


			<?if($delivery_file_ex):?>
            <!-- tab 2 -->
			<div class="tab">
				<?include($delivery_file);?>
			</div>
			<?endif;?>

            <!-- tab 3 -->
			<div class="tab">

				<?/* $APPLICATION->IncludeComponent("bitrix:forum.topic.reviews", "reviews", array(
	"COMPONENT_TEMPLATE" => "reviews",
		"FORUM_ID" => "1",
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"URL_TEMPLATES_READ" => "",
		"URL_TEMPLATES_DETAIL" => "",
		"URL_TEMPLATES_PROFILE_VIEW" => "",
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"MESSAGES_PER_PAGE" => "10",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"NAME_TEMPLATE" => "",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"EDITOR_CODE_DEFAULT" => "N",
		"SHOW_AVATAR" => "Y",
		"SHOW_RATING" => "",
		"RATING_TYPE" => "",
		"SHOW_MINIMIZED" => "N",
		"USE_CAPTCHA" => "Y",
		"PREORDER" => "Y",
		"SHOW_LINK_TO_FORUM" => "N",
		"FILES_COUNT" => "2",
		"AJAX_POST" => "Y"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); */  ?>
			</div>
		</div>
	</div>
    <!-- /tabs block -->

	<script>
		$(function(){
			$('.catalog-tab .tab-control li').click(function(){
				var tab_control = $('.catalog-tab .tab-control li'),
					index = $(tab_control).index(this),
					tab = $('.catalog-tab .tabs .tab').eq(index);

				$(tab_control).removeClass('active');
				$(this).addClass('active');

				$('.catalog-tab .tabs .tab').hide();
				$(tab).show();
				return false;
			});
			$('.catalog-tab .tab-control li:first').click();
		});
	</script>


	<div class="columns cataolog-product-more">
		<div class="col main_left product-more">

            <!-- recomendation -->
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"recomendation",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => 'RAND', #$arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => 'ASC', #$arParams["ELEMENT_SORT_ORDER"],
					//"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					//"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
					"INCLUDE_SUBSECTIONS" => 1 ,// 'Y' $arParams["INCLUDE_SUBSECTIONS"],
					"SHOW_ALL_WO_SECTION" => 'Y',
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					//"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					//"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					//"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					//"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],

					"FILTER_NAME" => 'arWithBuyFilter',

					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => 'Y',
					"CACHE_GROUPS" => 'N',

					"SET_TITLE" => 'N',
					"SET_STATUS_404" => 'N',
					"DISPLAY_COMPARE" => 'N',
					"PAGE_ELEMENT_COUNT" => 4,
					"LINE_ELEMENT_COUNT" => 4,

					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

					"DISPLAY_TOP_PAGER" => 'N',
					"DISPLAY_BOTTOM_PAGER" => 'N',

					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

					"SECTION_ID" => 0, //$arResult["VARIABLES"]["SECTION_ID"],
					#"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
					#"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => 'Y',

					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					#'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],

					"ADD_SECTIONS_CHAIN" => "N",
					//'ADD_TO_BASKET_ACTION' => $basketAction,
					'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>

            <!-- /recomendation -->

		</div>
		<div class="col main_right bg">

            <!-- viewed.product -->
			<?$APPLICATION->IncludeComponent("bitrix:sale.viewed.product", "slide_vertical", Array(

				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_ELEMENT_ID" => "",
				"SECTION_ELEMENT_CODE" => "",

				"SHOW_FROM_SECTION" => "N",
				"SHOW_DISCOUNT_PERCENT" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PRODUCT_SUBSCRIPTION" => "N",

				"SHOW_NAME" => "Y",
				"SHOW_IMAGE" => "Y",

				"PAGE_ELEMENT_COUNT" => 3,
				"LINE_ELEMENT_COUNT" => 3,

				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],

				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

				"SHOW_OLD_PRICE" => "N",
				"PRICE_CODE" => $arParams["PRICE_CODE"],

				"SHOW_PRICE_COUNT" => "1",
				//"PRICE_VAT_INCLUDE" => $arParams["PRICE_CODE"],
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"BASKET_URL" => $arParams["BASKET_URL"],	// URL, ведущий на страницу с корзиной покупателя

				"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
				"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"SHOW_PRODUCTS_9" => "Y",
				"PROPERTY_CODE_9" => array(
					0 => "CML2_ARTICLE",
					1 => "",
				),
				"CART_PROPERTIES_9" => array(
					0 => "NOVELTY",
					1 => "PROP_LIST",
					2 => "SPECIAL_OFFER",
					3 => "DAY_PRODUCT",
					4 => "",
					),
				"ADDITIONAL_PICT_PROP_9" => "",
				"LABEL_PROP_9" => "",



				"PRODUCT_QUANTITY_VARIABLE" => "quantity",

				"VIEWED_COUNT" => "20",	// Количество элементов
				"VIEWED_CURRENCY" => "RUB",	// Валюта
				"SET_TITLE" => "N",	// Устанавливать заголовок страницы
			),
				$component
			);?>
            <!-- /viewed.product -->

		</div>
	</div>
    <!-- /recomendation -->

<? } elseif ($arResult['PROPERTIES']['HIDE_OPT']['VALUE'] != 1) { ?>
    <!-- tabs block -->
	<div class="catalog-tab">
		<ul class="tab-control">
			<li class="active"><a href="#">Характеристики</a></li>
			<?if($delivery_file_ex):?>
			<li><a href="#">Оплата и доставка</a></li>
			<?endif;?>
			
		</ul>

		<div class="tabs">

            <!-- tab 1 -->
			<div class="tab">

				<?if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']):?>

					<h3>Общая информация</h3>

					<div class="prop-block" id="tovar-prop-block">
						<?foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp):?>
							<dl class="prop">
								<dt class="item"><? echo $arOneProp['NAME']; ?></dt>
								<dd class="item">
									<? echo (
									is_array($arOneProp['DISPLAY_VALUE'])
										? implode(' / ', $arOneProp['DISPLAY_VALUE'])
										: $arOneProp['DISPLAY_VALUE']
									); ?>
								</dd>
							</dl>
						<?endforeach;?>
					</div>

					<script>
						var max_w = 0;
						$(function(){
							$('#tovar-prop-block dt').each(function(i, el){
								var w = $(el).width() - 0;
								if(w > max_w || max_w == 0)
									max_w = w;
							});
							max_w += 20;
							$('#tovar-prop-block dd').css('marginLeft', max_w + 'px');

						});
					</script>

				<?endif;?>

			</div>


			<?if($delivery_file_ex):?>
            <!-- tab 2 -->
			<div class="tab">
				<?include($delivery_file);?>
			</div>
			<?endif;?>

            <!-- tab 3 -->
			<div class="tab">

				<?/* $APPLICATION->IncludeComponent("bitrix:forum.topic.reviews", "reviews", array(
	"COMPONENT_TEMPLATE" => "reviews",
		"FORUM_ID" => "1",
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"URL_TEMPLATES_READ" => "",
		"URL_TEMPLATES_DETAIL" => "",
		"URL_TEMPLATES_PROFILE_VIEW" => "",
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"MESSAGES_PER_PAGE" => "10",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"NAME_TEMPLATE" => "",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"EDITOR_CODE_DEFAULT" => "N",
		"SHOW_AVATAR" => "Y",
		"SHOW_RATING" => "",
		"RATING_TYPE" => "",
		"SHOW_MINIMIZED" => "N",
		"USE_CAPTCHA" => "Y",
		"PREORDER" => "Y",
		"SHOW_LINK_TO_FORUM" => "N",
		"FILES_COUNT" => "2",
		"AJAX_POST" => "Y"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); */  ?>
			</div>
		</div>
	</div>
    <!-- /tabs block -->

	<script>
		$(function(){
			$('.catalog-tab .tab-control li').click(function(){
				var tab_control = $('.catalog-tab .tab-control li'),
					index = $(tab_control).index(this),
					tab = $('.catalog-tab .tabs .tab').eq(index);

				$(tab_control).removeClass('active');
				$(this).addClass('active');

				$('.catalog-tab .tabs .tab').hide();
				$(tab).show();
				return false;
			});
			$('.catalog-tab .tab-control li:first').click();
		});
	</script>


	<div class="columns cataolog-product-more">
		<div class="col main_left product-more">

            <!-- recomendation -->
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"recomendation",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => 'RAND', #$arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => 'ASC', #$arParams["ELEMENT_SORT_ORDER"],
					//"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					//"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
					"INCLUDE_SUBSECTIONS" => 1 ,// 'Y' $arParams["INCLUDE_SUBSECTIONS"],
					"SHOW_ALL_WO_SECTION" => 'Y',
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					//"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					//"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					//"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					//"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],

					"FILTER_NAME" => 'arWithBuyFilter',

					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => 'Y',
					"CACHE_GROUPS" => 'N',

					"SET_TITLE" => 'N',
					"SET_STATUS_404" => 'N',
					"DISPLAY_COMPARE" => 'N',
					"PAGE_ELEMENT_COUNT" => 4,
					"LINE_ELEMENT_COUNT" => 4,

					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

					"DISPLAY_TOP_PAGER" => 'N',
					"DISPLAY_BOTTOM_PAGER" => 'N',

					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

					"SECTION_ID" => 0, //$arResult["VARIABLES"]["SECTION_ID"],
					#"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
					#"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => 'Y',

					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					#'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],

					"ADD_SECTIONS_CHAIN" => "N",
					//'ADD_TO_BASKET_ACTION' => $basketAction,
					'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>

            <!-- /recomendation -->

		</div>
		<div class="col main_right bg">

            <!-- viewed.product -->
			<?$APPLICATION->IncludeComponent("bitrix:sale.viewed.product", "slide_vertical", Array(

				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_ELEMENT_ID" => "",
				"SECTION_ELEMENT_CODE" => "",

				"SHOW_FROM_SECTION" => "N",
				"SHOW_DISCOUNT_PERCENT" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PRODUCT_SUBSCRIPTION" => "N",

				"SHOW_NAME" => "Y",
				"SHOW_IMAGE" => "Y",

				"PAGE_ELEMENT_COUNT" => 3,
				"LINE_ELEMENT_COUNT" => 3,

				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],

				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

				"SHOW_OLD_PRICE" => "N",
				"PRICE_CODE" => $arParams["PRICE_CODE"],

				"SHOW_PRICE_COUNT" => "1",
				//"PRICE_VAT_INCLUDE" => $arParams["PRICE_CODE"],
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"BASKET_URL" => $arParams["BASKET_URL"],	// URL, ведущий на страницу с корзиной покупателя

				"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
				"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"SHOW_PRODUCTS_9" => "Y",
				"PROPERTY_CODE_9" => array(
					0 => "CML2_ARTICLE",
					1 => "",
				),
				"CART_PROPERTIES_9" => array(
					0 => "NOVELTY",
					1 => "PROP_LIST",
					2 => "SPECIAL_OFFER",
					3 => "DAY_PRODUCT",
					4 => "",
					),
				"ADDITIONAL_PICT_PROP_9" => "",
				"LABEL_PROP_9" => "",



				"PRODUCT_QUANTITY_VARIABLE" => "quantity",

				"VIEWED_COUNT" => "20",	// Количество элементов
				"VIEWED_CURRENCY" => "RUB",	// Валюта
				"SET_TITLE" => "N",	// Устанавливать заголовок страницы
			),
				$component
			);?>
            <!-- /viewed.product -->

		</div>
	</div>
    <!-- /recomendation -->
<? } ?>