<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

#_print_r($arParams["PRICE_CODE"]);

if(!is_array($arParams["PRICE_CODE"]))
    $arParams["PRICE_CODE"] = array();

if(empty($arParams["PRICE_CODE"]))
{
    ShowMessage('Не задан тип цены в поиске');
    return false;
}


if(\Bitrix\Main\Loader::includeModule('iblock') && \Bitrix\Main\Loader::includeModule('catalog'))
{
    $arResult["CAT_PRICES"] = \CIBlockPriceTools::GetCatalogPrices(CATALOG_IBLOCK_ID, $arParams["PRICE_CODE"]);
    $arResult["PRICES"] = \CIBlockPriceTools::GetCatalogPrices(CATALOG_IBLOCK_ID, $arParams["PRICE_CODE"]);
    $arResult['PRICES_ALLOW'] = \CIBlockPriceTools::GetAllowCatalogPrices($arResult["PRICES"]);


    foreach($arResult["ITEMS"] as $index => $arItem)
    {

        $tmp = $arItem;
        $tmp['ID'] = $tmp['ELEMENT_ID'];

        foreach($arResult["CAT_PRICES"] as $price)
        {
            $aPrice = CCatalogProduct::GetOptimalPrice($arItem['ELEMENT_ID'], 1, $GLOBALS['USER']->GetUserGroupArray(), 'N');
            $arItem['CATALOG_PRICE_'.$price['ID']] = $aPrice['PRICE']['PRICE'];
            $arItem['CATALOG_CURRENCY_'.$price['ID']] = $aPrice['PRICE']['CURRENCY'];
        }


        $arItem["PRICES"] = CIBlockPriceTools::GetItemPrices($arItem['IBLOCK_ID'], $arResult["PRICES"], $arItem, false, $arConvertParams);


        /*if($arItem['ID'] == 61)
        {
            echo 'dd:';
            _print_r($arItem);
        }*/

        if (!empty($arItem["PRICES"]))
        {
            foreach ($arItem['PRICES'] as &$arOnePrice)
            {
                #if(!$arOnePrice['CAN_BUY'])
                #    $arItem['CAN_BUY'] = false;

                if ('Y' == $arOnePrice['MIN_PRICE'])
                {
                    $arItem['MIN_PRICE'] = $arOnePrice;
                    break;
                }
            }
            unset($arOnePrice);
        }


        $arItem['CAN_BUY'] = \CIBlockPriceTools::CanBuy($arItem['IBLOCK_ID'], $arResult["CAT_PRICES"], $arItem);

        $arItem['BUY_URL'] = $arItem['DETAIL_URL'].'?action=BUY&id='.$arItem['ELEMENT_ID'];
        $arItem['ADD_URL'] = $arItem['DETAIL_URL'].'?action=ADD2BASKET&id='.$arItem['ELEMENT_ID'];

        $arResult["ITEMS"][$index] = $arItem;
    }
}