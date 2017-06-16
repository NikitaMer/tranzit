<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

$this->setFrameMode(true);

$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
?>
<div class="columns">
	<div class="col main_left">

		<span class="section_title">Фильтр</span>

        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "left_menu",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "COUNT_ELEMENTS" => 'Y', //$arParams["SECTION_COUNT_ELEMENTS"],
                "TOP_DEPTH" => 1, //$arParams["SECTION_TOP_DEPTH"],
                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                "SHOW_PARENT_NAME" => 'N', //$arParams["SECTIONS_SHOW_PARENT_NAME"],
                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                "ADD_SECTIONS_CHAIN" => 'Y',  //(isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        );?>

		<?
		if ($arParams['USE_FILTER'] == 'Y')
		{
			$arFilter = array(
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ACTIVE" => "Y",
				"GLOBAL_ACTIVE" => "Y",
			);
			if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
			{
				$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
			}
			elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
			{
				$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
			}

			$obCache = new CPHPCache();
			if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
			{
				$arCurSection = $obCache->GetVars();
			}
			elseif ($obCache->StartDataCache())
			{
				$arCurSection = array();
				if (Loader::includeModule("iblock"))
				{
					$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

					if(defined("BX_COMP_MANAGED_CACHE"))
					{
						global $CACHE_MANAGER;
						$CACHE_MANAGER->StartTagCache("/iblock/catalog");

						if ($arCurSection = $dbRes->Fetch())
						{
							$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
						}
						$CACHE_MANAGER->EndTagCache();
					}
					else
					{
						if(!$arCurSection = $dbRes->Fetch())
							$arCurSection = array();
					}
				}
				$obCache->EndDataCache($arCurSection);
			}
			if (!isset($arCurSection))
			{
				$arCurSection = array();
			}
			if ($verticalGrid)
			{
				?><div class="bx_sidebar"><?
			}
			?>
			<!-- arParams <pre><?print_r($arCurSection['ID']);?></pre> -->

            <?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arCurSection['ID'],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => 'N', //$arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"XML_EXPORT" => "N",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					//"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);?>
			
			<?
		}
		?>






<?
                             include($_SERVER["DOCUMENT_ROOT"].'/local/templates/tranzit-oil_v2/banner/shop_left.php');
                            ?>




	</div>
	<div class="col main_right">

        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array(
            "START_FROM" => "",
            "PATH" => "",
            "SITE_ID" => SITE_ID,
            ),
            false
            );?>

		<h1><?$APPLICATION->ShowTitle(false)?></h1>

		<? if (1==1) { $APPLICATION->IncludeComponent("conf:form_wide"); } ?>

		<?/*$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => 'N', //$arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => 1, //$arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"SHOW_PARENT_NAME" => 'N', //$arParams["SECTIONS_SHOW_PARENT_NAME"],
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);*/?>

		<?
		#=================================================================
		# sort
		#=================================================================
		$arAvailableSort = array(
            "sort" => Array('SHOW_COUNTER', "desc"),
			"price_asc" => Array('CATALOG_PRICE_2', "asc"),
			//"sort" => Array('SORT', "asc"),
			//"popularity" => Array('SHOW_COUNTER', "desc"),
			#"price_desc" => Array('CATALOG_PRICE_1', "desc"),
			#"sklad" => Array('CATALOG_QUANTITY', "desc"),
			#"novely" => Array('PROPERTY_SPEC_N', "asc"),
			);

		$sort_key = isset($_GET["sort"]) && array_key_exists(ToLower($_GET["sort"]), $arAvailableSort) ? trim(htmlspecialchars($_GET["sort"])) : "";

		if($sort_key == '')
		{
			$SORT_KEY = $GLOBALS['APPLICATION']->get_cookie("CATALOG_SORT_KEY");
			$sort_key = $SORT_KEY && array_key_exists($SORT_KEY, $arAvailableSort) ? htmlspecialchars($SORT_KEY) : 'sort';
		}

		$GLOBALS['APPLICATION']->set_cookie("CATALOG_SORT_KEY", htmlspecialchars($sort_key), time()+60*60*24*30, "/");

		$sort = $arAvailableSort[$sort_key][0];
		$sort_order = $arAvailableSort[$sort_key][1];

		#=================================================================
		# pagination
		#=================================================================
		$arPagination = array(10,20,30);

		$arParams['PAGE_ELEMENT_COUNT'] = isset($_GET["pcount"]) && in_array((int)$_GET["pcount"], $arPagination) ? (int)$_GET["pcount"] : 0;

		if(!in_array($arParams['PAGE_ELEMENT_COUNT'], $arPagination))
		{
			$PCOUNT = (int)$GLOBALS['APPLICATION']->get_cookie("CATALOG_PAGE_COUNT");
			$arParams['PAGE_ELEMENT_COUNT'] = $PCOUNT > 0 && in_array($PCOUNT, $arPagination) ? $PCOUNT : 20;
		}

		$GLOBALS['APPLICATION']->set_cookie("CATALOG_PAGE_COUNT", (int)$arParams['PAGE_ELEMENT_COUNT'], time()+60*60*24*30, "/");
		?>
			
		<div class="catalog-opt-line" style="display: none;">

			<div class="sort-opt">
				<span>Сортировать по:</span>
				<div class="opt-group">
					<?foreach ($arAvailableSort as $key => $val):
						$selected = ($sort_key == $key) ? ' active' : '';
						$current_page = $APPLICATION->GetCurPageParam("sort=".$key, array("sort"));
						?>
					<?if (Loc::getMessage('SECT_SORT_'.$key)!='') { ?>	<a class="opt<?=$selected?>" href="<?=$current_page?>"><?=Loc::getMessage('SECT_SORT_'.$key)?></a>  <? } ?>
					<?endforeach;?>
				</div>
			</div>

			<div class="pagination-opt">
				<span>Показывать товаров:</span>
				<div class="opt-group">
					<?foreach($arPagination as $pag):
					$selected = ($pag == $arParams['PAGE_ELEMENT_COUNT']) ? ' active' : '';
					$current_page = $APPLICATION->GetCurPageParam("pcount=".$pag, array("pcount"));
					?>
					<a class="opt<?=$selected?>" href="<?=$current_page?>"><?=$pag?></a>
					<?endforeach;?>
				</div>
			</div>

		</div>
	
		<?$intSectionID = $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ELEMENT_SORT_FIELD" => $sort, //$arParams["ELEMENT_SORT_FIELD"],
				"ELEMENT_SORT_ORDER" => $sort_order, //$arParams["ELEMENT_SORT_ORDER"],

				"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
				"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],

				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
				"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
				"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
				"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
				"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
				"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

				"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
				"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
				"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

				'LABEL_PROP' => $arParams['LABEL_PROP'],
				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],

				"ADD_SECTIONS_CHAIN" => "N",
				'ADD_TO_BASKET_ACTION' => $basketAction,
				'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
			),
			$component
		);?>

	</div>
</div>