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

#echo '<pre>'.print_r($arResult).'</pre>';

$section_page = $arResult['FOLDER'].str_replace('#SECTION_CODE#',$arResult['VARIABLES']['SECTION_CODE'],$arResult['URL_TEMPLATES']['section']);
LocalRedirect($section_page);
?>