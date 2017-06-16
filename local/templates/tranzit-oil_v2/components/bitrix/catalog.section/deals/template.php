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
$count = 0;

if (!empty($arResult['ITEMS']))
{

	?>
	<div class="catalog-specoffers">
		<h3>Хиты продаж</h3>

		<?
		if ($arParams["DISPLAY_TOP_PAGER"])
			echo $arResult["NAV_STRING"];

		?><ul class="catalog-specoffers-list"><?

		$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
		$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
		$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

		foreach ($arResult['ITEMS'] as $key => $arItem)
		{
			$count++;

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

			$img = CFile::ResizeImageGet($pict, array('width'=>138, 'height'=>138), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			?>
			<li id="<? echo $strMainID; ?>">
				<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$img['src'];?>)" title="<?=$imgTitle;?>"></a>
				<div class="desc">
					<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="catalog-name"><?=TruncateText($productTitle, 30);?></a>
					<div class="price-block">
					<?
						if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
						{
							echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
						}
						?>
					</div>
				</div>
			</li>
			<?if($count % 6 == 0):?>
			</ul>
			<ul class="catalog-specoffers-list catalog-items">
			<?endif;?>
			<?
		}
		?></ul><?

	if ($arParams["DISPLAY_BOTTOM_PAGER"])
		echo $arResult["NAV_STRING"];

	?></div><?
}
?>