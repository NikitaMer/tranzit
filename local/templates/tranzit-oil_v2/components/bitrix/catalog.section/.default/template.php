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
	if ($arParams["DISPLAY_TOP_PAGER"])
		echo $arResult["NAV_STRING"];


	?>
	
	<ul class="catalog-element-list"><?

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
	
	include $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/status_bayers.php';

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

		$img = CFile::ResizeImageGet($pict, array('width'=>103, 'height'=>103), BX_RESIZE_IMAGE_PROPORTIONAL, true);

		$prev_text_len = 95;
		if(strlen($arItem['NAME']) > 45)
			$prev_text_len = 45;

		//pre($arItem["ADD_URL"]);
		?>
		
	<?php if ($status_bayer != 'Юридическое лицо') { ?>
		<li id="<? echo $strMainID; ?>">
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$img['src']; ?>);" title="<?=$imgTitle;?>"></a>
			<div class="desc">
				<div class="line1">
					
					<div class="left-block">
						<a href="<?=$arItem['DETAIL_PAGE_URL']; ?>" class="name" title="<? echo $productTitle; ?>"><?=TruncateText($productTitle, 95);?></a>
						<?if($arItem['PREVIEW_TEXT']):?>
						<div class="info"><?=TruncateText(HTMLToTxt($arItem['PREVIEW_TEXT']), $prev_text_len);?></div>
						<?endif;?>
					</div>
					
					<div class="right-block">
						<div class="price-block">
							<?
							if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
							{
								echo $CSiteController->getHtmlFormatedPrice($arItem["MIN_PRICE"]["CURRENCY"], $arItem["MIN_PRICE"]["DISCOUNT_VALUE"]); 
								#echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
							}
							?>
						</div>
						<?
                        //$arItem['CATALOG_QUANTITY'] = 8;

						if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
						{
							if ($arItem['CAN_BUY'] == 'Y' && $arItem['CATALOG_QUANTITY'] >= 10)
							{
								?>
								<div class="availability"><span>В наличии</span></div>
								<?
							}
                            elseif ($arItem['CAN_BUY'] == 'Y' && $arItem['CATALOG_QUANTITY'] > 0 && $arItem['CATALOG_QUANTITY'] < 10 )
                            {
                                ?>
                                <div class="availability"><span class="red">Меньше 10</span></div>
                                <?
                            }
							else
							{
								?>
								<div class="availability"><span class="no">Нет в наличии</span></div>
								<?
							}
							
						}

						#echo 'CAN_BUY='.$arItem['CAN_BUY'].' \ '.$arItem['CATALOG_QUANTITY'];

						?>
					</div>
				</div>
				<div class="line2">

                    <?if(strlen($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']) > 0):?>
					<div class="articul">Артикул: <span><?=TruncateText($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'], 12);?></span></div>
                    <?endif;?>

					<div class="action-block">
						<?
						if ($arParams['DISPLAY_COMPARE'] && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
						{
							?>
							<a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ID']?>" href="#"><span>К сравнению</span></a>
							<?
						}
						?>
						<a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ID']?>" href="#"><span>В закладки</span></a>
						<?

						if(!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
						{



							if ($arItem['CAN_BUY'])
							{
								#BUY_URL
								?>

                                                           <? if ($arItem['CATALOG_QUANTITY']>0) { ?>
								<a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
                                                            <? } else {?>
								<a class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Заказать</a>
							<? } ?>
							<? } else { ?>
								<a class="buy button white not_av" href="javascript:void(0);" rel="nofollow">Купить</a>
							<?
							}
						}
						?>
					</div>
				</div>
			</div>
		</li>
	<? } elseif ($arItem['PROPERTIES']['HIDE_OPT']['VALUE'] != 1) { ?>
		<li id="<? echo $strMainID; ?>">
			<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$img['src']; ?>);" title="<?=$imgTitle;?>"></a>
			<div class="desc">
				<div class="line1">
					
					<div class="left-block">
						<a href="<?=$arItem['DETAIL_PAGE_URL']; ?>" class="name" title="<? echo $productTitle; ?>"><?=TruncateText($productTitle, 95);?></a>
						<?if($arItem['PREVIEW_TEXT']):?>
						<div class="info"><?=TruncateText(HTMLToTxt($arItem['PREVIEW_TEXT']), $prev_text_len);?></div>
						<?endif;?>
					</div>
					
					<div class="right-block">
						<div class="price-block">
							<?
							if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
							{
								echo $CSiteController->getHtmlFormatedPrice($arItem["MIN_PRICE"]["CURRENCY"], $arItem["MIN_PRICE"]["DISCOUNT_VALUE"]); 
								#echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
							}
							?>
						</div>
						<?
                        //$arItem['CATALOG_QUANTITY'] = 8;

						if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
						{
							if ($arItem['CAN_BUY'] == 'Y' && $arItem['CATALOG_QUANTITY'] >= 10)
							{
								?>
								<div class="availability"><span>В наличии</span></div>
								<?
							}
                            elseif ($arItem['CAN_BUY'] == 'Y' && $arItem['CATALOG_QUANTITY'] > 0 && $arItem['CATALOG_QUANTITY'] < 10 )
                            {
                                ?>
                                <div class="availability"><span class="red">Меньше 10</span></div>
                                <?
                            }
							else
							{
								?>
								<div class="availability"><span class="no">Нет в наличии</span></div>
								<?
							}
							
						}

						#echo 'CAN_BUY='.$arItem['CAN_BUY'].' \ '.$arItem['CATALOG_QUANTITY'];

						?>
					</div>
				</div>
				<div class="line2">

                    <?if(strlen($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']) > 0):?>
					<div class="articul">Артикул: <span><?=TruncateText($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'], 12);?></span></div>
                    <?endif;?>

					<div class="action-block">
						<?
						if ($arParams['DISPLAY_COMPARE'] && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
						{
							?>
							<a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ID']?>" href="#"><span>К сравнению</span></a>
							<?
						}
						?>
						<a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ID']?>" href="#"><span>В закладки</span></a>
						<?

						if(!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
						{



							if ($arItem['CAN_BUY'])
							{
								#BUY_URL
								?>

                                                           <? if ($arItem['CATALOG_QUANTITY']>0) { ?>
								<a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
                                                            <? } else {?>
								<a class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Заказать</a>
							<? } ?>
							<? } else { ?>
								<a class="buy button white not_av" href="javascript:void(0);" rel="nofollow">Купить</a>
							<?
							}
						}
						?>
					</div>
				</div>
			</div>
		</li>
	<? } ?>
	    
	<? } ?>
	</ul>

<?php
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}

}
else
{
	global $CatalogSectionCount;

	if($CatalogSectionCount == 0)
		ShowError('Нет товаров для отображения');
}

?>
<script>
	$(function(){

		$('.catalog-element-list li').each(function(i, el){
			var name = $(el).find('.name'),
				info = $(el).find('.info');

			if(name.height() > 30)
				info.height(20);
			});

		<?if (!empty($arResult['ITEMS'])):?>
		$('.catalog-opt-line').show();
		<?endif;?>

		});
</script>

