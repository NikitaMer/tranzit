<?
use Bitrix\Main\Type\Collection;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

if(!\Bitrix\Main\Loader::includeModule('catalog'))
	return;

if(!is_array($arParams["PRICE_CODE"]))
	$arParams["PRICE_CODE"] = array();

$arResult["CAT_PRICES"] = CIBlockPriceTools::GetCatalogPrices(CATALOG_IBLOCK_ID, $arParams["PRICE_CODE"]);


#======================================================
# ADDITIONAL_PRODUCTS
#======================================================
if($arResult["ITEMS"]["AnDelCanBuy"])
{
	$aID = array();
	$aAddProdID = array();
	$ELEMENTS = array();

	foreach($arResult["ITEMS"]["AnDelCanBuy"] as $item)
	{
		if(!in_array($item['PRODUCT_ID'], $aID))
			$aID[] = $item['PRODUCT_ID'];
	}

	#echo '<pre>'.print_r($aID, true).'</pre>';
	#echo '<pre>'.print_r($arResult["ITEMS"]["AnDelCanBuy"], true).'</pre>';

	if(!empty($aID))
	{

		$arSelect = array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_ADDITIONAL_PRODUCTS');

		$arFilter = array(
			'!ID' => $aID,
			'IBLOCK_ID' => CATALOG_IBLOCK_ID,
			'ACTIVE' => 'Y',
			'ACTIVE_DATE' => 'Y',
			'CATALOG_AVAILABLE' => 'Y',
			'>CATALOG_QUANTITY' => 0,
			'!PROPERTY_ADDITIONAL_PRODUCTS' => false,
			);


		$rsElements = CIBlockElement::GetList(array('RAND' => 'ASC'), $arFilter, false, array("nPageSize"=>2), $arSelect);
		while($arElement = $rsElements->GetNext(false, false))
		{
			$arPrice = CCatalogProduct::GetOptimalPrice($arElement['ID'], 1, $GLOBALS['USER']->GetUserGroupArray());

			if(is_array($arPrice))
				$arElement = array_merge($arElement, $arPrice);

			$picture = $arElement['DETAIL_PICTURE'];

			if(!$picture)
				$picture = $arElement['PREVIEW_PICTURE'];

			$arElement['PICTURE'] = CFile::ResizeImageGet($picture, array('width'=>138, 'height'=>138), BX_RESIZE_IMAGE_PROPORTIONAL, true);

			$arElement['CAN_BUY'] = CIBlockPriceTools::CanBuy($arElement['IBLOCK_ID'], $arResult["CAT_PRICES"], $arElement);

			$ELEMENTS[$arElement['ID']] = $arElement;
		}



	}


	#echo '<pre>'.print_r($ELEMENTS, true).'</pre>';

	$arResult["ADDITIONAL_PRODUCTS"] = $ELEMENTS;
	unset($ELEMENTS);
}