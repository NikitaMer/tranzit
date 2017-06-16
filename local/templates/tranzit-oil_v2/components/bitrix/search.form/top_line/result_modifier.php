<?php

use \Bitrix\Iblock\SectionTable;
use Bitrix\Main\Data\Cache;

$arResult['CATALOG'] = array();

$CCache = Cache::createInstance();

$cache_time = 3600000;
$cache_id = 'seaarcform_catalog_sections';

if($CCache->initCache($cache_time, $cache_id)) #
{
    $vars = $CCache->getVars();
    $arResult['CATALOG'] = $vars['CATALOG'];
}
else
{
    $CCache->startDataCache($cache_time, $cache_id);
}

if($CCache->isStarted())
{


    if(defined('CATALOG_IBLOCK_ID') && intval(CATALOG_IBLOCK_ID) > 0 && \Bitrix\Main\Loader::includeModule('iblock'))
    {
        $arFilter = array(
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            'DEPTH_LEVEL' => 1,
            'ACTIVE' => 'Y',
            'GLOBAL_ACTIVE' => 'Y',
        );
        /*
        $rs = SectionTable::getList(array(
            'filter' => $arFilter,
            'order' => array(
                'SORT' => 'ASC'
                ),
            'select' => array(
                'NAME',
                'PICTURE',
                'CODE',
                'IBLOCK.SECTION_PAGE_URL'
                )
            ));

        if($ar = $rs->fetch())
        {
            echo '<pre>'.print_r($ar, true).'</pre>';

            $arResult['CATELOG'][$ar['ID']] = array(
                'NAME' => $ar['NAME'],
                'PICTURE' => $ar['PICTURE'],
                'PICTURE' => $ar['PICTURE'],
                'URL' => $ar['DETAIL_PAGE_URL'],
                );

        }
        */

        $dbSect = \CIBlockSection::GetList(Array('SORT' => 'ASC'), $arFilter, true);
        while($ar = $dbSect->GetNext(false, false))
        {
            #echo '<pre>'.print_r($ar, true).'</pre>';

            $arResult['CATALOG'][$ar['ID']] = array(
                'NAME'      => $ar['NAME'],
                'PICTURE'   => $ar['PICTURE'],
                'URL'       => $ar['SECTION_PAGE_URL'],
                'ELEMENT_CNT' => $ar['ELEMENT_CNT'],
            );

        }

    $CCache->endDataCache(array(
        'CATALOG' => $arResult['CATALOG']
    ));
}

}

