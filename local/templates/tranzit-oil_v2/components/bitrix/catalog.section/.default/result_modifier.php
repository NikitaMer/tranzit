<?

$arSection = CIblockSection::GetById($arResult["ID"])->GetNext();
$arResult['SECTION_PAGE_URL'] = $arSection['SECTION_PAGE_URL'];
$cp = $this->__component; 
if (is_object($cp))
$cp->SetResultCacheKeys(array('SECTION_PAGE_URL'));

use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

if (!empty($arResult['ITEMS']))
{
	$boolSKU = false;

	if ($arResult['MODULES']['catalog'])
	{
		if (!$boolConvert)
			$strBaseCurrency = CCurrency::GetBaseCurrency();

		$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
		$boolSKU = !empty($arSKU) && is_array($arSKU);
		if ($boolSKU && !empty($arParams['OFFER_TREE_PROPS']) && 'Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			$arSKUPropList = CIBlockPriceTools::getTreeProperties(
				$arSKU,
				$arParams['OFFER_TREE_PROPS'],
				array(
					'PICT' => $arEmptyPreview,
					'NAME' => '-'
				)
			);

			$arNeedValues = array();
			CIBlockPriceTools::getTreePropertyValues($arSKUPropList, $arNeedValues);
			$arSKUPropIDs = array_keys($arSKUPropList);
			if (empty($arSKUPropIDs))
				$arParams['PRODUCT_DISPLAY_MODE'] = 'N';
			else
				$arSKUPropKeys = array_fill_keys($arSKUPropIDs, false);
		}
	}

	$arNewItemsList = array();
	
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		
		$arItem['CHECK_QUANTITY'] = false;
		
		if (!isset($arItem['CATALOG_MEASURE_RATIO']))
			$arItem['CATALOG_MEASURE_RATIO'] = 1;
			
		if (!isset($arItem['CATALOG_QUANTITY']))
			$arItem['CATALOG_QUANTITY'] = 0;
			
		$arItem['CATALOG_QUANTITY'] = (
			0 < $arItem['CATALOG_QUANTITY'] && is_float($arItem['CATALOG_MEASURE_RATIO'])
			? floatval($arItem['CATALOG_QUANTITY'])
			: intval($arItem['CATALOG_QUANTITY'])
		);
		
		$arItem['CATALOG'] = false;

		if ($arResult['MODULES']['catalog'])
		{
			$arItem['CATALOG'] = true;
			
			if (!isset($arItem['CATALOG_TYPE']))
				$arItem['CATALOG_TYPE'] = CCatalogProduct::TYPE_PRODUCT;

			if (
				(CCatalogProduct::TYPE_PRODUCT == $arItem['CATALOG_TYPE'] || CCatalogProduct::TYPE_SKU == $arItem['CATALOG_TYPE'])
				&& !empty($arItem['OFFERS'])
			)
			{
				$arItem['CATALOG_TYPE'] = CCatalogProduct::TYPE_SKU;
			}
			
			switch ($arItem['CATALOG_TYPE'])
			{
				case CCatalogProduct::TYPE_SET:
					$arItem['OFFERS'] = array();
					$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
					break;
				case CCatalogProduct::TYPE_SKU:
					break;
				case CCatalogProduct::TYPE_PRODUCT:
				default:
					$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
					break;
			}
		}
		else
		{
			$arItem['CATALOG_TYPE'] = 0;
			$arItem['OFFERS'] = array();
		}


		if (!empty($arItem['DISPLAY_PROPERTIES']))
		{
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp)
			{
				if ('F' == $arDispProp['PROPERTY_TYPE'])
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
			}
		}
		
		$arNewItemsList[$key] = $arItem;
	}
	$arResult['ITEMS'] = $arNewItemsList;
}
?>