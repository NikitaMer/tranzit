<?
use Bitrix\Main\Type\Collection;

$arElement = CIblockElement::GetById($arResult["ID"])->GetNext();
$arResult['DETAIL_PAGE_URL'] = $arElement['DETAIL_PAGE_URL'];
$cp = $this->__component;
if (is_object($cp))
$cp->SetResultCacheKeys(array('DETAIL_PAGE_URL'));


if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$arResult['BONUS_AMOUNT'] = 0;




$arResult['SIMILAR_ID'] = array();

$arResult['CATALOG_QUANTITY'] = (
    0 < $arResult['CATALOG_QUANTITY'] && is_float($arResult['CATALOG_MEASURE_RATIO'])
    ? (float)$arResult['CATALOG_QUANTITY']
    : (int)$arResult['CATALOG_QUANTITY']
    );

$arResult['CATALOG'] = false;

CIBlockPriceTools::getLabel($arResult, $arParams['LABEL_PROP']);

function cmpCount($a, $b)
{
    if ($a['COUNT'] == $b['COUNT']) {
        return 0;
    }
    return ($a['COUNT'] > $b['COUNT']) ? -1 : 1;
}

if (!empty($arResult['DISPLAY_PROPERTIES']))
{
    foreach ($arResult['DISPLAY_PROPERTIES'] as $propKey => $arDispProp)
    {
        if ('F' == $arDispProp['PROPERTY_TYPE'])
            unset($arResult['DISPLAY_PROPERTIES'][$propKey]);
    }
}

#========================================================================
# PRODUCT_OFFER - получение связанных товаров
#========================================================================
$arProductOffer = array(
    'ID' => $arResult['PROPERTIES']['PRODUCT_OFFER']['VALUE'],
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    );

$res = CIBlockElement::GetList(Array('NAME' => 'ASC'), $arProductOffer, false, Array("nPageSize"=>20), $arSelect);
while($ob = $res->GetNextElement(false, false))
{
    $arOfferFields = $ob->GetFields();
    //$arFields['PROP'] = $ob->GetProperties();

    #echo '<pre>'.print_r($arFields, true).'</pre>';
    $arResult['PRODUCT_OFFER'][] = $arOfferFields;
}

#
//$arResult['SIMILAR_PRODUCTS'] = $arResult['PROPERTIES']['SIMILAR_PRODUCTS']['VALUE'];
//unset($arResult['PROPERTIES']['SIMILAR_PRODUCTS']['VALUE']);

$arResult['MORE_PHOTO'] = $arResult['PROPERTIES']['MORE_PHOTO']['VALUE'];

if(!is_array($arResult['MORE_PHOTO']))
    $arResult['MORE_PHOTO'] = array();

unset($arResult['PROPERTIES']['MORE_PHOTO']);

$main_picture = $arResult['DETAIL_PICTURE']['ID'];

if(!$main_picture && $arResult['PREVIEW_PICTURE'])
    $main_picture = $arResult['PREVIEW_PICTURE']['ID'];

if($main_picture)
    $arResult['MORE_PHOTO'] = array_merge(array($main_picture), $arResult['MORE_PHOTO']);


$first = true;
$tmp = array();

if(!is_array($arResult['MORE_PHOTO']))
    $arResult['MORE_PHOTO']= array();

foreach($arResult['MORE_PHOTO'] as $pid)
{
    if($first)
        $sm = CFile::ResizeImageGet($pid, array('width'=>335, 'height'=>335), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    else
        $sm = CFile::ResizeImageGet($pid, array('width'=>69, 'height'=>69), BX_RESIZE_IMAGE_PROPORTIONAL, true);

    $tmp[] = array(
        'thumb_s' => $sm,
        'thumb_b' => CFile::ResizeImageGet($pid, array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, true),
        );

    $first = false;
}

$arResult['MORE_PHOTO']= $tmp;
unset($tmp);

#print_r($arResult['MORE_PICTURES']);



#=======================================================
#выборка похожих товаров
#=======================================================
/*
$arResult['SIMILAR'] = array();

$arSelect = Array(
    "ID",
    "IBLOCK_ID",
    "NAME",
    "DETAIL_PAGE_URL",
    "PROPERTY_*"
    );

$arFilter = Array(
    "IBLOCK_ID"      => $arParams['IBLOCK_ID'],
    "ACTIVE_DATE" => "Y",
    "ACTIVE"      => "Y",
    "IBLOCK_SECTION_ID" => $arResult["IBLOCK_SECTION_ID"]
    );

$res = CIBlockElement::GetList(Array('NAME' => 'ASC'), $arFilter, false, Array("nPageSize"=>10), $arSelect);
while($ob = $res->GetNextElement(true, false))
{
    $arFields = $ob->GetFields();
    $arFields['PROP'] = $ob->GetProperties();

    #echo '<pre>'.print_r($arFields, true).'</pre>';
    $arResult['SIMILAR'][] = $arFields;
}

UF_SEARCH_SIMILAR
*/

#========================================================================
# Поиск похожих товаров
#========================================================================

$arSections = array();
if(\Bitrix\Main\Loader::includeModule('iblock'))
{
    $start = false;
    $f_section = -1;

    # получаем структуру каталога
    $arFilter = array(
        'ACTIVE' => 'Y',
        'GLOBAL_ACTIVE' => 'Y',
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        );

    $rs = CIBlockSection::GetList(Array("left_margin"=>"desc"), $arFilter, false, array('ID', 'IBLOCK_ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'UF_SEARCH_SIMILAR'));

    #поиск рраздела для сравнения
    while($s = $rs->GetNext(false, false))
    {
        if($s['ID'] == $arResult['IBLOCK_SECTION_ID'])
            $start = true;

        if($start && $s['UF_SEARCH_SIMILAR'])
            $f_section = $s['ID'];

        if($start && ($f_section || $s['DEPTH_LEVEL'] == 0))
            break;
    }

    if($f_section == -1)
        $f_section = $arResult['IBLOCK_SECTION_ID'];

    #выборка элементов из сравниваемого раздела
    $arCompare = array();

    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = Array(
        "!ID" => $arResult['ID'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "INCLUDE_SUBSECTIONS" => "Y",
        "IBLOCK_SECTION_ID" => $f_section
        );

    $arUsedProp = array();

    if(!empty($arResult['PROPERTIES']) && is_array($arResult['PROPERTIES']))
    {
        $aPropFilter = array('LOGIC' => 'OR');

        foreach($arResult['PROPERTIES'] as $code => $d)
        {
            if($code == 'DONACENKI' || $code == 'PRODUCT_OFFER' || $code == 'BUY_WITH' || $d['PROPERTY_TYPE'] == 'E')
                continue;

            #if($code == 'BRAND')
            #    echo '<!-- prop: <pre>'.print_r($d, true).' -->';

            if($d['PROPERTY_TYPE'] == 'L' && $d['VALUE_ENUM_ID'])
            {
                $aPropFilter['PROPERTY_'.$code] = $d['VALUE_ENUM_ID']; //PROPERTY_VALUE_ID
                $arUsedProp['PROPERTY_'.$code.'_ENUM_ID'] = $aPropFilter['PROPERTY_'.$code];
            }
            elseif($d['VALUE'])
            {
                $aPropFilter['PROPERTY_'.$code] = $d['VALUE'];
                $arUsedProp['PROPERTY_'.$code] = $aPropFilter['PROPERTY_'.$code];
            }

            if($d['VALUE'])
                $arSelect[] = 'PROPERTY_'.$code;
        }

        $arFilter[] = $aPropFilter;
    }

    #echo '<!-- filter: <pre>'.print_r($arFilter, true).' -->';
    #echo '<!-- $arUsedProp: <pre>'.print_r($arUsedProp, true).' -->';

    $res = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
    echo '<!-- founded : '. $res->SelectedRowsCount().' -->';

    while($aElem = $res->GetNext(false, false))
    {
        #echo '<!-- $aElem: <pre>'.print_r($aElem, true).' -->';

        $cc = 0;

        foreach($arUsedProp as $code => $value)
        {
            if($aElem[$code])
            {
                if($aElem[$code] == $value)
                    $cc++;
            }
        }

        if($cc > 1)
        {
            $arCompare[] = array(
                'ID' => $aElem['ID'],
                'COUNT' => $cc
                );
        }
    }

    usort($arCompare, "cmpCount");

    $c = 0;

    foreach($arCompare as $d)
    {
        $c++;

        $arResult['SIMILAR_ID'][] = $d['ID'];

        if($c > 10)
            break;
    }

    echo '<!-- SIMILAR_ID: <pre>'.print_r($arResult['SIMILAR_ID'], true).' -->';

}



$cp = $this->__component; // объект компонента

if (is_object($cp))
{
    $cp->arResult['DISPLAY_PROPERTIES'] = $arResult['DISPLAY_PROPERTIES'];
    //$cp->arResult['SIMILAR_ID'] = $arResult['SIMILAR_ID'];
    $cp->SetResultCacheKeys(array('DISPLAY_PROPERTIES'));
}



// Проверка свойства

$e0=explode(' ',$arResult['NAME']);

 foreach($arResult['PRODUCT_OFFER'] as $keys=>$aProductOffer):

$ee='';
$e=explode(' ',$aProductOffer['NAME']);

$be=0;
for ($i=0; $i<count($e); $i++)
{
if ( ($e0[$i]!=$e[$i]) || ($be!=0) ) { $ee=$ee.' '.$e[$i]; $be=10; }

}


$arResult['PRODUCT_OFFER'][$keys]['NAME']=$ee;

endforeach;










