<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
//Debug($arResult);
/**
 * Получаем идентификаторы родительских разделов для товаров
 */
$sectionsIds = array();
$iblockId = 0;
$remove = false;

#echo '<pre>'.print_r($arResult['ITEMS'], true).'</pre>';
/*
$items = $arResult['ITEMS'];
foreach($items as $arElement)
{
	if(isset($_REQUEST['remove']) && isset($_REQUEST['CATEGORY']))
	{
		if($_REQUEST['remove'] == 'Y' && (int)$_REQUEST['CATEGORY'] == $arElement['IBLOCK_SECTION_ID'])
		{
			$remove = true;
			unset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$arElement['ID']]);
		}
	}



	$sectionsIds[] = $arElement['IBLOCK_SECTION_ID'];
	$iblockId = $arElement['IBLOCK_ID'];
}

if($remove)
{
	$page = $APPLICATION->GetCurPageParam("", array('remove'));
	LocalRedirect($page);
}

$arResult['SEL_CATEGORY'] = 0;

if(isset($_REQUEST['CATEGORY']) && $_REQUEST['remove'] != 'Y')
{
	if(in_array((int)$_REQUEST['CATEGORY'], $sectionsIds))
		$arResult['SEL_CATEGORY'] = (int)$_REQUEST['CATEGORY'];
}
else
	$arResult['SEL_CATEGORY'] = current($sectionsIds);

foreach($arResult["ITEMS"] as $i => $arElement)
{
	if($arElement['IBLOCK_SECTION_ID'] != $arResult['SEL_CATEGORY'])
		unset($arResult["ITEMS"][$i]);
}

#Получаем названия родительских разделов и формируем массив лдя передачи в template.php
 
$arFilter = array('IBLOCK_ID' => $iblockId, 'ID' => $sectionsIds);
$arSelect = array('ID', 'NAME');
$db_list = CIBlockSection::GetList(
		array(),
		$arFilter,
		false,
		$arFilter,
		false
	);
$sectionsNames = array();
while($ar_result = $db_list->GetNext())
{
	$arResult['SECTIONS'][$ar_result['ID']] = $ar_result['NAME'];
}
*/



foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty)
{
    foreach($arResult["ITEMS"] as $arElement)
    {
        $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];

        if(is_array($arPropertyValue))
        {
            sort($arPropertyValue);
            $arPropertyValue = implode(" / ", $arPropertyValue);
        }

        $prop[$code][] = $arPropertyValue;
    }
}

$arResult['DIF_PROP']=array();
foreach($prop as $code => $values)
{
    $arResult['DIF_PROP'][$code] = count(array_unique($values)) == 1;
}


#_print_r($arResult['DIF_PROP']);

?>