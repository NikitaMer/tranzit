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

$CSiteController = SiteController::getEntity();

if (!empty($arResult['ITEMS']))
{
	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));


	?>
	<h3 class="uppercase">Похожие товары</h3>
	<div class="tovar-slider">

		<?if(count($arResult['ITEMS']) > 1):?>
		<a href="#" data-target="prev" class="nav-icon-white nav prev similar-custom""></a>
		<a href="#" data-target="next" class="nav-icon-white nav next similar-custom"></a>
		<?endif;?>

		<div class="slider-block" id="similar_slider">
			<?foreach($arResult['ITEMS'] as $key => $arItem):

				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
				$strMainID = $this->GetEditAreaId($arItem['ID']);

				$pict = null;

				if(!$pict && is_array($arItem['DETAIL_PICTURE']))
					$pict = $arItem['DETAIL_PICTURE'];

				if(!$pict && is_array($arItem['PREVIEW_PICTURE']))
					$pict = $arItem['PREVIEW_PICTURE'];

				$img = CFile::ResizeImageGet($pict, array('width'=>60, 'height'=>60), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				?>
				<div class="slider-item" id="<?=$strMainID?>">
					<a href="" class="image" style="background-image: url(<?=$img['src']?>);" title="<?=$arItem['NAME']?>"></a>
					<div class="desc">
						<div class="price-block">
							<?=$CSiteController->getHtmlFormatedPrice($arItem["MIN_PRICE"]["CURRENCY"], $arItem["MIN_PRICE"]["DISCOUNT_VALUE"]);?>
						</div>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="button gray show">Смотреть</a>
					</div>
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="catalog-name" title="<?=$arItem['NAME']?>"><?=TruncateText($arItem['NAME'], 40);?></a>
				</div>
			<?endforeach;?>
		</div>
	</div>

	<script>
		var total_list = <?=count($arResult['ITEMS'])?>;

		$('#similar_slider').sudoSlider({
			speed: 800,
			pause: 3000,
			auto: false,
			prevNext: false,
			numeric: false,
			touch: true,
			continuous: true,
			//startSlide: 1,
			slideCount: 1,
			customLink: '.similar-custom',
			controlsFade: false,
			controlsFadeSpeed: '800',
			beforeAnimation: function(t){

				if(t == 1)
					$('.tovar-slider a[data-target=prev]').hide();
				else
					$('.tovar-slider a[data-target=prev]').show();

				if(t == total_list + 1)
					$('.tovar-slider a[data-target=next]').hide();
				else
					$('.tovar-slider a[data-target=next]').show();

			},
			afterAnimation: function(t){

			}
			});

		$('.tovar-slider a[data-target=prev]').hide();

	</script>
<?
}