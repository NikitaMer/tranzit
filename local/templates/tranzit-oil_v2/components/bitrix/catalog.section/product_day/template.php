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

if (!empty($arResult['ITEMS']))
{
	?>
		<?

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
		$strMainID = $this->GetEditAreaId($arItem['ID']);

		$productTitle = (
			isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
			? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
			: $arItem['NAME']
			);
			
		$imgTitle = (
			isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
			? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
			: $arItem['NAME']
			);

		$pict = null;//$arItem['PREVIEW_PICTURE'];

		if(!$pict && is_array($arItem['DETAIL_PICTURE']))
			$pict = $arItem['DETAIL_PICTURE'];

		if(!$pict && is_array($arItem['PREVIEW_PICTURE']))
			$pict = $arItem['PREVIEW_PICTURE'];

		$img = CFile::ResizeImageGet($pict, array('width'=>146, 'height'=>146), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		?>
		<div class="day-product" id="<? echo $strMainID; ?>">
			<div class="title">Товар дня!</div>

			<a class="catalog-name" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" ><?=TruncateText($productTitle, 32);?></a>
			<div class="price-block">
				<?
				if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
				{
					echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
				}
				?>
			</div>
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$img['src'];?>)" title="<?=$imgTitle;?>"></a>
		</div><?
	}

}
?>