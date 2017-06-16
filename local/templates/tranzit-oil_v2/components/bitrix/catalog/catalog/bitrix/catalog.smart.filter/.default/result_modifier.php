<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*
 * подсчет количества товаров по фильтру
 */

/**
if(\Bitrix\Main\Loader::includeModule('iblock'))
{

	foreach($arResult["ITEMS"] as $index => $prop)
	{
		if($prop['PRICE'] && intval($prop['IBLOCK_ID'] <= 0))
			continue;


		$arSelect = array('ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_VALUE', 'DETAIL_PAGE_URL');

		#echo '<pre>'.print_r($prop['VALUES'], true).'</pre>'; //$prop['CODE']

		foreach($prop['VALUES'] as $vid => $val)
		{
			$arFilter = array(
				'IBLOCK_ID' => $prop['IBLOCK_ID'],
				'!PROPERTY_'.$prop['CODE'] => $vid,
				'ACTIVE' => 'Y',
				'ACTIVE_DATE' => 'Y',
				);

			$rsElements = \CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
			$arResult["ITEMS"][$index]['VALUES'][$vid]['COUNT'] = $rsElements->SelectedRowsCount();
		}

	}
}
**/