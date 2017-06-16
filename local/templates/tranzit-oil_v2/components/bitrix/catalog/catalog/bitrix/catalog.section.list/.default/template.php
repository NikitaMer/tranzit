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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

	?><h1 id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>"><?
		echo (
			isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
			? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
			: $arResult['SECTION']['NAME']
		);?></h1><?
}

if (0 < $arResult["SECTIONS_COUNT"])
{
	?>
	<ul class="catalog-section-list layer2">
	<?
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

		$arSection['PICTURE'] = array(
			'PICTURE' => $arSection['PICTURE'],
			'ALT' => (
				'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
				? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
				: $arSection["NAME"]
			),
			'TITLE' => (
				'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
				? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
				: $arSection["NAME"]
			)
		);

		$img = CFile::ResizeImageGet($arSection['PICTURE']['PICTURE'], array('width'=>138, 'height'=>138), BX_RESIZE_IMAGE_PROPORTIONAL, true);

		?><li id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
		
			<a href="<?=$arSection['SECTION_PAGE_URL']; ?>" title="<?=$arSection['PICTURE']['TITLE']; ?>">
				<div class="image" style="background-image: url(<? echo $img['src']; ?>);<?if($img['src']):?> background-color: #fff;<?endif;?>"></div>
				<span><?=$arSection['NAME'];?>
					<?if ($arParams["COUNT_ELEMENTS"])
						echo '('.$arSection['ELEMENT_CNT'].')';
				?></span>
			</a>
		</li><?
	}
	?></ul><?
}

