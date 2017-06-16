<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

LocalRedirect('/shop/');
die();

if(\Bitrix\Main\Loader::includeModule('iblock') && $_GET['debug'] != 'Y')
{
	$arFilter = array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'GLOBAL_ACTIVE' => 'Y',
		'DEPTH_LEVEL' => 1,
		);

	$rs = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter, true);
	if($arS = $rs->GetNext())
	{
		#print_r($arS);
		LocalRedirect($arS['SECTION_PAGE_URL']);
	}
}
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"layer1",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => 1, //$arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
	),
	$component,
	array("HIDE_ICONS" => "Y")
);
?>