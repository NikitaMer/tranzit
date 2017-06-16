<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$CSiteController = SiteController::getEntity();
?>

<?if(count($arResult["ITEMS"])):?>
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?><br />
	<?endif;?>

	<form action="" class="user-favorites" method="POST" id="user-favorites">
		<input type="hidden" name="SAVE_TO" value="<?=$arResult["SAVE_TO"]?>"/>
	    <?
        $frame = $this->createFrame("user-favorites", false)->begin();
        ?>
		<ul class="catalog-element-list">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			#_print_r($arItem['PROP']);
			$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width'=>103, 'height'=>103), BX_RESIZE_IMAGE_PROPORTIONAL , true);
			?>
			<li>
				<input type="checkbox" name="favorite[]" value="<?=$arItem['ELEMENT_ID']?>" style="display: none;"/>
				<?if($arParams["DISPLAY_DATE_CREATE"]):?>
					<?//echo $arItem["DISPLAY_DATE_CREATE"]?>
				<?endif?>

				<a href="<?=$arItem['DETAIL_PAGE_URL']; ?>" class="image" style="background-image: url(<?=$img['src']; ?>);"></a>
				<div class="desc">
					<div class="line1">

						<div class="left-block">
							<?
							$prev_text_len = 95;

							if(strlen($arItem['NAME']) > 45)
								$prev_text_len = 45;
							?>
							<a href="<?=$arItem['DETAIL_URL']; ?>" class="name"><?=TruncateText($arItem['NAME'], 95);?></a>
							<?if($arItem['PREVIEW_TEXT']):?>
								<div class="info"><?=TruncateText(HTMLToTxt($arItem['PREVIEW_TEXT']), $prev_text_len);?></div>
							<?endif;?>
						</div>

						<div class="right-block">
							<div class="price-block">


								<?

								if (!empty($arItem['MIN_PRICE']) && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
								{
									echo $CSiteController->getHtmlFormatedPrice('RUB', $arItem["MIN_PRICE"]["VALUE"]); //DISCOUNT_
									#echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
								}

								?>
							</div>
							<?
							/*if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
							{
								if ($arItem['CAN_BUY'] == 'Y' && $arItem['CATALOG_QUANTITY'] > 0)
								{
								
?>


							<?
							}

								}
								else
								{
									?>
									<div class="availability no">Нет в наличии</div>
								<?
								}

							}*/

							#echo 'CAN_BUY='.$arItem['CAN_BUY'].' \ '.$arItem['CATALOG_QUANTITY'];
							?>
						</div>
					</div>
					<div class="line2">
						<?if($arItem['PROP']['CML2_ARTICLE']):?>
						<div class="articul">Артикул: <span><?=TruncateText($arItem['PROP']['CML2_ARTICLE'], 20);?></span></div>
						<?endif;?>
						<div class="action-block">
							<?/*
							if ($arParams['DISPLAY_COMPARE'] && (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])))
							{
								?>
								<a class="icon icon16 compare link" data-action="add2compare" data-id="<?=$arItem['ID']?>" href="#"><span>К сравнению</span></a>
							<?
							}*/

							/*
							?>
							<a class="icon icon16 favorite link add2favorite" data-action="add2favorite" data-id="<?=$arItem['ID']?>" href="#"><span>В закладки</span></a>
							<?
							*/
?>
                            <button style="margin-right: 20px;" class="yellow round" type="submit" value="<?=$arItem['ELEMENT_ID']?>" onClick="if(!confirm('<?=GetMessage('WSM_FAVORITES_DEL_CONFIRM_ONE');?>')) return false;" name="removeFavID" value="<?=$arItem['ID']?>"><?=GetMessage("WSM_FAVORITES_REMOVE")?></button>
                            <?
							if(!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
							{

								if ($arItem['CAN_BUY'])
								{
CModule::IncludeModule('catalog');
CModule::IncludeModule('sale');

$ar_res = CCatalogProduct::GetByID($arItem[ELEMENT_ID]);

									#BUY_URL
									?>

<? if ($ar_res[QUANTITY]>0) { ?>
								<a  style="background:#99CC33;border: 1px solid #99CC33;"  class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Купить</a>
                                                            <? } else {?>
<a class="buy button yellow" data-action="add2basket" href="<?=$arItem['ADD_URL']; ?>" rel="nofollow">Заказать</a>
<? } ?>

								<?
								}
								else
								{
									?>
									<a class="buy button white not_av" href="javascript:void(0);" rel="nofollow">Купить</a>
								<?
								}

							}


							?>
						</div>
					</div>
				</div>

			</li>
		<?endforeach;?>
		</ul>

		<?/*
		<button class="yellow" type="submit" onClick="if(!confirm('<?=GetMessage('WSM_FAVORITES_DEL_CONFIRM');?>')) return false;" name="removeFav" value=""><?=GetMessage("WSM_FAVORITES_REMOVE")?></button>
		*/?>
        <?$frame->beginStub(); ?>

        <?$frame->end();?>
	</form>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>

<?else:?>
	<?=GetMessage("WSM_FAVORITES_NOT_FOUND")?>
<?endif;?>
