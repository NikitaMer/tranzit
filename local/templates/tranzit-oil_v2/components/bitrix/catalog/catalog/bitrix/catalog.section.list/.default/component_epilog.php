<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;

#echo '<pre>'.print_r($arResult['DISPLAY_PROPERTIES'], true).'</pre>';
global $CatalogSectionCount;
$CatalogSectionCount = $arResult['SECTIONS_COUNT'];


?>