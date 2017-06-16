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

?>
