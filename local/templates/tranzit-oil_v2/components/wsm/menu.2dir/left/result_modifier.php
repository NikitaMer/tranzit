<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

/*

$parent_selected = false;
$parent_selected_layer = false;
$parent_selected_index = false;

foreach($arResult as $index => $arItem)
{
	if($parent_selected && $arItem["DEPTH_LEVEL"] == $parent_selected_layer)
	{
		$parent_selected = false;
	}
	
	
    if($arItem["IS_PARENT"] && $arItem["SELECTED"])
    {
        $parent_selected = true;
        $parent_selected_layer = $arItem["DEPTH_LEVEL"];
    }
	
	
	if(!$parent_selected && $arItem["DEPTH_LEVEL"] > 1)
	{
		unset($arResult[$index]);
	}

    if($arItem["SELECTED"] && $arItem["DEPTH_LEVEL"] > $parent_selected_layer)
    {
        
    }

    //$arItem["DEPTH_LEVEL"]
}

echo '<pre>'.print_r($arResult, true).'</pre>';
*/