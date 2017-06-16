<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult['NAPITKI'] = array();
$arResult['NAPITKI_BASKET'] = array();

if(!is_array($arParams["PRICE_CODE"]))
    $arParams["PRICE_CODE"] = array();

if(empty($arParams["PRICE_CODE"]))
{
    ShowMessage('Не задан тип цены в поиске');
}


if(
    \Bitrix\Main\Loader::includeModule('iblock') &&
    \Bitrix\Main\Loader::includeModule('catalog') &&
    !empty($arResult["SEARCH"])
)
{

    $arResult["CAT_PRICES"] = CIBlockPriceTools::GetCatalogPrices(CATALOG_IBLOCK_ID, $arParams["PRICE_CODE"]);

    $aID = array();
    $ELEMENTS = array();

    foreach($arResult["SEARCH"] as $index => $elem)
    {
        if(substr($elem['ITEM_ID'], 0,1) == 'S')
        {
            unset($arResult["SEARCH"][$index]);
            continue;
        }

        $aID[] = $elem['ITEM_ID'];
    }

    if(!empty($aID))
    {
        $arSelect = array(
            'ID', 'NAME', 'IBLOCK_ID',
            'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'PREVIEW_PICTURE',
            'DETAIL_PICTURE', 'PROPERTY_VALUE', 'DETAIL_PAGE_URL',
            'CATALOG_AVAILABLE',
            //'CATALOG_QUANTITY'
            );

        $arFilter = array(
            'IBLOCK_ID' => $arParams['PARAM2'],
            'ID' => $aID,
            #'ACTIVE' => 'Y',
            #'ACTIVE_DATE' => 'Y',
            );

        foreach($arResult["CAT_PRICES"] as $code => $price)
        {
            $arSelect[] = 'CATALOG_GROUP_'.$price['ID'];
        }




        $rsElements = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
        while($obElement = $rsElements->GetNextElement(false, false))
        {
            $arElement = $obElement->GetFields(false, false);
            $arElement['PROP'] = $obElement->GetProperties();

            $arPrice = CCatalogProduct::GetOptimalPrice($arElement['ID'], 1, $GLOBALS['USER']->GetUserGroupArray());
            $arElement = array_merge($arElement, $arPrice);

            $picture = $arElement['DETAIL_PICTURE'];

            if(!$picture)
                $picture = $arElement['PREVIEW_PICTURE'];

            $arElement['PICTURE'] = CFile::ResizeImageGet($picture, array('width'=>103, 'height'=>103), BX_RESIZE_IMAGE_PROPORTIONAL, true);

            $arElement['CAN_BUY'] = CIBlockPriceTools::CanBuy($arElement['IBLOCK_ID'], $arResult["CAT_PRICES"], $arElement);

            $ELEMENTS[$arElement['ID']] = $arElement;

        }

    }

    foreach($arResult["SEARCH"] as $index => $elem)
    {
        $arResult["SEARCH"][$index]['PRODUCT'] = $ELEMENTS[$elem['ITEM_ID']];
    }

    unset($ELEMENTS);

}

$amount = count($arResult["SEARCH"]);

$c = $amount > 20 ? $amount - floor($amount / 10) * 10 : $amount;

$arResult["SEARCH_TEXT"] = '';

if($c == 1)
    $arResult["SEARCH_TEXT"] =  'Был найден';
elseif($c > 1 && $c < 5)
    $arResult["SEARCH_TEXT"] =  'Были найдены';
elseif($c > 5)
    $arResult["SEARCH_TEXT"] =  'Были найдены';



