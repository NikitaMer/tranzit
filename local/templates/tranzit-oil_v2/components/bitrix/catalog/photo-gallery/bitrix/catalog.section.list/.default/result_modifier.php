<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

$arPicture = array();

if(Loader::includeModule('iblock'))
{
    $arSectID = array();

    foreach ($arResult['SECTIONS'] as &$arSection)
    {
        if($arSection['PICTURE'])
            $arPicture[$arSection['ID']] = $arSection['PICTURE']['ID'];
        else
            $arSectID[] = $arSection['ID'];
    }

    if(!empty($arSectID))
    {
        #получаем фото для раздела
        $arFilter = array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'SECTION_ID' => $arSectID,
            '!PROPERTY_SECTION_PICTURE' => false,
            );

        $arSelect = array(
            'IBLOCK_ID',
            'ID',
            'NAME',
            'IBLOCK_SECTION_ID',
            'PREVIEW_PICTURE',
            );

        $rsElements = \CIBlockElement::GetList(array('ID' => 'ASC'), $arFilter, false, false, $arSelect);
        while($arFoto = $rsElements->GetNext(false, false))
        {
            $arPicture[$arFoto['IBLOCK_SECTION_ID']] = $arFoto['PREVIEW_PICTURE'];
            #echo '<pre>'.print_r($arFoto, true).'</pre>';
        }

    }

    foreach ($arResult['SECTIONS'] as $index => &$arSection)
    {
        $arResult['SECTIONS'][$index]['ALBUM_PICTURE'] = CFile::ResizeImageGet($arPicture[$arSection['ID']], array('width'=>302, 'height'=>400), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    }

}