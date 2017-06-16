<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arTemplateParameters = array(
	"USE_SUGGEST" => Array(
		"NAME" => 'Типы цен',
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
);

if (\Bitrix\Main\Loader::includeModule("catalog"))
{
	$arPrice = array();
	$rsPrice=CCatalogGroup::GetListEx(
		array("SORT" => "ASC"),
		array(),
		false,
		false,
		array('ID', 'NAME', 'NAME_LANG')
	);
	while($arr=$rsPrice->Fetch())
		$arPrice[$arr["NAME"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];

	$arTemplateParameters['PRICE_CODE'] = array(
		'PARENT' => 'BASE',
		'NAME' => GetMessage('SALE_PROPERTIES_RECALCULATE_BASKET'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'Y',
		"MULTIPLE" => "Y",
		"SIZE" => (count($arPrice) > 5 ? 8 : 3),
		"VALUES" => $arPrice,
		'REFRESH' => 'N',
	);

}


if(COption::GetOptionString("search", "use_social_rating") == "Y")
{
	$arTemplateParameters["SHOW_RATING"] = Array(
		"NAME" => GetMessage("TP_BSP_SHOW_RATING"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"" => GetMessage("TP_BSP_SHOW_RATING_CONFIG"),
			"Y" => GetMessage("MAIN_YES"),
			"N" => GetMessage("MAIN_NO"),
		),
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	);
	$arTemplateParameters["RATING_TYPE"] = Array(
		"NAME" => GetMessage("TP_BSP_RATING_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"" => GetMessage("TP_BSP_RATING_TYPE_CONFIG"),
			"like" => GetMessage("TP_BSP_RATING_TYPE_LIKE_TEXT"),
			"like_graphic" => GetMessage("TP_BSP_RATING_TYPE_LIKE_GRAPHIC"),
			"standart_text" => GetMessage("TP_BSP_RATING_TYPE_STANDART_TEXT"),
			"standart" => GetMessage("TP_BSP_RATING_TYPE_STANDART_GRAPHIC"),
		),
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	);
	$arTemplateParameters["PATH_TO_USER_PROFILE"] = Array(
		"NAME" => GetMessage("TP_BSP_PATH_TO_USER_PROFILE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}
?>
